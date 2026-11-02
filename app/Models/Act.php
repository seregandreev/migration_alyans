<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Act extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'company_id',
        'facility_id',
        'facility_name',
        'work_location_id',
        'date',
        'sign_inspector',
        'stamp'
    ];

    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id')->first();
    }
    
    public function facility()
    {
        return $this->hasOne(Facility::class, 'id', 'facility_id')->first();
    }
    
    public function get_formed_date_act()
    {
        if(!empty($this->date))
        {
            $date = explode('-', $this->date);
            $format_date = $date[2].'.'.$date[1].'.'.$date[0].' г.';
        } else
            $format_date = $this->date;

        return $format_date;
    }
}
