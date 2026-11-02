<?php

namespace App\Http\Controllers\Admin;

use App\Models\Driver;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    public function check_permission()
    {
        if(Auth::user()->role == 'Пользователь')
            abort(403);
    }
    
    public function index()
    {
        $this->check_permission();
        $drivers = Driver::orderBy('name', 'asc')
            ->get();

        return view('admin.drivers.index', [
            'drivers' => $drivers,
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
        return view('admin.drivers.create');
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
        $driver = Driver::create($request->all());
            $this->upload($request, $driver);

        return redirect()
            ->to(route('drivers.create'))
            ->with('success', 'Водитель успешно добавлен');
    }
    
    /*
     * загрузка удостоверения
     */
    public function upload($request, $item):void
    {
        $filename_driver = 'scan_document.pdf';
        // путь к файлу
        $file_path_driver = public_path().'/drivers_data/'.$item->id.'/'.$filename_driver;
        if($request->has('scan_document')) {
            if(file_exists($file_path_driver))
            {
                @unlink($file_path_driver);
            }
            $file_driver = $request->file('scan_document');
            $file_driver->move(public_path().'/drivers_data/'.$item->id, $filename_driver);
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
        $driver = Driver::findOrFail($id);

        return view('admin.drivers.edit', [
            'driver' => $driver,
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
        $driver = Driver::findOrFail($id);
        $driver->update($request->all());

        $this->upload($request, $driver);

        return redirect()
            ->to(route('drivers.index'))
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
        $driver = Driver::findOrFail($id);

        $driver->delete();

        return redirect()
            ->to(route('drivers.index'))
            ->with('success', 'Водитель успешно удалён');
    }
}
