<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alarm extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'link',
        'type_alarm',
        'level',
        'is_reading',
    ];

    /*
     * Формат даты
     */
    public function get_formed_data()
    {
        $datetime = explode(' ', $this->created_at);
        $date = explode('-', $datetime[0]);
        $time = explode(':', $datetime[1]);

        $formed_date = $date[2].'.'.$date[1].'.'.$date[0].' г. в '.$time[0].':'.$time[1];

        return $formed_date;
    }
}
