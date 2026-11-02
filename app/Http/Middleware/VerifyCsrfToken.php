<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/ajax/conclusions/get_data_on_type_number',
        '/conclusions/get_info_for_filters',
        '/ajax/components/get_data_on_type',
        '/configs/ecp_change',
        '/alarms/show',
        '/companies/get_work_locations',
        '/companies/get_facilities',
        '/components/check_tape_number_exists',
        '/conclusions/get_last_conclusion_on_tape_number',
        '/ajax/orders/update_info',
        '/conclusions/histories',
        '/acts/get_facilities',
        '/acts/get_work_locations',
        '/acts/get_dates',
    ];
}
