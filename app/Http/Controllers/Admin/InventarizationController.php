<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Models\Conclusion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class InventarizationController extends Controller
{
    /*
     * Инвентаризация
     */
    public function index()
    {
        $companies = Company::orderBy('name', 'asc')
            ->get();

        $conclusions = $this->get_conclusions();

        return view('admin.inventarization.index', [
            'companies' => $companies,
            'conclusions' => $conclusions,
        ]);
    }


    /*
     * Заключения
     */
    public function get_conclusions()
    {
        $conclusions = Conclusion::select('conclusions.*')
            ->leftJoin('components', 'components.id', '=', 'conclusions.component_id');

        // компания
        if(session('filters_inventarization_company_id'))
            $conclusions = $conclusions->where('components.company_id', session('filters_inventarization_company_id'));
        // дата от
        if(session('filters_inventarization_date_begin'))
            $conclusions = $conclusions->where('conclusions.date', '>=', session('filters_inventarization_date_begin'));
        // дата до
        if(session('filters_inventarization_date_end'))
            $conclusions = $conclusions->where('conclusions.date', '<=', session('filters_inventarization_date_end'));

        $conclusions = $conclusions->get();

        return $conclusions;
    }
    
    
    /*
     * Применение фильтров
     */
    public function accept_filters(Request $request)
    {
        // компания
        if(isset($request->filters_inventarization_company_id) && !empty($request->filters_inventarization_company_id))
            session()->put('filters_inventarization_company_id', $request->filters_inventarization_company_id);
        else
            session()->forget('filters_inventarization_company_id');
        // дата от
        if(isset($request->filters_inventarization_date_begin) && !empty($request->filters_inventarization_date_begin))
            session()->put('filters_inventarization_date_begin', $request->filters_inventarization_date_begin);
        else
            session()->forget('filters_inventarization_date_begin');
        // дата до
        if(isset($request->filters_inventarization_date_end) && !empty($request->filters_inventarization_date_end))
            session()->put('filters_inventarization_date_end', $request->filters_inventarization_date_end);
        else
            session()->forget('filters_inventarization_date_end');

        return redirect()
            ->to(route('admin.inventarization'));
    }
    
    
    /*
     * Сброс фильтров
     */
    public function reset_filters()
    {
        session()->forget('filters_inventarization_company_id');
        session()->forget('filters_inventarization_date_begin');
        session()->forget('filters_inventarization_date_end');

        return redirect()
            ->to(route('admin.inventarization'));
    }
    
    
    /*
     * Экспорт в XLSX
     */
    public function export_xlsx()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(35);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(35);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(35);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(23);

        $sheet->setCellValue('A1', 'Дата');
        $sheet->setCellValue('B1', 'Установки');
        $sheet->setCellValue('C1', 'Компоненты');
        $sheet->setCellValue('D1', 'Место проведения');
        $sheet->setCellValue('E1', 'Итоговый результат');

        $spreadsheet->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);

        $i = 2;

        $conclusions = $this->get_conclusions();

        foreach($conclusions as $conclusion)
        {
            $itog_uzt = 0;
            $result = 'Годен';
            // результат заключения общий
            if($conclusion->mk_result == 'Не годен') {
                $fGenReport['enter_mk'] = 'МК Годен';
                $result = 'Не годен';
            } elseif(strripos($conclusion->mk_result, 'Годен'))
            {
                $conclusion->mk_result = 'МК не годен';
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


            $sheet->setCellValue('A'.$i, $conclusion->date);
            $sheet->setCellValue('B'.$i, $conclusion->component()->facility()->number.' ('.$conclusion->component()->facility()->gos_number.', '.$conclusion->component()->facility()->area.')');
            $sheet->setCellValue('C'.$i, $conclusion->component()->type()->name.' | '.$conclusion->component()->type()->description.' | '.$conclusion->component()->tape_number);
            $sheet->setCellValue('D'.$i, $conclusion->component()->work_location()->name);
            $sheet->setCellValue('E'.$i, $result);

            $i++;
        }

        $style = $sheet->getStyle('A1:P'.$i);
        $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $style = $sheet->getStyle('A1:P'.$i);
        $style->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('A1:E'.$i)->getAlignment()->setWrapText(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Inventarization_'.date('d.m.Y_H-i-s').'.xlsx';
        $writer->save('uploads/'.$filename);

        return redirect()
            ->to('/uploads/'.$filename);
    }
}
