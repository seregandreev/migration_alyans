<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Conclusion extends Model
{
    protected $fillable = [
        'id',
        'component_id',
        'temperature',
        'propan',
        'vik_result',
        'vik_comment',
        'measure_1',
        'measure_2',
        'measure_3',
        'measure_4',
        'measure_5',
        'measure_6',
        'measure_7',
        'measure_8',
        'measure_9',
        'measure_10',
        'uzt_result',
        'area_deffects',
        'deffects_size',
        'mk_result',
        'graph',
        //'act_1',
        'period_1',
        //'act_2',
        'period_2',
        //'act_3',
        'period_3',
        'period_4',
        'period_5',
        'period_6',
        'crimping_1',
        'crimping_2',
        'crimping_3',
        'crimping_4',
        'crimping_5',
        'crimping_6',
        'gi_result',
        'uzk_result',
        'inspector_id',
        'date',
        'passport',
        'repair',
        'no_passportization',
        'date_next_verification',
        'signReady',
         'user_id_update',
        'date_update',
        'user_action',
        'diameter_plashki',
        'coefficient',
        'calibration_pressure',
        'check_vik',
        'check_uzt',
        'check_mk',
        'check_gi',
        'check_uzk',
        'installing_tape'
    ];


    public function component()
    {
        return $this->hasOne(Component::class, 'id', 'component_id')->first();
    }

    public function inspector()
    {
        return $this->hasOne(Inspector::class, 'id', 'inspector_id')->first();
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id_update')->first();
    }

    public function get_format_date()
    {
        $date = explode('-', $this->date);
        $format_date = $date[2].'.'.$date[1].'.'.$date[0];

        return $format_date;
    }

    public function get_formed_data_validity()
    {
        if(!empty($this->date_next_verification))
        {
            $date = explode('-', $this->date_next_verification);
            $date = $date[2].'.'.$date[1].'.'.$date[0].' г.';
        } else
            $date = $this->date_next_verification;

        return $date;
    }
}
