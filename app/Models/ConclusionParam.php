<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConclusionParam extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'inspector_id',
        'date',
        'date_next_verification',
    ];
}
