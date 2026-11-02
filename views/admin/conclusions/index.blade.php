@extends('layouts.template')
@section('title', 'Список заключений')

@section('header')
    <h4>Список заключений</h4>
@endsection

@section('content')
    @if(Auth::user()->role == 'Администратор' || Auth::user()->role == 'Работник лаборатории')
        <a href="{{ route('conclusions.create') }}" class="btn btn-primary">Добавить</a>
        <hr>
    @endif
        <h4>Фильтры</h4>
        @include('admin.conclusions.filter')
        <hr>
    
<script language="javascript" src="{{ asset('ex2/ex2_files/es6-promise.min.js') }}"></script>
<script language="javascript" src="{{ asset('ex2/ex2_files/ie_eventlistner_polyfill.js') }}"></script>
<script language="javascript">
    function setExtensionLoadingInfo() {
        if (document.getElementById('ExtensionEnabledImg'))
            document.getElementById('ExtensionEnabledImg').setAttribute("src", "Img/green_dot.png");
        if (document.getElementById('ExtensionEnabledTxt'))
            document.getElementById('ExtensionEnabledTxt').innerHTML = "Расширение загружено";
        if (document.getElementById('PluginEnabledImg'))
            document.getElementById('PluginEnabledImg').setAttribute("src", "Img/red_dot.png");
        if (document.getElementById('PlugInEnabledTxt'))
            document.getElementById('PlugInEnabledTxt').innerHTML = "Плагин не загружен";
        window.cadesplugin_extension_loaded = true;
    }
    function extensionLoadedCallback() {
        window.onload = function (e) {
            setExtensionLoadingInfo();
        }
        setExtensionLoadingInfo();
    }
    window.cadesplugin_extension_loaded_callback = extensionLoadedCallback;
</script>
<script language="javascript" src="{{ asset('ex2/ex2_files/cadesplugin_api.js') }}"></script>
<script type="text/javascript" src="chrome-extension://iifchhfnnmpdbibifmljnfjhpififfog/nmcades_plugin_api.js"></script>
<script language="javascript" src="{{ asset('ex2/ex2_files/Code.js') }}"></script>
<script type="text/javascript" src="{{ asset('ex2/ex2_files/async_code.js') }}"></script>

    <div class="row mb-4">
        <div class="col-4">
            {{-- <form style="margin-bottom:1rem;" method="POST" action="{{ route('conclusions.zip') }}">
                @csrf --}}
                {{-- <div id="conclusions_archive" style="display: none;"></div> --}}
                <button class="btn btn-dark" id="archSignLoading" type="button"><i class="fas fa-archive"></i> Скачать подписанные одним архивом</button>
            {{-- </form> --}}
        </div>
        <div class="col-4">
            {{-- <form style="margin-bottom:1rem;" id="arch" method="POST" action=""> --}}
                {{-- @csrf --}}
                {{-- <div id="conclusions_not_sign" style="display: none;"></div> --}}
                <button class="btn btn-dark" id="archLoading" type="button"><i class="fas fa-archive"></i> Скачать не подписанные одним архивом</button>
                {{-- <button id="arch-spinner" type="submit" class="btn btn-dark" target="_blank"><i class="fas fa-archive"></i> Скачать не подписанные одним архивом</button> --}}
            {{-- </form> --}}
        </div>
    </div>
    
    @if (session('noItemFileForZip'))
    <div class="alert alert-danger" role="alert">
        Архив не создан, выберите подписанные заключения!
    </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

<div class="scroller mb-5">
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="select_all_conclusions" name="select_all_conclusions">
        <label class="form-check-label" for="select_all_conclusions">Выбрать все на странице</label>
    </div>
    <table class="table table-bordered datatable" id="conclusions_table">
        <thead>
        @if(count($conclusions) > 0)
            <tr>
                <th>
                    <!--<input type="checkbox" name="select_all_conclusions">-->
                </th>
                <th>№</th>
                <th>Дата</th>
                <th>Установка</th>
                <th>Номер ленты</th>
                <th>Серийный номер</th>
                <th>Заключение №</th>
                <th>Отчёты</th>
                @if(Auth::user()->role == 'Администратор' || Auth::user()->role == 'Работник лаборатории')
                <th>Действия</th>
                @endif
            </tr>
        @endif
        </thead>
        <tbody>
        @if(count($conclusions) < 1)
            <div class="alert alert-danger" role="alert">
                Не добавлено ещё ни одного заключения
            </div>
        @else
            @foreach($conclusions as $idx => $conclusion)
                @php
                    $conclusionResult = 1;
                    $vikResult = 1;
                    $uztResult = 1;
                    $mkResult = 1;
                    $giResult = 1;
                    $uzkResult = 1;
                    if(!empty($conclusion->vik_result) && $conclusion->vik_result === "Состояние поверхности объекта контроля не соответствует требованиям 3997-00.001 МУ «Методические указания по определению критериев вывода из эксплуатации нефтепромыслового оборудования»; Обнаружены недопустимые дефекты")
                    {$vikResult = 0; $conclusionResult = 0;}
                            
                    if(!empty($conclusion->uzt_result) && $conclusion->uzt_result === "Обнаруженные толщины менее допустимых значений. Негоден")
                        {$uztResult = 0; $conclusionResult = 0;}
                            
                    if(!empty($conclusion->mk_result) && $conclusion->mk_result === "Не годен")
                        {$mkResult = 0; $conclusionResult = 0;}
                            
                    if(!empty($conclusion->gi_result) && $conclusion->gi_result === "Узел (объект) не признается выдержавшим гидравлическое испытание на прочность и герметичность")
                        {$giResult = 0; $conclusionResult = 0;}
                            
                    if(!empty($conclusion->uzk_result) && $conclusion->uzk_result === "Не годен")
                        {$uzkResult = 0; $conclusionResult = 0;}
                @endphp
                <tr @if($conclusion->signReady) style="background-color: #ADD8E6;"
                    @elseif($conclusionResult == 1) style="background-color: #99CC99;"
                    @elseif($conclusionResult == 0) style="background-color: #CC9999;"
                    @endif>
                    <td class="text-center">
                        <input type="checkbox" name="conclusion_checked[]" value="{{ $conclusion->id }}">
                    </td>
                    <td>{{ $idx + 1 }}</td>
                    <td>
                        {{ $conclusion->get_format_date() }}
                    </td>
                    <td>
                        @if(isset($conclusion->component()->id)) {{ $conclusion->component()->facility()->number.' '.$conclusion->component()->facility()->gos_number.' '.$conclusion->component()->facility()->area }} @endif
                        <button type="button" class="btn btn-dark btn-xs get-histories" data-toggle="modal" data-component_id="{{ $conclusion->component_id }}" data-target="#histories"><i class="fas fa-history"></i></button>
                    </td>
                    <td>@if(isset($conclusion->component()->id)) {{ $conclusion->component()->tape_number }} @endif</td>
                    <td>@if(isset($conclusion->component()->id)) {{ $conclusion->component()->serial_number }} @endif</td>
                    <td>{{ $conclusion->id }}</td>
                    <td>
                        <a href="{{ route('reports.passport_uzt_vik_mk_gi', ['id' => $conclusion->id]) }}" target="_blank">Единая форма</a> |
                        <a href="{{ route('reports.passport_uzt_vik_mk_gi_pdf', ['id' => $conclusion->id]) }}" target="_blank">Скачать PDF</a> |
                        @if(Auth::user()->role == 'Администратор' || Auth::user()->role == 'Работник лаборатории')
                        <a data-toggle="modal" data-conclusion_id="{{ $conclusion->id }}" data-target="#makesign" href="#" target="_blank" class="makesign">Подписать</a> |
                        @endif
                        
                        @if(!empty($conclusion->signReady))
                        <a href="{{$conclusion->signReady}}" target="_blank" class="makesign">Скачать подписанный</a>
                        @endif
                        <ul style="padding: 0px; list-style-type: none;">
                            
                        <!--mk -->
                        @if($conclusionResult == 1 && $mkResult == 1 && $conclusion->check_mk == 1)
                            <li>
                                <a href="{{ route('reports.mk', ['id' => $conclusion->id]) }}" target="_blank">MK</a>
                            </li>
                        @elseif($conclusionResult == 0 && $mkResult == 0 && $conclusion->check_mk == 1)
                            <li>
                                <a href="{{ route('reports.mk', ['id' => $conclusion->id]) }}" target="_blank">MK</a>
                            </li>
                        @endif
                        
                        <!--uzt-->
                        @if($conclusionResult == 1 && $uztResult == 1 && $conclusion->check_uzt == 1)
                            <li>
                                <a href="{{ route('reports.uzt', ['id' => $conclusion->id]) }}" target="_blank">УЗТ</a>
                            </li>
                        @elseif($conclusionResult == 0 && $uztResult == 0 && $conclusion->check_uzt == 1)
                            <li>
                                <a href="{{ route('reports.uzt', ['id' => $conclusion->id]) }}" target="_blank">УЗТ</a>
                            </li>
                        @endif
                        
                        <!-- vik -->
                        @if($conclusionResult == 1 && $vikResult == 1 && $conclusion->check_vik == 1)
                            <li>
                                <a href="{{ route('reports.vik', ['id' => $conclusion->id]) }}" target="_blank">ВИК</a>
                            </li>
                        @elseif($conclusionResult == 0 && $vikResult == 0 && $conclusion->check_vik == 1)
                            <li>
                                <a href="{{ route('reports.vik', ['id' => $conclusion->id]) }}" target="_blank">ВИК</a>
                            </li>
                        @endif
                        
                        <!-- gi -->
                        @if($conclusionResult == 1 && $giResult == 1 && $conclusion->check_gi == 1)
                            <li>
                                <a href="{{ route('reports.gi', ['id' => $conclusion->id]) }}" target="_blank">ГИ</a>
                            </li>
                        @elseif($conclusionResult == 0 && $giResult == 0 && $conclusion->check_gi == 1)
                            <li>
                                <a href="{{ route('reports.gi', ['id' => $conclusion->id]) }}" target="_blank">ГИ</a>
                            </li>
                        @endif
                        
                        <!-- uzk -->
                        @if($conclusionResult == 1 && $uzkResult == 1 && $conclusion->check_uzk == 1)
                            <li>
                                <a href="{{ route('reports.uzk', ['id' => $conclusion->id]) }}" target="_blank">УЗК</a>
                            </li>
                        @elseif($conclusionResult == 0 && $uzkResult == 0 && $conclusion->check_uzk == 1)
                            <li>
                                <a href="{{ route('reports.uzk', ['id' => $conclusion->id]) }}" target="_blank">УЗК</a>
                            </li>
                        @endif
                        
                        @if($giResult == 1 && !empty($conclusion->diameter_plashki))
                            <li>
                                <a href="{{ route('reports.preventer', ['id' => $conclusion->id]) }}" target="_blank">Превентор</a>
                            </li>
                        @endif
                        
                        @if($giResult == 1 && !empty($conclusion->calibration_pressure))
                            <li>
                                <a href="{{ route('reports.calibration', ['id' => $conclusion->id]) }}" target="_blank">Тарировка</a>
                            </li>
                        @endif
                        @if($giResult == 1 && !empty($conclusion->coefficient))
                            <li>
                                <a href="{{ route('reports.bgrp', ['id' => $conclusion->id]) }}" target="_blank">ПРОБНОЕ ДАВЛЕНИЕ</a>
                            </li>
                        @endif
                        @if($conclusion->passport == 1)
                            <li>
                                <a href="{{ route('reports.passport', ['id' => $conclusion->id]) }}" target="_blank">Паспорт</a>
                            </li>
                        @endif
                        </ul>
                    </td>
                    @if(Auth::user()->role == 'Администратор' || Auth::user()->role == 'Работник лаборатории')
                    <td>
                        {{-- Печать номера ленты --}}
                        <!--<a href="{{ route('conclusions.print_length', ['conclusion_id' => $conclusion->id]) }}" target="_blank" class="btn btn-dark">
                            <i class="fas fa-print"></i>
                        </a>-->
                        {{-- Редактирование --}}
                        <a href="{{ route('conclusions.edit', ['id' => $conclusion->id]) }}" class="btn btn-success">
                            <i class="fas fa-edit"></i>
                        </a>
                        {{-- Удаление --}}
                        <button type="button" class="btn btn-danger" onclick="if(confirm('Подтвердите удаление заключения: {{ $conclusion->name }}')){$('#item_{{ $conclusion->id }}_delete').submit();}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        <form action="{{ route('conclusions.destroy', ['id' => $conclusion->id]) }}" id="item_{{ $conclusion->id }}_delete" method="POST">
                            @csrf
                            @method('delete')
                        </form>
                    </td>
                    @endif
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    <input id="userRole" type="hidden" value="{{ Auth::user()->role }}">
</div>
    <hr>
   <!-- {{-- Создание заявки --}}
    <form style="margin-bottom:3rem;" method="POST" action="{{ route('conclusions.save_orders') }}">
        @csrf
        <div class="row">
            <div class="col-12 col-md-3">
                <label>Заявка</label>
                <select name="order_id" class="form-control">
                    @foreach($orders as $order)
                        <option value="{{ $order->id }}">Заявка №{{ $order->id }}</option>
                    @endforeach
                </select>
            </div>
            <div id="order_conclusions" style="display: none;"></div>
            <div class="col-12 col-md-3">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-success col-12">Добавить в заявку</button>
            </div>
        </div>
    </form>-->

    {{-- История заключения --}}
    @include('admin.conclusions.histories')
@endsection



@section('js')
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.11.4/i18n/ru.json"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <script>
        function sendRequest(){
            var signReady = $('#SignatureTxtBox').val();
            var conclusion_id = $('#conclusion_id').val();
            console.log(conclusion_id);
            $.ajax({
                type:'POST',
                url:'{{ route('conclusions.signToDB') }}',
                data:{_token: "{{ csrf_token() }}", 'signReady': signReady, 'conclusion_id': conclusion_id},
                success: function( msg ) {
                    console.log(msg);
                    $('#pdf_link').show().attr('href', msg);
                },
                error: function( json )
                {
                    console.log(json);
                }
            });
        }
            
        $(document).on("click", ".makesign", function () {
             var obj = $(this);
             var c_id = obj.data('conclusion_id');
             $(".modal-body #conclusion_id").val( c_id );
        });

        $(document).ready(function() {
            /* $('#make_pdf').on('click', function(){
                $('#pdf_link').show();
            }) */
            
            $('#type_manufacturers').select2();
            $('#conclusions_facilities').select2();
            $('#conclusions_work_locations').select2();
            $('#conclusions_company').select2();
            
            {{-- Выбор конкретного заключения --}}
            $('input[name="conclusion_checked[]"]').click(function() {
                archive_conclusions_sign();
                recreate_order_conclusions();
            });
            {{-- Выбор всех заключений --}}
            $('input[name="select_all_conclusions"]').click(function() {
                var obj = $(this);
                var conclusions = $('table#conclusions_table input[name="conclusion_checked[]"]');
                if(obj.is(':checked'))
                    conclusions.prop('checked', true);
                else
                    conclusions.prop('checked', false);

                recreate_order_conclusions();
            });
            {{-- Пересобирает заключения в заявку --}}
            function recreate_order_conclusions()
            {
                var inputs = $('#conclusions_table input[name="conclusion_checked[]"]:checked');
                $('#order_conclusions').html('');
                $.each(inputs, function(key, value){
                    // console.log(value);
                    $('#order_conclusions').append('<input type="checkbox" name="conclusion_checked[]" value="'+$(value).val()+'" checked>');
                });
            }
            {{-- Собираем выбранные заключения --}}
            function archive_conclusions_sign()
            {
                var inputs = $('#conclusions_table input[name="conclusion_checked[]"]:checked');
                $('#conclusions_archive').html('');
                $.each(inputs, function(key, value){
                    // console.log($(value).val());
                    $('#conclusions_archive').append('<input type="checkbox" name="conclusion_checked[]" value="'+$(value).val()+'" checked>');
                });
            }

            {{-- Печать для всех заключений метка в документах --}}
            $('#stamp_label').click(function() {
                var obj = $(this);
                var res;
                var token = $('input[name="_token"]').val();
                if(obj.is(':checked')){
                    res = 'on';
                    $.post('{{ route('configs.stamp_change') }}', {'_token': token, 'stamp_value': res}, function(){});
                    $('#peshat').css({'display':'block'});       
                    }   
                else {
                    res = 'off';
                    $.post('{{ route('configs.stamp_change') }}', {'_token': token, 'stamp_value': res}, function(){});
                    $('#peshat').css({'display':'none'});
                }
            });

            {{-- Отпечаток ЭЦП для всех заключений метка в документах --}}
            $('#ecp_label').click(function() {
                var obj = $(this);
                var res;
                var token = $('input[name="_token"]').val();
                if(obj.is(':checked')){
                    res = 'on';
                    $.post('{{ route('configs.ecpPrint_change') }}', {'_token': token, 'ecp_value': res}, function(){});
                    $('#ecp').css({'display':'block'});       
                    }   
                else {
                    res = 'off';
                    $.post('{{ route('configs.ecpPrint_change') }}', {'_token': token, 'ecp_value': res}, function(){});
                    $('#ecp').css({'display':'none'});
                }
            });

            {{-- Факсимиле директора для всех заключений метка в документах --}}
            $('#sign_director_label').click(function() {
                var obj = $(this);
                var res;
                var token = $('input[name="_token"]').val();
                if(obj.is(':checked')){
                    res = 'on';
                    // console.log($('#sign_director_label').val());
                    $.post('{{ route('configs.signDirector_change') }}', {'_token': token, 'sign_director': res}, function(){});
                    $('#sign_director').css({'display':'block'});       
                    }   
                else {
                    res = 'off';
                    $.post('{{ route('configs.signDirector_change') }}', {'_token': token, 'sign_director': res}, function(){});
                    $('#sign_director').css({'display':'none'});
                }
            });

            {{-- Факсимиле инспектора для всех заключений метка в документах --}}
            $('#sign_inspector_label').click(function() {
                var obj = $(this);
                var res;
                var token = $('input[name="_token"]').val();
                if(obj.is(':checked')){
                    res = 'on';
                    $.post('{{ route('configs.signInspector_change') }}', {'_token': token, 'sign_inspector': res}, function(){});       
                    }   
                else {
                    res = 'off';
                    $.post('{{ route('configs.signInspector_change') }}', {'_token': token, 'sign_inspector': res}, function(){});
                }
            });

            {{-- Смена компании --}}
            $('select[name="conclusions_company_id"]').change(function() {
                var company_id = $('select[name="conclusions_company_id"]').val();
                var work_location_id = $('select[name="conclusions_work_locations"]').val();
                var facility_id = $('select[name="conclusions_facilities"]').val();

                if(company_id !== '')
                {
                    $.post('{{ route('conclusions.get_info_for_filters') }}', {'company_id': company_id, 'work_location_id': work_location_id, 'facility_id': facility_id}, function(data) {
                        set_work_locations(data);
                        set_facilities(data);
                        set_dates(data);
                    });
                }
            });
            {{-- Смена места проведения работ --}}
            $('select[name="conclusions_work_locations"]').change(function() {
                var company_id = $('select[name="conclusions_company_id"]').val();
                var work_location_id = $('select[name="conclusions_work_locations"]').val();
                var facility_id = $('select[name="conclusions_facilities"]').val();

                $.post('{{ route('conclusions.get_info_for_filters') }}', {'company_id': company_id, 'work_location_id': work_location_id, 'facility_id': facility_id}, function(data) {
                    set_facilities(data);
                    set_dates(data);
                });
            });
            {{-- Смена установки --}}
            $('select[name="conclusions_facilities"]').change(function() {
                var company_id = $('select[name="conclusions_company_id"]').val();
                var work_location_id = $('select[name="conclusions_work_locations"]').val();
                var facility_id = $('select[name="conclusions_facilities"]').val();

                $.post('{{ route('conclusions.get_info_for_filters') }}', {'company_id': company_id, 'work_location_id': work_location_id, 'facility_id': facility_id}, function(data) {
                    set_dates(data);
                });
            });

            {{-- Подстановка мест проведения работ --}}
            function set_work_locations(data)
            {
                var locations = '<option value=""></option>';
                $.each(data['work_locations'], function(key, value) {
                    locations += '<option value="'+value.id+'">'+value.name+'</option>';
                });
                $('select[name="conclusions_work_locations"]').html(locations);
            }

            {{-- Подстановка установок --}}
            function set_facilities(data)
            {
                var facilities = '<option value=""></option>';
                $.each(data['facilities'], function(key, value) {
                    facilities += '<option value="'+value.id+'">'+value.number+' '+value.gos_number+' '+value.area+'</option>';
                });
                $('select[name="conclusions_facilities"]').html(facilities);
            }
            {{-- Подстановка дат заключений --}}
            function set_dates(data)
            {
                var dates = '<option value=""></option>';
                $.each(data['dates'], function(key, value) {
                    date = value.date.split('-');
                    dates += '<option value="'+value.date+'">'+date[2]+'.'+date[1]+'.'+date[0]+'</option>';
                });
                $('select[name="conclusions_date"]').html(dates);
            }
            
            
            
            
        
        
        

            {{-- История заключения --}}
            $('.get-histories').click(function() {
                var obj = $(this);
                var component_id = obj.data('component_id');

                $.post('{{ route('conclusions.histories') }}', {'component_id': component_id}, function(data) {
                    var result = '';
                    $.each(data['conclusions'], function(key, value) {
                        var conclusions_result = '<ul style="padding: 0px; list-style-type: none;">';
                        var conclusion_general_result = '<li><b>Вывод:</b> годен</li>';

                        // if(value.mk_result !== '')
                        // {
                        //     {{-- МК --}}
                        //     if(value.mk_result === 'Годен')
                        //         conclusions_result += '<li><b>МК:</b> годен</li>';
                        //     else {
                        //         conclusions_result += '<li><b>МК:</b> не годен</li>';
                        //         conclusion_general_result = '<li><b>Вывод:</b> не годен</li>';
                        //     }
                        // }
                        // if(value.vik_result !== '') {
                        //     {{-- ВИК --}}
                        //     if (value.vik_result === 'Состояние поверхности объекта контроля соответствует требованиям 3997-00.001 МУ «Методические указания по определению критериев вывода из эксплуатации нефтепромыслового оборудования»; Недопустимых дефектов не обнаружено')
                        //         conclusions_result += '<li><b>ВИК:</b> годен</li>';
                        //     else {
                        //         conclusions_result += '<li><b>ВИК:</b> не годен</li>';
                        //         conclusion_general_result = '<li><b>Вывод:</b> не годен</li>';
                        //     }
                        // }
                        // if(value.uzt_result !== '') {
                        //     {{-- УЗК --}}
                        //     if (value.uzt_result === 'Обнаруженные толщины не менее допустимых значений. Годен')
                        //         conclusions_result += '<li><b>УЗК:</b> годен</li>';
                        //     else {
                        //         conclusions_result += '<li><b>УЗК:</b> не годен</li>';
                        //         conclusion_general_result = '<li><b>Вывод:</b> не годен</li>';
                        //     }
                        // }
                        // if(value.gi_result !== '') {
                        //     {{-- ГИ --}}
                        //     if (value.gi_result === 'Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность')
                        //         conclusions_result += '<li><b>ГИ:</b> годен</li>';
                        //     else {
                        //         conclusions_result += '<li><b>ГИ:</b> не годен</li>';
                        //         conclusion_general_result = '<li><b>Вывод:</b> не годен</li>';
                        //     }
                        // }
                        
                        {{-- МК --}}
                        switch (value.mk_result) {
                            case "Годен":
                                conclusions_result += '<li><b>МК:</b> годен</li>';
                                break;
                            case "Не годен":
                                conclusions_result += '<li><b>МК:</b> не годен</li>';
                                conclusion_general_result = '<li><b>Вывод:</b> не годен</li>';
                                break;
                            default:
                                conclusions_result += '<li><b>МК:</b> -</li>';
                                conclusion_general_result = '<li><b>Вывод:</b> - </li>';
                                break;
                        }
                        {{-- ВИК --}}
                        switch (value.vik_result) {
                            case "Состояние поверхности объекта контроля соответствует требованиям 3997-00.001 МУ «Методические указания по определению критериев вывода из эксплуатации нефтепромыслового оборудования»; Недопустимых дефектов не обнаружено":
                                conclusions_result += '<li><b>ВИК:</b> годен</li>';
                                break;
                            case "Состояние поверхности объекта контроля не соответствует требованиям 3997-00.001 МУ «Методические указания по определению критериев вывода из эксплуатации нефтепромыслового оборудования»; Обнаружены недопустимые дефекты":
                                conclusions_result += '<li><b>ВИК:</b> не годен</li>';
                                conclusion_general_result = '<li><b>Вывод:</b> не годен</li>';
                                break;
                            default:
                                conclusions_result += '<li><b>ВИК:</b> -</li>';
                                conclusion_general_result = '<li><b>Вывод:</b> - </li>';
                                break;
                        }
                        {{-- УЗК --}}
                        switch (value.uzt_result) {
                            case "Обнаруженные толщины не менее допустимых значений. Годен":
                                conclusions_result += '<li><b>УЗК:</b> годен</li>';
                                break;
                            case "Обнаруженные толщины менее допустимых значений. Негоден":
                                conclusions_result += '<li><b>УЗК:</b> не годен</li>';
                                conclusion_general_result = '<li><b>Вывод:</b> не годен</li>';
                                break;
                            default:
                                conclusions_result += '<li><b>УЗК:</b> -</li>';
                                conclusion_general_result = '<li><b>Вывод:</b> - </li>';
                                break;
                        }
                        {{-- ГИ --}}
                        switch (value.gi_result) {
                            case "Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность":
                                conclusions_result += '<li><b>ГИ:</b> годен</li>';
                                break;
                            case "Узел (объект) не признается выдержавшим гидравлическое испытание на прочность и герметичность":
                                conclusions_result += '<li><b>ГИ:</b> не годен</li>';
                                conclusion_general_result = '<li><b>Вывод:</b> не годен</li>';
                                break;
                            default:
                                conclusions_result += '<li><b>ГИ:</b> -</li>';
                                conclusion_general_result = '<li><b>Вывод:</b> - </li>';
                                break;
                        }
                        conclusions_result += (conclusions_result === '<ul style="padding: 0px; list-style-type: none;">') ? '' : conclusion_general_result;
                        conclusions_result += '</ul>';

                        let date_update = value.date_update !== null ? value.date_update : '-';
                        let user_update_name = value.user_id_update !== null ? data['user_id_update']?.[value.id]?.name ?? '-' : '-';
                        let user_action = value.user_action !== null ? value.user_action : '-';
                        let splitDate = value.date.split('-');
                        let revDate = splitDate[2] + '-' + splitDate[1] + '-' + splitDate[0] + ' г.';
                        let typeName = data['type']?.name ?? '-';
                        let typeDescription = data['type']?.description ?? '-';
                        let facilityArea = data['facilities']?.[value.id]?.area ?? '-';
                        let inspectorName = data['inspectors']?.[value.id]?.name ?? '-';
                        result += '<tr>' +
                            '<td>'+revDate+'</td>' +
                            // '<td>'+data['type'].name+'</td>' +
                            // '<td>'+data['type'].description+'</td>' +
                            // '<td>'+data['facilities'][value.id].area+'</td>' +
                            // '<td>'+data['inspectors'][value.id].name+'</td>' +
                            '<td>'+typeName+'</td>' +
                            '<td>'+typeDescription+'</td>' +
                            '<td>'+facilityArea+'</td>' +
                            '<td>'+inspectorName+'</td>' +
                            '<td>'+conclusions_result+'</td>';
                            if($('#userRole').val() == "Администратор" || $('#userRole').val() == "Работник лаборатории") {
                                result += '<td><a href="/conclusions/'+value.id+'/edit" target="_blank">Открыть</a></td>';
                                result += '<td>' + date_update + '<br>' + user_action + '<br>' + user_update_name + '</td>';
                            }
                            result += '</tr>';
                    });
                    $('#histories tbody').html(result);
                });
            });

            // загрузка архива
            $.ajaxSetup({
                headers: {'X-CSRF-Token': '{{csrf_token()}}'}
            });

            $('#archLoading').click(function(e) {
                e.preventDefault();
                var inputs = $('#conclusions_table input[name="conclusion_checked[]"]:checked');
                var token = $('input[name="_token"]').val();
                var arr_conclusion_checked = [];
                $.each(inputs, function(key, value){
                    arr_conclusion_checked.push($(value).val());
                });
                if(arr_conclusion_checked.length != 0) {
                    $.ajax({
                    url: '{{ route('conclusions.zipNotSign') }}',
                    type: 'POST',
                    data: {
                        '_token': token,
                        conclusion_checked: arr_conclusion_checked
                    },
                    //async: false,
                    //processData: false,
                    //dataType: 'json',
                    beforeSend: function() {
                        $('#archLoading').html('<i class="spinner-view" aria-hidden="true"></i> Идет загрузка ... ');
                        $('#archLoading').attr('disabled', true);
                    },
                    complete: function() {
                        $('#archLoading').attr('disabled', false);
                        $('#archLoading').html('<i class="fas fa-archive"></i> Скачать не подписанные одним архивом');
                    },
                    success: function(response) {
                        window.location = response;
                        $('#conclusions_table input[name="conclusion_checked[]"]').attr('checked', false)
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\n" + xhr.statusText + "\n" + xhr.responseText);
                    }
                });
                } else {
                    alert("Не выбраны заключения!");
                }
            });

            $('#archSignLoading').click(function(e) {
                e.preventDefault();
                var inputs = $('#conclusions_table input[name="conclusion_checked[]"]:checked');
                var token = $('input[name="_token"]').val();
                var arr_conclusion_checked = [];
                $.each(inputs, function(key, value){
                    arr_conclusion_checked.push($(value).val());
                });
                if(arr_conclusion_checked.length != 0) {
                    $.ajax({
                        url: '{{ route('conclusions.zip') }}',
                        type: 'POST',
                        data: {
                            '_token': token,
                            conclusion_checked: arr_conclusion_checked
                    },
                    async: false,
                    //processData: false,
                    //dataType: 'json',
                    //timeout: 10000,
                    beforeSend: function() {
                        //$('#archLoading').html('<span class="spinner-border spinner-border-sm"></span> Загрузка ...');
                        $('#archSignLoading').html('<i class="spinner-view" aria-hidden="true"></i> Идет загрузка ... ');
                        $('#archSignLoading').attr('disabled', true);
                    },
                    complete: function() {
                        //$('#archLoading').button('reset');
                        $('#archSignLoading').attr('disabled', false);
                        $('#archSignLoading').html('<i class="fas fa-archive"></i> Скачать подписанные одним архивом');
                        //$("#archLoading").show(); 
                    },
                    success: function(response) {
                        window.location = response;
                        //console.log(response);
                        // var a = document.createElement("a");
                        // a.href = response;
                        // a.download = response;
                        // document.body.appendChild(a);
                        // a.click();
                        // a.remove();
                        //$('#archLoading').attr('disabled', false);
                        $('#conclusions_table input[name="conclusion_checked[]"]').attr('checked', false)
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
                } else {
                    alert("Не выбраны заключения!");
                }
            });
            
            $('#conclusions_table').DataTable({
                language: {
                    processing: "Подождите...",
                    loadingRecords: "Загрузка записей...",
                    emptyTable: "В таблице отсутствуют данные",
                    lengthMenu: "Показать _MENU_ записей",
                    search: "Поиск:",
                    info: "Записи с _START_ до _END_ из _TOTAL_ записей",
                    infoEmpty: "Записи с 0 до 0 из 0 записей",
                    infoFiltered: "",
                    previous: "Предыдущая",
                    next: "Следующая",
                    last: "Последняя",
                    Show: "Показать",
                    paginate: {
                        first: "Первая",
                        previous: "Предыдущая",
                        next: "Следующая",
                        last: "Последняя"
                    },
                }
            });
            
        });


    </script>
@endsection


@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet">

    <style>
        #reports {
            padding-top: 15px;
        }
        #reports a {
            margin-right: 15px;
            padding: 6px 10px;
            color: #fff;
        }
        .modal-lg {
            max-width: 1024px;
        }
        .spinner-view {
            /*position: absolute;
            top: 34px;
            right: 21px; */
            text-align: center;
            display: inline-block;
            width: 30px;
            height: 16px;
            background: url(/../../public/svg/loading.gif) 0 0 no-repeat;
        }
    </style>
@endsection