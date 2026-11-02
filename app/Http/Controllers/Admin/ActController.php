<?php

namespace App\Http\Controllers\Admin;

use App\Models\Act;
use App\Models\Company;
use App\Models\Conclusion;
use App\Models\Facility;
use App\Models\WorkLocation;
use App\Models\Inspector;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ActController extends Controller
{
    public function check_permission()
    {
        if(Auth::user()->role == 'Пользователь')
            abort(403);
    }
    
    /*
     * Список актов
     */
    public function index()
    {
        $this->check_permission();
        $acts = Act::orderBy('id', 'desc')
            ->get();
        $companies = Company::orderBy('name', 'asc')
            ->get();

        if(session('filters_acts_company_id'))
        {
            $facilities = Facility::where('company_id', session('filters_acts_company_id'))
                ->orderBy('id', 'desc')
                ->get();

            $work_locations = WorkLocation::where('company_id', session('filters_acts_company_id'))
                ->orderBy('id', 'desc')
                ->get();
            $conclusions = Conclusion::where('date', session('filters_acts_date'))
                ->orderBy('date', 'desc')
                ->get();
        } else {
            $facilities = [];
            $work_locations = [];
            $conclusions = [];
        }

        return view('admin.acts.index', [
            'acts' => $acts,
            'companies' => $companies,
            'facilities' => $facilities,
            'work_locations' => $work_locations,
            'conclusions' => $conclusions
        ]);
    }


    /*
     * Применение фильтров
     */
    public function accept_filters(Request $request)
    {
        if(isset($request->company_id))
            session()->put('filters_acts_company_id', $request->company_id);
        if(isset($request->facility_id))
            session()->put('filters_acts_facility_id', $request->facility_id);
        if(isset($request->work_location_id))
            session()->put('filters_acts_work_location_id', $request->work_location_id);
        if(isset($request->date))
            session()->put('filters_acts_date', $request->date);

        //$response = $this->act($request->company_id, $request->facility_id, $request->work_location_id, $request->date);

        // сохраняем в базу
        $company_id = (isset($request->company_id) && !empty($request->company_id) && $request->company_id != 0) ? $request->company_id : null;
        $facility_id = (isset($request->facility_id) && !empty($request->facility_id) && $request->facility_id != 0) ? $request->facility_id : null;
        $work_location_id = (isset($request->work_location_id) && !empty($request->work_location_id) && $request->work_location_id != 0) ? $request->work_location_id : null;
        $date = (isset($request->date) && !empty($request->date) && $request->date != 0) ? $request->date : null;

        $act = Act::where('company_id', $company_id)
            ->where('facility_id', $facility_id)
            ->where('work_location_id', $work_location_id)
            ->where('date', $date)
            ->first();
        if(empty($act))
            Act::create([
                'company_id' => $company_id,
                'facility_id' => $facility_id,
                'work_location_id' => $work_location_id,
                'date' => $date,
                'sign_inspector' => 'yes',
                'stamp' => 'yes'
            ]);

        //return $response;
        return back();
    }


    /*
     * Просмотр акта
     */
    public function show_act($act_id)
    {
        $act = Act::findOrFail($act_id);

        return $this->act($act->company_id, $act->facility_id, $act->work_location_id, $act->date);
    }

    /*
     * Формирование акта
     */
    public function act($company_id, $facility_id, $work_location_id, $date)
    {
        $conclusions = Conclusion::select('conclusions.*')
            ->leftJoin('components', 'components.id', '=', 'conclusions.component_id');

        if(isset($company_id) && !empty($company_id) && $company_id != 0)
            $conclusions = $conclusions->where('components.company_id', $company_id);
        if(isset($facility_id) && !empty($facility_id) && $facility_id != 0)
            $conclusions = $conclusions->where('components.facility_id', $facility_id);
        if(isset($work_location_id) && !empty($work_location_id) && $work_location_id != 0)
            $conclusions = $conclusions->where('components.work_location_id', $work_location_id);
        if(isset($date) && !empty($date) && $date != 0)
            $conclusions = $conclusions->where('conclusions.date', $date);

        $conclusions = $conclusions->orderBy('id', 'desc')
            ->get();

        // компания
        $company = Company::findOrFail($company_id);
        
        if(isset($work_location_id)) {
            $work_location = WorkLocation::findOrFail($work_location_id);
        } else {
            $work_location = '';
        }
        
       if(isset($facility_id)) {
            $facility = Facility::findOrFail($facility_id);
        } else {
            $facility = '';
        }        
        
        $dateFormated = implode('.', array_reverse(explode('-', $date)));
        
        // забрал регуляркой из урла значение get в качестве № акта
        $uriParam = $_SERVER['REQUEST_URI'];
        preg_match('/\d+/', $uriParam, $matches);
        $getParam = $matches[0];
        
        $act = Act::findOrFail($getParam);
        
        if($act->sign_inspector && $act->sign_inspector == 'yes')
        {
            $inspectorId = Auth::user()->inspector_id;
            $inspector = $inspectorId ? Inspector::findOrFail($inspectorId) : '';

        } else {
            $inspector = '';
        }
        
        return view('admin.acts.report', [
            'conclusions' => $conclusions,
            'company' => $company,
            'work_location' => $work_location,
            'dateFormated' => $dateFormated,
            'act' => $act,
            'facility' => $facility,
            'getParam' => $getParam,
            'inspector' => $inspector
        ]);
    }




    /*
     * Возвращает список компаний
     */
    public function get_facilities(Request $request)
    {
        $facilities = Facility::where('company_id', $request->company_id)
            ->orderBy('id', 'desc')
            ->get();

        return $facilities;
    }


    /*
     * Возвращает список локаций
     */
    public function get_work_locations(Request $request)
    {
        $work_locations = WorkLocation::where('company_id', $request->company_id)
            ->orderBy('id', 'desc')
            ->get();

        return $work_locations;
    }


    /*
     * Возвращает список дат
     */
    public function get_dates(Request $request)
    {
        $company_id = (int) $request->company_id;
        $work_location_id = (int) $request->work_location_id;
        $facility_id = (int) $request->facility_id;

        $conclusions = Conclusion::select('conclusions.date')
            ->leftJoin('components', 'components.id', '=', 'conclusions.component_id');

        if(!empty($company_id) && $company_id > 0)
            $conclusions = $conclusions->where('components.company_id', $company_id);
        if(!empty($work_location_id) && $work_location_id > 0)
            $conclusions = $conclusions->where('components.work_location_id', $work_location_id);
        if(!empty($facility_id) && $facility_id > 0)
            $conclusions = $conclusions->where('components.facility_id', $facility_id);

        $conclusions = $conclusions
            ->orderBy('date', 'desc')
            ->groupBy('date')
            ->get();

        return $conclusions;
    }
    
    public function deleteAct($id)
    {
        $this->check_permission();
        Act::where('id', $id)
           ->delete();
        return back();
    }
    
    // подпись
    public function signChange(Request $request)
    {
        $act = Act::findOrFail($request->act_id);
        if($act->update(['sign_inspector' => $request->sign_inspector]))
        {
            $result['status'] = 'ok';
        } else {
            $result['status'] = 'no';
        }
    
        return $result;
    }
    
    // печать
    public function stampChange(Request $request)
    {
        $act = Act::findOrFail($request->act_id);
        if($act->update(['stamp' => $request->stamp]))
        {
            $result['status'] = 'ok';
        } else {
            $result['status'] = 'no';
        }
    
        return $result;
    }
}
