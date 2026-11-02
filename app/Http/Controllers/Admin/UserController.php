<?php

namespace App\Http\Controllers\Admin;

use App\Models\Unit;
use App\User;
use App\Models\Company;
use App\Models\WorkLocation;
use App\Models\Inspector;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function check_permission()
    {
        if(Auth::user()->role == 'Пользователь')
            abort(403);
    }
        
    public function checkPermissionEdit()
    {
        if(Auth::user()->role == 'Работник лаборатории')
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
        $users = User::orderBy('id', 'desc')->get();
        
        return view('admin.users.index', [
            'users' => $users,
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
        $companies = Company::orderBy('name', 'asc')
            ->get();
        $inspectors = Inspector::orderBy('name', 'asc')
            ->get();

        $locations = WorkLocation::orderBy('name', 'asc')
            ->get();

        return view('admin.users.create', [
            'companies' => $companies,
            'locations' => $locations,
            'inspectors' => $inspectors
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
        $this->check_permission();
        $request->merge([
            'password' => Hash::make($request->remember_password),
            'bases_list' => json_encode($request->bases_list, true),
        ]);
        $user = User::create($request->all());

        if($request->has('avatar'))
            $this->uploadAvatar($request, $user);

        return redirect()->to(route('users.index'))->with('success', 'Пользователь успешно добавлен');
    }

    /*
     * загрузка логотипа
     */
    public function uploadAvatar($request, $item):void
    {
        $this->check_permission();
        $filename = $item->id.'.jpg';

        // путь к файлу
        $file_path = public_path().'/avatars/'.$filename;
        // если остался старый файл - удаляем его
        if(file_exists($file_path))
        {
            @unlink($file_path);
        }

        $file = $request->file('avatar');
        $file->move(public_path().'/avatars', $filename);
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
        $this->checkPermissionEdit();
        $companies = Company::orderBy('name', 'asc')
            ->get();
        $inspectors = Inspector::orderBy('name', 'asc')
            ->get();
        $user = User::findOrFail($id);
        $locations = WorkLocation::where('company_id', $user->company_id)
            ->orderBy('name', 'asc')
            ->get();
        // $locations = WorkLocation::orderBy('name', 'asc')
        //     ->get();
        return view('admin.users.edit', [
            'user' => $user,
            'companies' => $companies,
            'locations' => $locations,
            'inspectors' => $inspectors
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
        $this->checkPermissionEdit();
        $user = User::findOrFail($id);
        $request->merge([
            'password' => Hash::make($request->remember_password),
            'bases_list' => json_encode($request->bases_list, true),
        ]);

        $user->update($request->all());

        if($request->has('avatar'))
            $this->uploadAvatar($request, $user);

        return redirect()
            ->to(route('users.index'))
            ->with('status', 'Информация успешно изменена');
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
        $this->checkPermissionEdit();
        $user = User::findOrFail($id);
        $user->delete();

        // удаляем аватар, если он был
        if(file_exists(public_path('avatars/'.$user->id.'.jpg')))
            unlink(public_path('avatars/'.$user->id.'.jpg'));

        return redirect()
            ->to(route('users.index'))
            ->with('success', 'Пользователь успешно удалён');
    }
    
    
    /*
     * проверка пользователя на существование
     */
    public function checkExistUser(Request $request)
    {
        $this->check_permission();
        $user = User::where('email', strtolower($request->login))
            ->first();

        if(!empty($user))
            return 'true';
        else
            return 'false';
    }
    
    /*
     * Возвращает список мест проведения работ
     */
    public function get_work_locations(Request $request)
    {
        $company_id = (int) $request->company_id;

        $locations = WorkLocation::where('company_id', $company_id)
            ->orderBy('name', 'asc')
            ->get();

        return $locations;
    }
    
    /*
     * Блокировка пользователя
    */
    public function blocking_user(Request $request)
    {
        $this->check_permission();
        $this->checkPermissionEdit();
        User::where('id', $request->userId)->update([
            'blocking' => $request->blocking,
        ]);
    }
}
