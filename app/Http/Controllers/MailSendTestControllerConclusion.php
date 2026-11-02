<?php

namespace App\Http\Controllers;

use App\Models\Alarm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use Mail;
use App\Models\Inspector;
use App\User;
use App\Models\Component;
use App\Models\Company;
use App\Models\Conclusion;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;

class MailSendTestControllerConclusion extends Controller
{
    public function send()
    {
        // оповещение по заключениям
        $current_time = time();
        $month1 = 60*60*24*30;
        $users = User::where('role', 'Пользователь')->get();
        foreach($users as $user)
        {
            if($user->company_id != null)
            {
                $components = Component::where('company_id', $user->company_id)
                    ->orderBy('id', 'asc')
                    ->get();
                if(isset($components))
                {
                    foreach($components as $component)
                    {
                        $conclusions = Conclusion::where('component_id', $component->id)
                            ->orderBy('id', 'asc')
                            ->get();
                        if(isset($conclusions))
                        {
                            foreach($conclusions as $conclusion)
                            {
                                $date_verify = strtotime($conclusion->date_next_verification);
                                $max_date = $date_verify - $month1;
                                if($max_date < $current_time || $date_verify < $current_time)
                                {
                                    $conclusionIds[] = $conclusion->id;
                                }
                            }                            
                        } else {
                            $conclusionIds = [];
                        }
                    }                   
                } else {
                    $conclusionIds = [];
                }
                
                $userCompany = Company::where('id', $user->company_id)->first();
                if(isset($conclusionIds) && count($conclusionIds) > 0)
                {
                    $userCompanyIds[] = $userCompany->id;
                    $emails = "s.andrk@yandex.ru";
                    $userCompanyNames[] = $userCompany->name;
                    $cntConclusionIds[] = count($conclusionIds);
                }
                
            }
            $conclusionIds = [];
        }
        
        if(isset($cntConclusionIds) && count($cntConclusionIds) > 0)
            {
                $userCompanyIds = array_unique($userCompanyIds);
                foreach($userCompanyIds as $value)
                {
                    $userCompanyIds[] = $value;
                }
                $cntConclusionIds = array_unique($cntConclusionIds);
                foreach($cntConclusionIds as $value)
                {
                    $cntConclusionIds[] = $value;
                }
                $userCompanyNames = array_unique($userCompanyNames);
                foreach($userCompanyNames as $value)
                {
                    $userCompanyNames[] = $value;
                }
                $dataConclusionsVerif = [
                        'userCompanyIds' => $userCompanyIds,
                        'cnts' => $cntConclusionIds,
                        'userCompanyNames' => $userCompanyNames,
                    ];
                    
            $inspectors = User::where('role', 'Работник лаборатории')->get();
            // foreach($inspectors as $inspector)
            // {
            //     $name = $inspector->name;
            //     $email = $inspector->email;
            //     Mail::send('mail.alarmConclusionInspectors', ['$dataConclusionsVerif' => $dataConclusionsVerif], function($message) use ($name, $email) {
            //         $message->from('system@alyansekspert.ru', 'ООО АльянсЭксперт');
            //         $message->to($email, $name)->subject('Выполнить заключения');
            //     });
            // }
            }
        
        // print_r($cntConclusionIds);

        // dd($dataConclusionsVerif);

        return view('mail.alarmConclusionInspectors', [
            'dataConclusionsVerif' => $dataConclusionsVerif,
        ]);     
    }

}