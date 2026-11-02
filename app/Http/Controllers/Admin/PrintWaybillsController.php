<?php

namespace App\Http\Controllers\Admin;

use App\Models\Driver;
use App\Models\Transport;
use App\Models\Waybill;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrintWaybillsController extends Controller
{
    public function legkovoy(Request $request, $id)
    {
        $waybill = Waybill::findOrFail($id);
        $driver = Driver::findOrFail($waybill->driver_id);
        $transport = Transport::findOrFail($waybill->transport_id);
        $userMechanic = User::findOrFail($waybill->mechanic_id);
        $userDispetcher = User::findOrFail($waybill->dispetcher_id);
        
        $fullNameDriver = explode(" ", $driver->name);
        $surnNameDriver = $fullNameDriver['2'] ? mb_substr($fullNameDriver['2'], 0, 1) : '';
        $firstNameDriver = $fullNameDriver['1'] ? mb_substr($fullNameDriver['1'], 0, 1) : '';
        $lastNameDriver = $fullNameDriver['0'];
        $nameDriver = $lastNameDriver . ' ' . $firstNameDriver . '. ' . $surnNameDriver . '.';

        $fullNameMechanic = explode(" ", $userMechanic->name);
        $surnNameMechanic = $fullNameMechanic['2'] ? mb_substr($fullNameMechanic['2'], 0, 1) : '';
        $firstNameMechanic = $fullNameMechanic['1'] ? mb_substr($fullNameMechanic['1'], 0, 1) : '';
        $lastNameMechanic = $fullNameMechanic['0'];
        $nameMechanic = $lastNameMechanic . ' ' . $firstNameMechanic . '. ' . $surnNameMechanic . '.';

        $fullNameDispetcher = explode(" ", $userDispetcher->name);
        $surnNameDispetcher = $fullNameDispetcher['2'] ? mb_substr($fullNameDispetcher['2'], 0, 1) : '';
        $firstNameDispetcher = $fullNameDispetcher['1'] ? mb_substr($fullNameDispetcher['1'], 0, 1) : '';
        $lastNameDispetcher = $fullNameDispetcher['0'];
        $nameDispetcher = $lastNameDispetcher . ' ' . $firstNameDispetcher . '. ' . $surnNameDispetcher . '.';

        $number = $waybill->id;
        $number = str_pad($number, '3', '0', STR_PAD_LEFT);

        return view('admin.print_waybills.legkovoy', [
            'waybill' => $waybill,
            'nameDriver' => $nameDriver,
            'driver' => $driver,
            'transport' => $transport,
            'number' => $number,
            'nameMechanic' => $nameMechanic,
            'nameDispetcher' => $nameDispetcher,
        ]);
    }

    public function cargo(Request $request, $id)
    {
        $waybill = Waybill::findOrFail($id);
        $driver = Driver::findOrFail($waybill->driver_id);
        $transport = Transport::findOrFail($waybill->transport_id);
        $userMechanic = User::findOrFail($waybill->mechanic_id);
        $userDispetcher = User::findOrFail($waybill->dispetcher_id);

        $fullNameDriver = explode(" ", $driver->name);
        $surnNameDriver = $fullNameDriver['2'] ? mb_substr($fullNameDriver['2'], 0, 1) : '';
        $firstNameDriver = $fullNameDriver['1'] ? mb_substr($fullNameDriver['1'], 0, 1) : '';
        $lastNameDriver = $fullNameDriver['0'];
        $nameDriver = $lastNameDriver . ' ' . $firstNameDriver . '. ' . $surnNameDriver . '.';

        $fullNameMechanic = explode(" ", $userMechanic->name);
        $surnNameMechanic = $fullNameMechanic['2'] ? mb_substr($fullNameMechanic['2'], 0, 1) : '';
        $firstNameMechanic = $fullNameMechanic['1'] ? mb_substr($fullNameMechanic['1'], 0, 1) : '';
        $lastNameMechanic = $fullNameMechanic['0'];
        $nameMechanic = $lastNameMechanic . ' ' . $firstNameMechanic . '. ' . $surnNameMechanic . '.';

        $fullNameDispetcher = explode(" ", $userDispetcher->name);
        $surnNameDispetcher = $fullNameDispetcher['2'] ? mb_substr($fullNameDispetcher['2'], 0, 1) : '';
        $firstNameDispetcher = $fullNameDispetcher['1'] ? mb_substr($fullNameDispetcher['1'], 0, 1) : '';
        $lastNameDispetcher = $fullNameDispetcher['0'];
        $nameDispetcher = $lastNameDispetcher . ' ' . $firstNameDispetcher . '. ' . $surnNameDispetcher . '.';
        
        $number = $waybill->id;
        $number = str_pad($number, '3', '0', STR_PAD_LEFT);

        return view('admin.print_waybills.cargo', [
            'waybill' => $waybill,
            'nameDriver' => $nameDriver,
            'driver' => $driver,
            'transport' => $transport,
            'number' => $number,
            'nameMechanic' => $nameMechanic,
            'nameDispetcher' => $nameDispetcher,
        ]);
    }
}
