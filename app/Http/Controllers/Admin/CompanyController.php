<?php

namespace App\Http\Controllers\Admin;

use App\Models\Component;
use App\Models\Facility;
use App\Models\Unit;
use App\Models\Company;
use App\Models\WorkLocation;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function check_permission()
    {
        if(Auth::user()->role == 'Пользователь')
            abort(403);
    }
    
    public function index()
    {
        $this->check_permission();
        $companies = Company::orderBy('id', 'desc')
            ->get();

        return view('admin.companies.index', [
            'companies' => $companies,
        ]);
    }



    public function create()
    {
        $this->check_permission();
        $units = WorkLocation::orderBy('name', 'asc')
            ->get();
        $responsibles = User::orderBy('id', 'desc')
            ->get();

        return view('admin.companies.create', [
            'units' => $units,
            'responsibles' => $responsibles,
        ]);
    }



    public function store(Request $request)
    {
        $this->check_permission();
        $company = Company::create($request->all());

        // места проведения работ
        if(isset($request->work_locations) && is_array($request->work_locations))
        {
            foreach($request->work_locations as $location)
            {
                WorkLocation::create([
                    'company_id' => $company->id,
                    'name' => $location,
                ]);
            }
        }
        // установки
        if(isset($request->facility_number) && is_array($request->facility_number))
        {
            foreach($request->facility_number as $key => $facility_number)
            {
                Facility::create([
                    'company_id' => $company->id,
                    'number' => $request->facility_number[$key],
                    'gos_number' => $request->facility_gos_number[$key],
                    'area' => $request->facility_area[$key],
                    'responsible_id' => $request->facility_responsible_id[$key],
                    /*'garante' => $request->facility_garante[$key],*/
                ]);
            }
        }

        // логотип компании
        if($request->has('logo'))
            $this->uploadLogo($request->logo, $company->id);


        return redirect()
            ->to(route('companies.index'))
            ->with('success', 'Компания успешно добавлена');
    }

    /*
     * загрузка логотипа на сервер
     */
    public function uploadLogo($image, $company_id):void
    {
        $this->check_permission();
        // путь к документу
        $document_path = public_path('/companies_data/'.$company_id.'/');
        // если не создана директория - создаём её
        @mkdir($document_path);
        // если остался старый файл - удаляем его
        if(file_exists($document_path.'logo.jpg'))
        {
            @unlink($document_path.'logo.jpg');
        }

        $image->move($document_path, 'logo.jpg');

    }



    public function edit($id)
    {
        $this->check_permission();
        $company = Company::findOrFail($id);
        $units = WorkLocation::orderBy('name', 'asc')
            ->get();
        $responsibles = User::orderBy('id', 'desc')
            ->get();

        return view('admin.companies.edit', [
            'company' => $company,
            'units' => $units,
            'responsibles' => $responsibles,
        ]);
    }



    
    
    
    public function update(Request $request, $id)
    {
        $this->check_permission();
        //dd($request->all());
        $company = Company::findOrFail($id);

        // места проведения работ
        /*WorkLocation::where('company_id', $company->id)
           ->delete();*/
      
        if(isset($request->work_locations) && is_array($request->work_locations))
        {
            foreach($request->work_locations as $location)
           {
                WorkLocation::Create([
                  'company_id' => $company->id,
                   'name' => $location,
                ]);
            }
        }

        // установки
        /*Facility::where('company_id', $company->id)
            ->delete();*/
            
        if(isset($request->facility_number) && is_array($request->facility_number))
        {
            foreach($request->facility_number as $key => $facility_number)
            {
                Facility::Create([
                    'company_id' => $company->id,
                    'number' => $request->facility_number[$key],
                    'gos_number' => $request->facility_gos_number[$key],
                    'area' => $request->facility_area[$key],
                    'responsible_id' => $request->facility_responsible_id[$key],
                    /*'garante' => $request->facility_garante[$key],*/
                ]);
            }
        }

        $company->update($request->all());

        // логотип компании
        if($request->has('logo'))
            $this->uploadLogo($request->logo, $company->id);

        return redirect()
            ->to(route('companies.index'))
            ->with('success', 'Информация успешно обновлена');
    }

    //удаляем место проведния работ
    public function workLocationDelete($id)
    {
        $this->check_permission();
        // места проведения работ
        WorkLocation::where('id', $id)
           ->delete();
        return back();
    }

    //удаляем установку
    public function facilityDelete($id)
    {
        $this->check_permission();
        // установки
        Facility::where('id', $id)
            ->delete();
        return back();
    }

    public function destroy($id)
    {
        $this->check_permission();
        $company = Company::findOrFail($id);
        $company->delete();

        return redirect()
            ->to(route('companies.index'))
            ->with('success', 'Компания успешно удалена');
    }


    /*
     * Возвращает список мест проведения работ
     */
    public function get_work_locations(Request $request)
    {
        $this->check_permission();
        $company_id = (int) $request->company_id;

        $locations = WorkLocation::where('company_id', $company_id)
            ->orderBy('name', 'asc')
            ->get();

        return $locations;
    }


    /*
     * Возвращает список установок
     */
    public function get_facilities(Request $request)
    {
        $this->check_permission();
        $company_id = (int) $request->company_id;

        $facilities = Facility::where('company_id', $company_id)
            ->orderBy('id', 'asc')
            ->get();

        return $facilities;
    }
    
    // устанавливаем имя проведения работ
    public function setlocation(Request $request):void
    {
        $this->check_permission();
        $location_id = (int) $request->location_id;
        $location = WorkLocation::findOrFail($location_id);
        $location->update([
            'name' => $request->location_current_name,
        ]);
    }

    // обновляем значения полей установок
    public function setFacility(Request $request):void
    {
        $this->check_permission();
        $facility_id = (int) $request->facility_id;
        $facility = Facility::findOrFail($facility_id);
        $facility->update(
        [
            'number' => $request->facility_current_number,
            'gos_number' => $request->facility_current_gos_number,
            'area' => $request->facility_current_area,
            'responsible_id' => $request->facility_current_responsible_id,
        ]);
    }
}
