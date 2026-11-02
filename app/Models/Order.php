<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['responsible_id', 'status', 'comment'];

    public function responsible()
    {
        return $this->hasOne(User::class, 'id', 'responsible_id')->first();
    }

    public function count_conclusions()
    {
        $order_conclusions = OrderConclusion::where('order_id', $this->id)
            ->count();

        return $order_conclusions;
    }
}
