<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
	    //'abbr_name_type',
        'manufacturer',
        'partial_number',
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
        'pressure',
        'measure',
        'crimping_1',
        'crimping_2',
        'crimping_3',
        'crimping_4',
        'crimping_5',
        'crimping_6',
        'act_1',
        'period_1',
        //'act_2',
        'period_2',
        //'act_3',
        'period_3',
        'period_4',
        'period_5',
        'period_6',
        /*'act_4',
        'act_5',
        'act_6',*/
        'tape_length',
        'life_time',
        //'temperature',
        'temperature_mode',
        'temperature_mode1',
        'description',
        'is_non_typical_type',
    ];

    public function components ()
    {
      return $this->hasMany(Component::class, 'type_id', 'id')->first();
    }

}