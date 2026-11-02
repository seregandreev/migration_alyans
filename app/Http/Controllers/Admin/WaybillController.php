<?php

namespace App\Http\Controllers\Admin;

use App\Models\Waybill;
use App\Models\Driver;
use App\Models\Transport;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaybillController extends Controller
{
    public function check_permission()
    {
        if(Auth::user()->role == 'Пользователь')
            abort(403);
    }
    
    public function index(Request $request)
    {   
        $this->check_permission();
        $waybillQuery = Waybill::query();

        if ($request->filled('type_waybill')){
            $waybillQuery->where('type_waybill', $request->type_waybill);
        }
        $waybills = $waybillQuery->paginate(15)->withPath("?" . $request->getQueryString());
        return view('admin.waybills.index', [
            'waybills' => $waybills,
        ]);
    }
}
