@extends('layouts.template')
@section('title', 'Новое оборудование')

@section('header')

@endsection

@section('content')

    <div class="row justify-content-center">
         <div class="col-md-10 col-12">
            <div class="card">
                <div class="card-header first"><h3>Заполните информацию по новому оборудованию</h3><a class="card-header-link"  href="{{ route('types.index') }}"><i class="fa fa-mail-reply-all" aria-hidden="true"></i>  Вернуться к списку оборудования</a></div>
                <div class="card-body">
                    <form action="{{ route('types.store') }}" method="POST" id="form_type" enctype="multipart/form-data">
                         <div class="list card-header  pt-5 pb-5">
                            <div class="row">
                                <div class="col-6 col-lg-6 form-group">
                                    @csrf
                                    {{-- Наименование --}}
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Наименование</h4>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="col-6 col-lg-6 form-group">
                                    {{-- Производитель --}}
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Производитель</h4>
                                    <input type="text" class="form-control" name="manufacturer" required>
                                </div>
                                <!--<div class="col-12 col-lg-6">
                                    <h4 class="card-title">Сокращение</h4>
                                    <input type="text" class="form-control" name="abbr_name_type">
                                     <small><i>Внимание! Данное поле участвует в формировании номера ленты. Если в номере ленты вместо краткого наименования используется другая аббревиатура, введите ее здесь</i> </small>
                                </div>-->  
                            </div>
                        </div>
                        <div class="list card-header  pt-5 pb-5 mt-5 mb-5">
                            <div class="row">
                                <div class="col-3 col-lg-3 form-group">
                                    {{-- Расч. срок службы --}}
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Расч. срок службы</h4>
                                    <input type="text" class="form-control" name="life_time" required>
                                </div>
                                <div class="col-12 col-lg-5 form-group">
                                    @csrf
                                    {{-- Характеристики --}}
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Характеристики</h4>
                                    <input type="text" class="form-control" name="description" required>
                                </div>
                                <div class="col-12 col-lg-4 form-group">
                                    {{-- Партийный номер --}}
                                    <h4 class="card-title">Партийный номер</h4>
                                    <input type="text" class="form-control" name="partial_number">
                                </div>
                            </div>
                        </div>
                        <div class="list card-header  pt-5 pb-5  mb-5">
                            <div class="row">
                                <div class="col-4 col-lg-3 form-group">
                                     {{-- Этапы оприсовки 1 --}}
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Этап оприсовки 1, МПа/Psi</h4>
                                     <input type="text" id="crimping_1" name="crimping_1" class="form-control">
                                </div>
                                <div class="col-12 col-md-3">
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Продолжительность, мин.</h4>
                                    <input type="text" name="period_1" class="form-control" >
                                </div>
                                <div class="col-4 col-lg-3 form-group">
                                     {{-- Этапы оприсовки 2 --}}
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Этап оприсовки 2, МПа/Psi</h4>
                                     <input type="text" id="crimping_2" name="crimping_2" class="form-control">
                                </div>
                                <div class="col-12 col-md-3">
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Продолжительность, мин.</h4>
                                    <input type="text" name="period_2" class="form-control" >
                                </div>
                                <div class="col-4 col-lg-3 form-group">
                                     {{-- Этапы оприсовки 3 --}}
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Этап оприсовки 3, МПа/Psi</h4>
                                     <input type="text" id="crimping_3" name="crimping_3" class="form-control">
                                </div>
                                <div class="col-12 col-md-3">
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Продолжительность, мин.</h4>
                                    <input type="text" name="period_3" class="form-control" >
                                </div>
                                <div class="col-4 col-lg-3 form-group">
                                     {{-- Этапы оприсовки 4 --}}
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Этап оприсовки 4, МПа/Psi</h4>
                                     <input type="text" id="crimping_4" name="crimping_4" class="form-control">
                                </div>
                                <div class="col-12 col-md-3">
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Продолжительность, мин.</h4>
                                    <input type="text" name="period_4" class="form-control" >
                                </div>
                                <div class="col-4 col-lg-3 form-group">
                                     {{-- Этапы оприсовки 5 --}}
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Этап оприсовки 5, МПа/Psi</h4>
                                     <input type="text"id="crimping_5"  name="crimping_5" class="form-control">
                                </div>
                                <div class="col-12 col-md-3">
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Продолжительность, мин.</h4>
                                    <input type="text" name="period_5" class="form-control">
                                </div>
                                <div class="col-4 col-lg-3 form-group">
                                     {{-- Этапы оприсовки 6 --}}
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Этап оприсовки 6, МПа/Psi</h4>
                                     <input type="text" id="crimping_6" name="crimping_6" class="form-control">
                                </div>
                                <div class="col-12 col-md-3">
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Продолжительность, мин.</h4>
                                    <input type="text" name="period_6" class="form-control">
                                </div>
                                <div class="col-12 col-lg-4 form-group">
                                     {{-- Рабочее давление --}}
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Рабочее давление, МПа/Psi</h4>
                                     <input type="text" id="pressure" name="pressure" class="form-control" required>
                                     <!--<p id="out"></p>-->
                                </div>
                                <div class="col-12 col-lg-2 form-group">
                                    <h4 class="card-title">&nbsp;</h4>                     
                                    <select id="measure" name="measure" class="form-control convert">
                                        <option value="МПа">МПа</option>
                                        <option value="Psi">Psi</option>
                                        <!--<option value="кг\см2">кг\см2</option>-->
                                    </select>
                                </div>
                                <!--<div class="col-md-2 mb-2">
                                    <h4 class="card-title">&nbsp;</h4>
                                    <button type="button" class="btn btn-success convert">Конвертировать давление</button>
                                </div>-->
                            </div>
                        </div>
                        <div class="list card-header  pt-5 pb-5 mt-5 mb-5">
                            <div class="row">
                                <div class="col-12  form-group">
                                    {{-- Минимально-допустимые размеры --}}
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Минимально-допустимые размеры</h4>
                                </div>
                                <div class="col-2 col-md-2">
                                    <label>Сечение 1</label>
                                    <input type="text" name="measure_1" class="form-control">
                                </div>
                                <div class="col-2 col-md-2">
                                    <label>Сечение 2</label>
                                    <input type="text" name="measure_2" class="form-control">
                                </div>
                                <div class="col-2 col-md-2">
                                    <label>Сечение 3</label>
                                    <input type="text" name="measure_3" class="form-control">
                                </div>
                                <div class="col-2 col-md-2">
                                    <label>Сечение 4</label>
                                    <input type="text" name="measure_4" class="form-control">
                                </div>
                                <div class="col-2 col-md-2">
                                    <label>Сечение 5</label>
                                    <input type="text" name="measure_5" class="form-control">
                                </div>
                                <div class="col-2 col-md-2">
                                    <label>Сечение 6</label>
                                    <input type="text" name="measure_6" class="form-control">
                                </div>
                                <div class="col-2 col-md-2">
                                    <label>Сечение 7</label>
                                    <input type="text" name="measure_7" class="form-control">
                                </div>
                                <div class="col-2 col-md-2">
                                    <label>Сечение 8</label>
                                    <input type="text" name="measure_8" class="form-control">
                                </div>
                                <div class="col-2 col-md-2">
                                    <label>Сечение 9</label>
                                    <input type="text" name="measure_9" class="form-control">
                                </div>
                                <div class="col-2 col-md-2">
                                    <label>Сечение 10</label>
                                    <input type="text" name="measure_10" class="form-control">
                                </div>
                            </div>
                        </div>
                        <!--<div class="list card-header  pt-5 pb-5  mb-5">
   
                        {{-- Время выдержки --}}
                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Время выдержки</h4>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label>Этап 1</label>
                                    <input type="text" name="act_1" class="form-control" required>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label>Продолжительность, мин.</label>
                                    <input type="text" name="period_1" class="form-control" required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label>Этап 2</label>
                                    <input type="text" name="act_2" class="form-control" required>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label>Продолжительность, мин.</label>
                                    <input type="text" name="period_2" class="form-control" required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label>Этап 3</label>
                                    <input type="text" name="act_3" class="form-control" required>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label>Продолжительность, мин.</label>
                                    <input type="text" name="period_3" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        </div>-->
                        <div class="list card-header  pt-5 pb-5 mb-5">
                             {{-- Температурный режим --}}
                            <div class="row">
                                <div class="col-12 form-group">
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Температурный режим</h4>
                                </div>
                                <div class="col-12 col-lg-4 form-group">
                                   <h4 class="card-title">От</h4>
                                    <input type="text" class="form-control" name="temperature_mode" placeholder="-40" required>
                                </div>
                                <div class="col-12 col-lg-4 form-group">
                                     <h4 class="card-title">До</h4>
                                    <input type="text" class="form-control" name="temperature_mode1" placeholder="+120"  required>
                                </div>
                                <!-- <div class="col-12 col-lg-4 form-group">
                                    {{-- Температура окружающей среды --}}
                                    <h4 class="card-title">Температура окружающей среды</h4>
                                    <input type="text" class="form-control"  name="temperature">
                                </div> -->
                                <div class="col-12 col-lg-4 form-group">
                                    {{-- Длина ленты --}}
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Длина ленты</h4>
                                    <input type="text" class="form-control" name="tape_length" required>
                                </div>
                            </div>
                        </div>
                        {{-- Изображения --}}
                        <div class="list card-header  pt-5 pb-5">
                            <div class="row">
                                <div class="col-12 col-md-12 item-uzt">
                                    <div class="list">
                                        <h4 class="card-title"><span style="color: #ff0000;">*</span>УЗТ</h4>
                                        <input type="file" class="form-control" id="uztImg" name="image_uzt" required>
                                        <div class="upload-image">
                                            <img src="" alt="">
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-12 col-md-12 item-mk">
                                    <div class="list">
                                        <h4 class="card-title"><span style="color: #ff0000;">*</span>МК</h4>
                                        <input type="file" class="form-control" id="mkImg" name="image_mk" required>
                                        <div class="upload-image">
                                            <img src="" alt="">
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-12 col-md-12 item-vik">
                                    <div class="list">
                                        <h4 class="card-title"><span style="color: #ff0000;">*</span>ВИК</h4>
                                        <input type="file" class="form-control" id="vikImg" name="image_vik" required>
                                        <div class="upload-image">
                                            <img src="" alt="">
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 item-uk">
                                    <div class="list">
                                        <h4 class="card-title"><span style="color: #ff0000;"></span>УЗК</h4>
                                        <input type="file" class="form-control" id="ukImg" name="image_uk">
                                        <div class="upload-image">
                                            <img src="" alt="">
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-12 col-md-12 item-diagram_crimping">
                                    <div class="list">
                                        <h4 class="card-title"><span style="color: #ff0000;"></span>Диаграмма оприсовки</h4>
                                        <input type="file" class="form-control" id="diagram_crimpingImg" name="image_diagram_crimping">
                                        <div class="upload-image">
                                            <img src="" alt="">
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-5">
                                <label>
                                    <input type="checkbox" name="is_non_typical_type" value="1"> Не типовое оборудование(Позволяет игноировать обязательные поля)
                                </label>
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col-md-2 offset-md-10 col-12 mb-5"> 
                                <button type="submit" class="btn btn-primary">Добавить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')

    <script>
        $(document).ready(function() {
            {{-- Не типовое оборудование --}}
            $('input[name="is_non_typical_type"]').click(function() {
                var obj = $(this);
                if(obj.is(':checked'))
                    $('#form_type input, #form_type select, #form_type textarea').removeAttr('required');
                else
                    $('#form_type input, #form_type select, #form_type textarea').attr('required', true);
            });

            {{-- подгрузка изображений --}}
            $("#uztImg").change(function(){
                readURLUzt(this);
            });

            function readURLUzt(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.item-uzt .upload-image img').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }


            $("#mkImg").change(function(){
                readURLMk(this);
            });
            function readURLMk(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.item-mk .upload-image img').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#vikImg").change(function(){
                readURLVikItem(this);
            });
            function readURLVikItem(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.item-vik .upload-image img').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#ukImg").change(function(){
                readURLUkItem(this);
            });
            function readURLUkItem(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.item-uk .upload-image img').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#diagram_crimpingImg").change(function(){
                readURLDiagCrimpItem(this);
            });
            function readURLDiagCrimpItem(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.item-diagram_crimping .upload-image img').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
        
        /*{{-- Конвертация давления --}}
            $('.convert').click(function() {
                var pressure = $('#pressure').val();
                if ($('#measure').val() === 'Psi'){
                    $('#out').val(pressure * 145);
                } else {
                    $('#out').val(pressure);
                }
                
            })*/
        })
    </script>
@endsection


@section('css')
    <style>
        .upload-image {
            height: 150px;
            text-align: center;
        }

        .upload-image img {
            height: 150px;
            border-radius: 4px;
        }
    </style>
@endsection