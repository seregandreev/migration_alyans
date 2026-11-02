<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="{{ asset('css/print.css') }}">
</head>
<body>
    <div class="conclusion">
        <div>
            <div style="font-size: 10px;">
                {!! $header->value !!}
            </div>
            <div style="display: flex;justify-content: center;align-items: center;margin-top: -30px;">
                <img style="width: 150px; height: 150px;" src="{{ asset('alyansLogo.png') }}" alt="">
            </div>
        </div>
        <br>
        <div class="title">
            <div class="header-data">ООО &#171АльянсЭксперт&#187 <br>Лаборатория неразрушающего контроля</div>
            <div style="font-size: 22px;"><b>
                АКТ № {{ $conclusion->id }}<br>
                Гидравлических испытаний противовыбросового оборудования</b>
            </div>
        </div>
        <div class="date">От:
            <span>
            @php($conclusion->date = implode('.', array_reverse(explode('-', $conclusion->date))))
                {{ $conclusion->date }}
        </span>
        </div>
        <div class="name-object">
            <span>Мы, нижеподписавшиеся:</span><br>
            <span>Представитель ООО «АльянсЭксперт»:</span> <span style="float: right;"> ______________ / {{ $inspector->name }}</span><br>
        </div>
    <div class="city">
        <span>Ответственный за оборудование</span><br>
        {{ $company->name }} <span style="float: right;">______________ / _____________________________ </span>
    </div>
    <br>
    <div>Составили настоящий акт в том, что на территории заказчика, а именно:<br>
        {{ $company->name }} {{ $component->work_location()->name }} {{ $component->facility()->number }} {{ $component->facility()->gos_number }} {{ $component->facility()->area }}
        ,были проведены гидравлические испытания противовыбросового оборудования.
    </div>
    <br>
    @if(!empty($instruments) && count($instruments) > 0)
        <div class="measure_instruments">
            @foreach($instruments as $instrument)
                @if($instrument->yes_instrument == 1)
                    @php($instrument->next_verification_date = implode('.', array_reverse(explode('-', $instrument->next_verification_date))))
                    <span>{{ $instrument->name }} № {{ $instrument->sertificate_number }} {{ $instrument->model }} s/n {{ $instrument->serial_number }} дата калибровки до {{ $instrument->next_verification_date }}г.;</span><br>
                @endif
            @endforeach
        </div>
    @endif
    <br>
    <div class="gi">
        <span>Этапы испытания:</span>
        @if($conclusion->gi_result === 'Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность')
            <table border="0">
                @if(!empty($type->act_1) || !empty($type->period_1))
                <tr>
                    <td>1 этап - P<sub>1</sub>= {{ $type->crimping_1 }} {{ $component->type()->measure }}, время выдержки {{ $type->period_1 }} минут</td>
                </tr>
                @endif
                @if(!empty($type->act_2) || !empty($type->period_2))
                <tr>
                    <td>2 этап - P<sub>2</sub>= {{ $type->crimping_2 }} {{ $component->type()->measure }}, время выдержки {{ $type->period_2 }} минут</td>
                </tr>
                @endif
                @if(!empty($type->act_3) || !empty($type->period_3))
                <tr>
                    <td>3 этап - P<sub>3</sub>= {{ $type->crimping_3 }} {{ $component->type()->measure }}, время выдержки {{ $type->period_3 }} минут</td>
                </tr>
                @endif
                @if(!empty($type->act_4) || !empty($type->period_4))
                <tr>
                    <td>4 этап - P<sub>4</sub>= {{ $type->crimping_4 }} {{ $component->type()->measure }}, время выдержки {{ $type->period_4 }} минут</td>
                </tr>
                @endif
                @if(!empty($type->act_5) || !empty($type->period_5))
                <tr>
                    <td>5 этап - P<sub>5</sub>= {{ $type->crimping_5 }} {{ $component->type()->measure }}, время выдержки {{ $type->period_5 }} минут</td>
                </tr>
                @endif
                @if(!empty($type->act_6) || !empty($type->period_6))
                <tr>
                    <td>6 этап - P<sub>6</sub>= {{ $type->crimping_6 }} {{ $component->type()->measure }}, время выдержки {{ $type->period_6 }} минут</td>
                </tr>
                @endif
            </table>
        @else
        <table border="0">
                @if(!empty($type->act_1) || !empty($type->period_1))
                <tr>
                    <td>1 этап - P<sub>1</sub>= 0 {{ $component->type()->measure }}, время выдержки 0 минут</td>
                </tr>
                @endif
                @if(!empty($type->act_2) || !empty($type->period_2))
                <tr>
                    <td>2 этап - P<sub>2</sub>= 0 {{ $component->type()->measure }}, время выдержки 0 минут</td>
                </tr>
                @endif
                @if(!empty($type->act_3) || !empty($type->period_3))
                <tr>
                    <td>3 этап - P<sub>3</sub>= 0 {{ $component->type()->measure }}, время выдержки 0 минут</td>
                </tr>
                @endif
                @if(!empty($type->act_4) || !empty($type->period_4))
                <tr>
                    <td>4 этап - P<sub>4</sub>= 0 {{ $component->type()->measure }}, время выдержки 0 минут</td>
                </tr>
                @endif
                @if(!empty($type->act_5) || !empty($type->period_5))
                <tr>
                    <td>5 этап - P<sub>5</sub>= 0 {{ $component->type()->measure }}, время выдержки 0 минут</td>
                </tr>
                @endif
                @if(!empty($type->act_6) || !empty($type->period_6))
                <tr>
                    <td>6 этап - P<sub>6</sub>= 0 {{ $component->type()->measure }}, время выдержки 0 минут</td>
                </tr>
                @endif
            </table>
        @endif
    </div>
    <div class="conditions_controls">
        <span>Условия контроля: температура окружающей среды: </span>{{ $conclusion->temperature }} °С; <span>температура воды + 10 °С</span>
    </div>
    <br>
    <div>Корпус превентора: {{ $type->name }}</div>
    <div>Производства: {{ $type->manufacturer }} S/N: {{ $component->serial_number }}</div>
    <div>опрессован на давление {{ $component->type()->pressure }} {{ $component->type()->measure }}</div>
        <div class="gost"><span>Нормативная документация </span>{{ $gost_gi->value }}</div>
        <div class="result-control">
            <div class="result">
                Результат испытаний:
                @if($conclusion->gi_result === 'Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность')
                    герметично. Диаграмма №: {{ $conclusion->id }}/1
                @else
                    не герметично. Диаграмма №: {{ $conclusion->id }}/1
                @endif
            </div>
        </div>
        <br>
    <div>Секция с глухими плашками превентора: {{ $type->name }}</div>
    <div>Производства: {{ $type->manufacturer }} S/N: {{ $component->serial_number }}</div>
    <div>опрессован на давление {{ $component->type()->pressure }} {{ $component->type()->measure }}</div>
        <!--<div class="gost"><span>Нормативная документация </span>{{ $gost_gi->value }}</div>-->
        <div class="result-control">
            <div class="result">
                Результат испытаний:
                @if($conclusion->gi_result === 'Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность')
                    герметично. Диаграмма №: {{ $conclusion->id }}/2
                @else
                    не герметично. Диаграмма №: {{ $conclusion->id }}/2
                @endif
            </div>
        </div>
        <br>
    <div>Секция с тубными плашками Ø {{ $conclusion->diameter_plashki }} мм. {{ $type->name }}</div>
    <div>Производства: {{ $type->manufacturer }} S/N: {{ $component->serial_number }}</div>
    <div>опрессован на давление {{ $component->type()->pressure }} {{ $component->type()->measure }}</div>
        <!--<div class="gost"><span>Нормативная документация </span>{{ $gost_gi->value }}</div>-->
        <div class="result-control">
            <div class="result">
                Результат испытаний:
                @if($conclusion->gi_result === 'Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность')
                    герметично. Диаграмма №: {{ $conclusion->id }}/3
                @else
                    не герметично. Диаграмма №: {{ $conclusion->id }}/3
                @endif
            </div>
        </div>
        <div class="executor">
            <div class="datas mb-1">
                <span><b>Исполнитель:</b></span><br>
                <span>специалист {{ $inspector->level }} уровня по {{ $inspector->control_method }}</span><br>
                <span>Удостоверение № {{ $inspector->num_document }}</span>
                <span class="value">{{ $inspector->name }}</span>
                    @if($signInspector->value == 'on' || Auth::user()->role == 'Пользователь')
                    <div class="podpis-inspector">
                        <img src="{{ asset('inspectors_data/'.$inspector->id.'/signInspector.png') }}" alt="">
                    </div>
                    @endif
                    @if($stamp->value == 'on' || Auth::user()->role == 'Пользователь')
                    <div class="data-podpis" style="top: 5px;">
                        <img src="{{ asset('config_data/stamp.png') }}" alt="" class="ecp_image">
                    </div>
                    @endif
            </div>
        </div>
        <div id="border" style="font-size: 20px;">
           @if($ecp->value == 'on' || Auth::user()->role == 'Пользователь')
            <div style="position: relative; text-align: center; margin-bottom: 0px; overflow: auto;">
                <img src="{{ asset('config_data/ecpPrint.png') }}" alt="" style="width: 330px;">
            </div>
            @endif
        </div>
    </div>
    </div>

    @if(file_exists(public_path('conclusions_data/'.$conclusion->id.'/diagramma_crimping_1.jpg')))
    <div class="breaker"></div>
    <div class="image-object-control">
        <div>Диаграмма № {{ $conclusion->id }}/1</div>
        <img src="{{ asset('conclusions_data/'.$conclusion->id.'/diagramma_crimping_1.jpg') }}" alt="" style="height: 100%; width: 100%;">
    </div>
    @endif
    @if(file_exists(public_path('conclusions_data/'.$conclusion->id.'/diagramma_crimping_2.jpg')))
    <div class="breaker"></div>
    <div class="image-object-control">
        <div>Диаграмма № {{ $conclusion->id }}/2</div>
        <img src="{{ asset('conclusions_data/'.$conclusion->id.'/diagramma_crimping_2.jpg') }}" alt="" style="height: 100%; width: 100%;">
    </div>
    @endif
    @if(file_exists(public_path('conclusions_data/'.$conclusion->id.'/diagramma_crimping_3.jpg')))
    <div class="breaker"></div>
    <div class="image-object-control">
        <div>Диаграмма № {{ $conclusion->id }}/3</div>
        <img src="{{ asset('conclusions_data/'.$conclusion->id.'/diagramma_crimping_3.jpg') }}" alt="" style="height: 100%; width: 100%;">
    </div>
    @endif
    <script>
        window.print();
    </script>
</body>
</html>