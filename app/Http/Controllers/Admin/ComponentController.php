<?php

namespace App\Http\Controllers\Admin;
use DB;
use App\Models\Company;
use App\Models\Component;
use App\Models\Facility;
use App\Models\Type;
use App\Models\Unit;
use App\Models\WorkLocation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

class ComponentController extends Controller
{
    public function check_permission()
    {
        if(Auth::user()->role == 'Пользователь')
            abort(403);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $this->check_permission();
        $currentUser = Auth::user();
        
        if (!$currentUser) {
            // Гость — пустая коллекция (или abort(403), или редирект)
            $companies = collect();
        } elseif (mb_strtolower($currentUser->role) === 'пользователь') {
            // Для обычного пользователя — только его компания
            // find() вернёт одну модель, обернём в коллекцию для единообразия
            $company = Company::find($currentUser->company_id);
            $companies = $company ? collect([$company]) : collect();
            $components = $this->list_components_for_user();
        } else {
            // Для других ролей — все компании с сортировкой
            $companies = Company::orderBy('name', 'asc')->get();
            $components = $this->list_components();
        }
        
        // ++ 01/09/2026 Для фильтра по производителю
        // $types = Type::select('manufacturer')
        //             ->distinct()
        //             ->orderBy('manufacturer', 'asc')
        //             ->get();
        // -- 01/09/2026

        $filter_work_locations = (session('components_company_id')) ? $this->list_work_locations(session('components_company_id')) : '';
        $filter_facilities = (session('components_company_id')) ? $this->list_facilities(session('components_company_id')) : '';
        
        // ++ 01/09/2026 Для фильтра по производителю
        $filter_manufacturers = session('components_company_id') ? $this->getManufacturersByCompanyAndLocation(
                                                                            session('components_company_id'),
                                                                            session('components_work_locations', null),
                                                                            session('components_facilities', null)
                                                                        ) : '';

        return view('admin.components.index', 
                compact([
                    'components', 
                    'filter_work_locations', 
                    'filter_facilities',
                    'companies',
                    'filter_manufacturers'
                ]));
    }
    
    // Показать все записи
    public function show_all()
    {
        $this->check_permission();
        $components = Component::orderBy('id', 'desc')->get();
        $companies = Company::orderBy('name', 'asc')
            ->get();
            
        session()->forget('components_company_id');
        session()->forget('components_work_locations');
        session()->forget('components_facilities');
        session()->forget('components_tape_number');
        session()->forget('components_serial_number');
        session()->forget('components_partial_number');
        session()->forget('components_type_name');
        session()->forget('type_manufacturers');
        // $filter_work_locations = (session('components_company_id')) ? $this->list_work_locations(session('components_company_id')) : '';
        // $filter_facilities = (session('components_company_id')) ? $this->list_facilities(session('components_company_id')) : '';

        return view('admin.components.index', 
                compact([
                    'components', 
                    // 'filter_work_locations', 
                    // 'filter_facilities',
                    'companies'
                ]));
    }
    /*
     * Поиск компонентов. Применение фильтров
     */
    public function accept_filters(Request $request)
    {
        // компания
        if(isset($request->components_company_id) && !empty($request->components_company_id))
            session()->put('components_company_id', $request->components_company_id);
        else
            session()->forget('components_company_id');
        // место проведения работ
        if(isset($request->components_work_locations) && !empty($request->components_work_locations))
            session()->put('components_work_locations', $request->components_work_locations);
        else
            session()->forget('components_work_locations');
            // установка
        if(isset($request->components_facilities) && !empty($request->components_facilities))
            session()->put('components_facilities', $request->components_facilities);
        else
            session()->forget('components_facilities');
        // номер ленты
        if(isset($request->components_tape_number) && !empty($request->components_tape_number))
            session()->put('components_tape_number', $request->components_tape_number);
        else
            session()->forget('components_tape_number');
        // серийный номер
        if(isset($request->components_serial_number) && !empty($request->components_serial_number))
            session()->put('components_serial_number', $request->components_serial_number);
        else
            session()->forget('components_serial_number');
        // партийный номер
        if(isset($request->components_partial_number) && !empty($request->components_partial_number))
            session()->put('components_partial_number', $request->components_partial_number);
        else
            session()->forget('components_partial_number');
        // наименование типа
        if(isset($request->components_type_name) && !empty($request->components_type_name))
            session()->put('components_type_name', $request->components_type_name);
        else
            session()->forget('components_type_name');
        // ++ 01/09/2026 производитель
        if(isset($request->type_manufacturers) && !empty($request->type_manufacturers))
            session()->put('type_manufacturers', $request->type_manufacturers);
        else
            session()->forget('type_manufacturers');

        return redirect()
            ->to(route('components.index'));
    }

    /*
     * Поиск заключений. Сброс фильтров
     */
    public function reset_filters(Request $request)
    {
        session()->forget('components_company_id');
        session()->forget('components_work_locations');
        session()->forget('components_facilities');
        session()->forget('components_tape_number');
        session()->forget('components_serial_number');
        session()->forget('components_partial_number');
        session()->forget('components_type_name');
        // ++ 01/09/2026
        session()->forget('type_manufacturers');

        return redirect()
            ->to(route('components.index'));
    }

    /*
     * Получение информации для фильтра
     */
    public function get_info_for_filters(Request $request)
    {
        $result = [];
        $company_id = (!empty($request->company_id)) ? $request->company_id : '';
        $work_location_id = (!empty($request->work_location_id)) ? $request->work_location_id : '';
        $facility_id = (!empty($request->facility_id)) ? $request->facility_id : '';

        // список мест проведения работ
        $result['work_locations'] = $this->list_work_locations($company_id);
        // список установок
        $result['facilities'] = $this->list_facilities($company_id);
        // ++ 02/09/2026 производители
        $result['manufacturers'] = $this->getManufacturersByCompanyAndLocation($company_id, $work_location_id, $facility_id);

        return $result;
    }

    /*
     * Список мест проведения работ
     */
    public function list_work_locations($company_id)
    {
        $query = WorkLocation::where('company_id', $company_id);
        
        $currentUser = Auth::user();
        if($currentUser && $currentUser->role === 'Пользователь') {
            $allowedIds = json_decode($currentUser->bases_list, true);
            $allowedIds = array_map('intval', $allowedIds);
            if (!is_array($allowedIds)) {
                $allowedIds = [0];
            }
    
            $query->whereIn('id', $allowedIds);
        }
    
        return $query->orderBy('name', 'asc')->get();
    }

    /*
     * Список установок
     */
    public function list_facilities($company_id)
    {
        $facilities = Facility::where('company_id', $company_id)
            ->orderBy('id', 'asc')
            ->get();

        return $facilities;
    }

    /*
     * Список производителей
     */
    public function getManufacturersByCompanyAndLocation($companyId, $workLocationId = null, $faciityId = null)
    {
        $query = Component::query()
            ->leftJoin('types', 'components.type_id', '=', 'types.id')
            ->where('components.company_id', $companyId);

        if (!is_null($workLocationId) && $workLocationId !== '') {
            $query->where('components.work_location_id', $workLocationId);
        }
                
        if (!is_null($faciityId) && $faciityId !== '') {
            $query->where('components.facility_id', $faciityId);
        }

        // Возвращаем коллекцию уникальных объектов (каждый содержит поле manufacturer)
        return $query->whereNotNull('types.manufacturer')
                    ->select('types.manufacturer')
                    ->distinct()
                    ->get();
    }

    /*
     * Список компонентов
     */
    public function list_components()
    {
            $components = Component::select('components.*')
                ->leftJoin('types', 'components.type_id', '=', 'types.id');
            if(session('components_company_id'))
                $components = $components->where('components.company_id', session('components_company_id'));
            if(session('components_work_locations'))
                $components = $components->where('components.work_location_id', session('components_work_locations'));
            if(session('components_facilities'))
                $components = $components->where('components.facility_id', session('components_facilities'));
            if(session('components_tape_number'))
                $components = $components->where('components.tape_number',  'LIKE', '%'.session('components_tape_number').'%');
            if(session('components_serial_number'))
                $components = $components->where('components.serial_number', session('components_serial_number'));
            if(session('components_type_name'))
                $components = $components->where('types.name', 'LIKE', '%'.session('components_type_name').'%');
            if(session('components_partial_number'))
                $components = $components->where('types.partial_number', session('components_partial_number'));
            // ++ 01/09/2026             
            if(session('type_manufacturers'))
                $components = $components->where('types.manufacturer', session('type_manufacturers'));
            
            if(!empty(session('components_company_id')) || !empty(session('components_work_locations')) || !empty(session('components_facilities')) || !empty(session('components_tape_number')) || !empty(session('components_serial_number')) || !empty(session('components_type_name')) || !empty(session('components_partial_number')) || !empty(session('components_serial_number')) || !empty(session('components_type_name')) || !empty(session('type_manufacturers')))
            {
                $components = $components->orderBy('id', 'desc')->get();
            } else {
                $components = $components->orderBy('id', 'desc')->limit(200)->get();
            }


        return $components;
    }

    /*
     * Список компонентов для пользователя
     */
    public function list_components_for_user()
    {
        $currentUser = Auth::user();
        
        // Если пользователь не авторизован — пустая коллекция или abort(403)
        if (!$currentUser) {
            return collect();
        }
        
        $query = Component::select('components.*')
            ->leftJoin('types', 'components.type_id', '=', 'types.id')
            ->where('components.company_id', $currentUser->company_id); // или любой другой $company_id
        
        if (mb_strtolower($currentUser->role) === 'пользователь') {
            $allowedLocationIds = json_decode($currentUser->bases_list, true);
            $allowedLocationIds = array_map('intval', $allowedLocationIds);
            if (is_array($allowedLocationIds) && count($allowedLocationIds) > 0) {
                if(session()->has('components_work_locations')) {
                    $query->where('components.work_location_id', session('components_work_locations'));
                } else {
                    $query->whereIn('components.work_location_id', $allowedLocationIds);
                }
                if(session()->has('components_facilities'))
                    $query->where('components.facility_id', session('components_facilities'));
                if(session()->has('components_tape_number'))
                    $query->where('components.tape_number',  'LIKE', '%'.session('components_tape_number').'%');
                if(session()->has('components_serial_number'))
                    $query->where('components.serial_number', session('components_serial_number'));
                if(session()->has('components_type_name'))
                    $query->where('types.name', 'LIKE', '%'.session('components_type_name').'%');
                if(session()->has('components_partial_number'))
                    $query->where('types.partial_number', session('components_partial_number'));
                // ++ 01/09/2026
                if(session()->has('type_manufacturers'))
                    $query->where('types.manufacturer', session('type_manufacturers'));    
            } else {
                // Если доступных точек нет — возвращаем пустую коллекцию (можно через ->whereRaw('1=0'))
                $query->whereRaw('1 = 0');
            }
        }
        
        $components = $query->orderBy('id', 'desc')->get();
        
        return $components;
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->check_permission();
        $companies = Company::orderBy('name', 'asc')
            ->get();
        /*$units = Unit::orderBy('name', 'asc')
           ->get();*/
        $types = Type::orderBy('name', 'asc')
            ->get();
        // $last_component = Component::orderBy('id', 'desc')
        //     ->first();
            
        if(Auth::user()->role == 'Работник лаборатории') {
            $inspectorId = Auth::user()->inspector_id;
            $last_component = Component::where('inspector_id', Auth::user()->inspector_id)->orderBy('id', 'desc')->first() ? Component::where('inspector_id', Auth::user()->inspector_id)->orderBy('id', 'desc')->first() : Component::orderBy('id', 'desc')->first();
        } else {
            $inspectorId = 0;
            $last_component = Component::orderBy('id', 'desc')->first();
        }
        
        // if (preg_match("/" . $last_component->company()->abbr . "_/i", $last_component->tape_number)) {
        //     $lastTypeNumber = explode('_', $last_component->tape_number)[1];
        // } else {
        //     $lastTypeNumber = $last_component->tape_number;
        // }
        
        if (preg_match("/" . $last_component->company()->abbr . "_/i", $last_component->tape_number)) {
            $lastTypeNumber = trim(str_replace($last_component->company()->abbr . '_', '', $last_component->tape_number));
        } else {
            $lastTypeNumber = $last_component->tape_number;
        }
        
        /*$last_component = Component::orderBy('id', 'desc')
            ->first();
        if(empty($last_component))
            $id = 1;
        else
            $id = $last_component->id + 1;
        $id = str_pad($id, '4', '0', STR_PAD_LEFT);*/

        return view('admin.components.create', [
            'companies' => $companies,
            //'units' => $units,
            'types' => $types,
            'last_component' => $last_component,
            //'id' => $id,
            'inspectorId' => $inspectorId,
            'lastTypeNumber' => $lastTypeNumber
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->check_permission();
        date_default_timezone_set('Asia/Yekaterinburg');
        $timeNow = date("d-m-Y H:i:s");
        $action = "Создал";
        $company = Company::where('id', $request->company_id)->first();
        $component = Component::create($request->all());
        $component->inspector_id = $request->inspectorId;
        $component->user_id_update = Auth::user()->id;
        $component->date_update = $timeNow;
        $component->user_action = $action;
        
        if (preg_match("/$company->abbr" . "_/i", $request->tape_number)) {
            $typeNumber = $request->tape_number;
        } else {
            $typeNumber = $company->abbr . '_' . $request->tape_number;
        }

        $component->tape_number = $typeNumber;
        
        $component->save();
        return redirect()
            ->to(route('components.index'))
            ->with('success', 'Компонент успешно добавлен');
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
        $component = Component::findOrFail($id);
        $companies = Company::orderBy('name', 'asc')
            ->get();
        /*$units = Unit::orderBy('name', 'asc')
            ->get();*/
        $types = Type::orderBy('name', 'asc')
            ->get();
        $current_type = Type::findOrFail($component->type_id);

        $work_locations = WorkLocation::where('company_id', $component->company_id)
            ->orderBy('name', 'asc')
            ->get();
        $facilities = Facility::where('company_id', $component->company_id)
            ->get();

        // if (preg_match("/" . $component->company()->abbr . "_/i", $component->tape_number)) {
        //     $typeNumber = explode('_', $component->tape_number)[1];
        // } else {
        //     $typeNumber = $component->tape_number;
        // }

        if (preg_match("/" . $component->company()->abbr . "_/i", $component->tape_number)) {
            $typeNumber = trim(str_replace($component->company()->abbr . '_', '', $component->tape_number));
        } else {
            $typeNumber = $component->tape_number;
        }

        return view('admin.components.edit', [
            'component' => $component,
            'companies' => $companies,
            //'units' => $units,
            'types' => $types,
            'current_type' => $current_type,
            'work_locations' => $work_locations,
            'facilities' => $facilities,
            'typeNumber' => $typeNumber
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
        date_default_timezone_set('Asia/Yekaterinburg');
        $timeNow = date("d-m-Y H:i:s");
        $action = "Обновил";
        $component = Component::findOrFail($id);
        $company = Company::where('id', $request->company_id)->first();
        if (preg_match("/$company->abbr" . "_/i", $request->tape_number)) {
            $typeNumber = $request->tape_number;
        } else {
            $typeNumber = $company->abbr . '_' . $request->tape_number;
        }
        
        $component->update($request->all());
        $component->update([
            'user_id_update' => Auth::user()->id,
            'date_update' => $timeNow,
            'user_action' => $action,
            'tape_number' => $typeNumber
        ]);

        return redirect()
            ->to(route('components.index'))
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
        $component = Component::findOrFail($id);

        $component->delete();

        return redirect()
            ->to(route('components.index'))
            ->with('success', 'Компонент успешно удалён');
    }

    /*
     * Подгрузка информации при выборе типа
     */
    public function get_type(Request $request)
    {
        $this->check_permission();
        if(isset($request->type_id))
        {
            $type_id = (int) $request->type_id;
            $type = Type::findOrFail($type_id);

            return $type;
        } elseif(isset($request->partial_number)) {
            $type = Type::where('partial_number', $request->partial_number)->first();
            return $type;
        }

        return false;
    }


    /*
     * Проверка на уникальность номера ленты
     */
    public function check_tape_number(Request $request)
    {
        $this->check_permission();
        $tape_number = $request->tape_number;
        $component = Component::where('tape_number', $tape_number)
            ->first();

        if(empty($component))
            return 'no';
        else
            return 'yes';
    }


    /*
     * проверка номера ленты на существование
     */
    public function check_tape_number_exists(Request $request)
    {
        $this->check_permission();
        $company = Company::where('id', $request->company_id)->first();
        $component = Component::where('tape_number', $request->tape_number)
            ->orWhere('tape_number', $company->abbr . '_' . $request->tape_number)
            ->first();

        $response = [];
        if(!empty($component)) {
            $response['result'] = 'true';
            $response['component'] = $component;
            return $response;
        } else {
            $response['result'] = 'false';
            return $response;
        }
    }
    
    /*
     * История компонента
     */
    public function histories(Request $request)
    {
        $componentId = (int) $request->component_id;
        // $component = Component::findOrFail($componentId);
        $component = Component::where('id', $componentId)
             ->first();
        $response['component'] = $component;
        if(isset($component->user_id_update)) $response['user_update'] = User::findOrFail($component->user_id_update);
        else $response['user_update'] = '';
        return $response;
    }
}
