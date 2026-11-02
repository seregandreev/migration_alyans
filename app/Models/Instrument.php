<?php

namespace App\Models;

use App\Http\Controllers\Admin\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
        'serial_number',
        'inventory_number',
        //'description',
        'purpose',
        'control_method',
        'meter_limit',
        'sertificate_number',
        'verification_date',
        'next_verification_date',
        'verifier',
        'model',
        'yes_instrument',
        'scan_passport',
        'scan_sertificate',
    ];


    public function format_date($date)
    {
        if (isset($date)) {
        $date = explode('-', $date);
        $new_date = $date[2].'.'.$date[1].'.'.$date[0].' г.';
        }
        else{
         $new_date = '';   
        }
        

        return $new_date;
    }
    public function lessThanOneMonth($date) {

        return (strtotime($date))>(strtotime("-1 month"));
     
     }

     public function scopeFilter(Builder $builder, QueryFilter $filter){
        return $filter->apply($builder);
    }
}
