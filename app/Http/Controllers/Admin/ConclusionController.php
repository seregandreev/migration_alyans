<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Models\Instrument;
use App\Models\Component;
use App\Models\Conclusion;
use App\Models\ConclusionParam;
use App\Models\Config;
use App\Models\Facility;
use App\Models\Inspector;
use App\Models\Order;
use App\Models\OrderConclusion;
use App\Models\Type;
use App\Models\Unit;
use App\Models\WorkLocation;
use App\Models\QrConclusion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use File;
use PDF;
use App\User;
use Spatie\Browsershot\Browsershot;
use Image;

class ConclusionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        $companies = Company::orderBy('name', 'asc')
            ->get();
        $stamp = Config::where('key', 'stamp')
            ->first();
        $signDirector = Config::where('key', 'signature_director')
            ->first();
        $signInspector = Config::where('key', 'signature_inspector')
            ->first();
        $ecp = Config::where('key', 'ecp')
            ->first();
        $companyId = Auth::user()->company_id;
        $selectCompany = Company::where('id', $companyId)
            ->get();
        // список заявок
        $orders = Order::orderBy('created_at', 'desc')
            ->get();

        $types = Type::orderBy('manufacturer', 'asc')
            ->groupBy('manufacturer')
            ->get();
            
        if(isset($_GET['qr']))
        {
            $qrId = (int) $_GET['qr'];
            $qr = QrConclusion::findOrFail($qrId);
            if($qr->status_exp == 'yes')
            {
                $component = Component::findOrFail($qr->component_id);
    
                // компания
                if(isset($component->company_id) && !empty($component->company_id))
                    session()->put('conclusions_company_id', $component->company_id);
                else
                    session()->forget('conclusions_company_id');
                // место проведения работ
                if(isset($component->work_location_id) && !empty($component->work_location_id))
                    session()->put('conclusions_work_locations', $component->work_location_id);
                else
                    session()->forget('conclusions_work_locations');
                    // установка
                if(isset($component->facility_id) && !empty($component->facility_id))
                    session()->put('conclusions_facilities', $component->facility_id);
                else
                    session()->forget('conclusions_facilities');
                // номер ленты
                if(isset($component->tape_number) && !empty($component->tape_number))
                    session()->put('conclusions_tape_number', $component->tape_number);
                else
                    session()->forget('conclusions_tape_number');
                // серийный номер
                if(isset($component->serial_number) && !empty($component->serial_number))
                    session()->put('conclusions_serial_number', $component->serial_number);
                else
                    session()->forget('conclusions_serial_number');                
            }

        }
        
        $filter_work_locations = (session('conclusions_company_id')) ? $this->list_work_locations(session('conclusions_company_id')) : '';
        $filter_facilities = (session('conclusions_company_id')) ? $this->list_facilities(session('conclusions_company_id')) : '';
        $filter_dates = (session('conclusions_company_id')) ? $this->list_dates_conclusion(session('conclusions_company_id'), session('conclusions_work_location_id'), session('conclusions_facility_id')) : '';

        $conclusions = $this->list_conclusions();

        return view('admin.conclusions.index', [
            'conclusions' => $conclusions,
            'companies' => $companies,
            'filter_work_locations' => $filter_work_locations,
            'filter_facilities' => $filter_facilities,
            'filter_dates' => $filter_dates,
            'ecp' => $ecp,
            'orders' => $orders,
            'stamp' => $stamp,
            'signDirector' => $signDirector,
            'signInspector' => $signInspector,
            'selectCompany' => $selectCompany,
            'types' => $types
        ]);
    }
    
    /*
     * сжатие, загрузка изображения диаграммы
     */
    public function uploadDiagram($image, $conclusion_id, $conclusion_image):void
    {

        // путь к документу
        $document_path = public_path('/conclusions_data/'.$conclusion_id.'/');
        // если не создана директория - создаём её
        @mkdir($document_path);
        // если остался старый файл - удаляем его
        if(file_exists($document_path.$conclusion_image.'.jpg'))
        {
            @unlink($document_path.$conclusion_image.'.jpg');
        }

        $img = Image::make($image->getRealPath());
        $img->resize(600, 600, function ($constraint) {
            $constraint->aspectRatio();
        })->save($document_path.$conclusion_image.'.jpg');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(Auth::user()->role == 'Работник лаборатории') {
            $inspectorId = Auth::user()->inspector_id;
            $inspectors = Inspector::where('id', $inspectorId)
                ->get();
            $conclusion_last = Conclusion::where('inspector_id', $inspectorId)
                ->orderBy('id', 'desc')
                ->first();
        } else {
            $inspectors = Inspector::orderBy('name', 'asc')
                ->get();
            $conclusion_last = Conclusion::orderBy('id', 'desc')
                ->first();
        }

        $conclusion_params = ConclusionParam::where('user_id', Auth::id())
            ->first();
            
        /*$conclusion_company = Company::select('companies.*')
            ->leftJoin('components', 'components.company_id', '=', 'companies.id')
            ->first();*/

        if(isset($request->tape_number))
            $tape_number = $request->tape_number;
        else
            $tape_number = '';
            
        return view('admin.conclusions.create', [
            //'conclusion_company' => $conclusion_company,
            'inspectors' => $inspectors,
            'conclusion_params' => $conclusion_params,
            'tape_number' => $tape_number,
            'conclusion_last' => $conclusion_last,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Yekaterinburg');
        $timeNow = date("d-m-Y H:i:s");
        $action = "Создал";
        
        $conclusion_params = ConclusionParam::where('user_id', Auth::id())
            ->first();
        if(empty($conclusion_params))
            ConclusionParam::create([
                'user_id' => Auth::id(),
                'inspector_id' => $request->inspector_id,
                'date' => $request->date,
                'date_next_verification' => $request->date_next_verification,
            ]);
        else
            ConclusionParam::where('user_id', Auth::id())->update([
                'user_id' => Auth::id(),
                'inspector_id' => $request->inspector_id,
                'date' => $request->date,
                'date_next_verification' => $request->date_next_verification,
            ]);
        if(isset($request->component_id)) {
            $componetnId = (int) $request->component_id;
            $workLocationId = (int) $request->work_location_id;
            $faciityId = (int) $request->facility_id;
            Component::where('id', $componetnId)->update([
                'work_location_id' => $workLocationId,
                'facility_id' => $faciityId
            ]);
        }
        $conclusion = Conclusion::create($request->all());
        if($request->has('diagramma_crimping_1'))
            $this->uploadDiagram($request->diagramma_crimping_1, $conclusion->id, 'diagramma_crimping_1');
        if($request->has('diagramma_crimping_2'))
            $this->uploadDiagram($request->diagramma_crimping_2, $conclusion->id, 'diagramma_crimping_2');
        if($request->has('diagramma_crimping_3'))
            $this->uploadDiagram($request->diagramma_crimping_3, $conclusion->id, 'diagramma_crimping_3');
        if($request->has('diagramma_calibration'))
            $this->uploadDiagram($request->diagramma_calibration, $conclusion->id, 'diagramma_calibration');
        if($request->has('diagramma_bgrp'))
            $this->uploadDiagram($request->diagramma_bgrp, $conclusion->id, 'diagramma_bgrp');
            
        $conclusion->user_id_update = Auth::user()->id;
        $conclusion->date_update = $timeNow;
        $conclusion->user_action = $action;
        $conclusion->save();
        return redirect()
            ->to(route('conclusions.index'))
            ->with('success', 'Заключение успешно добавлено');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $conclusion = Conclusion::findOrFail($id);
        // if(Auth::user()->role == 'Работник лаборатории') {
        //     $inspectorId = Auth::user()->inspector_id;
        //     $inspectors = Inspector::select('inspectors.*')
        //         ->leftJoin('users', 'inspectors.id', '=', 'users.inspector_id')
        //         ->where('users.inspector_id', $inspectorId)
        //         ->get();
        // } else {
        //     $inspectors = Inspector::orderBy('name', 'asc')
        //         ->get();
        // }
        
        $inspectors = Inspector::orderBy('name', 'asc')->get();
        $component = Component::where('id', $conclusion->component_id)->first();
        $work_locations = WorkLocation::where('company_id', $component->company_id)
            ->orderBy('name', 'asc')
            ->get();
        $facilities = Facility::where('company_id', $component->company_id)
            ->get();

        if (preg_match("/" . $component->company()->abbr . "_/i", $component->tape_number)) {
            $typeNumber = trim(str_replace($component->company()->abbr . '_', '', $component->tape_number));
        } else {
            $typeNumber = $component->tape_number;
        }
        
        return view('admin.conclusions.edit', [
            'conclusion' => $conclusion,
            'inspectors' => $inspectors,
            'work_locations' => $work_locations,
            'facilities' => $facilities,
            'typeNumber' => $typeNumber
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        date_default_timezone_set('Asia/Yekaterinburg');
        $timeNow = date("d-m-Y H:i:s");
        $action = "Обновил";
        $conclusion = Conclusion::findOrFail($id);
        if(isset($request->component_id)) {
            $componetnId = (int) $request->component_id;
            $workLocationId = (int) $request->work_location_id;
            $faciityId = (int) $request->facility_id;
            Component::where('id', $componetnId)->update([
                'work_location_id' => $workLocationId,
                'facility_id' => $faciityId
            ]);
        }
        $conclusion->update($request->all());
        if($request->passport) {
            $conclusion->update([
                'passport' => 1
            ]);
        } else {
            $conclusion->update([
                'passport' => 0
            ]);
        }
        if($request->repair) {
            $conclusion->update([
                'repair' => 1
            ]);
        } else {
            $conclusion->update([
                'repair' => 0
            ]);
        }
        if($request->no_passportization) {
            $conclusion->update([
                'no_passportization' => 1
            ]);
        } else {
            $conclusion->update([
                'no_passportization' => 0
            ]);
        }

        if($request->check_vik) {
            $conclusion->update([
                'check_vik' => 1
            ]);
        } else {
            $conclusion->update([
                'check_vik' => 0,
                'vik_result' => ''
            ]);
        }
        if($request->check_uzt) {
            $conclusion->update([
                'check_uzt' => 1
            ]);
        } else {
            $conclusion->update([
                'check_uzt' => 0,
                'uzt_result' => ''
            ]);
        }
        if($request->check_mk) {
            $conclusion->update([
                'check_mk' => 1
            ]);
        } else {
            $conclusion->update([
                'check_mk' => 0,
                'mk_result' => ''
            ]);
        }
        if($request->check_gi) {
            $conclusion->update([
                'check_gi' => 1
            ]);
        } else {
            $conclusion->update([
                'check_gi' => 0,
                'gi_result' => ''
            ]);
        }
        if($request->check_uzk) {
            $conclusion->update([
                'check_uzk' => 1
            ]);
        } else {
            $conclusion->update([
                'check_uzk' => 0,
                'uzk_result' => ''
            ]);
        }
        
        if(!$request->check_bgrp) {
            $conclusion->update([
                'coefficient' => ''
            ]);
        }
        if(!$request->check_calibration) {
            $conclusion->update([
                'calibration_pressure' => ''
            ]);
        }
        if(!$request->crimpingGi) {
            $conclusion->update([
                'diameter_plashki' => ''
            ]);
        }
        if($request->installing_tape) {
            $conclusion->update([
                'installing_tape' => 1
            ]);
        } else {
            $conclusion->update([
                'installing_tape' => 0
            ]);
        }
        $conclusion->update([
            'user_id_update' => Auth::user()->id,
            'date_update' => $timeNow,
            'user_action' => $action,
        ]);
        
        if($request->has('diagramma_crimping_1'))
            $this->uploadDiagram($request->diagramma_crimping_1, $conclusion->id, 'diagramma_crimping_1');
        if($request->has('diagramma_crimping_2'))
            $this->uploadDiagram($request->diagramma_crimping_2, $conclusion->id, 'diagramma_crimping_2');
        if($request->has('diagramma_crimping_3'))
            $this->uploadDiagram($request->diagramma_crimping_3, $conclusion->id, 'diagramma_crimping_3');
        if($request->has('diagramma_calibration'))
            $this->uploadDiagram($request->diagramma_calibration, $conclusion->id, 'diagramma_calibration');
        if($request->has('diagramma_bgrp'))
            $this->uploadDiagram($request->diagramma_bgrp, $conclusion->id, 'diagramma_bgrp');
        
        //dd($conclusion);
        return redirect()
            ->to(route('conclusions.index'))
            ->with('success', 'Информация успешно изменена');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conclusion = Conclusion::findOrFail($id);

        $conclusion->delete();

        return redirect()
            ->to(route('conclusions.index'))
            ->with('success', 'Заключение успешно удалёно');
    }
    
    /*
     * Получение данных по номеру ленты
     */
    public function get_data_on_type_number(Request $request)
    {
        $component = Component::where('tape_number', 'LIKE', '%'.$request->tape_number)
            ->first();

        if(!empty($component))
        {
            $type = Type::findOrFail($component->type_id);
            $company = Company::findOrFail($component->company_id);
            $work_locations = WorkLocation::where('company_id', $component->company_id)
                ->orderBy('id', 'desc')
                ->get();
            $current_work_location = WorkLocation::findOrFail($component->work_location_id);
            $facilities = Facility::where('company_id', $component->company_id)
                ->orderBy('id', 'desc')
                ->get();
            $current_facility = Facility::findOrFail($component->facility_id);;
            $lastConclusion = Conclusion::where('component_id', $component->id)
                ->orderBy('created_at', 'desc')
                ->first();

            $result['company'] = $company;
            $result['work_locations'] = $work_locations;
            $result['current_work_location'] = $current_work_location;
            $result['current_facility'] = $current_facility;
            $result['facilities'] = $facilities;
            $result['component'] = $component;
            $result['type'] = $type;
            $result['last_conclusion'] = $lastConclusion;

            return $result;
        } else
            return 'false';
    }

    /*
     * Поиск заключений. Применение фильтров
     */
    public function accept_filters(Request $request)
    {
        // компания
        if(isset($request->conclusions_company_id) && !empty($request->conclusions_company_id))
            session()->put('conclusions_company_id', $request->conclusions_company_id);
        else
            session()->forget('conclusions_company_id');
        // место проведения работ
        if(isset($request->conclusions_work_locations) && !empty($request->conclusions_work_locations))
            session()->put('conclusions_work_locations', $request->conclusions_work_locations);
        else
            session()->forget('conclusions_work_locations');
            // установка
        if(isset($request->conclusions_facilities) && !empty($request->conclusions_facilities))
            session()->put('conclusions_facilities', $request->conclusions_facilities);
        else
            session()->forget('conclusions_facilities');
        // дата заключения
        if(isset($request->conclusions_date) && !empty($request->conclusions_date))
            session()->put('conclusions_date', $request->conclusions_date);
        else
            session()->forget('conclusions_date');
        // номер ленты
        if(isset($request->conclusions_tape_number) && !empty($request->conclusions_tape_number))
            session()->put('conclusions_tape_number', $request->conclusions_tape_number);
        else
            session()->forget('conclusions_tape_number');
        // серийный номер
        if(isset($request->conclusions_serial_number) && !empty($request->conclusions_serial_number))
            session()->put('conclusions_serial_number', $request->conclusions_serial_number);
        else
            session()->forget('conclusions_serial_number');
        // Производители типа
        if(isset($request->type_manufacturers) && !empty($request->type_manufacturers))
            session()->put('type_manufacturers', $request->type_manufacturers);
        else
            session()->forget('type_manufacturers');
            
        return redirect()
            ->to(route('conclusions.index'));
    }

    /*
     * Поиск заключений. Сброс фильтров
     */
    public function reset_filters(Request $request)
    {
        session()->forget('conclusions_company_id');
        session()->forget('conclusions_work_locations');
        session()->forget('conclusions_facilities');
        session()->forget('conclusions_date');
        session()->forget('conclusions_tape_number');
        session()->forget('conclusions_serial_number');
        session()->forget('type_manufacturers');

        return redirect()
            ->to(route('conclusions.index'));
    }
    
    /*
     * Показать все заключения
     */
    public function show_all()
    {
        $conclusions = Conclusion::orderBy('id', 'desc')->get();

        $companies = Company::orderBy('name', 'asc')
            ->get();
        $stamp = Config::where('key', 'stamp')
            ->first();
        $signDirector = Config::where('key', 'signature_director')
            ->first();
        $signInspector = Config::where('key', 'signature_inspector')
            ->first();
        $ecp = Config::where('key', 'ecp')
            ->first();
        $companyId = Auth::user()->company_id;
        $selectCompany = Company::where('id', $companyId)
            ->get();
        // список заявок
        $orders = Order::orderBy('created_at', 'desc')
            ->get();
        
        session()->forget('conclusions_company_id');
        session()->forget('conclusions_work_locations');
        session()->forget('conclusions_facilities');
        session()->forget('conclusions_date');
        session()->forget('conclusions_tape_number');
        session()->forget('conclusions_serial_number');
        
        // $filter_work_locations = (session('conclusions_company_id')) ? $this->list_work_locations(session('conclusions_company_id')) : '';
        // $filter_facilities = (session('conclusions_company_id')) ? $this->list_facilities(session('conclusions_company_id')) : '';
        // $filter_dates = (session('conclusions_company_id')) ? $this->list_dates_conclusion(session('conclusions_dates'), session('conclusions_work_location_id'), session('conclusions_facility_id')) : '';

        return view('admin.conclusions.index', [
            'conclusions' => $conclusions,
            'companies' => $companies,
            // 'filter_work_locations' => $filter_work_locations,
            // 'filter_facilities' => $filter_facilities,
            // 'filter_dates' => $filter_dates,
            'ecp' => $ecp,
            'orders' => $orders,
            'stamp' => $stamp,
            'signDirector' => $signDirector,
            'signInspector' => $signInspector,
            'selectCompany' => $selectCompany
        ]);
    }

    /*
     * Получение информации для фильтра
     */
    public function get_info_for_filters(Request $request)
    {
        $result = [];
        $company_id = (!empty($request->company_id)) ? $request->company_id : '';
        $work_location_id = (!empty($request->work_locations)) ? $request->work_locations : '';
        $facility_id = (!empty($request->facilities)) ? $request->facilities : '';

        // список мест проведения работ
        $result['work_locations'] = $this->list_work_locations($company_id);
        // список установок
        $result['facilities'] = $this->list_facilities($company_id);
        // список дат
        $result['dates'] = $this->list_dates_conclusion($company_id, $work_location_id, $facility_id);

        return $result;
    }


    /*
     * Список мест проведения работ
     */
    public function list_work_locations($company_id)
    {
        $work_locations = WorkLocation::where('company_id', $company_id)
            ->orderBy('name', 'asc')
            ->get();

        return $work_locations;
    }


    /*
     * Список установок
     */
    public function list_facilities($company_id)
    {
        $facilities = Facility::where('company_id', $company_id)
            ->orderBy('id', 'asc')
            ->get();

        return $facilities;
    }


    /*
     * Список дат
     */
    public function list_dates_conclusion($company_id, $work_location_id, $facility_id)
    {
        // DB::connection()->enableQueryLog();

        $dates = Conclusion::select('conclusions.*')
            ->leftJoin('components', 'components.id', '=', 'conclusions.component_id');

        if(!empty($company_id))
            $dates = $dates->where('components.company_id', $company_id);
        if(!empty($work_location_id))
            $dates = $dates->where('components.work_location_id', $work_location_id);
        if(!empty($facility_id))
            $dates = $dates->where('components.facility_id', $facility_id);
            
        $dates = $dates->orderBy('date', 'desc')->groupBy('date')->get();

        // $dates = $dates->orderBy('date', 'desc')
        //     ->groupBy('date')
        //     ->get();

        // $queries = DB::getQueryLog();

        return $dates;
    }


    /*
     * Список заключений
     */
    public function list_conclusions()
    {
        if(Auth::user()->role == 'Администратор' || Auth::user()->role == 'Работник лаборатории')
        {
            $conclusions = Conclusion::select('conclusions.*')
                ->leftJoin('components', 'conclusions.component_id', '=', 'components.id');
            if(session('conclusions_company_id'))
                $conclusions = $conclusions->where('components.company_id', session('conclusions_company_id'));
            if(session('conclusions_work_locations'))
                $conclusions = $conclusions->where('components.work_location_id', session('conclusions_work_locations'));
            if(session('conclusions_facilities'))
                $conclusions = $conclusions->where('components.facility_id', session('conclusions_facilities'));
            if(session('conclusions_date'))
                $conclusions = $conclusions->where('conclusions.date', session('conclusions_date'));
            if(session('conclusions_tape_number'))
                $conclusions = $conclusions->where('components.tape_number', 'LIKE', '%' . session('conclusions_tape_number') . '%');
            if(session('conclusions_serial_number'))
                $conclusions = $conclusions->where('components.serial_number', session('conclusions_serial_number'));
            if(session('type_manufacturers')) {
                $types = Type::where('manufacturer', session('type_manufacturers'))->select('id')->get();
                foreach($types as $type)
                {
                    $arrayTypeId[] = $type->id;
                }
                $conclusions = $conclusions->whereIn('components.type_id', $arrayTypeId);
            }
            if(!empty(session('conclusions_company_id')) || !empty(session('conclusions_work_locations')) || !empty(session('conclusions_facilities')) || !empty(session('conclusions_date')) || !empty(session('conclusions_tape_number')) || !empty(session('conclusions_serial_number')) || !empty(session('type_manufacturers')))
             {
                 $conclusions = $conclusions->orderBy('id', 'desc')->limit(2000)->get();
             } else {
                 $conclusions = $conclusions->orderBy('id', 'desc')->limit(200)->get();
             }
        } else {
//            DB::enableQueryLog();

            $conclusions = Conclusion::select('conclusions.*')
                ->leftJoin('components', 'conclusions.component_id', '=', 'components.id')
                ->where('components.company_id', '=', Auth::user()->company_id);
            if(session('conclusions_work_locations'))
                $conclusions = $conclusions->where('components.work_location_id', session('conclusions_work_locations'));
            if(session('conclusions_facilities'))
                $conclusions = $conclusions->where('components.facility_id', session('conclusions_facilities'));
            if(session('conclusions_date'))
                $conclusions = $conclusions->where('conclusions.date', session('conclusions_date'));
            if(session('conclusions_tape_number'))
                $conclusions = $conclusions->where('components.tape_number', 'LIKE', '%' . session('conclusions_tape_number') . '%');
            if(session('conclusions_serial_number'))
                $conclusions = $conclusions->where('components.serial_number', session('conclusions_serial_number'));
            if(session('type_manufacturers')) {
                $types = Type::where('manufacturer', session('type_manufacturers'))->select('id')->get();
                foreach($types as $type)
                {
                    $arrayTypeId[] = $type->id;
                }
                $conclusions = $conclusions->whereIn('components.type_id', $arrayTypeId);
            }
            $conclusions = $conclusions->orderBy('id', 'desc')->limit(2000)->get();
            // if(!empty(session('conclusions_work_locations')) || !empty(session('conclusions_facilities')) || !empty(session('conclusions_date')) || !empty(session('conclusions_tape_number')) || !empty(session('conclusions_serial_number')))
            //  {
            //      $conclusions = $conclusions->orderBy('id', 'desc')->get();
            //  } else {
            //      $conclusions = $conclusions->orderBy('id', 'desc')->limit(200)->get();
            //  }

//            dd(DB::getQueryLog());

//            dd($conclusions);
        }

        return $conclusions;
    }


    /*
     * Печать лент
     */
    public function print_lengths()
    {
        $this->clear_print_catalog();

        $conclusions = $this->list_conclusions();
        $numbers = '';
        $filename = time().'.txt';
        foreach($conclusions as $conclusion)
            $numbers .= $conclusion->component()->tape_number . '.' . $conclusion->component()->date_start_expluatation.PHP_EOL;

        $dir = 'uploads/print_lengths';
        $dir_save = public_path($dir);

        file_put_contents($dir_save.'/'.$filename, $numbers);

        return response()
            ->download($dir.'/'.$filename, 'Для печати от '.date('d.m.Y_H-i-s').'.txt', ['location' => '/path_to_url']);
    }


    /*
     * Печать ленты
     */
    public function print_length($conclusion_id)
    {
        $this->clear_print_catalog();

        $conclusion = Conclusion::findOrFail($conclusion_id);
        $number = $conclusion->component()->tape_number;
        $filename = time().'.txt';

        $dir = 'uploads/print_lengths';
        $dir_save = public_path($dir);

        file_put_contents($dir_save.'/'.$filename, $number);

        return response()
            ->download($dir.'/'.$filename, 'Для печати.txt', ['location' => '/path_to_url']);
    }


    /*
     * Очистка каталога с файлами номеров лент
     */
    public function clear_print_catalog():void
    {
        $dir = public_path('uploads/print_lengths');
        $files = scandir($dir);
        foreach($files as $file)
            if($file != '.' && $file != '..')
                @unlink($dir.'/'.$file);
    }


    /*
     * Получение последнего заключения по указанному номеру ленты
     */
    public function get_last_conclusion_on_tape_number(Request $request)
    {
        $tape_number = trim($request->tape_number);
        $component = Component::where('tape_number', 'LIKE', '%' . $tape_number)
            ->first();
        if(!empty($component))
        {
            $last_conclusion = Conclusion::where('component_id', $component->id)
                ->orderBy('id', 'desc')
                ->first();
            if(!empty($last_conclusion))
            {
                $date_last_conclusion = strtotime($last_conclusion->date);
                $date_conclusion = strtotime($request->date);
                $year1 = 60*60*24*365; // 1 год
                $difference = $date_conclusion - $date_last_conclusion;
                if($difference > $year1)
                    return 'yes';
            }
        }

        return 'no';
    }

    /*
     * Получение заключения по указанному номеру ленты и датам
     */
    public function get_conclusion_on_tape_number_and_date(Request $request)
    {
        $tape_number = trim($request->tape_number);
        $component = Component::where('tape_number', 'LIKE', '%'.$tape_number)
            ->first();
        if(!empty($component))
        {
            $conclusionMatch = Conclusion::where([
                ['component_id', $component->id],
                ['date', $request->date],
                ['date_next_verification', $request->date_next_verification]
            ])->first();
            if(!empty($conclusionMatch))
            {
                $result['success'] = 'true';
                $result['conclusionMatchId'] = $conclusionMatch->id;
                return $result;
            } else {
                $result['success'] = 'false';
            }
        } else {
            $result['success'] = 'false';
        }
        return $result;
    }

    /*
     * Сохранение заключений в заявку
     */
    public function save_orders(Request $request)
    {
        $conclusions = (isset($request->conclusion_checked)) ? $request->conclusion_checked : [];
        $order_id = (int) $request->order_id;
        $order = Order::findOrFail($order_id);
        foreach($conclusions as $conclusion)
        {
            $check_exists = OrderConclusion::where('order_id', $order_id)
                ->where('conclusion_id', $conclusion)
                ->first();
            if(!empty($check_exists))
                continue;

            OrderConclusion::create([
                'order_id' => $order_id,
                'conclusion_id' => $conclusion,
            ]);
        }

        return redirect(route('conclusions.index'))
            ->with('success', 'Заключения успешно добавлены в заявку');
    }


    /*
     * История заключений
     */
    public function histories(Request $request)
    {
        $component_id = (int) $request->component_id;
        $response['conclusions'] = Conclusion::where('component_id', $component_id)
            ->orderBy('id', 'desc')
            ->get();

        foreach($response['conclusions'] as $conclusion)
        {
            $response['inspectors'][$conclusion->id] = $conclusion->inspector();
            $response['facilities'][$conclusion->id] = $conclusion->component()->facility();
            $response['user_id_update'][$conclusion->id] = $conclusion->user_id_update ? $conclusion->user() : '';
            $response['date_update'][$conclusion->id] = $conclusion->date_update ? $conclusion->date_update : '';
            $response['user_action'][$conclusion->id] = $conclusion->user_action ? $conclusion->user_action : '';
        }

        $response['component'] = Component::findOrFail($component_id);
        $response['type'] = Type::findOrFail($response['component']->type_id);

        return $response;
    }
    
    public function signToDB(Request $request){
        
        $signReady = $request->signReady;
        $conclusion_id = $request->conclusion_id;
        
        
        $path_full = public_path().'/pdf/'.$conclusion_id. '_passport_uzt_vik_mk_gi.pdf';
        $path_uri = '/pdf/'.$conclusion_id. '_passport_uzt_vik_mk_gi.pdf';
        $data = base64_decode($signReady);
        file_put_contents($path_full, $data);
        
        $conclusion = Conclusion::findOrFail($conclusion_id);
        $conclusion->update([
            'signReady' => $path_uri,
        ]);
        
        return $path_uri;
            
     }
     
    /*Очистка не подписанных пдф файлов*/
    public function clear_pdf_catalog($userId):void
    {
        $dir = public_path('pdf_not_sign/'.$userId);
        $files = scandir($dir);
        foreach($files as $file)
            if($file != '.' && $file != '..')
                @unlink($dir.'/'.$file);
    }
     
/*	Архивация выбранных подписанных заключений
*/	
    public function zipArchiveFile(Request $request)
    {
        $zip = new ZipArchive;
        $today = date("d-m-Y_H:i:s");
        $zipName = $today.'_archive.zip';
        $userId = Auth::id();
        $archiveDir = public_path('/archive/'.$userId).'/';
        if(!file_exists($archiveDir))
        {
            @mkdir($archiveDir, 0775, true);
        }

        if($zip->open($archiveDir.$zipName, ZipArchive::CREATE) === TRUE);
        {
            $conclusionIds = (isset($request->conclusion_checked)) ? $request->conclusion_checked : [];
            $files = File::files(public_path('pdf'));
            foreach($files as $key => $value)
            {
                $fileToZip = basename($value);
                foreach($conclusionIds as $conclusionId) 
                {
                   $conclusionIdSignReady = Conclusion::where('id', $conclusionId)->value('id');
                   if(isset($conclusionIdSignReady) && $fileToZip == $conclusionIdSignReady.'_passport_uzt_vik_mk_gi.pdf') 
                   {
                       $zip->addFile($value, $fileToZip);
                    }
                }
            }
            $zip->close();
        }
        if(file_exists($archiveDir.$zipName)) {
            $zipDowload = '/public/archive/' . $userId . '/' . $zipName;
            return $zipDowload;
            //return response()->download($archiveDir.$zipName)->deleteFileAfterSend(true);
            //return back();
        } else {
            return redirect(route('conclusions.index'))
                ->with('success', 'Не выбраны заключения для архива!');
        }
    }
    
    /*
        Скачивание архива не подписанных документов
    */
    public function zipArchiveNotSignFile(Request $request)
    {
        ini_set('max_execution_time', 300);
        $zip = new ZipArchive;
        $today = date("d-m-Y_H:i:s");
        $zipName = $today.'_archive.zip';
        $userId = Auth::id();
        $pdfDir = public_path('/pdf_not_sign/'.$userId).'/';
        if(!file_exists($pdfDir))
        {
            @mkdir($pdfDir, 0775, true);
        }

        $this->clear_pdf_catalog($userId);

        // создает директорию для архива
        $archiveDir = public_path('/archive_not_sign/'.$userId).'/';
        if(!file_exists($archiveDir))
        {
            @mkdir($archiveDir, 0775, true);
        }
        //sleep(5);
        //$conclusionIds = json_decode($request->conclusion_checked, true);
        $conclusionIds = (isset($request->conclusion_checked)) ? $request->conclusion_checked : [];
        foreach($conclusionIds as $conclusionId) 
        {
            $conclusion = Conclusion::findOrFail($conclusionId);
            $component = Component::findOrFail($conclusion->component_id);
            $type = Type::findOrFail($component->type_id);
            $company = Company::findOrFail($component->company_id);
            $inspector = Inspector::findOrFail($conclusion->inspector_id);
            
            // проведённые работы
            $conclusions = Conclusion::where('component_id', $component->id)
                ->where('date', '<=', $conclusion->date)
                // + 04.02.2026 
                ->orderBy('date', 'desc')
                ->take(4)
                // + 04.02.2026
                ->get()
                ->sortBy('date');
            $ecp = Config::where('key', 'ecp')->first();
            $header = Config::where('key', 'header_data')->first();
            $director = Config::where('key', 'director')->first();
            $stamp = Config::where('key', 'stamp')->first();
            $signDirector = Config::where('key', 'signature_director')->first();
            $signInspector = Config::where('key', 'signature_inspector')->first();
            
            $instruments_passport = Instrument::where('control_method', 'ВИК')->get();
            $gost_passport = Config::where('key', 'gost_passport')->first();
            $passport_purpose_passport = Config::where('key', 'passport_purpose')->first();
            
            if (preg_match("/$company->abbr" . "_/i", $component->tape_number)) {
                $typeNumber = trim(str_replace($company->abbr . '_', '', $component->tape_number));
            } else {
                $typeNumber = $component->tape_number;
            }
            
            $arr_create_pdf_data['conclusion'] = $conclusion;
            $arr_create_pdf_data['type'] = $type;
            $arr_create_pdf_data['company'] = $company;
            $arr_create_pdf_data['component'] = $component;
            $arr_create_pdf_data['inspector'] = $inspector;
            $arr_create_pdf_data['conclusions'] = $conclusions;
            $arr_create_pdf_data['ecp'] = $ecp;
            $arr_create_pdf_data['header'] = $header;
            $arr_create_pdf_data['director'] = $director;
            $arr_create_pdf_data['stamp'] = $stamp;
            $arr_create_pdf_data['signDirector'] = $signDirector;
            $arr_create_pdf_data['signInspector'] = $signInspector;
            
            $arr_create_pdf_data['instruments_passport'] = $instruments_passport;
            $arr_create_pdf_data['gost_passport'] = $gost_passport;
            $arr_create_pdf_data['passport_purpose_passport'] = $passport_purpose_passport;
            
            if(!empty($conclusion->uzt_result)){
                $gost_uzt = Config::where('key', 'gost_uzt')->first();
                $instruments_uzt = Instrument::where('control_method', 'УЗТ')->get();
                $arr_create_pdf_data['gost_uzt'] = $gost_uzt;
                $arr_create_pdf_data['instruments_uzt'] = $instruments_uzt;
            }
            
            if(!empty($conclusion->uzk_result)){
                $gost_uzk = Config::where('key', 'gost_uzk')->first();
                $instruments_uzk = Instrument::where('control_method', 'УЗК')->get();
                $arr_create_pdf_data['gost_uzk'] = $gost_uzk;
                $arr_create_pdf_data['instruments_uzk'] = $instruments_uzk;
            }
            
            if(!empty($conclusion->vik_result)){
                $instruments_vik = Instrument::where('control_method', 'ВИК')->get();
                $gost_vik = Config::where('key', 'gost_vik')->first();
                $arr_create_pdf_data['gost_vik'] = $gost_vik;
                $arr_create_pdf_data['instruments_vik'] = $instruments_vik;
            }
            
            if(!empty($conclusion->mk_result)){
                $gost_mk = Config::where('key', 'gost_mk')->first();
                $instruments_mk = Instrument::where('control_method', 'МК')->get();
                $arr_create_pdf_data['gost_mk'] = $gost_mk;
                $arr_create_pdf_data['instruments_mk'] = $instruments_mk;
            }
            
            if(!empty($conclusion->gi_result)){
                $instruments_gi = Instrument::where('control_method', 'ГИ')->get();
                $gost_gi = Config::where('key', 'gost_gi')->first();
                $arr_create_pdf_data['gost_gi'] = $gost_gi;
                $arr_create_pdf_data['instruments_gi'] = $instruments_gi;
            }
            
            if(!empty($conclusion->calibration_pressure)) {
                $gost_container = Config::where('key', 'gost_container')->first();
                $gost_armature = Config::where('key', 'gost_armature')->first();
                $gost_requirement = Config::where('key', 'gost_requirement')->first();
                $arr_create_pdf_data['gost_container'] = $gost_container;
                $arr_create_pdf_data['gost_armature'] = $gost_armature;
                $arr_create_pdf_data['gost_requirement'] = $gost_requirement;
            }
        
        //* 30.03.2024
        if(!empty($conclusion->coefficient) && $conclusion->coefficient == 1.5)
        {
            if(!empty($type->crimping_3))
            {
                $repCrimping3 = strripos($type->crimping_3, ',') ? str_replace(',', '.', $type->crimping_3) : $type->crimping_3;
                $crimping_3 = (float) $repCrimping3 * 1.5;
                $crimping_2 = $type->crimping_2;
            } elseif(!empty($type->crimping_2))
            {
                $repCrimping2 = strripos($type->crimping_2, ',') ? str_replace(',', '.', $type->crimping_2) : $type->crimping_2;
                $crimping_3 = (float) $repCrimping2 * 1.5;
                $crimping_2 = $type->crimping_2;
            } else {
                $repCrimping1 = strripos($type->crimping_1, ',') ? str_replace(',', '.', $type->crimping_1) : $type->crimping_1;
                $crimping_3 = '';
                $crimping_2 = (float) $repCrimping1 * 1.5;
            }
        } elseif(!empty($conclusion->coefficient) && $conclusion->coefficient == 2)
        {
             if(!empty($type->crimping_3))
            {
                $repCrimping3 = strripos($type->crimping_3, ',') ? str_replace(',', '.', $type->crimping_3) : $type->crimping_3;
                $crimping_3 = (float) $repCrimping3 * 2;
                $crimping_2 = $type->crimping_2;
            } elseif(!empty($type->crimping_2))
            {
                $repCrimping2 = strripos($type->crimping_2, ',') ? str_replace(',', '.', $type->crimping_2) : $type->crimping_2;
                $crimping_3 = (float) $repCrimping2 * 2;
                $crimping_2 = $type->crimping_2;
            } else {
                $repCrimping1 = strripos($type->crimping_1, ',') ? str_replace(',', '.', $type->crimping_1) : $type->crimping_1;
                $crimping_3 = '';
                $crimping_2 = (float) $repCrimping1 * 2;
            }
        } elseif(!empty($conclusion->coefficient) && $conclusion->coefficient == 1.25)
        {
             if(!empty($type->crimping_3))
            {
                $repCrimping3 = strripos($type->crimping_3, ',') ? str_replace(',', '.', $type->crimping_3) : $type->crimping_3;
                $crimping_3 = (float) $repCrimping3 * 1.25;
                $crimping_2 = $type->crimping_2;
            } elseif(!empty($type->crimping_2))
            {
                $repCrimping2 = strripos($type->crimping_2, ',') ? str_replace(',', '.', $type->crimping_2) : $type->crimping_2;
                $crimping_3 = (float) $repCrimping2 * 1.25;
                $crimping_2 = $type->crimping_2;
            } else {
                $repCrimping1 = strripos($type->crimping_1, ',') ? str_replace(',', '.', $type->crimping_1) : $type->crimping_1;
                $crimping_3 = '';
                $crimping_2 = (float) $repCrimping1 * 1.25;
            }
        } else {
            $crimping_3 = '';
            $crimping_2 = '';
        }
 
         //* 31.03.2024
        if(!empty($component->type()->pressure))
        {
            $repCrimpingMain = strripos($component->type()->pressure, ',') ? str_replace(',', '.', $component->type()->pressure) : $component->type()->pressure;
            if(!empty($conclusion->coefficient) && $conclusion->coefficient == 1.5)
            {
                $crimping = (float) $repCrimpingMain * 1.5;
            } elseif(!empty($conclusion->coefficient) && $conclusion->coefficient == 2)
            {
                // $repCrimpingMain = strripos($component->type()->pressure, ',') ? str_replace(',', '.', $component->type()->pressure) : $component->type()->pressure;
                $crimping = (float) $repCrimpingMain * 2;
            } elseif(!empty($conclusion->coefficient) && $conclusion->coefficient == 1.25) {
                // $repCrimpingMain = strripos($component->type()->pressure, ',') ? str_replace(',', '.', $component->type()->pressure) : $component->type()->pressure;
                $crimping = (float) $repCrimpingMain * 1.25;
            } else {
                $crimping = (float) $repCrimpingMain * 1.5;
            }
        } else {
            $crimping = '';
        }
        
            $arr_create_pdf_data['crimping_2'] = $crimping_2;
            $arr_create_pdf_data['crimping_3'] = $crimping_3;
            $arr_create_pdf_data['crimping'] = $crimping;
            
            if(!empty($conclusion->calibration_pressure)){
                $fixPressure = round((int)$conclusion->calibration_pressure * 0.04 + (int)$conclusion->calibration_pressure, 1);
            } else {
                $fixPressure = '';
            }
            
            $arr_create_pdf_data['fixPressure'] = $fixPressure;
            $arr_create_pdf_data['typeNumber'] = $typeNumber;
            //dd($arr_create_pdf_data);
            // замена / в директории
            $specSimbols = array('\\', '/', '|');
            $typeNumberName = str_replace($specSimbols, '_', $component->tape_number);
            $pdf = PDF::loadView('admin.reports.passport_uzt_vik_mk_gi_pdf', $arr_create_pdf_data);    
            $pdf_name = $conclusionId. '_' . $typeNumberName . '_' . $conclusion->date . '.pdf';

            // сохраняет pdf в директорию
            $pdf->save($pdfDir.$pdf_name);

        }

        if($zip->open($archiveDir.$zipName, ZipArchive::CREATE) === TRUE);
        {
            $files = File::files(public_path('pdf_not_sign/'.$userId));
            foreach($files as $key => $value)
            {
                $fileToZip = basename($value);
                $zip->addFile($value, $fileToZip);
            }
            $zip->close();
        }
        if(file_exists($archiveDir.$zipName)) {
            //dd($response);
            // $headers = [
            //     'Content-Type' => 'application/zip',
            // ];
            $zipDowload = '/public/archive_not_sign/' . $userId . '/' . $zipName;
            return $zipDowload;
            //$zipDowload = $archiveDir.$zipName;
            //return response()->download($zipDowload, $zipName, $headers)->deleteFileAfterSend(true);
            //return back();
            return File::delete(public_path($archiveDir));
        } else {
            return redirect(route('conclusions.index'))
                ->with('success', 'Не выбраны заключения для архива!');
        }
    }
    
}
