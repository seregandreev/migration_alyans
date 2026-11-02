<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waybill extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'id',
        'driver_id',
        'transport_id',
        'type_waybill',
        'date_from',
        'date_to',
        'medical_check_before',
        'medical_check_after',
        'doctor_name_before',
        'doctor_name_after',
        'date_medical_check_before',
        'date_medical_check_after',
        'time_medical_check_before',
        'time_medical_check_after',
        'transport_check_before',
        'date_transport_check_before',
        'time_transport_check_before',
        //'date_transport_check_after',
        //'time_transport_check_after',
        //'transport_inspector_name',
        //'transport_inspector_check_before',
        'transport_meliage_before',
        'disposition_organization_name',
        'address_departure',
        'date_transport_departure',
        'time_transport_departure',
        'date_transport_return',
        'time_transport_return',
        'other_marks',
        'driver_name_return',
        'dispetcher_id',
        'mechanic_id',
        'transport_meliage_after',
        'sulder_issued',
        'sulder_departure',
        'sulder_return',
        'expense_sulder_norm',
        'expense_sulder_fact',
        'overspending',
        'driver_id_return',
        ];

    public function driver()
    {
        return $this->hasOne(Driver::class, 'id', 'driver_id')->first();
    }

    public function transport()
    {
        return $this->hasOne(Transport::class, 'id', 'transport_id')->first();
    }

    public function userDispetcher()
    {
        return $this->hasOne(User::class, 'id', 'dispetcher_id')->first();
    }

    public function userMechanic()
    {
        return $this->hasOne(User::class, 'id', 'mechanic_id')->first();
    }


    /*
     * Формат даты
     */
    public function get_formed_date_from()
    {
        if(!empty($this->date_from))
        {
            $date = explode('-', $this->date_from);
            $date = $date[2].'.'.$date[1].'.'.$date[0].' г.';
        } else
            $date = $this->date_from;

        return $date;
    }
    public function get_formed_date_to()
    {
        if(!empty($this->date_to))
        {
            $date = explode('-', $this->date_to);
            $date = $date[2].'.'.$date[1].'.'.$date[0].' г.';
        } else
            $date = $this->date_to;

        return $date;
    }
}
