<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'vin_num',
        'gos_num',
        'mileage',
        'num_sts',
        'num_pts',
        'date_service',
        'date_inspection',
        'date_insurance',
        'make_year',
        'type_avto',
        'garage_number',
        'type_sulder',
        ];

    /*
     * Формат даты
     */
    public function get_formed_date_service()
    {
        if(!empty($this->date_service))
        {
            $date = explode('-', $this->date_service);
            $date = $date[2].'.'.$date[1].'.'.$date[0].' г.';
        } else
            $date = $this->date_service;

        return $date;
    }

    public function get_formed_date_inspection()
    {
        if(!empty($this->date_inspection))
        {
            $date = explode('-', $this->date_inspection);
            $date = $date[2].'.'.$date[1].'.'.$date[0].' г.';
        } else
            $date = $this->date_inspection;

        return $date;
    }

    public function get_formed_date_insurance()
    {
        if(!empty($this->date_insurance))
        {
            $date = explode('-', $this->date_insurance);
            $date = $date[2].'.'.$date[1].'.'.$date[0].' г.';
        } else
            $date = $this->date_insurance;

        return $date;
    }

    public function lessThanOneMonth($date) {

        return (strtotime($date))>(strtotime("-1 month"));
     
     }
}