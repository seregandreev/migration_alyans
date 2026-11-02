<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Instrument;
use App\Models\Inspector;
use App\Models\Conclusion;
use App\Models\Company;
use App\Models\Component;
use App\Models\Act;
use Illuminate\Http\Request;
use DataTables;

class MainController extends Controller
{
    /*
     * Главная страница
     */
    public function index()
    {
        $conclusions = Conclusion::where('date_next_verification', '<', strtotime('+1 month'))->orderBy('date_next_verification', 'asc')->paginate(15);
        // $conclusions = Conclusion::orderBy('date_next_verification', 'asc')->get();
        $instruments = Instrument::orderBy('id', 'desc')->get();
        $inspectors = Inspector::orderBy('id', 'desc')->get();

        return view('main.index', 
            compact([
                'conclusions',
                'instruments',
                'inspectors'
            ]));
        //return view('main.index');
    }
    
    public function getConclusions(Request $request)
    {
        if ($request->ajax()) {
            // $data = Conclusion::where('date_next_verification', '<', strtotime('+1 month'))
            //     ->orderBy('date_next_verification', 'asc')
            //     ->query();
            return Datatables::of(Conclusion::query())->make(true);
        }
            //return view('main.index');
            //return view('main.index',compact('conclusions'));
            

        //$conclusions = Conclusion::where('date_next_verification', '<', strtotime('+1 month'))->orderBy('date_next_verification', 'asc')->get();
        
        //return response()->json($conclusions);
        //return json_encode($conclusions);
    }
    
    /*
     * данные для графика
     */
    public function chartCreate(Request $request)
    {
        //$result = [];
        
        $companies = Company::orderBy('id', 'asc')->get();
        foreach($companies as $company) 
        {        
            $conclusions = Conclusion::select('conclusions.*')
                ->leftJoin('components', 'components.id', '=', 'conclusions.component_id');
            $conclusionCount = $conclusions->where('components.company_id', $company->id)->count();
            if($conclusionCount) 
            {
                $result[] = [
                    'name' => $company->name,
                    'count' => $conclusionCount
                ];
            }
        }
        return $result;
    }
    
    public function chartCreateAct()
    {
        //$result = [];
        
        $companies = Company::orderBy('id', 'asc')->get();
        foreach($companies as $company) 
        {        
            $actCount = Act::where('company_id', $company->id)->count();
            if($actCount) 
            {
                $result[] = [
                    'name' => $company->name,
                    'count' => $actCount
                ];
            }
        }
        return $result;
    }
}