<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransportController extends Controller
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
        $transports = Transport::orderBy('id', 'desc')
            ->get();

        return view('admin.transports.index', [
            'transports' => $transports,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->check_permission();
        return view('admin.transports.create');
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
        $transport = Transport::create($request->all());

        //if($request->has('scan_inspection') || $request->has('scan_insurance'))
        $this->upload($request, $transport);

        return redirect()
            ->to(route('transports.index'))
            ->with('success', 'Транспорт успешно добавлен');
    }

    /*
     * загрузка удостоверения
     */
    public function upload($request, $item):void
    {
        $filename_inspection = 'scan_inspection.pdf';
        $filename_insurance = 'scan_insurance.pdf';
        // путь к файлу
        $file_path_inspection = public_path().'/transports_data/'.$item->id.'/'.$filename_inspection;
        $file_path_insurance = public_path().'/transports_data/'.$item->id.'/'.$filename_insurance;

        if($request->has('scan_inspection')) {
            // если остался старый файл - удаляем его
            if(file_exists($file_path_inspection))
            {
                @unlink($file_path_inspection);
            }

        $file_inspection = $request->file('scan_inspection');
        $file_inspection->move(public_path().'/transports_data/'.$item->id, $filename_inspection);
        }

        if($request->has('scan_insurance')) {
            if(file_exists($file_path_insurance))
            {
                @unlink($file_path_insurance);
            }
            $file_insurance = $request->file('scan_insurance');
            $file_insurance->move(public_path().'/transports_data/'.$item->id, $filename_insurance);
        }
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
        $transport = Transport::findOrFail($id);

        return view('admin.transports.edit', [
            'transport' => $transport,
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
        $transport = Transport::findOrFail($id);
        $transport->update($request->all());
        $this->upload($request, $transport);

        return redirect()
            ->to(route('transports.index'))
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
        $transport = Transport::findOrFail($id);

        $transport->delete();

        return redirect()
            ->to(route('transports.index'))
            ->with('success', 'Транспорт успешно удалён');
    }
}