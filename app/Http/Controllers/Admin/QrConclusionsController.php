<?php

namespace App\Http\Controllers\Admin;

use App\Models\QrConclusion;
use App\Models\Company;
use App\Models\Component;
use App\Models\Conclusion;
use App\Models\Facility;
use App\Models\WorkLocation;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use QrCode;

class QrConclusionsController extends Controller
{
    public function check_permission()
    {
        if(Auth::user()->role == 'Пользователь')
            abort(403);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->check_permission();
        $qrs = QrConclusion::orderBy('id', 'desc')
            ->get();

        return view('admin.qrs.index', [
            'qrs' => $qrs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $componentId = (int) $request->component_id;
        $qr = QrConclusion::create([
            'component_id' => $componentId,
            'status_exp' => 'yes'
        ]);

        $qrUrl = "https://bd.alyansekspert.ru/conclusions?qr=$qr->id";
        $qrcode = QrCode::size(250)
            ->format('png')
            ->margin(5)
            ->errorCorrection('H')
            ->generate($qrUrl, base_path() . '/public/qr_files/' . $qr->id . '.png');
            
        $qr->update([
            'qr_url' => $qrUrl
        ]);

        return redirect()
            ->to(route('qrs.index'))
            ->with('success', 'Запись успешно добавлена');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\QrConclusion  $qrConclusion
     * @return \Illuminate\Http\Response
     */
    public function show(QrConclusion $qrConclusion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\QrConclusion  $qrConclusion
     * @return \Illuminate\Http\Response
     */
    public function edit(QrConclusion $qrConclusion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\QrConclusion  $qrConclusion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QrConclusion $qrConclusion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\QrConclusion  $qrConclusion
     * @return \Illuminate\Http\Response
     */
    public function destroy(QrConclusion $qrConclusion)
    {
        $qr = QrConclusion::findOrFail($id);

        $qr->delete();

        return redirect()
            ->to(route('qrs.index'))
            ->with('success', 'Запись успешно удалёна');
    }
    
    /*
     * Получение данных по номеру ленты
     */
    public function get_data_on_type_number(Request $request)
    {
        $tapeNumber = trim($request->tape_number);
        $component = Component::where('tape_number', $tapeNumber)
            ->first();

        if(!empty($component))
        {
            $company = Company::findOrFail($component->company_id);
            $current_work_location = WorkLocation::findOrFail($component->work_location_id);
            $current_facility = Facility::findOrFail($component->facility_id);

            $result['company'] = $company;
            $result['work_location'] = $current_work_location;
            $result['facility'] = $current_facility;
            $result['component'] = $component;

            return $result;
        } else
            return 'false';

    }    

    public function get_type_number(Request $request)
    {
        $tapeNumber = trim($request->tape_number);
        $components = Component::where('tape_number', 'LIKE', '%'.$tapeNumber.'%')
            ->get();

        if(isset($components) && count($components) > 0)
        {
            http_response_code(200);
            $result['components'] = $components;
            $result['status'] = 'ok';
        } else {
            http_response_code(404);
            $result['status'] = 'bad';
            $result['components'] = [];
            $result['msg'] = 'Нет компонента';
        }

        return $result;
    }

    public function editQr(Request $request)
    {
        $id = (int) $request->id;
        $qr = QrConclusion::findOrFail($id);
        $component = Component::findOrFail($qr->component_id);
        $company = Company::findOrFail($component->company_id);
        $current_work_location = WorkLocation::findOrFail($component->work_location_id);
        $current_facility = Facility::findOrFail($component->facility_id);

        $result['company'] = $company;
        $result['work_location'] = $current_work_location;
        $result['facility'] = $current_facility;
        $result['component'] = $component;

        return $result;
    }

    public function updateQr(Request $request)
    {
        if($request->qr_id_edit)
        {
            $id = (int) $request->qr_id_edit;
            $qr = QrConclusion::findOrFail($id);
            $qr->update([
                'component_id' => $request->component_id_edit
            ]);
            return redirect()
                ->to(route('qrs.index'))
                ->with('success', 'Информация успешно обновлена');
        } else {
            return redirect()
                ->to(route('qrs.index'))
                ->with('errors', 'Ошибка обновления записи');
        }

    }

    public function checkComponentId(Request $request)
    {
        $id = (int) $request->component_id;
        $component = Component::findOrFail($id);
        $qr = QrConclusion::where('component_id', $component->id)->first();

        if($component)
        {
            $result['status'] = 'yes';
            $result['qr'] = $qr;
        } else {
            $result['status'] = 'no';
        }

        return $result;
    }

    public function activeChange(Request $request)
    {
        $qr = QrConclusion::findOrFail($request->qr_id);
        if($qr->update(['status_exp' => $request->status_exp]))
        {
            $result['status'] = 'ok';
        } else {
            $result['status'] = 'no';
        }
    
        return $result;
    }
}
