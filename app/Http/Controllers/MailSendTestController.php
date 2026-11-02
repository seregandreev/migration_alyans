<?php

namespace App\Http\Controllers;

use App\Models\Alarm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use Mail;
use App\Models\Inspector;
use App\User;
use App\Models\Instrument;

class MailSendTestController extends Controller
{
    public function send()
    {
        // оповещение инспекторов оканчание поверки инструментов
        $date = time();
        $instruments = Instrument::orderBy('id', 'desc')->get();
        //$dataInstruments = [];
        foreach($instruments as $instrument) 
        {
            //dd($instrument->name);
            $instrumentValidity = strtotime($instrument->next_verification_date);
            if($instrumentValidity < $date) 
            {
                $names[] = $instrument->name;
                $models[] = $instrument->model;
                $methods[] = $instrument->control_method;
                $sertificate_numbers[] = $instrument->sertificate_number;
                $next_verification_dates[] = $instrument->verification_date;
                $ids[] = $instrument->id;
            }
        }
        
        $dataInstruments = [
            'names' => $names,
            'models' => $models,
            'methods' => $methods,
            'sertificate_numbers' => $sertificate_numbers,
            'next_verification_dates' => $next_verification_dates,
            'ids' => $ids,
        ];
            if(!empty($dataInstruments['names']) && count($dataInstruments['names']) > 0) {
                $users = User::where('role', 'Работник лаборатории')->get();
                foreach($users as $user)
                {
                    $name = $user->name;
                    $email = $user->email;
                    // Mail::send('mail.alarmInstrument', $dataInstruments, function($message) use ($name, $email) {
                    //     $message->to($email, $name)
                    //         ->subject('Дата поверки инструмента');
                    //     $message->from('system@alyansekspert.ru', 'ООО АльянсЭксперт');
                    // });
                }
            };
        
        return view('mail.alarmInstrument', [
            'dataInstruments' => $dataInstruments,
            'users' => $users,
            // 'names' => $names,
            // 'models' => $models,
            ]);        
    }

}