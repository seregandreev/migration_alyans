<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Models\Component;
use App\Models\Conclusion;
use App\Models\Config;
use App\Models\Inspector;
use App\Models\Instrument;
use App\Models\Type;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PDF;

class ReportController extends Controller
{
    public function passport_uzt_vik_mk_gi($id){
        $conclusion = Conclusion::findOrFail($id);
        $component = Component::findOrFail($conclusion->component_id);
        $type = Type::findOrFail($component->type_id);
        $company = Company::findOrFail($component->company_id);
        $inspector = Inspector::findOrFail($conclusion->inspector_id);
        
        // проведённые работы
        $conclusions = Conclusion::where('component_id', $component->id)
            ->where('date', '<=', $conclusion->date)
            // + 04.02.2026 
            ->orderBy('date', 'desc')
            ->take(4)
            // + 04.02.2026
            ->get()
            ->sortBy('date');
        $ecp = Config::where('key', 'ecp')->first();
        $header = Config::where('key', 'header_data')->first();
        $director = Config::where('key', 'director')->first();
        $stamp = Config::where('key', 'stamp')
            ->first();
        $signDirector = Config::where('key', 'signature_director')
            ->first();
        $signInspector = Config::where('key', 'signature_inspector')
            ->first();
        
        $instruments_passport = Instrument::where('control_method', 'ВИК')->get();
        $gost_passport = Config::where('key', 'gost_passport')->first();
        $passport_purpose_passport = Config::where('key', 'passport_purpose')->first();
        
        $gost_uzt = Config::where('key', 'gost_uzt')->first();
        $instruments_uzt = Instrument::where('control_method', 'УЗТ')->get();
        
        $gost_uzk = Config::where('key', 'gost_uzk')->first();
        $instruments_uzk = Instrument::where('control_method', 'УЗК')->get();
        
        $instruments_vik = Instrument::where('control_method', 'ВИК')->get();
        $gost_vik = Config::where('key', 'gost_vik')->first();
        
        $gost_mk = Config::where('key', 'gost_mk')->first();
        $instruments_mk = Instrument::where('control_method', 'МК')->get();
        
        $instruments_gi = Instrument::where('control_method', 'ГИ')->get();
        $gost_gi = Config::where('key', 'gost_gi')->first();
        
        $gost_container = Config::where('key', 'gost_container')
            ->first();
        $gost_armature = Config::where('key', 'gost_armature')
            ->first();
        $gost_requirement = Config::where('key', 'gost_requirement')
            ->first();
            
        // if(!empty($type->crimping_1) && $conclusion->coefficient == 1.5)
        // {
        //     $crimping_1 = (int) $type->crimping_1 * 1.5;
        // } elseif(!empty($type->crimping_1) && $conclusion->coefficient == 2)
        // {
        //     $crimping_1 = (int) $type->crimping_1 * 2;
        // } else {
        //     $crimping_1 = $type->crimping_1;
        // }

        //* 30.03.2024
        if(!empty($conclusion->coefficient) && $conclusion->coefficient == 1.5)
        {
            if(!empty($type->crimping_3))
            {
                $repCrimping3 = strripos($type->crimping_3, ',') ? str_replace(',', '.', $type->crimping_3) : $type->crimping_3;
                $crimping_3 = (float) $repCrimping3 * 1.5;
                $crimping_2 = $type->crimping_2;
            } elseif(!empty($type->crimping_2))
            {
                $repCrimping2 = strripos($type->crimping_2, ',') ? str_replace(',', '.', $type->crimping_2) : $type->crimping_2;
                $crimping_3 = (float) $repCrimping2 * 1.5;
                $crimping_2 = $type->crimping_2;
            } else {
                $repCrimping1 = strripos($type->crimping_1, ',') ? str_replace(',', '.', $type->crimping_1) : $type->crimping_1;
                $crimping_3 = '';
                $crimping_2 = (float) $repCrimping1 * 1.5;
            }
        } elseif(!empty($conclusion->coefficient) && $conclusion->coefficient == 2)
        {
             if(!empty($type->crimping_3))
            {
                $repCrimping3 = strripos($type->crimping_3, ',') ? str_replace(',', '.', $type->crimping_3) : $type->crimping_3;
                $crimping_3 = (float) $repCrimping3 * 2;
                $crimping_2 = $type->crimping_2;
            } elseif(!empty($type->crimping_2))
            {
                $repCrimping2 = strripos($type->crimping_2, ',') ? str_replace(',', '.', $type->crimping_2) : $type->crimping_2;
                $crimping_3 = (float) $repCrimping2 * 2;
                $crimping_2 = $type->crimping_2;
            } else {
                $repCrimping1 = strripos($type->crimping_1, ',') ? str_replace(',', '.', $type->crimping_1) : $type->crimping_1;
                $crimping_3 = '';
                $crimping_2 = (float) $repCrimping1 * 2;
            }
        } elseif(!empty($conclusion->coefficient) && $conclusion->coefficient == 1.25)
        {
             if(!empty($type->crimping_3))
            {
                $repCrimping3 = strripos($type->crimping_3, ',') ? str_replace(',', '.', $type->crimping_3) : $type->crimping_3;
                $crimping_3 = (float) $repCrimping3 * 1.25;
                $crimping_2 = $type->crimping_2;
            } elseif(!empty($type->crimping_2))
            {
                $repCrimping2 = strripos($type->crimping_2, ',') ? str_replace(',', '.', $type->crimping_2) : $type->crimping_2;
                $crimping_3 = (float) $repCrimping2 * 1.25;
                $crimping_2 = $type->crimping_2;
            } else {
                $repCrimping1 = strripos($type->crimping_1, ',') ? str_replace(',', '.', $type->crimping_1) : $type->crimping_1;
                $crimping_3 = '';
                $crimping_2 = (float) $repCrimping1 * 1.25;
            }
        } else {
            $crimping_3 = '';
            $crimping_2 = '';
        }
        
// 		if(!empty($type->crimping_2) && $conclusion->coefficient == 1.5)
//         {
//             $crimping_3 = (int) $type->crimping_2 * 1.5;
//         } elseif(!empty($type->crimping_2) && $conclusion->coefficient == 2)
//         {
//             $crimping_3 = (int) $type->crimping_2 * 2;
//         } else {
//             $crimping_3 = '';
//         }       
        
// 		if(!empty($type->crimping_3) && $conclusion->coefficient == 1.5)
//         {
//             $crimping_3 = (int) $type->crimping_3 * 1.5;
//         } elseif(!empty($type->crimping_3) && $conclusion->coefficient == 2)
//         {
//             $crimping_3 = (int) $type->crimping_3 * 2;
//         } else {
//             $crimping_3 = $type->crimping_3;
//         }
        
        //* 31.03.2024
        if(!empty($component->type()->pressure))
        {
            $repCrimpingMain = strripos($component->type()->pressure, ',') ? str_replace(',', '.', $component->type()->pressure) : $component->type()->pressure;
            if(!empty($conclusion->coefficient) && $conclusion->coefficient == 1.5)
            {
                $crimping = (float) $repCrimpingMain * 1.5;
            } elseif(!empty($conclusion->coefficient) && $conclusion->coefficient == 2)
            {
                // $repCrimpingMain = strripos($component->type()->pressure, ',') ? str_replace(',', '.', $component->type()->pressure) : $component->type()->pressure;
                $crimping = (float) $repCrimpingMain * 2;
            } elseif(!empty($conclusion->coefficient) && $conclusion->coefficient == 1.25) {
                // $repCrimpingMain = strripos($component->type()->pressure, ',') ? str_replace(',', '.', $component->type()->pressure) : $component->type()->pressure;
                $crimping = (float) $repCrimpingMain * 1.25;
            } else {
                $crimping = (float) $repCrimpingMain * 1.5;
            }
        } else {
            $crimping = '';
        }
        
        
        if (preg_match("/$company->abbr" . "_/i", $component->tape_number)) {
            $typeNumber = trim(str_replace($company->abbr . '_', '', $component->tape_number));
        } else {
            $typeNumber = $component->tape_number;
        }
        
    //	$fixPressure = round((int)$component->type()->pressure * 0.04 + (int)$component->type()->pressure, 1); Макс правил) 05.09.22
        $fixPressure = round((int)$conclusion->calibration_pressure * 0.04 + (int)$conclusion->calibration_pressure, 1);
            
        return view('admin.reports.passport_uzt_vik_mk_gi', [
            'conclusion' => $conclusion,
            'type' => $type,
            'component' => $component,
            'company' => $company,
            'inspector' => $inspector,
            'conclusions' => $conclusions,
            'ecp' => $ecp,
            'header' => $header,
            'director' => $director,
            'stamp' => $stamp,
            'signDirector' => $signDirector,
            'signInspector' => $signInspector,

            'instruments_passport' => $instruments_passport,
            'gost_passport' => $gost_passport,
            'passport_purpose_passport' => $passport_purpose_passport,
            
            'gost_uzt' => $gost_uzt,
            'instruments_uzt' => $instruments_uzt,
            'gost_uzk' => $gost_uzk,
            'instruments_uzk' => $instruments_uzk,
            
            'gost_vik' => $gost_vik,
            'instruments_vik' => $instruments_vik,
            
            'gost_mk' => $gost_mk,
            'instruments_mk' => $instruments_mk,
            
            'gost_gi' => $gost_gi,
            'instruments_gi' => $instruments_gi,
// 			'crimping_1' => $crimping_1,
            'crimping_2' => $crimping_2,
            'crimping_3' => $crimping_3,
            'gost_container' => $gost_container,
            'gost_armature' => $gost_armature,
            'gost_requirement' => $gost_requirement,
            'fixPressure' => $fixPressure,
            'typeNumber' => $typeNumber,
            'crimping' => $crimping
            
        ]);	
        
    }
    
    
    public function passport_uzt_vik_mk_gi_pdf($id){
        $conclusion = Conclusion::findOrFail($id);
        $component = Component::findOrFail($conclusion->component_id);
        $type = Type::findOrFail($component->type_id);
        $company = Company::findOrFail($component->company_id);
        $inspector = Inspector::findOrFail($conclusion->inspector_id);
        
        // проведённые работы
        $conclusions = Conclusion::where('component_id', $component->id)
            ->where('date', '<=', $conclusion->date)
            // + 04.02.2026 
            ->orderBy('date', 'desc')
            ->take(4)
            // + 04.02.2026
            ->get()
            ->sortBy('date');
        $ecp = Config::where('key', 'ecp')->first();
        $header = Config::where('key', 'header_data')->first();
        $director = Config::where('key', 'director')->first();
        $stamp = Config::where('key', 'stamp')->first();
        $signDirector = Config::where('key', 'signature_director')->first();
        $signInspector = Config::where('key', 'signature_inspector')->first();
        
        $instruments_passport = Instrument::where('control_method', 'ВИК')->get();
        $gost_passport = Config::where('key', 'gost_passport')->first();
        $passport_purpose_passport = Config::where('key', 'passport_purpose')->first();
        
        $arr_create_pdf_data['conclusion'] = $conclusion;
        $arr_create_pdf_data['type'] = $type;
        $arr_create_pdf_data['company'] = $company;
        $arr_create_pdf_data['component'] = $component;
        $arr_create_pdf_data['inspector'] = $inspector;
        $arr_create_pdf_data['conclusions'] = $conclusions;
        $arr_create_pdf_data['ecp'] = $ecp;
        $arr_create_pdf_data['header'] = $header;
        $arr_create_pdf_data['director'] = $director;
        $arr_create_pdf_data['stamp'] = $stamp;
        $arr_create_pdf_data['signDirector'] = $signDirector;
        $arr_create_pdf_data['signInspector'] = $signInspector;
        
        $arr_create_pdf_data['instruments_passport'] = $instruments_passport;
        $arr_create_pdf_data['gost_passport'] = $gost_passport;
        $arr_create_pdf_data['passport_purpose_passport'] = $passport_purpose_passport;
        
        if (preg_match("/$company->abbr" . "_/i", $component->tape_number)) {
            $typeNumber = trim(str_replace($company->abbr . '_', '', $component->tape_number));
        } else {
            $typeNumber = $component->tape_number;
        }
        $arr_create_pdf_data['typeNumber'] = $typeNumber;
        
        if(!empty($conclusion->uzt_result)){
            $gost_uzt = Config::where('key', 'gost_uzt')->first();
            $instruments_uzt = Instrument::where('control_method', 'УЗТ')->get();
            $arr_create_pdf_data['gost_uzt'] = $gost_uzt;
            $arr_create_pdf_data['instruments_uzt'] = $instruments_uzt;
        }
        if(!empty($conclusion->uzk_result)){
            $gost_uzk = Config::where('key', 'gost_uzk')->first();
            $instruments_uzk = Instrument::where('control_method', 'УЗК')->get();
            $arr_create_pdf_data['gost_uzk'] = $gost_uzk;
            $arr_create_pdf_data['instruments_uzk'] = $instruments_uzk;
        }
        
        if(!empty($conclusion->vik_result)){
            $instruments_vik = Instrument::where('control_method', 'ВИК')->get();
            $gost_vik = Config::where('key', 'gost_vik')->first();
            $arr_create_pdf_data['gost_vik'] = $gost_vik;
            $arr_create_pdf_data['instruments_vik'] = $instruments_vik;
        }
        
        if(!empty($conclusion->mk_result)){
            $gost_mk = Config::where('key', 'gost_mk')->first();
            $instruments_mk = Instrument::where('control_method', 'МК')->get();
            $arr_create_pdf_data['gost_mk'] = $gost_mk;
            $arr_create_pdf_data['instruments_mk'] = $instruments_mk;
        }
        
        if(!empty($conclusion->gi_result)){
            $instruments_gi = Instrument::where('control_method', 'ГИ')->get();
            $gost_gi = Config::where('key', 'gost_gi')->first();
            $arr_create_pdf_data['gost_gi'] = $gost_gi;
            $arr_create_pdf_data['instruments_gi'] = $instruments_gi;
        }
        
        if(!empty($conclusion->calibration_pressure)) {
            $gost_container = Config::where('key', 'gost_container')->first();
            $gost_armature = Config::where('key', 'gost_armature')->first();
            $gost_requirement = Config::where('key', 'gost_requirement')->first();
            $arr_create_pdf_data['gost_container'] = $gost_container;
            $arr_create_pdf_data['gost_armature'] = $gost_armature;
            $arr_create_pdf_data['gost_requirement'] = $gost_requirement;
        }
 
        // if(!empty($conclusion->coefficient) && !empty($type->crimping_1)) {
        //     if($conclusion->coefficient == 1.5)
        //     {
        //         $crimping_1 = (int) $type->crimping_1 * 1.5;
        //     } elseif($conclusion->coefficient == 2)
        //     {
        //         $crimping_1 = (int) $type->crimping_1 * 2;
        //     } else {
        //         $crimping_1 = $type->crimping_1;
        //     }
        //     $arr_create_pdf_data['crimping_1'] = $crimping_1;
        // }

        //* 30.03.2024
        if(!empty($conclusion->coefficient) && $conclusion->coefficient == 1.5)
        {
            if(!empty($type->crimping_3))
            {
                $repCrimping3 = strripos($type->crimping_3, ',') ? str_replace(',', '.', $type->crimping_3) : $type->crimping_3;
                $crimping_3 = (float) $repCrimping3 * 1.5;
                $crimping_2 = $type->crimping_2;
            } elseif(!empty($type->crimping_2))
            {
                $repCrimping2 = strripos($type->crimping_2, ',') ? str_replace(',', '.', $type->crimping_2) : $type->crimping_2;
                $crimping_3 = (float) $repCrimping2 * 1.5;
                $crimping_2 = $type->crimping_2;
            } else {
                $repCrimping1 = strripos($type->crimping_1, ',') ? str_replace(',', '.', $type->crimping_1) : $type->crimping_1;
                $crimping_3 = '';
                $crimping_2 = (float) $repCrimping1 * 1.5;
            }
        } elseif(!empty($conclusion->coefficient) && $conclusion->coefficient == 2)
        {
             if(!empty($type->crimping_3))
            {
                $repCrimping3 = strripos($type->crimping_3, ',') ? str_replace(',', '.', $type->crimping_3) : $type->crimping_3;
                $crimping_3 = (float) $repCrimping3 * 2;
                $crimping_2 = $type->crimping_2;
            } elseif(!empty($type->crimping_2))
            {
                $repCrimping2 = strripos($type->crimping_2, ',') ? str_replace(',', '.', $type->crimping_2) : $type->crimping_2;
                $crimping_3 = (float) $repCrimping2 * 2;
                $crimping_2 = $type->crimping_2;
            } else {
                $repCrimping1 = strripos($type->crimping_1, ',') ? str_replace(',', '.', $type->crimping_1) : $type->crimping_1;
                $crimping_3 = '';
                $crimping_2 = (float) $repCrimping1 * 2;
            }
        } elseif(!empty($conclusion->coefficient) && $conclusion->coefficient == 1.25)
        {
             if(!empty($type->crimping_3))
            {
                $repCrimping3 = strripos($type->crimping_3, ',') ? str_replace(',', '.', $type->crimping_3) : $type->crimping_3;
                $crimping_3 = (float) $repCrimping3 * 1.25;
                $crimping_2 = $type->crimping_2;
            } elseif(!empty($type->crimping_2))
            {
                $repCrimping2 = strripos($type->crimping_2, ',') ? str_replace(',', '.', $type->crimping_2) : $type->crimping_2;
                $crimping_3 = (float) $repCrimping2 * 1.25;
                $crimping_2 = $type->crimping_2;
            } else {
                $repCrimping1 = strripos($type->crimping_1, ',') ? str_replace(',', '.', $type->crimping_1) : $type->crimping_1;
                $crimping_3 = '';
                $crimping_2 = (float) $repCrimping1 * 1.25;
            }
        } else {
            $crimping_3 = '';
            $crimping_2 = '';
        }
 
         //* 31.03.2024
        if(!empty($component->type()->pressure))
        {
            $repCrimpingMain = strripos($component->type()->pressure, ',') ? str_replace(',', '.', $component->type()->pressure) : $component->type()->pressure;
            if(!empty($conclusion->coefficient) && $conclusion->coefficient == 1.5)
            {
                $crimping = (float) $repCrimpingMain * 1.5;
            } elseif(!empty($conclusion->coefficient) && $conclusion->coefficient == 2)
            {
                // $repCrimpingMain = strripos($component->type()->pressure, ',') ? str_replace(',', '.', $component->type()->pressure) : $component->type()->pressure;
                $crimping = (float) $repCrimpingMain * 2;
            } elseif(!empty($conclusion->coefficient) && $conclusion->coefficient == 1.25) {
                // $repCrimpingMain = strripos($component->type()->pressure, ',') ? str_replace(',', '.', $component->type()->pressure) : $component->type()->pressure;
                $crimping = (float) $repCrimpingMain * 1.25;
            } else {
                $crimping = (float) $repCrimpingMain * 1.5;
            }
        } else {
            $crimping = '';
        }
        
        $arr_create_pdf_data['crimping_2'] = $crimping_2;
        $arr_create_pdf_data['crimping_3'] = $crimping_3;
        $arr_create_pdf_data['crimping'] = $crimping;
       
        // if(!empty($conclusion->coefficient) && !empty($type->crimping_2)) {
        //     if($conclusion->coefficient == 1.5)
        //     {
        //         $crimping_3 = (int) $type->crimping_2 * 1.5;
        //     } elseif($conclusion->coefficient == 2)
        //     {
        //         $crimping_3 = (int) $type->crimping_2 * 2;
        //     } else {
        //         $crimping_3 = '';
        //     }
        //     $arr_create_pdf_data['crimping_3'] = $crimping_3;
        // }
        
        // if(!empty($conclusion->coefficient) && !empty($type->crimping_3)) {
        //     if($conclusion->coefficient == 1.5)
        //     {
        //         $crimping_3 = (int) $type->crimping_3 * 1.5;
        //     } elseif($conclusion->coefficient == 2)
        //     {
        //         $crimping_3 = (int) $type->crimping_3 * 2;
        //     } else {
        //         $crimping_3 = $type->crimping_3;
        //     }
        //     $arr_create_pdf_data['crimping_3'] = $crimping_3;
        // }
        
        if(!empty($conclusion->calibration_pressure)){
            $fixPressure = round((int)$conclusion->calibration_pressure * 0.04 + (int)$conclusion->calibration_pressure, 1);
            $arr_create_pdf_data['fixPressure'] = $fixPressure;
        }

        $pdf = PDF::loadView('admin.reports.passport_uzt_vik_mk_gi_pdf', $arr_create_pdf_data);    
        $pdf_name = $id. '_' . $component->tape_number . '_' . $conclusion->date . '.pdf';
        //$pdf->save(storage_path().'/pdf/'.$pdf_name);
        
        
        return $pdf->download($pdf_name);	
        
    }
    
    public function passport_uzt_vik_mk_gi_pdf_ecp($id){
        $conclusion = Conclusion::findOrFail($id);
        $component = Component::findOrFail($conclusion->component_id);
        $type = Type::findOrFail($component->type_id);
        $company = Company::findOrFail($component->company_id);
        $inspector = Inspector::findOrFail($conclusion->inspector_id);
        
        // проведённые работы
        $conclusions = Conclusion::where('component_id', $component->id)
            ->where('date', '<=', $conclusion->date)
            // + 04.02.2026 
            ->orderBy('date', 'desc')
            ->take(4)
            // + 04.02.2026
            ->get()
            ->sortBy('date');
        $ecp = Config::where('key', 'ecp')->first();
        $header = Config::where('key', 'header_data')->first();
        $director = Config::where('key', 'director')->first();
        
        $instruments_passport = Instrument::where('control_method', 'ВИК')->get();
        $gost_passport = Config::where('key', 'gost_passport')->first();
        $passport_purpose_passport = Config::where('key', 'passport_purpose')->first();
        
        $arr_create_pdf_data['conclusion'] = $conclusion;
        $arr_create_pdf_data['type'] = $type;
        $arr_create_pdf_data['company'] = $company;
        $arr_create_pdf_data['component'] = $component;
        $arr_create_pdf_data['inspector'] = $inspector;
        $arr_create_pdf_data['conclusions'] = $conclusions;
        $arr_create_pdf_data['ecp'] = $ecp;
        $arr_create_pdf_data['header'] = $header;
        $arr_create_pdf_data['director'] = $director;
        
        $arr_create_pdf_data['instruments_passport'] = $instruments_passport;
        $arr_create_pdf_data['gost_passport'] = $gost_passport;
        $arr_create_pdf_data['passport_purpose_passport'] = $passport_purpose_passport;
        
        if(!empty($conclusion->uzt_result)){
            $gost_uzt = Config::where('key', 'gost_uzt')->first();
            $instruments_uzt = Instrument::where('control_method', 'УЗТ')->get();
            $arr_create_pdf_data['gost_uzt'] = $gost_uzt;
            $arr_create_pdf_data['instruments_uzt'] = $instruments_uzt;
        }
        
        if(!empty($conclusion->uzk_result)){
            $gost_uzk = Config::where('key', 'gost_uzk')->first();
            $instruments_uzk = Instrument::where('control_method', 'УЗК')->get();
            $arr_create_pdf_data['gost_uzk'] = $gost_uzk;
            $arr_create_pdf_data['instruments_uzk'] = $instruments_uzk;
        }	
        
        if(!empty($conclusion->vik_result)){
            $instruments_vik = Instrument::where('control_method', 'ВИК')->get();
            $gost_vik = Config::where('key', 'gost_vik')->first();
            $arr_create_pdf_data['gost_vik'] = $gost_vik;
            $arr_create_pdf_data['instruments_vik'] = $instruments_vik;
        }
        
        if(!empty($conclusion->mk_result)){
            $gost_mk = Config::where('key', 'gost_mk')->first();
            $instruments_mk = Instrument::where('control_method', 'МК')->get();
            $arr_create_pdf_data['gost_mk'] = $gost_mk;
            $arr_create_pdf_data['instruments_mk'] = $instruments_mk;
        }
        
        if(!empty($conclusion->gi_result)){
            $instruments_gi = Instrument::where('control_method', 'ГИ')->get();
            $gost_gi = Config::where('key', 'gost_gi')->first();
            $arr_create_pdf_data['gost_gi'] = $gost_gi;
            $arr_create_pdf_data['instruments_gi'] = $instruments_gi;
        }
        
        if(!empty($conclusion->calibration_pressure)) {
            $gost_container = Config::where('key', 'gost_container')->first();
            $gost_armature = Config::where('key', 'gost_armature')->first();
            $gost_requirement = Config::where('key', 'gost_requirement')->first();
            $arr_create_pdf_data['gost_container'] = $gost_container;
            $arr_create_pdf_data['gost_armature'] = $gost_armature;
            $arr_create_pdf_data['gost_requirement'] = $gost_requirement;
        }
        
        if (preg_match("/$company->abbr" . "_/i", $component->tape_number)) {
            $typeNumber = trim(str_replace($company->abbr . '_', '', $component->tape_number));
        } else {
            $typeNumber = $component->tape_number;
        }
        $arr_create_pdf_data['typeNumber'] = $typeNumber;
        
        //* 30.03.2024
        if(!empty($conclusion->coefficient) && $conclusion->coefficient == 1.5)
        {
            if(!empty($type->crimping_3))
            {
                $repCrimping3 = strripos($type->crimping_3, ',') ? str_replace(',', '.', $type->crimping_3) : $type->crimping_3;
                $crimping_3 = (float) $repCrimping3 * 1.5;
                $crimping_2 = $type->crimping_2;
            } elseif(!empty($type->crimping_2))
            {
                $repCrimping2 = strripos($type->crimping_2, ',') ? str_replace(',', '.', $type->crimping_2) : $type->crimping_2;
                $crimping_3 = (float) $repCrimping2 * 1.5;
                $crimping_2 = $type->crimping_2;
            } else {
                $repCrimping1 = strripos($type->crimping_1, ',') ? str_replace(',', '.', $type->crimping_1) : $type->crimping_1;
                $crimping_3 = '';
                $crimping_2 = (float) $repCrimping1 * 1.5;
            }
        } elseif(!empty($conclusion->coefficient) && $conclusion->coefficient == 2)
        {
             if(!empty($type->crimping_3))
            {
                $repCrimping3 = strripos($type->crimping_3, ',') ? str_replace(',', '.', $type->crimping_3) : $type->crimping_3;
                $crimping_3 = (float) $repCrimping3 * 2;
                $crimping_2 = $type->crimping_2;
            } elseif(!empty($type->crimping_2))
            {
                $repCrimping2 = strripos($type->crimping_2, ',') ? str_replace(',', '.', $type->crimping_2) : $type->crimping_2;
                $crimping_3 = (float) $repCrimping2 * 2;
                $crimping_2 = $type->crimping_2;
            } else {
                $repCrimping1 = strripos($type->crimping_1, ',') ? str_replace(',', '.', $type->crimping_1) : $type->crimping_1;
                $crimping_3 = '';
                $crimping_2 = (float) $repCrimping1 * 2;
            }
        } elseif(!empty($conclusion->coefficient) && $conclusion->coefficient == 1.25)
        {
             if(!empty($type->crimping_3))
            {
                $repCrimping3 = strripos($type->crimping_3, ',') ? str_replace(',', '.', $type->crimping_3) : $type->crimping_3;
                $crimping_3 = (float) $repCrimping3 * 1.25;
                $crimping_2 = $type->crimping_2;
            } elseif(!empty($type->crimping_2))
            {
                $repCrimping2 = strripos($type->crimping_2, ',') ? str_replace(',', '.', $type->crimping_2) : $type->crimping_2;
                $crimping_3 = (float) $repCrimping2 * 1.25;
                $crimping_2 = $type->crimping_2;
            } else {
                $repCrimping1 = strripos($type->crimping_1, ',') ? str_replace(',', '.', $type->crimping_1) : $type->crimping_1;
                $crimping_3 = '';
                $crimping_2 = (float) $repCrimping1 * 1.25;
            }
        } else {
            $crimping_3 = '';
            $crimping_2 = '';
        }

         //* 31.03.2024
        if(!empty($component->type()->pressure))
        {
            $repCrimpingMain = strripos($component->type()->pressure, ',') ? str_replace(',', '.', $component->type()->pressure) : $component->type()->pressure;
            if(!empty($conclusion->coefficient) && $conclusion->coefficient == 1.5)
            {
                $crimping = (float) $repCrimpingMain * 1.5;
            } elseif(!empty($conclusion->coefficient) && $conclusion->coefficient == 2)
            {
                // $repCrimpingMain = strripos($component->type()->pressure, ',') ? str_replace(',', '.', $component->type()->pressure) : $component->type()->pressure;
                $crimping = (float) $repCrimpingMain * 2;
            } elseif(!empty($conclusion->coefficient) && $conclusion->coefficient == 1.25) {
                // $repCrimpingMain = strripos($component->type()->pressure, ',') ? str_replace(',', '.', $component->type()->pressure) : $component->type()->pressure;
                $crimping = (float) $repCrimpingMain * 1.25;
            } else {
                $crimping = (float) $repCrimpingMain * 1.5;
            }
        } else {
            $crimping = '';
        }
        
        $arr_create_pdf_data['crimping_2'] = $crimping_2;
        $arr_create_pdf_data['crimping_3'] = $crimping_3;
        $arr_create_pdf_data['crimping'] = $crimping;
        
        // if(!empty($conclusion->coefficient) && !empty($type->crimping_2)) {
        //     if($conclusion->coefficient == 1.5)
        //     {
        //         $crimping_3 = (int) $type->crimping_2 * 1.5;
        //     } elseif($conclusion->coefficient == 2)
        //     {
        //         $crimping_3 = (int) $type->crimping_2 * 2;
        //     } else {
        //         $crimping_3 = '';
        //     }
        //     $arr_create_pdf_data['crimping_3'] = $crimping_3;
        // }
        
        // if(!empty($conclusion->coefficient) && !empty($type->crimping_3)) {
        //     if($conclusion->coefficient == 1.5)
        //     {
        //         $crimping_3 = $type->crimping_3 * 1.5;
        //     } elseif($conclusion->coefficient == 2)
        //     {
        //         $crimping_3 = (int) $type->crimping_3 * 2;
        //     } else {
        //         $crimping_3 = (int) $type->crimping_3;
        //     }
        //     $arr_create_pdf_data['crimping_3'] = $crimping_3;
        // }
        
        if(!empty($conclusion->calibration_pressure)){
            $fixPressure = round((int)$component->type()->pressure * 0.04 + (int)$component->type()->pressure, 1);
            $arr_create_pdf_data['fixPressure'] = $fixPressure;
        }
        
        $pdf = PDF::loadView('admin.reports.passport_uzt_vik_mk_gi_pdf', $arr_create_pdf_data);    
        $pdf_name = $id. '_' . $component->tape_number . '_' . $conclusion->date . '.pdf';
        $pdf->save(storage_path().'/pdf/'.$pdf_name);
        
        $pdf_path = storage_path().'/pdf/'.$pdf_name;
        
        return $pdf_path;
        
    }
    
    
    /*
     * отчёт МК
     */
    public function mk($id)
    {
        // основные параметры
        $conclusion = Conclusion::findOrFail($id);
        $component = Component::findOrFail($conclusion->component_id);
        $type = Type::findOrFail($component->type_id);
        $company = Company::findOrFail($component->company_id);
        $inspector = Inspector::findOrFail($conclusion->inspector_id);
        // дополнительные
        $instruments = Instrument::where('control_method', 'МК')
            ->get();
        $header = Config::where('key', 'header_data')
            ->first();
        $director = Config::where('key', 'director')
            ->first();
        $gost_mk = Config::where('key', 'gost_mk')
            ->first();
        $ecp = Config::where('key', 'ecp')
            ->first();
        $stamp = Config::where('key', 'stamp')
            ->first();
        $signDirector = Config::where('key', 'signature_director')
            ->first();
        $signInspector = Config::where('key', 'signature_inspector')
            ->first();
        
        if (preg_match("/$company->abbr" . "_/i", $component->tape_number)) {
            $typeNumber = trim(str_replace($company->abbr . '_', '', $component->tape_number));
        } else {
            $typeNumber = $component->tape_number;
        }			
            
/* 		$pdf = PDF::loadView('admin.reports.mk', [
            'id' => $id,
            'conclusion' => $conclusion,
            'type' => $type,
            'component' => $component,
            'company' => $company,
            'inspector' => $inspector,
            'instruments' => $instruments,
            'header' => $header,
            'director' => $director,
            'gost_mk' => $gost_mk,
            'ecp' => $ecp
            'stamp' => $stamp,
            'signDirector' => $signDirector,
            'signInspector' => $signInspector,
            //'img_output' => base64_encode( base64_decode( $img_output ),
        ]);    
        return $pdf->download('demo.pdf'); */	


        return view('admin.reports.mk', [
            'id' => $id,
            'conclusion' => $conclusion,
            'type' => $type,
            'component' => $component,
            'company' => $company,
            'inspector' => $inspector,
            'instruments' => $instruments,
            'header' => $header,
            'director' => $director,
            'gost_mk' => $gost_mk,
            'ecp' => $ecp,
            'stamp' => $stamp,
            'signDirector' => $signDirector,
            'signInspector' => $signInspector,
            'typeNumber' => $typeNumber,
            'pdf' => base64_encode(''),
        ]);
    }

    /*
     * отчёт УЗК
     */
    public function uzt($id)
    {
        // основные параметры
        $conclusion = Conclusion::findOrFail($id);
        $component = Component::findOrFail($conclusion->component_id);
        $type = Type::findOrFail($component->type_id);
        $company = Company::findOrFail($component->company_id);
        $inspector = Inspector::findOrFail($conclusion->inspector_id);
        // дополнительные
        $instruments = Instrument::where('control_method', 'УЗТ')
            ->get();
        $header = Config::where('key', 'header_data')
            ->first();
        $director = Config::where('key', 'director')
            ->first();
        $gost_uzt = Config::where('key', 'gost_uzt')
            ->first();
        $ecp = Config::where('key', 'ecp')
            ->first();
        $stamp = Config::where('key', 'stamp')
            ->first();
        $signDirector = Config::where('key', 'signature_director')
            ->first();
        $signInspector = Config::where('key', 'signature_inspector')
            ->first();
            
        if (preg_match("/$company->abbr" . "_/i", $component->tape_number)) {
            $typeNumber = trim(str_replace($company->abbr . '_', '', $component->tape_number));
        } else {
            $typeNumber = $component->tape_number;
        }

        return view('admin.reports.uzt', [
            'conclusion' => $conclusion,
            'type' => $type,
            'component' => $component,
            'company' => $company,
            'inspector' => $inspector,
            'instruments' => $instruments,
            'header' => $header,
            'director' => $director,
            'gost_uzt' => $gost_uzt,
            'ecp' => $ecp,
            'stamp' => $stamp,
            'signDirector' => $signDirector,
            'signInspector' => $signInspector,
            'typeNumber' => $typeNumber
        ]);
    }

    /*
     * отчёт УЗК
     */
    public function uzk($id)
    {
        // основные параметры
        $conclusion = Conclusion::findOrFail($id);
        $component = Component::findOrFail($conclusion->component_id);
        $type = Type::findOrFail($component->type_id);
        $company = Company::findOrFail($component->company_id);
        $inspector = Inspector::findOrFail($conclusion->inspector_id);
        // дополнительные
        $instrumentsUzt = Instrument::where('control_method', 'УЗТ')
            ->get();
        $instrumentsVik = Instrument::where('control_method', 'ВИК')
            ->get();
        $instrumentsUzk = Instrument::where('control_method', 'УЗК')
            ->get();
        $header = Config::where('key', 'header_data')
            ->first();
        $director = Config::where('key', 'director')
            ->first();
        $gost_uzk = Config::where('key', 'gost_uzk')
            ->first();
        $ecp = Config::where('key', 'ecp')
            ->first();
        $stamp = Config::where('key', 'stamp')
            ->first();
        $signDirector = Config::where('key', 'signature_director')
            ->first();
        $signInspector = Config::where('key', 'signature_inspector')
            ->first();

        if (preg_match("/$company->abbr" . "_/i", $component->tape_number)) {
            $typeNumber = trim(str_replace($company->abbr . '_', '', $component->tape_number));
        } else {
            $typeNumber = $component->tape_number;
        }
        
        return view('admin.reports.uzk', [
            'conclusion' => $conclusion,
            'type' => $type,
            'component' => $component,
            'company' => $company,
            'inspector' => $inspector,
            'instrumentsUzt' => $instrumentsUzt,
            'instrumentsVik' => $instrumentsVik,
            'instrumentsUzk' => $instrumentsUzk,
            'header' => $header,
            'director' => $director,
            'gost_uzk' => $gost_uzk,
            'ecp' => $ecp,
            'stamp' => $stamp,
            'signDirector' => $signDirector,
            'signInspector' => $signInspector,
            'typeNumber' => $typeNumber
        ]);
    }

    /*
     * отчёт ВИК
     */
    public function vik($id)
    {
        // основные параметры
        $conclusion = Conclusion::findOrFail($id);
        $component = Component::findOrFail($conclusion->component_id);
        $type = Type::findOrFail($component->type_id);
        $company = Company::findOrFail($component->company_id);
        $inspector = Inspector::findOrFail($conclusion->inspector_id);
        // дополнительные
        $instruments = Instrument::where('control_method', 'ВИК')
            ->get();
        $header = Config::where('key', 'header_data')
            ->first();
        $director = Config::where('key', 'director')
            ->first();
        $gost_vik = Config::where('key', 'gost_vik')
            ->first();
        $ecp = Config::where('key', 'ecp')
            ->first();
        $stamp = Config::where('key', 'stamp')
            ->first();
        $signDirector = Config::where('key', 'signature_director')
            ->first();
        $signInspector = Config::where('key', 'signature_inspector')
            ->first();

        if (preg_match("/$company->abbr" . "_/i", $component->tape_number)) {
            $typeNumber = trim(str_replace($company->abbr . '_', '', $component->tape_number));
        } else {
            $typeNumber = $component->tape_number;
        }

        return view('admin.reports.vik', [
            'conclusion' => $conclusion,
            'type' => $type,
            'component' => $component,
            'company' => $company,
            'inspector' => $inspector,
            'instruments' => $instruments,
            'header' => $header,
            'director' => $director,
            'gost_vik' => $gost_vik,
            'ecp' => $ecp,
            'stamp' => $stamp,
            'signDirector' => $signDirector,
            'signInspector' => $signInspector,
            'typeNumber' => $typeNumber
        ]);
    }

    /*
     * отчёт ГИ
     */
    public function gi($id)
    {
        // основные параметры
        $conclusion = Conclusion::findOrFail($id);
        $component = Component::findOrFail($conclusion->component_id);
        $type = Type::findOrFail($component->type_id);
        $company = Company::findOrFail($component->company_id);
        $inspector = Inspector::findOrFail($conclusion->inspector_id);
        // дополнительные
        $instruments = Instrument::where('control_method', 'ГИ')
            ->get();
        $header = Config::where('key', 'header_data')
            ->first();
        $director = Config::where('key', 'director')
            ->first();
        $gost_gi = Config::where('key', 'gost_gi')
            ->first();
        $ecp = Config::where('key', 'ecp')
            ->first();
        $stamp = Config::where('key', 'stamp')
            ->first();
        $signDirector = Config::where('key', 'signature_director')
            ->first();
        $signInspector = Config::where('key', 'signature_inspector')
            ->first();

        if (preg_match("/$company->abbr" . "_/i", $component->tape_number)) {
            $typeNumber = trim(str_replace($company->abbr . '_', '', $component->tape_number));
        } else {
            $typeNumber = $component->tape_number;
        }
        
        return view('admin.reports.gi', [
            'conclusion' => $conclusion,
            'type' => $type,
            'component' => $component,
            'company' => $company,
            'inspector' => $inspector,
            'instruments' => $instruments,
            'header' => $header,
            'director' => $director,
            'gost_gi' => $gost_gi,
            'ecp' => $ecp,
            'stamp' => $stamp,
            'signDirector' => $signDirector,
            'signInspector' => $signInspector,
            'typeNumber' => $typeNumber
        ]);
    }

    /*
     * Паспорт заключения
     */
    public function passport($id)
    {
        // основные параметры
        $conclusion = Conclusion::findOrFail($id);
        $component = Component::findOrFail($conclusion->component_id);
        $type = Type::findOrFail($component->type_id);
        $company = Company::findOrFail($component->company_id);
        $inspector = Inspector::findOrFail($conclusion->inspector_id);
        // дополнительные
        $instruments = Instrument::where('control_method', 'ВИК')
            ->get();
        $header = Config::where('key', 'header_data')
            ->first();
        $director = Config::where('key', 'director')
            ->first();
        $gost_passport = Config::where('key', 'gost_passport')
            ->first();
        $passport_purpose = Config::where('key', 'passport_purpose')
            ->first();
        // проведённые работы
        $conclusions = Conclusion::where('component_id', $component->id)
            ->where('date', '<=', $conclusion->date)
            // + 04.02.2026 
            // ->orderBy('date', 'desc')
            // ->take(4)
            // + 04.02.2026
            ->get();
            // ->sortBy('date')
        $ecp = Config::where('key', 'ecp')
            ->first();
        $stamp = Config::where('key', 'stamp')
            ->first();
        $signDirector = Config::where('key', 'signature_director')
            ->first();
        $signInspector = Config::where('key', 'signature_inspector')
            ->first();

        //* 31.03.2024
        if(!empty($component->type()->pressure))
        {
            $repCrimpingMain = strripos($component->type()->pressure, ',') ? str_replace(',', '.', $component->type()->pressure) : $component->type()->pressure;
            if(!empty($conclusion->coefficient) && $conclusion->coefficient == 1.5)
            {
                $crimping = (float) $repCrimpingMain * 1.5;
            } elseif(!empty($conclusion->coefficient) && $conclusion->coefficient == 2)
            {
                // $repCrimpingMain = strripos($component->type()->pressure, ',') ? str_replace(',', '.', $component->type()->pressure) : $component->type()->pressure;
                $crimping = (float) $repCrimpingMain * 2;
            } elseif(!empty($conclusion->coefficient) && $conclusion->coefficient == 1.25) {
                // $repCrimpingMain = strripos($component->type()->pressure, ',') ? str_replace(',', '.', $component->type()->pressure) : $component->type()->pressure;
                $crimping = (float) $repCrimpingMain * 1.25;
            } else {
                $crimping = (float) $repCrimpingMain * 1.5;
            }
        } else {
            $crimping = '';
        }
        
        if (preg_match("/$company->abbr" . "_/i", $component->tape_number)) {
            $typeNumber = trim(str_replace($company->abbr . '_', '', $component->tape_number));
        } else {
            $typeNumber = $component->tape_number;
        }
        
        return view('admin.reports.passport', [
            'conclusion' => $conclusion,
            'type' => $type,
            'component' => $component,
            'company' => $company,
            'inspector' => $inspector,
            'instruments' => $instruments,
            'header' => $header,
            'director' => $director,
            'gost_passport' => $gost_passport,
            'passport_purpose' => $passport_purpose,
            'conclusions' => $conclusions,
            'ecp' => $ecp,
            'stamp' => $stamp,
            'signDirector' => $signDirector,
            'signInspector' => $signInspector,
            'typeNumber' => $typeNumber,
            'crimping' => $crimping
        ]);
    }




    /*
     * Общие отчёты
     */



    /*
     * Общий отчёт
     */
    public function general_all()
    {
        // основные параметры
        $conclusions = Conclusion::select('conclusions.*')
            ->leftJoin('components', 'conclusions.component_id', '=', 'components.id');

        if(session()->get('conclusion_unit_id') !== null)
            $conclusions = $conclusions->where('components.unit_id', session()->get('conclusion_unit_id'));
        if(session()->get('conclusion_facility') !== null)
            $conclusions = $conclusions->where('components.facility_id', session()->get('conclusion_facility_id'));
        if(session()->get('conclusion_date') !== null)
            $conclusions = $conclusions->where('conclusions.date', session()->get('conclusion_date'));
        if(session()->get('conclusion_tape_number') !== null)
            $conclusions = $conclusions->where('components.tape_number', session()->get('conclusion_tape_number'));
        if(session()->get('conclusion_serial_number') !== null)
            $conclusions = $conclusions->where('components.serial_number', session()->get('conclusion_serial_number'));

        $conclusions = $conclusions->get();

      $header = Config::where('key', 'header_data')
           ->first();
       $director = Config::where('key', 'director')
          ->first();
        // проведённые работы
        $ecp = Config::where('key', 'ecp')
            ->first();
        $stamp = Config::where('key', 'stamp')
            ->first();
        $signDirector = Config::where('key', 'signature_director')
            ->first();
        $signInspector = Config::where('key', 'signature_inspector')
            ->first();
        $unit = Unit::findOrFail(session()->get('conclusion_unit_id'));


        return view('admin.reports.general.general', [
            'conclusions' => $conclusions,
            'ecp' => $ecp,
            'unit' => $unit,
            'header' => $header,
            'director' => $director,
            'stamp' => $stamp,
            'signDirector' => $signDirector,
            'signInspector' => $signInspector,
        ]);
        
        
    }
    /*
     * Отчёт в excel
     */
    public function general_excel()
    {

        // основной запрос (даные в таблице)
        $conclusions = Conclusion::select('conclusions.*')
            ->leftJoin('components', 'conclusions.component_id', '=', 'components.id');

        if(session()->get('conclusion_unit_id') !== null)
            $conclusions = $conclusions->where('components.unit_id', session()->get('conclusion_unit_id'));
        if(session()->get('conclusion_facility') !== null)
            $conclusions = $conclusions->where('components.facility', session()->get('conclusion_facility'));
        if(session()->get('conclusion_date') !== null)
            $conclusions = $conclusions->where('conclusions.date', session()->get('conclusion_date'));
        if(session()->get('conclusion_tape_number') !== null)
            $conclusions = $conclusions->where('components.tape_number', session()->get('conclusion_tape_number'));
        if(session()->get('conclusion_serial_number') !== null)
            $conclusions = $conclusions->where('components.serial_number', session()->get('conclusion_serial_number'));

        $conclusions = $conclusions->get();

        // счётчик заключений

        $itog_vik = 0;
        $itog_uzt = 0;
        $itog_mk = 0;
        $itog_gi = 0;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(35);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(23);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(45);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(18);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(12);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(13);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(13);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(17);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(30);

        $sheet->mergeCells('A1:L1');

        // дата заключения (из фильтра)
        if(session()->get('conclusion_date') !== null)
        {
            $date_exp = explode('-', session()->get('conclusion_date'));
            $date_report = $date_exp[2].'-'.$date_exp[1].'-'.$date_exp[0];
        } else
            $date_report = 'Не указано';

        // база (из фильтра)
        if(session()->get('conclusion_unit_id') !== null)
        {
            $unit = Unit::findOrFail(session()->get('conclusion_unit_id'));
            $unit_name = $unit->name;
        } else
            $unit_name = 'Не указано';

        // установка (из фильтра)
        if(session()->get('conclusion_facility') !== null)
        {
            $facility_name = session()->get('conclusion_facility');
        } else
            $facility_name = 'Не указано';

        $sheet->setCellValue('A1', 'База неразрушающего контроля (дефектоскопии) оборудования '.$unit_name.'  (от '.$date_report.' '.$facility_name.')');

        $sheet->mergeCells('A2:L2');
        $sheet->setCellValue('A2', 'Исполнитель неразрушающего контроля ООО "АльянсЭксперт"');

        $sheet->setCellValue('A3', '№');
        $sheet->setCellValue('B3', 'Результат заключения');
        $sheet->setCellValue('C3', 'Тип');
        $sheet->setCellValue('D3', 'Описание');
        $sheet->setCellValue('E3', 'Серийный номер');
        $sheet->setCellValue('F3', 'Номер ленты');
        $sheet->setCellValue('G3', 'Производитель');
        $sheet->setCellValue('H3', 'Флот');
        $sheet->setCellValue('I3', 'Дата');
        $sheet->setCellValue('J3', 'Остаточный ресурс');
        $sheet->setCellValue('K3', 'Гидроиспытания');
        $sheet->setCellValue('L3', 'Исполнитель');

        $spreadsheet->getActiveSheet()->getStyle('A3:L3')->getFont()->setBold(true);



        $spreadsheet->getActiveSheet()
            ->getStyle('A3')
            ->getFill()
            ->getStartColor()
            ->setRGB('FF0000');





        $i = 4;
        $y = 1;

        foreach($conclusions as $conclusion)
        {
            $component = Component::findOrFail($conclusion->component_id);
            $type = Type::findOrFail($component->type_id);
            $inspector = Inspector::findOrFail($conclusion->inspector_id);

            $result = 'Годен';

            // результат заключения общий
            if(strripos($conclusion->mk_result, 'Годен'))
                $fGenReport['enter_mk'] = 'МК Годен';
            elseif(strripos($conclusion->mk_result, 'Не годен'))
            {
                $conclusion->mk_result = 'МК не годен';
                $result = 'Не годен';
            } else
                $conclusion->mk_result = ' ';


            if(strripos($conclusion->vik_result, 'Недопустимых дефектов не обнаружено'))
                $itog_uzt++;
            elseif(empty($conclusion->vik_result))
                $conclusion->vik_result = ' ';
            else
                $result = 'Не годен';

            if(strripos($conclusion->uzt_result, 'не менее допустимых значений. Годен'))
            {
                $conclusion->uzt_result = 'Годен';
                $itog_uzt++;
            } elseif(empty($conclusion->uzt_result))
                $conclusion->uzt_result = ' ';
            else
                $result = 'Не годен';


            if(strripos($conclusion->gi_result, 'не признается выдержавшим гидравлическое испытание'))
                $result = 'Не годен';
            elseif(empty($conclusion->gi_result))
                $conclusion->gi_result = '-';

            else {
                $conclusion->gi_result = 'Герметичен';
                $itog_gi++;
            }

            $date_exp = explode('-', $conclusion->date);

            $conclusion->date = $date_exp[2].'-'.$date_exp[1].'-'.$date_exp[0];

            // вычитаем минимально допустимую толщину
            $ras = [];
            @$ras[] = $type->measure_1 - $conclusion->measure_1;
            @$ras[] = $type->measure_2 - $conclusion->measure_2;
            @$ras[] = $type->measure_3 - $conclusion->measure_3;
            @$ras[] = $type->measure_4 - $conclusion->measure_4;

            $res_ras = [];

            foreach($ras as $value)
            {
                if($value > 0) $res_ras[] = $value;
            }

            @$res = min($res_ras);

            if($res === false) $res = '-';
            $sheet->setCellValue('A'.$i, $y);
            $sheet->setCellValue('B'.$i, $result);
            $sheet->setCellValue('C'.$i, $type->name)->getStyle('C1')->getAlignment()->setWrapText(true);
            $sheet->setCellValue('D'.$i, htmlspecialchars_decode($type->description, ENT_QUOTES));
            $sheet->setCellValue('E'.$i, $component->serial_number);
            $sheet->setCellValue('F'.$i, $component->tape_number);
            $sheet->setCellValue('G'.$i, $type->manufacturer);
            $sheet->setCellValue('H'.$i, $component->company()->facilities()->first()->area);
            $sheet->setCellValue('I'.$i, $conclusion->date);
            $sheet->setCellValue('J'.$i, $res);
            $sheet->setCellValue('K'.$i, $conclusion->gi_result);
            $sheet->setCellValue('L'.$i, $inspector->name.' '.$inspector->level.' '.$inspector->document);

            $i++;
            $y++;
        }

        $style = $sheet->getStyle('A1:L1');
        $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $style = $sheet->getStyle('A2:L2');
        $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $style = $sheet->getStyle('A3:L3');
        $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $style = $sheet->getStyle('A4:L'.$i);
        $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $style = $sheet->getStyle('A1:L'.$i);
        $style->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('A1:L'.$i)->getAlignment()->setWrapText(true);


        $writer = new Xlsx($spreadsheet);
        $filename = date('d.m.Y_H-i-s').'.xlsx';
        $writer->save('excel_reports/'.$filename);

        $spreadsheet->getActiveSheet()->getStyle('A3:L3')->getAlignment()->setWrapText(true);

        return redirect()
            ->to('/excel_reports/'.$filename);
    }

    /*
     * Пасспорт
     */
    public function general_passport()
    {
        $conclusions = Conclusion::select('conclusions.*')
            ->leftJoin('components', 'conclusions.component_id', '=', 'components.id');

        if(session()->get('conclusion_unit_id') !== null)
            $conclusions = $conclusions->where('components.unit_id', session()->get('conclusion_unit_id'));
        if(session()->get('conclusion_facility') !== null)
            $conclusions = $conclusions->where('components.facility', session()->get('conclusion_facility'));
        if(session()->get('conclusion_date') !== null)
            $conclusions = $conclusions->where('conclusions.date', session()->get('conclusion_date'));
        if(session()->get('conclusion_tape_number') !== null)
            $conclusions = $conclusions->where('components.tape_number', session()->get('conclusion_tape_number'));
        if(session()->get('conclusion_serial_number') !== null)
            $conclusions = $conclusions->where('components.serial_number', session()->get('conclusion_serial_number'));

        $conclusions = $conclusions->get();

        // дополнительные
        $header = Config::where('key', 'header_data')
            ->first();
        $director = Config::where('key', 'director')
            ->first();
        $ecp = Config::where('key', 'ecp')
            ->first();
        $gost_passport = Config::where('key', 'gost_passport')
            ->first();
        $stamp = Config::where('key', 'stamp')
            ->first();
        $signDirector = Config::where('key', 'signature_director')
            ->first();
        $signInspector = Config::where('key', 'signature_inspector')
            ->first();

        return view('admin.reports.general.passport', [
            'conclusions' => $conclusions,
            'header' => $header,
            'director' => $director,
            'gost_passport' => $gost_passport,
            'ecp' => $ecp,
            'stamp' => $stamp,
            'signDirector' => $signDirector,
            'signInspector' => $signInspector,
        ]);
    }

    /*
     * МК
     */
    public function general_mk()
    {
        $conclusions = Conclusion::select('conclusions.*')
            ->leftJoin('components', 'conclusions.component_id', '=', 'components.id');

        if(session()->get('conclusion_unit_id') !== null)
            $conclusions = $conclusions->where('components.unit_id', session()->get('conclusion_unit_id'));
        if(session()->get('conclusion_facility') !== null)
            $conclusions = $conclusions->where('components.facility', session()->get('conclusion_facility'));
        if(session()->get('conclusion_date') !== null)
            $conclusions = $conclusions->where('conclusions.date', session()->get('conclusion_date'));
        if(session()->get('conclusion_tape_number') !== null)
            $conclusions = $conclusions->where('components.tape_number', session()->get('conclusion_tape_number'));
        if(session()->get('conclusion_serial_number') !== null)
            $conclusions = $conclusions->where('components.serial_number', session()->get('conclusion_serial_number'));

        $conclusions = $conclusions->get();

        // дополнительные
        $instruments = Instrument::where('control_method', 'МК')
            ->get();
        $header = Config::where('key', 'header_data')
            ->first();
        $director = Config::where('key', 'director')
            ->first();
        $gost_mk = Config::where('key', 'gost_mk')
            ->first();
        $ecp = Config::where('key', 'ecp')
            ->first();
        $stamp = Config::where('key', 'stamp')
            ->first();
        $signDirector = Config::where('key', 'signature_director')
            ->first();
        $signInspector = Config::where('key', 'signature_inspector')
            ->first();


        return view('admin.reports.general.mk', [
            'conclusions' => $conclusions,
            'instruments' => $instruments,
            'header' => $header,
            'director' => $director,
            'gost_mk' => $gost_mk,
            'ecp' => $ecp,
            'stamp' => $stamp,
            'signDirector' => $signDirector,
            'signInspector' => $signInspector,
        ]);
    }

    /*
     * УЗК
     */
    public function general_uzt()
    {
        $conclusions = Conclusion::select('conclusions.*')
        ->leftJoin('components', 'conclusions.component_id', '=', 'components.id');

        if(session()->get('conclusion_unit_id') !== null)
            $conclusions = $conclusions->where('components.unit_id', session()->get('conclusion_unit_id'));
        if(session()->get('conclusion_facility') !== null)
            $conclusions = $conclusions->where('components.facility', session()->get('conclusion_facility'));
        if(session()->get('conclusion_date') !== null)
            $conclusions = $conclusions->where('conclusions.date', session()->get('conclusion_date'));
        if(session()->get('conclusion_tape_number') !== null)
            $conclusions = $conclusions->where('components.tape_number', session()->get('conclusion_tape_number'));
        if(session()->get('conclusion_serial_number') !== null)
            $conclusions = $conclusions->where('components.serial_number', session()->get('conclusion_serial_number'));

        $conclusions = $conclusions->get();

        // дополнительные
        $instruments = Instrument::where('control_method', 'УЗТ')
            ->get();
        $header = Config::where('key', 'header_data')
            ->first();
        $director = Config::where('key', 'director')
            ->first();
        $gost_uzt = Config::where('key', 'gost_uzt')
            ->first();
        $ecp = Config::where('key', 'ecp')
            ->first();
        $stamp = Config::where('key', 'stamp')
            ->first();
        $signDirector = Config::where('key', 'signature_director')
            ->first();
        $signInspector = Config::where('key', 'signature_inspector')
            ->first();


        return view('admin.reports.general.uzt', [
            'conclusions' => $conclusions,
            'instruments' => $instruments,
            'header' => $header,
            'director' => $director,
            'gost_uzt' => $gost_uzt,
            'ecp' => $ecp,
            'stamp' => $stamp,
            'signDirector' => $signDirector,
            'signInspector' => $signInspector,
        ]);
    }

    /*
     * ВИК
     */
    public function general_vik()
    {
        $conclusions = Conclusion::select('conclusions.*')
            ->leftJoin('components', 'conclusions.component_id', '=', 'components.id');

        if(session()->get('conclusion_unit_id') !== null)
            $conclusions = $conclusions->where('components.unit_id', session()->get('conclusion_unit_id'));
        if(session()->get('conclusion_facility') !== null)
            $conclusions = $conclusions->where('components.facility', session()->get('conclusion_facility'));
        if(session()->get('conclusion_date') !== null)
            $conclusions = $conclusions->where('conclusions.date', session()->get('conclusion_date'));
        if(session()->get('conclusion_tape_number') !== null)
            $conclusions = $conclusions->where('components.tape_number', session()->get('conclusion_tape_number'));
        if(session()->get('conclusion_serial_number') !== null)
            $conclusions = $conclusions->where('components.serial_number', session()->get('conclusion_serial_number'));

        $conclusions = $conclusions->get();

        // дополнительные
        $instruments = Instrument::where('control_method', 'ВИК')
            ->get();
        $header = Config::where('key', 'header_data')
            ->first();
        $director = Config::where('key', 'director')
            ->first();
        $gost_vik = Config::where('key', 'gost_vik')
            ->first();
        $ecp = Config::where('key', 'ecp')
            ->first();
        $stamp = Config::where('key', 'stamp')
            ->first();
        $signDirector = Config::where('key', 'signature_director')
            ->first();
        $signInspector = Config::where('key', 'signature_inspector')
            ->first();


        return view('admin.reports.general.vik', [
            'conclusions' => $conclusions,
            'instruments' => $instruments,
            'header' => $header,
            'director' => $director,
            'gost_vik' => $gost_vik,
            'ecp' => $ecp,
            'stamp' => $stamp,
            'signDirector' => $signDirector,
            'signInspector' => $signInspector,
        ]);
    }

    /*
     * ГИ
     */
    public function general_gi()
    {
        $conclusions = Conclusion::select('conclusions.*')
            ->leftJoin('components', 'conclusions.component_id', '=', 'components.id');

        if(session()->get('conclusion_unit_id') !== null)
            $conclusions = $conclusions->where('components.unit_id', session()->get('conclusion_unit_id'));
        if(session()->get('conclusion_facility') !== null)
            $conclusions = $conclusions->where('components.facility', session()->get('conclusion_facility'));
        if(session()->get('conclusion_date') !== null)
            $conclusions = $conclusions->where('conclusions.date', session()->get('conclusion_date'));
        if(session()->get('conclusion_tape_number') !== null)
            $conclusions = $conclusions->where('components.tape_number', session()->get('conclusion_tape_number'));
        if(session()->get('conclusion_serial_number') !== null)
            $conclusions = $conclusions->where('components.serial_number', session()->get('conclusion_serial_number'));

        $conclusions = $conclusions->get();

        // дополнительные
        $instruments = Instrument::where('control_method', 'ГИ')
            ->get();
        $header = Config::where('key', 'header_data')
            ->first();
        $director = Config::where('key', 'director')
            ->first();
        $gost_gi = Config::where('key', 'gost_gi')
            ->first();
        $ecp = Config::where('key', 'ecp')
            ->first();
        $stamp = Config::where('key', 'stamp')
            ->first();
        $signDirector = Config::where('key', 'signature_director')
            ->first();
        $signInspector = Config::where('key', 'signature_inspector')
            ->first();


        return view('admin.reports.general.gi', [
            'conclusions' => $conclusions,
            'instruments' => $instruments,
            'header' => $header,
            'director' => $director,
            'gost_gi' => $gost_gi,
            'ecp' => $ecp,
            'stamp' => $stamp,
            'signDirector' => $signDirector,
            'signInspector' => $signInspector,
        ]);
    }
    
    /*
     * отчёт превентер
     */
    public function preventer($id)
    {
        // основные параметры
        $conclusion = Conclusion::findOrFail($id);
        $component = Component::findOrFail($conclusion->component_id);
        $type = Type::findOrFail($component->type_id);
        $company = Company::findOrFail($component->company_id);
        $inspector = Inspector::findOrFail($conclusion->inspector_id);
        // дополнительные
        $instruments = Instrument::where('control_method', 'ГИ')
            ->get();
        $header = Config::where('key', 'header_data')
            ->first();
        $director = Config::where('key', 'director')
            ->first();
        $gost_gi = Config::where('key', 'gost_gi')
            ->first();
        $ecp = Config::where('key', 'ecp')
            ->first();
        $stamp = Config::where('key', 'stamp')
            ->first();
        $signDirector = Config::where('key', 'signature_director')
            ->first();
        $signInspector = Config::where('key', 'signature_inspector')
            ->first();

        if (preg_match("/$company->abbr" . "_/i", $component->tape_number)) {
            $typeNumber = trim(str_replace($company->abbr . '_', '', $component->tape_number));
        } else {
            $typeNumber = $component->tape_number;
        }

        return view('admin.reports.preventer', [
            'conclusion' => $conclusion,
            'type' => $type,
            'component' => $component,
            'company' => $company,
            'inspector' => $inspector,
            'instruments' => $instruments,
            'header' => $header,
            'director' => $director,
            'gost_gi' => $gost_gi,
            'ecp' => $ecp,
            'stamp' => $stamp,
            'signDirector' => $signDirector,
            'signInspector' => $signInspector,
            'typeNumber' => $typeNumber
        ]);
    }

    /*
     * отчёт клапан
     */
    public function calibration($id)
    {
        // основные параметры
        $conclusion = Conclusion::findOrFail($id);
        $component = Component::findOrFail($conclusion->component_id);
        $type = Type::findOrFail($component->type_id);
        $company = Company::findOrFail($component->company_id);
        $inspector = Inspector::findOrFail($conclusion->inspector_id);
        // дополнительные
        $instruments = Instrument::where('control_method', 'ГИ')
            ->get();
        $header = Config::where('key', 'header_data')
            ->first();
        $director = Config::where('key', 'director')
            ->first();
        $gost_container = Config::where('key', 'gost_container')
            ->first();
        $gost_armature = Config::where('key', 'gost_armature')
            ->first();
        $gost_requirement = Config::where('key', 'gost_requirement')
            ->first();
        $ecp = Config::where('key', 'ecp')
            ->first();
        $stamp = Config::where('key', 'stamp')
            ->first();
        $signDirector = Config::where('key', 'signature_director')
            ->first();
        $signInspector = Config::where('key', 'signature_inspector')
            ->first();

        if (preg_match("/$company->abbr" . "_/i", $component->tape_number)) {
            $typeNumber = trim(str_replace($company->abbr . '_', '', $component->tape_number));
        } else {
            $typeNumber = $component->tape_number;
        }

        $fixPressure = round((int)$conclusion->calibration_pressure * 0.04 + (int)$conclusion->calibration_pressure, 1);

        return view('admin.reports.calibration', [
            'conclusion' => $conclusion,
            'type' => $type,
            'component' => $component,
            'company' => $company,
            'inspector' => $inspector,
            'instruments' => $instruments,
            'header' => $header,
            'director' => $director,
            'gost_container' => $gost_container,
            'gost_armature' => $gost_armature,
            'gost_requirement' => $gost_requirement,
            'ecp' => $ecp,
            'stamp' => $stamp,
            'signDirector' => $signDirector,
            'signInspector' => $signInspector,
            'fixPressure' => $fixPressure,
            'typeNumber' => $typeNumber
        ]);
    }

    /*
     * отчёт БГРП
     */
    public function bgrp($id)
    {
        // основные параметры
        $conclusion = Conclusion::findOrFail($id);
        $component = Component::findOrFail($conclusion->component_id);
        $type = Type::findOrFail($component->type_id);
        $company = Company::findOrFail($component->company_id);
        $inspector = Inspector::findOrFail($conclusion->inspector_id);
        // дополнительные
        $instruments = Instrument::where('control_method', 'ГИ')
            ->get();
        $header = Config::where('key', 'header_data')
            ->first();
        $director = Config::where('key', 'director')
            ->first();
        $ecp = Config::where('key', 'ecp')
            ->first();
        $stamp = Config::where('key', 'stamp')
            ->first();
        $signDirector = Config::where('key', 'signature_director')
            ->first();
        $signInspector = Config::where('key', 'signature_inspector')
            ->first();


        //* 30.03.2024
        if(!empty($conclusion->coefficient) && $conclusion->coefficient == 1.5)
        {
            if(!empty($type->crimping_3))
            {
                $repCrimping3 = strripos($type->crimping_3, ',') ? str_replace(',', '.', $type->crimping_3) : $type->crimping_3;
                $crimping_3 = (float) $repCrimping3 * 1.5;
                $crimping_2 = $type->crimping_2;
            } elseif(!empty($type->crimping_2))
            {
                $repCrimping2 = strripos($type->crimping_2, ',') ? str_replace(',', '.', $type->crimping_2) : $type->crimping_2;
                $crimping_3 = (float) $repCrimping2 * 1.5;
                $crimping_2 = $type->crimping_2;
            } else {
                $repCrimping1 = strripos($type->crimping_1, ',') ? str_replace(',', '.', $type->crimping_1) : $type->crimping_1;
                $crimping_3 = '';
                $crimping_2 = (float) $repCrimping1 * 1.5;
            }
        } elseif(!empty($conclusion->coefficient) && $conclusion->coefficient == 2)
        {
             if(!empty($type->crimping_3))
            {
                $repCrimping3 = strripos($type->crimping_3, ',') ? str_replace(',', '.', $type->crimping_3) : $type->crimping_3;
                $crimping_3 = (float) $repCrimping3 * 2;
                $crimping_2 = $type->crimping_2;
            } elseif(!empty($type->crimping_2))
            {
                $repCrimping2 = strripos($type->crimping_2, ',') ? str_replace(',', '.', $type->crimping_2) : $type->crimping_2;
                $crimping_3 = (float) $repCrimping2 * 2;
                $crimping_2 = $type->crimping_2;
            } else {
                $repCrimping1 = strripos($type->crimping_1, ',') ? str_replace(',', '.', $type->crimping_1) : $type->crimping_1;
                $crimping_3 = '';
                $crimping_2 = (float) $repCrimping1 * 2;
            }
        } elseif(!empty($conclusion->coefficient) && $conclusion->coefficient == 1.25)
        {
             if(!empty($type->crimping_3))
            {
                $repCrimping3 = strripos($type->crimping_3, ',') ? str_replace(',', '.', $type->crimping_3) : $type->crimping_3;
                $crimping_3 = (float) $repCrimping3 * 1.25;
                $crimping_2 = $type->crimping_2;
            } elseif(!empty($type->crimping_2))
            {
                $repCrimping2 = strripos($type->crimping_2, ',') ? str_replace(',', '.', $type->crimping_2) : $type->crimping_2;
                $crimping_3 = (float) $repCrimping2 * 1.25;
                $crimping_2 = $type->crimping_2;
            } else {
                $repCrimping1 = strripos($type->crimping_1, ',') ? str_replace(',', '.', $type->crimping_1) : $type->crimping_1;
                $crimping_3 = '';
                $crimping_2 = (float) $repCrimping1 * 1.25;
            }
        } else {
            $crimping_3 = '';
            $crimping_2 = '';
        }
        
        
        if (preg_match("/$company->abbr" . "_/i", $component->tape_number)) {
            $typeNumber = trim(str_replace($company->abbr . '_', '', $component->tape_number));
        } else {
            $typeNumber = $component->tape_number;
        }  

        return view('admin.reports.bgrp', [
            'conclusion' => $conclusion,
            'type' => $type,
            'component' => $component,
            'company' => $company,
            'inspector' => $inspector,
            'instruments' => $instruments,
            'header' => $header,
            'director' => $director,
            'ecp' => $ecp,
            'stamp' => $stamp,
            'signDirector' => $signDirector,
            'signInspector' => $signInspector,
            // 'crimping_1' => $crimping_1,
            'crimping_3' => $crimping_3,
            'crimping_2' => $crimping_2,
            'typeNumber' => $typeNumber
        ]);
    }

    // public function getCrimping($coefficient, $crimping1, $crimping2, $crimping3)
    // {
    //     if($coefficient == 1.5)
    //     {
    //         if(!empty($crimping3))
    //         {
    //             $repCrimping3 = strripos($crimping3, ',') ? str_replace(',', '.', $crimping3) : $crimping3;
    //             $crimping_3 = (float) $repCrimping3 * 1.5;
    //             $crimping_2 = $tcrimping2;
    //         } elseif(!empty($tcrimping2))
    //         {
    //             $repCrimping2 = strripos($crimping2, ',') ? str_replace(',', '.', $crimping2) : $crimping2;
    //             $crimping_3 = (float) $repCrimping2 * 1.5;
    //             $crimping_2 = $crimping2;
    //         } else {
    //             $repCrimping1 = strripos($crimping1, ',') ? str_replace(',', '.', $crimping1) : $crimping1;
    //             $crimping_3 = '';
    //             $crimping_2 = (float) $repCrimping1 * 2;
    //         }
    //     } elseif($coefficient == 2)
    //     {
    //          if(!empty($crimping3))
    //         {
    //             $repCrimping3 = strripos($crimping3, ',') ? str_replace(',', '.', $crimping3) : $crimping3;
    //             $crimping_3 = (float) $repCrimping3 * 2;
    //             $crimping_2 = $crimping2;
    //         } elseif(!empty($crimping2))
    //         {
    //             $repCrimping2 = strripos($crimping2, ',') ? str_replace(',', '.', $crimping2) : $crimping2;
    //             $crimping_3 = (float) $repCrimping2 * 2;
    //             $crimping_2 = $crimping2;
    //         } else {
    //             $repCrimping1 = strripos($crimping1, ',') ? str_replace(',', '.', $crimping1) : $crimping1;
    //             $crimping_3 = '';
    //             $crimping_2 = (float) $repCrimping1 * 2;
    //         }
    //     } else {
    //         $crimping_3 = '';
    //         $crimping_2 = '';
    //     } 

    //     $crimpings = array('crimping2' => $crimping_2, 'crimping3' => $crimping_3);
    //     return $crimpings;
    // }
}
