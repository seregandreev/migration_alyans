<?php

namespace App\Http\Controllers\Admin;

use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ConfigController extends Controller
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
        $configs = Config::orderBy('id', 'desc')->get();
        $stamp = Config::where('key', 'stamp')->value('picture');
        $ecpPrint = Config::where('key', 'ecp')->value('picture');
        $signDirector = Config::where('key', 'signature_director')->value('picture');

        return view('admin.configs.index', [
            'configs' => $configs,
            'stamp' => $stamp,
            'ecpPrint' => $ecpPrint,
            'signDirector' => $signDirector,
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
        return view('admin.configs.create');
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
        Config::create($request->all());

        return redirect()
            ->to(route('configs.index'))
            ->with('success', 'Параметр успешно добавлен');
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
        $config = Config::findOrFail($id);

        return view('admin.configs.edit', [
            'config' => $config,
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
        $config = Config::findOrFail($id);

        $config->update($request->all());

        return redirect()
            ->to(route('configs.index'))
            ->with('success', 'Информация успешно обновлена');
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
        $config = Config::findOrFail($id);
        $config->delete();

        return redirect()
            ->to(route('configs.index'))
            ->with('success', 'Параметр успешно удалён');
    }

        /*
     * Смена значения печати на всех заключениях (при печати заключений)
     */
    public function stamp_change(Request $request)
    {
        $this->check_permission();
        Config::where('key', 'stamp')->update([
            'value' => $request->stamp_value,
        ]);
    }

    /*
     * Смена значения факсимиле директора на всех заключениях (при печати заключений)
     */
    public function signDirector_change(Request $request)
    {
        $this->check_permission();
        Config::where('key', 'signature_director')->update([
            'value' => $request->sign_director,
        ]);
    }

    /*
     * Смена значения факсимиле директора на всех заключениях (при печати заключений)
     */
    public function signInspector_change(Request $request)
    {
        $this->check_permission();
        Config::where('key', 'signature_inspector')->update([
            'value' => $request->sign_inspector,
        ]);
    }

    /*
     * Смена значения отпечатка ЭЦП на всех заключениях (при печати заключений)
     */
    public function ecpPrint_change(Request $request)
    {
        $this->check_permission();
        Config::where('key', 'ecp')->update([
            'value' => $request->ecp_value,
        ]);
    }


    /*
     * загрузка изображений
     */
    public function uploadSignDiretor(Request $request)
    {
        $file = $request->file('signDirector');
        $ext = $file->getClientOriginalExtension();
        $filename = 'signDirector'.'.'.$ext;
        // путь к файлу
        $file_path = public_path().'/config_data/'.$filename;
        $pathInDB = 'config_data/'.$filename;
        if($request->has('signDirector')) {
            // если остался старый файл - удаляем его
            if(file_exists($file_path))
            {
                @unlink($file_path);
            }

        $file->move(public_path().'/config_data/', $filename);
        Config::where('key', 'signature_director')->update([
            'picture' => $pathInDB,
        ]);
        }
    }

    public function uploadStamp(Request $request)
    {
        $file = $request->file('stamp');
        $ext = $file->getClientOriginalExtension();
        $filename = 'stamp'.'.'.$ext;
        // путь к файлу
        $file_path = public_path().'/config_data/'.$filename;
        $pathInDB = 'config_data/'.$filename;
        if($request->has('stamp')) {
            // если остался старый файл - удаляем его
            if(file_exists($file_path))
            {
                @unlink($file_path);
            }

        $file->move(public_path().'/config_data/', $filename);
        Config::where('key', 'stamp')->update([
            'picture' => $pathInDB,
        ]);
        }
    }

    public function uploadEcpPrint(Request $request)
    {
        $file = $request->file('ecpPrint');
        $ext = $file->getClientOriginalExtension();
        $filename = 'ecpPrint'.'.'.$ext;
        // путь к файлу
        $file_path = public_path().'/config_data/'.$filename;
        $pathInDB = 'config_data/'.$filename;
        if($request->has('ecpPrint')) {
            // если остался старый файл - удаляем его
            if(file_exists($file_path))
            {
                @unlink($file_path);
            }

        $file->move(public_path().'/config_data/', $filename);
        Config::where('key', 'ecp')->update([
            'picture' => $pathInDB,
        ]);
        }
    }
}
