@extends('layouts.template')
@section('title', 'Новое оборудование')


@section('header')
    <h4>
        <a href="{{ route('components.index') }}">Список оборудования</a> / Новое оборудование
    </h4>
@endsection


@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Заполните информацию по новому оборудованию</div>
                <div class="card-body">
                    <form action="{{ route('components.store') }}" method="POST">
                        <div class="alert alert-danger" style="display: none; margin-top: 15px;" id="error_tape_number"></div>
                        @csrf
                        <div class="row">
                            {{-- Компания --}}
                            <div class="col-12 col-md-6">
                                <div class="list">
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Организация владелец</h4>
                                    <select name="company_id" id="company_id" class="form-control" required>
                                        <option value="@if(!empty($last_component)){{ $last_component->company()->id }}@endif">@if(!empty($last_component)){{ $last_component->company()->name }}@endif</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}" data-abbr="{{ $company->abbr }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- Место проведения работ --}}
                            <div class="col-12 col-md-6">
                                <div class="list">
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Место пров. работ</h4>
                                     <select name="work_location_id" class="form-control" required>
                                        <option value="@if(!empty($last_component)){{ $last_component->work_location()->id }}@endif">@if(!empty($last_component)){{ $last_component->work_location()->name }}@endif</option>
                                    </select>
                                </div>
                            </div>
                            {{-- Установка --}}
                            <div class="col-12 col-md-6">
                                <div class="list">
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Номер флота/установки</h4>
                                    <select name="facility_id" class="form-control" required>
                                        <option value="@if(!empty($last_component)){{ $last_component->facility()->id }}@endif">@if(!empty($last_component)){{ $last_component->facility()->number }} {{ $last_component->facility()->gos_number }} {{ $last_component->facility()->area }}@endif</option>
                                    </select>
                                  <input type="hidden" id="facility__name" value="" />
                                </div>
                            </div>
                            {{-- Номер ленты --}}
                            <div class="col-12 col-md-6">
                                <div class="list">
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Номер бандажной ленты</h4>
                                    <input type="text" name="tape_number" class="form-control" placeholder="@if(!empty($last_component)){{ $lastTypeNumber }}@endif" required>
                                </div>
                            </div>
                            {{-- Тип --}}
                            <div class="col-12 col-md-6">
                                <div class="list">
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Оборудование / инструменты</h4>
                                    <select name="type_id" id="type_id" class="form-control searcher" required>
                                        <option value=""></option>
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}" data-abbr_name_type="{{ $type->abbr_name_type }}">{{ $type->name.' ('.$type->description.' / '.$type->partial_number.' / '.$type->manufacturer.')' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- Описание --}}
                            <div class="col-12 col-md-6">
                                <div class="list">
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Характеристики</h4>
                                    <input type="text" id="description" class="form-control" readonly>
                                </div>
                            </div>
                            {{-- Производитель --}}
                            <div class="col-12 col-md-6">
                                <div class="list">
                                    <h4 class="card-title">Производитель</h4>
                                    <input type="text" id="manufacturer" class="form-control" readonly>
                                </div>
                            </div>
                            {{-- Партийный номер --}}
                            <div class="col-12 col-md-3">
                                <div class="list">
                                    <h4 class="card-title">Партийный номер</h4>
                                    <input type="text" id="partial_number" class="form-control" required>
                                </div>
                            </div>
                            {{-- Серийный номер --}}
                            <div class="col-12 col-md-3">
                                <div class="list">
                                    <h4 class="card-title">Серийный номер</h4>
                                    <input type="text" class="form-control" name="serial_number" required>
                                </div>
                            </div>
                            {{-- Комментарий --}}
                            <div class="col-12 col-md-6">
                                <div class="list">
                                    <h4 class="card-title">Комментарий</h4>
                                    <input type="text" class="form-control" name="comment">
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                    {{-- Расч. срок службы --}}
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Расч. срок службы</h4>
                                    <input type="text" id="life_time" class="form-control" name="life_time" readonly>
                                </div>
                            {{-- Дата ввода в эксплуатацию --}}
                            <div class="col-12 col-md-3">
                                <div class="list">
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Дата ввода в экспл.</h4>
                                    <input type="date" class="form-control" name="date_start_expluatation">
                                </div>
                            </div>
                            {{-- Рабочее давление --}}
                            <div class="col-4 col-md-4">
                                <div class="list">
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Рабочее давление, МПа/Psi</h4>
                                    <input type="text" class="form-control" name="pressure" required>
                                </div>
                            </div>
                            {{-- Ед. изм --}}
                            <div class="col-4 col-md-2">
                                <div class="list">
                                    <h4 class="card-title">Ед. изм.</h4>
                                    <select name="measure" id="measure" class="form-control" required>
                                        <option value="Мпа">МПа</option>
                                        <option value="Psi">Psi</option>
                                        <!--<option value="кг\см2">кг\см2</option>-->
                                    </select>
                                </div>
                            </div>
                            <div class="col-5 col-md-5">
                                <div class="list">
                                </div>
                            </div>
                            <div class="col-4 col-lg-4">
                                     {{-- Этапы оприсовки 1 --}}
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Этапы оприсовки 1, МПа/Psi</h4>
                                     <input type="text" id="crimping_1" name="crimping_1" class="form-control" required disabled>
                                </div>
                                <div class="col-4 col-lg-4">
                                     {{-- Этапы оприсовки 2 --}}
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Этапы оприсовки 2, МПа/Psi</h4>
                                     <input type="text" id="crimping_2" name="crimping_2" class="form-control" required disabled>
                                </div>
                                <div class="col-4 col-lg-4">
                                     {{-- Этапы оприсовки 3 --}}
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Этапы оприсовки 3, МПа/Psi</h4>
                                     <input type="text" id="crimping_3" name="crimping_3" class="form-control" required disabled>
                                </div>
                                <div class="col-4 col-lg-4">
                                     {{-- Этапы оприсовки 4 --}}
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Этапы оприсовки 4, МПа/Psi</h4>
                                     <input type="text" id="crimping_4" name="crimping_4" class="form-control" required disabled>
                                </div>
                                <div class="col-4 col-lg-4">
                                     {{-- Этапы оприсовки 5 --}}
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Этапы оприсовки 5, МПа/Psi</h4>
                                     <input type="text"id="crimping_5"  name="crimping_5" class="form-control" required disabled>
                                </div>
                                <div class="col-4 col-lg-4">
                                     {{-- Этапы оприсовки 6 --}}
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Этапы оприсовки 6, МПа/Psi</h4>
                                     <input type="text" id="crimping_6" name="crimping_6" class="form-control" required disabled>
                                </div>
                        </div>
                        <div class="row">
                            {{-- Замеры 1 --}}
                            <div class="col-12 col-md-2">
                                <div class="list">
                                    <h4 class="card-title">Сечение 1</h4>
                                    <input type="text" id="measure_1" class="form-control" readonly>
                                </div>
                            </div>
                            {{-- Замеры 2 --}}
                            <div class="col-12 col-md-2">
                                <div class="list">
                                    <h4 class="card-title">Сечение 2</h4>
                                    <input type="text" id="measure_2" class="form-control" readonly>
                                </div>
                            </div>
                            {{-- Замеры 3 --}}
                            <div class="col-12 col-md-2">
                                <div class="list">
                                    <h4 class="card-title">Сечение 3</h4>
                                    <input type="text" id="measure_3" class="form-control" readonly>
                                </div>
                            </div>
                            {{-- Замеры 4 --}}
                            <div class="col-12 col-md-2">
                                <div class="list">
                                    <h4 class="card-title">Сечение 4</h4>
                                    <input type="text" id="measure_4" class="form-control" readonly>
                                </div>
                            </div>
                            {{-- Замеры 5 --}}
                            <div class="col-12 col-md-2">
                                <div class="list">
                                    <h4 class="card-title">Сечение 5</h4>
                                    <input type="text" id="measure_5" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-2">
                                <div class="list">
                                    <h4 class="card-title">Сечение 6</h4>
                                    <input type="text" id="measure_6" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-2">
                                <div class="list">
                                    <h4 class="card-title">Сечение 7</h4>
                                    <input type="text" id="measure_7" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-2">
                                <div class="list">
                                    <h4 class="card-title">Сечение 8</h4>
                                    <input type="text" id="measure_8" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-2">
                                <div class="list">
                                    <h4 class="card-title">Сечение 9</h4>
                                    <input type="text" id="measure_9" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-2">
                                <div class="list">
                                    <h4 class="card-title">Сечение 10</h4>
                                    <input type="text" id="measure_10" class="form-control" readonly>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            {{-- УЗТ --}}
                            <div class="col-12 col-md-12 item-uzt">
                                <div class="list">
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>УЗТ</h4>
                                    <div class="upload-image">
                                        <img src="" alt="">
                                    </div>
                                </div>
                                <hr>
                            </div>
                            {{-- МК --}}
                            <div class="col-12 col-md-12 item-mk">
                                <div class="list">
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>МК</h4>
                                    <div class="upload-image">
                                        <img src="" alt="">
                                    </div>
                                </div>
                                <hr>
                            </div>
                            {{-- ВИК --}}
                            <div class="col-12 col-md-12 item-vik">
                                <div class="list">
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>ВИК</h4>
                                    <div class="upload-image">
                                        <img src="" alt="">
                                    </div>
                                </div>
                                <hr>
                            </div>
                            {{-- УК --}}
                            <div class="col-12 col-md-12 item-uk">
                                <div class="list">
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>УЗК</h4>
                                    <div class="upload-image">
                                        <img src="" alt="">
                                    </div>
                                </div>
                                <hr>
                            </div>
                            {{-- Диаграмма оприсовки --}}
                            <div class="col-12 col-md-12 item-diagram_crimping">
                                <div class="list">
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Диаграмма оприсовки</h4>
                                    <div class="upload-image">
                                        <img src="" alt="">
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                        <br>

                        {{-- <input type="hidden" name="id" value="{{ $id }}"> --}}
                        <input type="hidden" name="inspectorId" value="{{ $inspectorId }}">
                        <button type="submit" class="btn btn-primary">Добавить</button>
                        <div class="alert alert-danger" style="display: none; margin-top: 15px;" id="error_tape_number"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.searcher').select2();

            // проверка номера ленты на существование
            function check_exists_tape_number()
            {
                var tape_number = $('input[name="tape_number"]').val();
                var abbr = $('select[name="company_id"] option:selected').data('abbr');
                var company_id = $('select[name="company_id"]').val();
                const regexTapeNumber = /_/gi;
                if(tape_number.match(regexTapeNumber))
                {
                        $('input[name="tape_number"]').css('border', '1px solid #ff0000');
                        $('button[type="submit"]').attr('disabled', true);
                        $('#error_tape_number').css('display', 'block');
                        $('#error_tape_number').html('В номере ленты нельзя применять спецсимвол "_" ! Допустимы пробелы, ".", "-"');
                } else {
                    $.post('{{ route('components.check_tape_number_exists') }}', {'tape_number': tape_number, 'abbr': abbr, 'company_id': company_id}, function(data) {
                        if(data['result'] === 'true')
                        {
                            $('input[name="tape_number"]').css('border', '1px solid #ff0000');
                            $('button[type="submit"]').attr('disabled', true);
                            $('#error_tape_number').css('display', 'block');
                            $('#error_tape_number').html('Данный номер ленты уже есть в базе. Вы можете <a href="{{ route('conclusions.create') }}" target="_blank">создать заключение</a> или <a href="/components/'+data['component'].id+'/edit" target="_blank">редактировать компонент</a>');
                        } else if(data['result'] === 'false')
                        {
                            $('input[name="tape_number"]').css('border', '1px solid #e5e6e7');
                            $('button[type="submit"]').attr('disabled', false);
                            $('#error_tape_number').css('display', 'none');
                        }
                    });
                }
            }

            {{-- При смене компании подгружаем места проведения работ и установки --}}
            $('select[name="company_id"]').change(function() {
                var obj = $(this);
                var company_id = obj.val();

                {{-- места проведения работ --}}
                $.post('{{ route('companies.get_work_locations') }}', {'company_id': company_id}, function(data) {
                    var locations = '<option></option>';
                    $.each(data, function(key, value) {
                        locations += '<option value="'+value.id+'">'+value.name+'</option>';
                    });
                    $('select[name="work_location_id"]').html(locations);
                });
                {{-- установки --}}
                $.post('{{ route('companies.get_facilities') }}', {'company_id': company_id}, function(data) {
                    var facilities = '<option></option>';
                    $.each(data, function(key, value) {
                        facilities += '<option value="'+value.id+'" data-facility_name="'+value.number+'">'+value.number+' '+value.gos_number+' '+value.area+'</option>';
                    });
                    $('select[name="facility_id"]').html(facilities);
                });

                create_tape_number();
            });
            $('select[name="facility_id"]').change(function() {
                
                var facilitiy = $('select[name="facility_id"] option:selected').text();
                   $('#facility__name').val(facilitiy)    
                
            });

            // событие при выборе оборудования
            $('#type_id').change(function() {
                var current_obj = $(this);
                var type_id = current_obj.val();
                if(current_obj.val() !== '')
                {
                    var token = $('input[name="_token"]').val();

                    $.post('{{ route('ajax.components.get_type') }}', {'_token': token, 'type_id': type_id}, function(data) {
                        $('input[name="pressure"]').val(data.pressure);
                        $('#manufacturer').val(data.manufacturer);
                        $('#partial_number').val(data.partial_number);
                        $('#description').val(data.description);
                        //$('#measure').val(data.measure);
                        $('#measure_1').val(data.measure_1);
                        $('#measure_2').val(data.measure_2);
                        $('#measure_3').val(data.measure_3);
                        $('#measure_4').val(data.measure_4);
                        $('#measure_5').val(data.measure_5);
                        $('#measure_6').val(data.measure_6);
                        $('#measure_7').val(data.measure_7);
                        $('#measure_8').val(data.measure_8);
                        $('#measure_9').val(data.measure_9);
                        $('#measure_10').val(data.measure_10);
                        $('#crimping_1').val(data.crimping_1);
                        $('#crimping_2').val(data.crimping_2);
                        $('#crimping_3').val(data.crimping_3);
                        $('#crimping_4').val(data.crimping_4);
                        $('#crimping_5').val(data.crimping_5);
                        $('#crimping_6').val(data.crimping_6);
                        $('#life_time').val(data.life_time);

                        $('.item-uzt img').attr('src', '/types_data/'+data.id+'/uzt.jpg');
                        $('.item-uzt a').attr('src', '/types_data/'+data.id+'/uzt.jpg');
                        $('.item-mk img').attr('src', '/types_data/'+data.id+'/mk.jpg');
                        $('.item-mk a').attr('src', '/types_data/'+data.id+'/mk.jpg');
                        $('.item-vik img').attr('src', '/types_data/'+data.id+'/vik.jpg');
                        $('.item-vik a').attr('src', '/types_data/'+data.id+'/vik.jpg');
                        $('.item-uk img').attr('src', '/types_data/'+data.id+'/uk.jpg');
                        $('.item-uk a').attr('src', '/types_data/'+data.id+'/uk.jpg');
                        $('.item-diagram_crimping img').attr('src', '/types_data/'+data.id+'/diagram_crimping.jpg');
                        $('.item-diagram_crimping a').attr('src', '/types_data/'+data.id+'/diagram_crimping.jpg');
                        $('#measure option[value="'+data.measure+'"]').prop('selected', true);

                        create_tape_number();
                    });
                }
            });

            // событие при указании партийного номера
            $('#partial_number').change(function() {
                var current_obj = $(this);
                var partial_number = current_obj.val();
                if(current_obj.val() !== '')
                {
                    var token = $('input[name="_token"]').val();

                    $.post('{{ route('ajax.components.get_type') }}', {'_token': token, 'partial_number': partial_number}, function(data) {
                        $('#manufacturer').val(data.manufacturer);
                        $('select#type_id option').removeAttr('selected');
                        $('select#type_id option[value="'+data.id+'"]').attr('selected', true);
                        $('#type_id').trigger('change.select2');
                        $('#description').val(data.description);
                        $('#measure_1').val(data.measure_1);
                        $('#measure_2').val(data.measure_2);
                        $('#measure_3').val(data.measure_3);
                        $('#measure_4').val(data.measure_4);
                        $('#measure_5').val(data.measure_5);
                        $('#measure_6').val(data.measure_6);
                        $('#measure_7').val(data.measure_7);
                        $('#measure_8').val(data.measure_8);
                        $('#measure_9').val(data.measure_9);
                        $('#measure_10').val(data.measure_10);
                        $('#crimping_1').val(data.crimping_1);
                        $('#crimping_2').val(data.crimping_2);
                        $('#crimping_3').val(data.crimping_3);
                        $('#crimping_4').val(data.crimping_4);
                        $('#crimping_5').val(data.crimping_5);
                        $('#crimping_6').val(data.crimping_6);
                        $('input[name="pressure"]').val(data.pressure);

                        $('.item-uzt img').attr('src', '/types_data/'+data.id+'/uzt.jpg');
                        $('.item-uzt a').attr('src', '/types_data/'+data.id+'/uzt.jpg');
                        $('.item-mk img').attr('src', '/types_data/'+data.id+'/mk.jpg');
                        $('.item-mk a').attr('src', '/types_data/'+data.id+'/mk.jpg');
                        $('.item-vik img').attr('src', '/types_data/'+data.id+'/vik.jpg');
                        $('.item-vik a').attr('src', '/types_data/'+data.id+'/vik.jpg');
                        $('.item-uk img').attr('src', '/types_data/'+data.id+'/uk.jpg');
                        $('.item-uk a').attr('src', '/types_data/'+data.id+'/uk.jpg');
                        $('.item-diagram_crimping img').attr('src', '/types_data/'+data.id+'/diagram_crimping.jpg');
                        $('.item-diagram_crimping a').attr('src', '/types_data/'+data.id+'/diagram_crimping.jpg');
                        $('#measure option[value="'+data.measure+'"]').prop('selected', true);
                        create_tape_number();
                    });
                }
            });
/*
            {{-- При смене ключевых данных, обновляем номер ленты --}}
            $('select[name="abbr"], select[name="facility_id"], select[name="abbr_name_type"], input[name="pressure"], input[name="date_start_expluatation"]').change(function(){create_tape_number()});
            $('select[name="abbr"], select[name="facility_id"], select[name="abbr_name_type"], input[name="pressure"], input[name="date_start_expluatation"]').keyup(function(){create_tape_number()});
            */
            $('input[name="tape_number"]').keyup(function() {
                check_exists_tape_number();
            });
            function create_tape_number() {
                /*var abbr = $('select[name="company_id"] option:selected').data('abbr');
                abbr = (abbr === undefined) ? '' : abbr;
                var facility = $('select[name="facility_id"] option:selected').data('facility_name');
                facility = (facility === undefined || facility === null) ? '' : facility;*/
                /*var abbr_name_type = $('select[name="type_id"] option:selected').data('abbr_name_type');
                abbr_name_type = (abbr_name_type === undefined) ? '' : abbr_name_type;*/
                /*var pressure = $('input[name="pressure"]').val();
                var date = $('input[name="date_start_expluatation"]').val();
                var date_format = date.split('-');
                date = (date === '') ? '' : date_format[1]+date_format[0];

                var id = parseInt($('input[name="id"]').val());
                var tape_number = abbr+'.'+facility+'.'+id+'.'+pressure;
                $('input[name="tape_number"]').val(tape_number);

                {{-- Проверяем, что такого номера ленты ещё нет в базе --}}
                check_exists_tape_number();*/
            }
        });
    </script>
@endsection


@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet">
    <style>
        .upload-image {
            text-align: center;
        }

        .upload-image img {
            height: 200px;
            border-radius: 5px;
        }
    </style>
@endsection