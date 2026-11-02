<?php

namespace App\Http\Controllers\Admin;

class InstrumentFilter extends QueryFilter{
    public function control_method($method = ''){
        return $this->builder
        ->where('control_method', $method);
        }

    public function search_field($search_string = ''){
        return $this->builder
            ->where('name', 'LIKE', '%'.$search_string.'%')
            ->orWhere('model', 'LIKE', '%'.$search_string.'%')
            ->orWhere('serial_number', 'LIKE', '%'.$search_string.'%')
            ->orWhere('control_method', 'LIKE', '%'.$search_string.'%')
            ->orWhere('inventory_number', 'LIKE', '%'.$search_string.'%');
    }

    public function is_active($value = null){
        return $this->builder
        ->where('yes_instrument', $value);
    }
}
