<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class QueryFilter
{
    public $request;
    protected $builder;
    protected $delimiter = ',';

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function filters()
    {
        return $this->request->query();
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                call_user_func_array([$this, $filter], array_filter([$value]));
            }
        }

        return $this->builder;
    }

    protected function paramToArray($param)
    {
        return explode($this->delimiter, $param);
    }
}
