<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Storage;
use File;
use Mail;
use App\User;
use App\Models\Instrument;
use App\Models\Inspector;
use App\Models\Component;
use App\Models\Company;
use App\Models\Conclusion;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // \App\Console\Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            File::cleanDirectory(public_path('archive'));
            File::cleanDirectory(public_path('archive_not_sign'));

            // оповещение инспекторов оканчания срока действия сертификата
            $inspectors = Inspector::orderBy('id', 'desc')->get();
            $date = time();
            $current_time = time();
            $month1 = 60*60*24*30;
            foreach($inspectors as $inspector)
            {
                $document_validity = strtotime($inspector->document_validity);
                if($document_validity < $date)
                {
                    $user = User::where('inspector_id', $inspector->id)->first();
                    $name = $user->name;
                    $email = $user->email;
                    $data = array("name" => $name, "body" => "Просрочен документ сертификации $inspector->document_validity. Необходимо продление");
                    Mail::send('mail.alarm', $data, function($message) use ($name, $email) {
                        $message->to($email, $name)
                            ->subject('Просрочен документ у инспектора');
                        $message->from('system@alyansekspert.ru', 'ООО АльянсЭксперт');
                    });
                }
            }
            
            // оповещение инспекторов оканчание поверки инструментов
            $instruments = Instrument::orderBy('id', 'desc')->get();
            $dataInstruments = [];
            foreach($instruments as $instrument) 
            {
                //$instrumentValidity = strtotime($instrument->next_verification_date);
                $instrumentValidity = strtotime($instrument->next_verification_date);
                $max_date = $instrumentValidity - $month1;
                if($max_date < $current_time || $instrumentValidity < $current_time) 
                {
                    $names[] = $instrument->name;
                    $models[] = $instrument->model;
                    $methods[] = $instrument->control_method;
                    $sertificate_numbers[] = $instrument->sertificate_number;
                    $next_verification_dates[] = $instrument->next_verification_date;
                    $ids[] = $instrument->id;
                }
            }
            
            if(isset($names) && count($names) > 0)
            {
                $dataInstruments = [
                    'names' => $names,
                    'models' => $models,
                    'methods' => $methods,
                    'sertificate_numbers' => $sertificate_numbers,
                    'next_verification_dates' => $next_verification_dates,
                    'ids' => $ids,
                ];
            } else {
                $dataInstruments = [];
            }
            if(!empty($dataInstruments) && count($dataInstruments) > 0) {
                $users = User::where('role', 'Работник лаборатории')->get();
                foreach($users as $user)
                {
                    $name = $user->name;
                    $email = $user->email;
                    Mail::send('mail.alarmInstrument', ['dataInstruments' => $dataInstruments], function($message) use ($name, $email) {
                        $message->from('system@alyansekspert.ru', 'ООО АльянсЭксперт');
                        $message->to($email, $name)->subject('Дата поверки инструмента');
                    });
                }
            }
            
            // оповещение по заключениям
            $current_time = time();
            $month1 = 60*60*24*30;
    
            $usersConcl = User::where('role', 'Пользователь')->get();
    
            foreach($usersConcl as $user)
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
                    if(!empty($conclusionIds) || count($conclusionIds) > 0)
                    {
                        $userName = $user->name;
                        $userEmail = $user->email;
                        $userCompanyName = $userCompany->name;
                        $cntConclusionIds = count($conclusionIds);
                        $dataConclusion = array("company" => $userCompanyName, "name" => $userName, "body" => $cntConclusionIds);
                        if(filter_var($userEmail, FILTER_VALIDATE_EMAIL)) 
                        {
                            Mail::send('mail.alarmConclusion', $dataConclusion, function($message) use ($userName, $userEmail) {
                                $message->to($userEmail, $userName)->subject('Выполнить заключения');
                                $message->from('system@alyansekspert.ru', 'ООО АльянсЭксперт');
                            });
                        }
                        
                        $userCompanyIds[] = $userCompany->id;
                        $userCompanyNames[] = $userCompany->name;
                        $cntConclusionIdsArray[] = count($conclusionIds);
                    }
                }
                $conclusionIds = [];
            }

            if(isset($cntConclusionIdsArray) && count($cntConclusionIdsArray) > 0)
                {
                    $userCompanyIds = array_unique($userCompanyIds);
                    foreach($userCompanyIds as $value)
                    {
                        $userCompanyIds[] = $value;
                    }
                    $cntConclusionIdsArray = array_unique($cntConclusionIdsArray);
                    foreach($cntConclusionIdsArray as $value)
                    {
                        $cntConclusionIdsArray[] = $value;
                    }
                    $userCompanyNames = array_unique($userCompanyNames);
                    foreach($userCompanyNames as $value)
                    {
                        $userCompanyNames[] = $value;
                    }
                    $dataConclusionsVerif = [
                            'userCompanyIds' => $userCompanyIds,
                            'cnts' => $cntConclusionIdsArray,
                            'userCompanyNames' => $userCompanyNames,
                        ];
                        
                    $inspectorsConcl = User::where('role', 'Работник лаборатории')->get();
                    foreach($inspectorsConcl as $inspector)
                    {
                        $nameInspector = $inspector->name;
                        $emailInspector = $inspector->email;
                        if(filter_var($emailInspector, FILTER_VALIDATE_EMAIL))
                        {
                            Mail::send('mail.alarmConclusionInspectors', ['dataConclusionsVerif' => $dataConclusionsVerif], function($message) use ($nameInspector, $emailInspector) {
                                $message->from('system@alyansekspert.ru', 'ООО АльянсЭксперт');
                                $message->to($emailInspector, $nameInspector)->subject('Выполнить заключения');
                            });                            
                        }
                    }
                }
        });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
