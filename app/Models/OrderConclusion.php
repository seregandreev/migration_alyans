<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderConclusion extends Model
{
    protected $fillable = [
        'order_id',
        'conclusion_id',
    ];

    public function conclusion()
    {
        return $this->hasOne(Conclusion::class, 'id', 'conclusion_id')->first();
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id')->first();
    }
}
