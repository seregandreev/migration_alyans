<?php

namespace App\Models;
use App\Main;
use Illuminate\Database\Eloquent\Model;

class Main extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
        'next_verification_date',
    ];

}
