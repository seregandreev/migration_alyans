<?php

namespace App\Http\Controllers\Admin;

use App\Models\Waybill;
use App\Models\Driver;
use App\Models\Transport;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaybillLegkovoyController extends Controller
{
    public function check_permission()
    {
        if(Auth::user()->role == 'Пользователь')
            abort(403);
    }
    
    /*public function index()
    {
        $waybills = Waybill::orderBy('id', 'desc')
        ->where('type_waybill', 'Легковой')
        ->paginate(15);
        return view('admin.waybills_legkovoy.index', [
            'waybills' => $waybills,
        ]);
    }*/

    public function create(Request $request)
    {
        $this->check_permission();
        $drivers = Driver::orderBy('id', 'asc')
            ->get();
        $transports = Transport::orderBy('id', 'asc')
            ->where('type_avto', 'Легковой')
            ->get();
        $userMechanics = User::orderBy('name', 'asc')
            ->where('role', 'Механик')
            ->get();
        $userDoctors = User::orderBy('name', 'asc')
            ->where('role', 'Фельдшер')
            ->get();
        $userDispetchers = User::orderBy('name', 'asc')
            ->where('role', 'Диспетчер')
            ->get();
        $last_waybill = Waybill::orderBy('id', 'desc')
            ->first();
        if(empty($last_waybill))
            $number = 1;
        else
            $number = $last_waybill->id + 1;
        $number = str_pad($number, '3', '0', STR_PAD_LEFT);

        return view('admin.waybills_legkovoy.create', [
            'drivers' => $drivers,
            'transports' => $transports,
            'last_waybill' => $last_waybill,
            'number' => $number,
            'userMechanics' => $userMechanics,
            'userDoctors' => $userDoctors,
            'userDispetchers' => $userDispetchers,
        ]);
    }

    public function store(Request $request)
    {
        $this->check_permission();
        Waybill::create($request->all());

        return redirect()
            ->to(route('waybills.index'))
            ->with('success', 'Путевой лист успешно добавлен');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->check_permission();
        $waybill = Waybill::findOrFail($id);
        $drivers = Driver::orderBy('id', 'asc')
            ->get();
        $transports = Transport::orderBy('id', 'asc')
            ->where('type_avto', 'Легковой')
            ->get();
        $userMechanics = User::orderBy('name', 'asc')
            ->where('role', 'Механик')
            ->get();
        $userDoctors = User::orderBy('name', 'asc')
            ->where('role', 'Фельдшер')
            ->get();
        $userDispetchers = User::orderBy('name', 'asc')
            ->where('role', 'Диспетчер')
            ->get();
        $number = $waybill->id;
        $number = str_pad($number, '3', '0', STR_PAD_LEFT);

        return view('admin.waybills_legkovoy.edit', [
            'waybill' => $waybill,
            'drivers' => $drivers,
            'transports' => $transports,
            'number' => $number,
            'userMechanics' => $userMechanics,
            'userDoctors' => $userDoctors,
            'userDispetchers' => $userDispetchers,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->check_permission();
        $inputEdit = $request->all();
        $meliage_after = $inputEdit['transport_meliage_after'];
        $transportId = $inputEdit['transport_id'];
        $waybill = Waybill::findOrFail($id);

        Transport::where('id', $transportId)
            ->first()
            ->update(['mileage' => $meliage_after]);

        $waybill->update($request->all());

        return redirect()
            ->to(route('waybills.index'))
            ->with('success', 'Информация успешно изменена');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->check_permission();
        $waybill = Waybill::findOrFail($id);
        $waybill->delete();

        return redirect()
            ->to(route('waybills.index'))
            ->with('success', 'Путевой лист успешно удалён');
    }

        /*
     * Получение данных по водителю
     */
    public function get_data_on_driver_id(Request $request)
    {
        $driver = Driver::where('id', $request->driver_id)
            ->first();

        $result['driver'] = $driver;
        return $result;
    }

    /*
     * Получение данных по ТС
     */
    public function get_data_on_transport_id(Request $request)
    {
        $transport = Transport::where('id', $request->transport_id)
            ->first();

        $result['transport'] = $transport;
        return $result;
    }
}
