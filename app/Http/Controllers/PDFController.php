<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Component;
use App\Models\Conclusion;
use App\Models\Config;
use App\Models\Inspector;
use App\Models\Instrument;
use App\Models\Type;
use App\Models\Unit;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
	
	public function generatePDFmk($id)
    {
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
	
        $pdf = PDF::loadView('admin.reports.mk', [
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
        ]);    
        return $pdf->download('demo.pdf');
		//$pdf = PDF::loadView('report/'.$id.'/'.$type);   
    }
}
