<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmRegister;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
     * Регистрация
     */
    public function create()
    {
        return view('auth.register');
    }

    /*
     * Сохранение пользователя в базе
     */
    public function store(Request $request)
    {
        $password = Str::random(11);
        $request->validate([
            'g-recaptcha-response' => 'required|captcha'
        ]);
        $user = User::create([
            'company_on_register' => $request->company_on_register,
            'fio' => $request->fio,
            'position' => $request->position,
            'email' => $request->email,
            'phone' => $request->phone,
            'name' => $request->name,
            'password' => Hash::make($password),
            'remember_password' => $password,
            //['email'], 'unique', 'targetClass' => User::class, 'message' => 'Пользователь уже существует',
        ]);
        // оповещение администратора о новом зарегистрированном пользователе
        Mail::to('system@alyansekspert.ru')->send(new ConfirmRegister($user));

        return redirect()
            ->to(route('register.create'))
            ->with('register_success', 'Ваша заявка успешно отправлена! В скором времени Вы получите уведомление на e-mail адрес с доступами к системе');
    }
}
