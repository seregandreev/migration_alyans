<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'id',
        'company_id',
        'work_location_id',
        'tape_number',
        'type_id',
        'date_start_expluatation',
        'comment',
        'facility_id',
        'facility_name',
        'serial_number',
        'inspector_id',
        'user_id_update',
        'date_update',
        'user_action'
    ];

    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id')->first();
    }

    public function type()
    {
        return $this->hasOne(Type::class, 'id', 'type_id')->first();
    }

    public function work_location()
    {
        return $this->hasOne(WorkLocation::class, 'id', 'work_location_id')->first();
    }

    public function facility()
    {
        return $this->hasOne(Facility::class, 'id', 'facility_id')->first();
       
    }
    public function type_component()
    {
      return $this->belongsTo(Type::class, 'id', 'type_id')->get();
    }

    public function get_formed_date_component()
    {
        if(!empty($this->date_start_expluatation))
        {
            $date = explode('-', $this->date_start_expluatation);
            $date = $date[2].'.'.$date[1].'.'.$date[0].' г.';
        } else
            $date = $this->date_start_expluatation;

        return $date;
    }
}
