<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspector extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'level',
        'document',
        'position',
        'num_document',
        'document_validity',
        'control_method',
        'phone',
        'birth_day',
        ];

    /*
     * Формат даты
     */
    public function get_formed_data_document_validity()
    {
        if(!empty($this->document_validity))
        {
            $date = explode('-', $this->document_validity);
            $date = $date[2].'.'.$date[1].'.'.$date[0].' г.';
        } else
            $date = $this->document_validity;

        return $date;
    }

    public function get_formed_data_birth_day()
    {
        if(!empty($this->birth_day))
        {
            $date = explode('-', $this->birth_day);
            $date = $date[2].'.'.$date[1].'.'.$date[0].' г.';
        } else
            $date = $this->birth_day;

        return $date;
    }

    public function lessThanOneMonth($date) {

        return (strtotime($date))>(strtotime("-1 month"));
     
     }
}
