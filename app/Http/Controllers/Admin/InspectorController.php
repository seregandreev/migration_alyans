<?php

namespace App\Http\Controllers\Admin;

use App\Models\Inspector;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InspectorController extends Controller
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
        $inspectors = Inspector::orderBy('id', 'desc')
            ->get();

        return view('admin.inspectors.index', [
            'inspectors' => $inspectors,
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
        return view('admin.inspectors.create');
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
        $inspector = Inspector::create($request->all());
            $this->upload($request, $inspector);

        return redirect()
            ->to(route('inspectors.index'))
            ->with('success', 'Инспектор успешно добавлен');
    }
    
    /*
     * загрузка удостоверения
     */
    public function upload($request, $item):void
    {
        $this->check_permission();
        $filename_inspector = 'scan_document.pdf';
        $filename_sign = 'signInspector.png';
        // путь к файлу
        $file_path_inspector = public_path().'/inspectors_data/'.$item->id.'/'.$filename_inspector;
        $file_path_sign = public_path().'/inspectors_data/'.$item->id.'/'.$filename_sign;

        if($request->has('scan_document')) {
            if(file_exists($file_path_inspector))
            {
                @unlink($file_path_inspector);
            }
            $file_inspector = $request->file('scan_document');
            $file_inspector->move(public_path().'/inspectors_data/'.$item->id, $filename_inspector);
        }

        if($request->has('signInspector')) {
            if(file_exists($file_path_sign))
            {
                @unlink($file_path_sign);
            }
            $file_sign = $request->file('signInspector');
            $file_sign->move(public_path().'/inspectors_data/'.$item->id, $filename_sign);
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
        $inspector = Inspector::findOrFail($id);

        return view('admin.inspectors.edit', [
            'inspector' => $inspector,
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
        $inspector = Inspector::findOrFail($id);
        $inspector->update($request->all());

        $this->upload($request, $inspector);

        return redirect()
            ->to(route('inspectors.index'))
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
        $inspector = Inspector::findOrFail($id);

        $inspector->delete();

        return redirect()
            ->to(route('inspectors.index'))
            ->with('success', 'Инспектор успешно удалён');
    }
}
