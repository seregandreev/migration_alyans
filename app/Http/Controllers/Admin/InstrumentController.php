<?php

namespace App\Http\Controllers\Admin;

use App\Models\Instrument;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\InstrumentFilter;
use App\Http\Controllers\Admin\InstrumentFilters;
use App\Http\Requests\InstrumentsFilterRequest;
use Response;
use Illuminate\Support\Facades\Auth;

class InstrumentController extends Controller
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
    public function index(Request $request)
    {
        $this->check_permission();
        /*$instruments = Instrument::orderBy('id', 'desc')
            ->paginate(15);*/
        //dd($request->all());

        $productQuery = Instrument::query();
        if ($request->filled('search_field')){
            $productQuery->where('name', 'LIKE', '%'.$request->search_field.'%');
        }
        if ($request->filled('control_method')){
            $productQuery->where('control_method', $request->control_method);
        }
        if ($request->has('is_active')){
            $productQuery->where('yes_instrument',  $request->is_active);
        } 
        $instruments = $productQuery->get();
        //$instruments = $productQuery->paginate(15)->withPath("?" . $request->getQueryString());
        //$instruments = Instrument::all()->paginate(15);

        return view('admin.instruments.index', compact(['instruments']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->check_permission();
        return view('admin.instruments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->check_permission();
        $instrument = Instrument::create($request->all());

        //if($request->has('scan_instrument') || $request->has('scan_sertificate'))
        //  $this->upload($request, $instrument);
            
        if($request->has('scan_instrument'))
        {
            $this->upload($request->scan_instrument, $instrument->id, 'scan_passport');
            $ext = $request->scan_instrument->getClientOriginalExtension();
            $pathFilePassport = '/instruments_data/'.$instrument->id.'/scan_passport.'.$ext;
            $instrument->scan_passport = $pathFilePassport;
        }

        if($request->has('scan_sertificate'))
        {
            $this->upload($request->scan_sertificate, $instrument->id, 'scan_sertificate');
            $ext = $request->scan_sertificate->getClientOriginalExtension();
            $pathFileCert = '/instruments_data/'.$instrument->id.'/scan_sertificate.'.$ext;
            $instrument->scan_sertificate = $pathFileCert;
        }
        $instrument->save();
        return redirect()
            ->to(route('instruments.index'))
            ->with('success', 'Инструмент успешно добавлен');
    }


    /*
     * загрузка изображения инструмента
     */
    public function upload($scan, $instrument_id, $type_scan):void
    {
        $this->check_permission();
        $instrument = Instrument::findOrFail($instrument_id);
        // путь к документу
        $document_path = public_path('/instruments_data/'.$instrument_id.'/');
        $ext = $scan->getClientOriginalExtension();
        // если не создана директория - создаём её
        @mkdir($document_path);
        // если остался старый файл - удаляем его
        if(file_exists($document_path.$type_scan.'.'.$ext))
        {
            @unlink($document_path.$type_scan.'.'.$ext);
        }
        $scan->move($document_path, $type_scan.'.'.$ext);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->check_permission();
        $instrument = Instrument::findOrFail($id);

        return view('admin.instruments.edit', [
            'instrument' => $instrument,
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
        $this->check_permission();
        $instrument = Instrument::findOrFail($id);
        $instrument->update($request->all());
        
        if($request->yes_instrument) {
            $instrument->update([
                'yes_instrument' => 1
            ]);
        } else {
            $instrument->update([
                'yes_instrument' => 0
            ]);
        }

        //if($request->has('scan_instrument') || $request->has('scan_sertificate'))
            //$this->upload($request, $instrument);
            
        if($request->has('scan_instrument'))
        {
            $this->upload($request->scan_instrument, $instrument->id, 'scan_passport');
            $ext = $request->scan_instrument->getClientOriginalExtension();
            $pathFilePassport = '/instruments_data/'.$instrument->id.'/scan_passport.'.$ext;
            $instrument->update([
                'scan_passport' => $pathFilePassport,
            ]);
        }

        if($request->has('scan_sertificate'))
        {
            $this->upload($request->scan_sertificate, $instrument->id, 'scan_sertificate');
            $ext = $request->scan_sertificate->getClientOriginalExtension();
            $pathFileCert = '/instruments_data/'.$instrument->id.'/scan_sertificate.'.$ext;
            $instrument->update([
                'scan_sertificate' => $pathFileCert,
            ]);
        }
            
        return redirect()
            ->to(route('instruments.index'))
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
        $this->check_permission();
        $instrument = Instrument::findOrFail($id);
        $instrument->delete();

        return redirect()
            ->to(route('instruments.index'))
            ->with('success', 'Инструмент успешно удалён');
    }
}
