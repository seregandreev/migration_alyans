<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>АКТ</title>
<style>
    body{font-size: 12px;}
    .table-header{border-collapse: collapse;}
    .table-header th, td{ border: 1px solid black;}
    .table-body{border-collapse: collapse;}
    .table-body th, td{ border: 1px solid black;}
    @media print {
         body {font-size: 10px; line-height: 1;}
         .container {margin-right: 5px; padding: 2px;}
         .acts {margin-right: 5px; padding: 2px;}
    }
</style>
</head>
<body>
    <div class="container mt-3 mb-1">
        <div class="acts">
            <div class="row">
                <div class="col-4" style="text-align: left; padding: 5px; margin-top: -20px;">
                    <img src="{{ asset('alyansLogo.svg') }}" alt="" style="height: 120px; width: 120px; border-radius: 5px;">
                </div>
                <div class="col-8 text-left"><h5>АКТ № <u>{{$getParam}}</u> от <u>{{ $dateFormated }} г.</u> <br> приема-передачи документов</h5></div>
            </div>
            <div class="description">ООО «АльянсЭксперт» в лице представителя __________________________________________</div>
            <div class="description">с одной стороны, передал, а {{ $company->name }} в лице представителя _______________________________ <br> с другой стороны, принял следующие документы:</div>
            <br>
            <table class="w-70 table-header mb-3">
                <tr>
                    <td class="text-center" colspan="2"><b>Общие сведения о документах</b></td>
                </tr>
                <tr>
                    <td class="text-start" colspan="2">Документы по результатам контроля оборудования/деталей оборудования {{ $company->name }}</td>
                </tr>
                <tr>
                    <td>Место проведения контроля оборудования/деталей оборудования:</td>
                    <td class="text-center"><b>@if(!empty($work_location)) {{ $work_location->name }} @else &nbsp @endif </b></td>
                </tr>
                <tr>
                    <td class="text-start">Установка:</td>
                    <td><b>@if(!empty($facility)) {{ $facility->number }} / {{ $facility->gos_number }} / {{ $facility->area }} @else &nbsp @endif </b></td>
                </tr>
            </table>
            
                <table class="w-100 table-body text-center">
                    <thead>
                    <tr bgcolor="#f0f0f0">
                        <th rowspan="3">№<br><nobr>п/п</nobr></th>
                        <th colspan="9"><b>Общие сведения о документах</b></th>
                        <th colspan="2"><b>Оборудование/Детали оборудования, на которые передаются документы</b></th>
                    </tr>
                    <tr bgcolor="#f0f0f0">
                        <th colspan="7">Заключения по неразрушающему контролю (НК):</th>
                        <th rowspan="2">Бандажная лента</th>
                        <th rowspan="2">Технический паспорт</th>
                        <th rowspan="2">Наименование  |  Тип  |  Серийный номер (S/N)  |  рег. №</th>
                        <th rowspan="2">Принадлежность</th>
                    </tr>
                    <tr bgcolor="#f0f0f0">
                        <th>дата</th>
                        <th>ВИК<br>(№)</th>
                        <th>УЗТ<br>(№)</th>
                        <th>УЗК<br>(№)</th>
                        <th>МК<br>(№)</th>
                        <th>ГИ<br>(№)</th>
                        <th>общая оценка НК</th>
                    </tr>
                    </thead>
                    @php($summ = 0)
                    
                    @php($summVikYes = 0)
                    @php($summUztYes = 0)
                    @php($summUzkYes = 0)
                    @php($summMkYes = 0)
                    @php($summGiYes = 0)
                    
                    @php($summVikNo = 0)
                    @php($summUztNo = 0)
                    @php($summUzkNo = 0)
                    @php($summMkNo = 0)
                    @php($summGiNo = 0)
                    @php($summInstallingTape = 0)
                    @php($summPassport = 0)
                    <tbody>
                    @foreach($conclusions as $idx => $conclusion)
                        @php($summ += 1)
                        <!--@if(($summ % 8) == 0)-->
                        <!--    @php($styleBreake = "page-break-after: always;")  -->
                        <!--@elseif($summ >= 4 && $summ <= 8)-->
                        <!--    @php($styleBreake = "page-break-after: always;")-->
                        <!--@else-->
                        <!--    @php($styleBreake = "")-->
                        <!--@endif-->
                        @php($styleBreake = ($summ % 8) == 0 ? "page-break-after: always;" : "")
                        <!--<tr style="{{$styleBreake}}">-->
                        <tr>
                                @php($result_conclusion = 'Годен')
                                @php($vikResult = 1)
                                @php($uztResult = 1)
                                @php($mkResult = 1)
                                @php($giResult = 1)
                                @php($uzkResult = 1)
                                @if(!empty($conclusion->vik_result) && $conclusion->vik_result === "Состояние поверхности объекта контроля не соответствует требованиям 3997-00.001 МУ «Методические указания по определению критериев вывода из эксплуатации нефтепромыслового оборудования»; Обнаружены недопустимые дефекты")
                                    @php($vikResult = 0)
                                    @php($result_conclusion = 'Не годен')
                                @endif
                                @if(!empty($conclusion->uzt_result) && $conclusion->uzt_result === "Обнаруженные толщины менее допустимых значений. Негоден")
                                    @php($uztResult = 0)
                                    @php($result_conclusion = 'Не годен')
                                @endif
                                @if(!empty($conclusion->mk_result) && $conclusion->mk_result === "Не годен")
                                    @php($mkResult = 0)
                                    @php($result_conclusion = 'Не годен')
                                @endif
                                @if(!empty($conclusion->gi_result) && $conclusion->gi_result === "Узел (объект) не признается выдержавшим гидравлическое испытание на прочность и герметичность")
                                    @php($giResult = 0)
                                    @php($result_conclusion = 'Не годен')
                                @endif                                
                                @if(!empty($conclusion->uzk_result) && $conclusion->uzk_result === "Не годен")
                                    @php($uzkResult = 0)
                                    @php($result_conclusion = 'Не годен')
                                @endif
                        
                            <td>{{ $idx + 1 }}</td>
                            <td><nobr>{{ $conclusion->get_format_date() }} г.</nobr></td>
                            
                            @if($conclusion->check_vik == 1 && $vikResult == 1)
                                @php($summVikYes += 1)
                                <td>{{ $conclusion->id }}(+)</td>
                            @elseif($conclusion->check_vik == 1 && $vikResult == 0)
                                @php($summVikNo += 1)
                                <td>{{ $conclusion->id }}(-)</td>
                            @else
                                <td> ** </td>
                            @endif
                            
                            @if($conclusion->check_uzt == 1 && $uztResult == 1)
                                @php($summUztYes += 1)
                                <td>{{ $conclusion->id }}(+)</td>
                            @elseif($conclusion->check_uzt == 1 && $uztResult == 0)
                                @php($summUztNo += 1)
                                <td>{{ $conclusion->id }}(-)</td>
                            @else 
                                <td> ** </td>
                            @endif
                                                        
                            @if($conclusion->check_uzk == 1 && $uzkResult == 1)
                                @php($summUzkYes += 1)
                                <td>{{ $conclusion->id }}(+)</td>
                            @elseif($conclusion->check_uzk == 1 && $uzkResult == 0)
                                @php($summUzkNo += 1)
                                <td>{{ $conclusion->id }}(-)</td>
                            @else 
                                <td> ** </td>
                            @endif
                            
                            @if($conclusion->check_mk == 1 && $mkResult == 1)
                                @php($summMkYes += 1)
                                <td>{{ $conclusion->id }}(+)</td>
                            @elseif($conclusion->check_mk == 1 && $mkResult == 0)
                                @php($summMkNo += 1)
                                <td>{{ $conclusion->id }}(-)</td>
                            @else 
                                <td> ** </td>
                            @endif
                            
                            {{-- ГИ --}}
                            @if($conclusion->check_gi == 1 && $giResult == 1)
                                @php($summGiYes += 1)
                                <td>{{ $conclusion->id }}(+)</td>
                            @elseif($conclusion->check_gi == 1 && $giResult == 0)
                                @php($summGiNo += 1)
                                <td>{{ $conclusion->id }}(-)</td>
                            @else 
                                <td> ** </td>
                            @endif
                            
                            <td>{{ $result_conclusion }}</td>
                                                        
                            @if($conclusion->installing_tape == 1)
                                @php($summInstallingTape += 1)
                                <td>Установлена</td>
                            @else
                                <td>Не установлена</td>
                            @endif
                            
                            @if($conclusion->passport == 1)
                                @php($summPassport += 1)
                                <td>Составлен паспорт;
                                    <br>Произведена запись
                                    @if($conclusion->repair == 1)
                                        <br>Произведен ремонт
                                    @endif
                                </td>
                            @else
                                <td>Не паспортизируется
                                    @if($conclusion->repair == 1)
                                        <br>Произведен ремонт
                                    @endif
                                </td>
                            @endif
                            @if(preg_match("/" . $conclusion->component()->company()->abbr . "_/i", $conclusion->component()->tape_number))
                                <td>{{ $conclusion->component()->type()->name }} | {{ $conclusion->component()->type()->description }} | {{ $conclusion->component()->serial_number }} | {{ trim(str_replace($conclusion->component()->company()->abbr . '_', '', $conclusion->component()->tape_number)) }} | {{ $conclusion->component()->type()->manufacturer }}</td>
                            @else
                                <td>{{ $conclusion->component()->type()->name }} | {{ $conclusion->component()->type()->description }} | {{ $conclusion->component()->serial_number }} | {{ $conclusion->component()->tape_number }} | {{ $conclusion->component()->type()->manufacturer }}</td>
                            @endif
                            <td></td>
                        </tr>
                    @endforeach

                    <tr>
                        <td colspan="2">Итого</td>
                        <td><nobr>ВИК {{ $summVikYes + $summVikNo }},</nobr><br> <nobr>Годен {{ $summVikYes }},</nobr><br> <nobr>Не годен {{ $summVikNo }}</nobr></td>
                        <td><nobr>УЗТ {{ $summUztYes + $summUztNo }},</nobr><br> <nobr>Годен {{ $summUztYes }},</nobr><br> <nobr>Не годен {{ $summUztNo }}</nobr></td>
                        <td><nobr>УЗК {{ $summUzkYes + $summUzkNo }},</nobr><br> <nobr>Годен {{ $summUzkYes }},</nobr><br> <nobr>Не годен {{ $summUzkNo }}</nobr></td>
                        <td><nobr>МК {{ $summMkYes + $summMkNo }},</nobr><br> <nobr>Годен {{ $summMkYes }},</nobr><br> <nobr>Не годен {{ $summMkNo }}</nobr></td>
                        <td><nobr>ГИ {{ $summGiYes + $summGiNo }},</nobr><br> <nobr>Годен {{ $summGiYes }},</nobr><br> <nobr>Не годен {{ $summGiNo }}</nobr></td>
                        <td>&nbsp</td>
                        <td><nobr>Установлена {{ $summInstallingTape }}</nobr></td>
                        <td><nobr>Составлено {{ $summPassport }}</nobr></td>
                        <td colspan="2">&nbsp</td>
                    </tr>
                    </tbody>
                </table>
                <!--@if($act->stamp == 'yes' && file_exists(public_path('config_data/stamp.png')))-->
                <!--    <div class="data-podpis" style="position: absolute; margin-top: 3%;">-->
                <!--        <img src="{{ asset('config_data/stamp.png') }}" alt="" class="ecp_image" style="width: 250px;margin-left: 300px;margin-top: -30px;">-->
                <!--    </div>-->
                <!--@endif-->
                <!--@if(($summ % 3) == 0)-->
                <!--    <div style="page-break-after: always;"></div>-->
                <!--@endif-->
                                
                <div style="page-break-after: always;"></div>

                <table class="description" style="width: 100%; border-collapse: collapse; border: 0;">
                    <tr>
                        <td colspan="3" style="padding: 5px; border-collapse: collapse; border: 0;">Данный акт составлен в двух экземплярах, по одному экземпляру для каждой из сторон.</td>
                    </tr>
                    <tr>
                        <td style="padding: 5px; border-collapse: collapse; border: 0;">
                            <b>Передал документы:</b>
                            <br>
                            <br>
                            @if(!empty($inspector))
                                <u> {{ $inspector->name }} </u> 
                                @if(file_exists(public_path('inspectors_data/'.$inspector->id.'/signInspector.png')))
                                    <!--<div class="podpis-inspector" style="position: absolute;margin-left: 115px;margin-top: -30px;">-->
                                        <img src="{{ asset('inspectors_data/'.$inspector->id.'/signInspector.png') }}" alt="" style="width: 50px;">
                                    <!--</div>-->
                                @endif
                            @else
                                _________________________________ / ___________________ /
                            @endif
                        </td>
                        <td style="border-collapse: collapse; border: 0;">
                            @if($act->stamp == 'yes' && file_exists(public_path('config_data/stamp.png')))
                                <!--<div class="data-podpis">-->
                                    <img src="{{ asset('config_data/stamp.png') }}" alt="" class="ecp_image" style="width: 200px;">
                                <!--</div>-->
                            @endif
                        </td>
                        <td style="padding: 5px; border-collapse: collapse; border: 0;">
                            <b>Принял документы:</b>
                            <br>
                            <br>
                            Ф.И.О.(полностью) _______________________________________
                            <br><br>
                            Департамент _____________________________________________
                            <br><br>
                            Локация ________________________________________________
                            <br>
                        </td>
                    </tr>
                </table>
                <!--@if($summ == 3 || $summ == 4 || $summ == 7)-->
                <!--    <div style="page-break-after: always;"></div>-->
                <!--@endif-->
                <div>
                    <table>
                        <tr>
                            <td colspan="10" class="text-start p-2">
                                Используемые сокращения:<br>
                                НК - неразрушающий контроль;  ВИК - визуальный и измерительный контроль;<br>
                                УЗТ - ультразвуковая толщинометрия;   МК - магнитопорошковый контроль;<br>
                                ГИ - гидравлические испытания;<br> 
                                ( + ) - испытание выдержано;<br>
                                ( - ) - испытание не выдержано.<br>
                                ** - испытания не проводились.<br>
                                Составлен паспорт - данная отметка говорит о том, что специалистами ООО "АльянсЭксперт" был составлен технический (эксплуатационный) паспорт на данное оборудование/деталь оборудования для ведения записей в процессе эксплуатации.<br><br>
                                Произведена запись - запись в паспорте о дате, видах и результатах контроля оборудования/детали оборудования.<br><br>
                                Не паспортизируется - технический (эксплуатационный) паспорт на данное оборудование/деталь оборудования не требуется. 
                            </td>
                            <td colspan="2" class="text-center p-2">
                                На сайте ООО «АльянсЭксперт» в разделе «ЗАКАЗЧИКАМ» Вы можете
                                получить информацию о неразрушающем контроле (дефектоскопии) <br>
                                вашего оборудования, его деталей и сборочных единиц, <br>
                                просмотреть и скачать заключения по результатам НК.<br>
                                Учетные данные для доступа в «Персональный раздел» сайта<br>
                                Вы можете получить, обратившись в ООО "АльянсЭксперт"<br>
                                по адресу электронной почты: reception@alyansekspert.ru<br><br>
                                
                                Адреса сайта ООО «АльянсЭксперт»:  alyansekspert.ru,  альянсэксперт.рф
                            </td>
                        </tr>
                    </table> 
                </div>
            
                <!--<div class="description">-->
                <!--    <div class="mb-3">Данный акт составлен в двух экземплярах, по одному экземпляру для каждой из сторон.</div>-->
                <!--    <div style="width: 30%; float: left;">-->
                <!--        <b>Передал документы:</b>-->
                <!--        <br>-->
                <!--        <br>-->
                <!--        <div class="row">-->
                <!--            @if(!empty($inspector))-->
                <!--                <u> {{ $inspector->name }} </u> -->
                <!--                @if(file_exists(public_path('inspectors_data/'.$inspector->id.'/signInspector.png')))-->
                <!--                    <div class="podpis-inspector" style="position: absolute;margin-left: 115px;margin-top: -30px;">-->
                <!--                        <img src="{{ asset('inspectors_data/'.$inspector->id.'/signInspector.png') }}" alt="">-->
                <!--                    </div>-->
                <!--                @endif-->
                <!--            @else-->
                <!--                _________________________________ / ___________________ /-->
                <!--            @endif-->
                <!--        </div>-->
                <!--        @if($act->stamp == 'yes' && file_exists(public_path('config_data/stamp.png')))-->
                <!--            <div class="data-podpis" style="position: absolute;">-->
                <!--                <img src="{{ asset('config_data/stamp.png') }}" alt="" class="ecp_image" style="width: 250px;margin-left: 300px;margin-top: -30px;">-->
                <!--            </div>-->
                <!--        @endif-->
                <!--    </div>-->
                <!--    <div style="width: 40%; float: right;">-->
                <!--        <b>Принял документы:</b>-->
                <!--        <br>-->
                <!--        <br>-->
                <!--        Ф.И.О.(полностью) _______________________________________-->
                <!--        <br><br>-->
                <!--        Департамент _____________________________________________-->
                <!--        <br><br>-->
                <!--        Локация ________________________________________________-->
                <!--    </div>-->
                <!--</div>-->
            
        </div>
    </div>
    <script>
        window.print();
    </script>
</body>
</html>