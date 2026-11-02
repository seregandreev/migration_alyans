<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'abbr',
        'responsible_id',
        'num_facility',
        'gov_number',
        'area',
        'garante',
    ];


    // места проведения работ
    public function work_locations()
    {
        return $this->hasMany(WorkLocation::class, 'company_id', 'id')->get();
    }

    // установки
    public function facilities()
    {
        return $this->hasMany(Facility::class, 'company_id', 'id')->get();
    }

    // владелец компании
    public function user()
    {
        $user = User::where('company_id', $this->id)
            ->first();

        return $user;
    }
}
