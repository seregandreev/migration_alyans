<?php

namespace App\Http\Controllers;

use App\Models\Alarm;
use App\Models\Component;
use App\Models\Conclusion;
use App\Models\Inspector;
use App\Models\Instrument;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CronController extends Controller
{

    /*
     * Запускает проверку оповещений
     */
    public function alarm_processing()
    {
        if(Auth::user()->role == 'Работник лаборатории' || Auth::user()->role == 'Администратор') {
            $this->check_document_validity_to_inspectors();
            $this->check_instrument_date_verify_on_month();
            $this->check_conclusion_date_verify_on_month();
        } else {
            $this->check_conclusion_date_verify_on_month();
        }
        return back();
    }


    /*
     * Проверяем срок действия документов у инспекторов
     */
    public function check_document_validity_to_inspectors()
    {
        $inspectors = Inspector::orderBy('id', 'desc')
            ->get();
        $date = time();

        foreach($inspectors as $inspector)
        {
            $document_validity = strtotime($inspector->document_validity);
            if($document_validity < $date)
                Alarm::updateOrCreate(
                    [
                        'content' => 'ФИО: <b>'.$inspector->name.'</b><br> Номер документа: <b>'.$inspector->num_document.'</b><br> Дата: <b>'.$inspector->get_formed_data_document_validity($inspector->document_validity).'</b><br> Необходимо продление'
                    ],
                    [
                        'user_id' => Auth::id(),
                        'title' => 'Просрочен документ у инспектора',
                        'content' => 'ФИО: <b>'.$inspector->name.'</b><br> Номер документа: <b>'.$inspector->num_document.'</b><br> Дата: <b>'.$inspector->get_formed_data_document_validity($inspector->document_validity).'</b><br> Необходимо продление',
                        'link' => '/inspectors/'.$inspector->id.'/edit',
                        'type_alarm' => 'инспектор',
                        'level' => 1,
                    ]);
        }
    }


    /*
     * Проверка инструментов на поверку (если меньше месяца до следующей поверки - оповещает)
     */
    public function check_instrument_date_verify_on_month()
    {
        $instruments = Instrument::orderBy('id', 'desc')
            ->get();

        $current_time = time();
        $month1 = 60*60*24*30;

        foreach($instruments as $instrument)
        {
            $date_verify = strtotime($instrument->next_verification_date);
            $max_date = $date_verify - $month1;
            if($max_date < $current_time)
            {
                Alarm::updateOrCreate(
                    [
                        'content' => 'Наименование: <b>'.$instrument->name.'</b><br> S/N: <b>'.$instrument->serial_number.'</b><br> Дата поверки: <b>'.$instrument->format_date($instrument->next_verification_date).'</b>'
                    ],
                    [
                        'user_id' => Auth::id(),
                        'title' => 'Необходимо выполнить поверку инструмента',
                        'content' => 'Наименование: <b>'.$instrument->name.'</b><br> S/N: <b>'.$instrument->serial_number.'</b><br> Дата поверки: <b>'.$instrument->format_date($instrument->next_verification_date).'</b>',
                        'link' => '/instruments/'.$instrument->id.'/edit',
                        'type_alarm' => 'инструмент',
                        'level' => 1,
                    ]);
            }
        }

    }

    /*
     * Проверка даты следующего заключения
     */
    public function check_conclusion_date_verify_on_month()
    {
        $conclusions = Conclusion::orderBy('id', 'desc')
            ->get();

        $current_time = time();
        $month1 = 60*60*24*30;

        //dd($conclusions);
        foreach($conclusions as $conclusion)
        {
            $date_verify = strtotime($conclusion->date_next_verification);
            $max_date = $date_verify - $month1;
            if($max_date < $current_time || $date_verify < $current_time)
            {
                $component = Component::findOrFail($conclusion->component_id);
                /*$userCompany = User::where('company_id', $component->company_id)->first();
                //dd($userCompany->id);
                if(isset($userCompany))
                {
                    $userId = $userCompany->id;
                } else {
                    $userId = 1;
                } */
                Alarm::updateOrCreate(
                    [
                        'content' => 'Номер заключения: <b>'.$conclusion->id.'</b><br> Номер ленты: <b>'.$component->tape_number.'</b><br> Дата: <b>'.$conclusion->get_formed_data_validity($conclusion->date_next_verification).'</b>'
                    ],
                    [
                        'user_id' => $component->company_id,
                        'title' => 'Необходимо выполнить заключение',
                        'content' => 'Номер заключения: <b>'.$conclusion->id.'</b><br> Номер ленты: <b>'.$component->tape_number.'</b><br> Дата: <b>'.$conclusion->get_formed_data_validity($conclusion->date_next_verification).'</b>',
                        'link' => '/conclusions/'.$conclusion->id.'/edit',
                        'type_alarm' => 'заключение',
                        'level' => 1,
                    ]);
            }
        }
    }
}
