<?php

namespace App\Models;

use App\Models\Component;
use Illuminate\Database\Eloquent\Model;

class QrConclusion extends Model
{
    protected $fillable = [
        'id',
        'component_id',
        'number_qr',
        'status_exp',
        'qr_url'
    ];
    
    public function components()
    {
        return $this->hasOne(Component::class, 'id', 'component_id')->first();
    }
}
