<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        'company_id',
        'number',
        'gos_number',
        'area',
        'responsible_id',
        'garante',
    ];

    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id')->first();
    }

    public function responsible()
    {
        return $this->hasOne(User::class, 'id', 'responsible_id')->first();
    }
}
