@extends('layouts.template')
@section('title', 'Редактирование')


@section('header')

@endsection


@section('content')

    <div class="row justify-content-center">
       <div class="col-md-10 col-12">
            <div class="card">
                <div class="card-header first"><h3>Изменить оборудование: {{ $type->name }}</h3><a class="card-header-link"  href="{{ route('types.index') }}"><i class="fa fa-mail-reply-all" aria-hidden="true"></i>  Вернуться к списку оборудования</a></div>
                <div class="card-body">
                    <form action="{{ route('types.update', ['id' => $type->id]) }}" method="POST" id="form_type" enctype="multipart/form-data">
                        <div class="list card-header  pt-5 pb-5">
                            <div class="row">
                                <div class="col-12 col-lg-6 form-group">
                                    @csrf
                                    @method('put')
                                    {{-- Наименование --}}
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Наименование</h4>
                                    <input type="text" class="form-control" name="name" value="{{ $type->name }}" required>
                                </div>
                                <div class="col-12 col-lg-6 form-group">
                                    {{-- Производитель --}}
                                     <h4 class="card-title"><span style="color: #ff0000;">*</span>Производитель</h4>
                                    <input type="text" class="form-control" name="manufacturer" value="{{ $type->manufacturer }}" required>
                                </div>
                                <!--<div class="col-12 col-lg-6 form-group">
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Сокращение</h4>
                                    <input type="text" class="form-control" name="abbr_name_type" value="{{ $type->abbr_name_type }}" >
                                    <small><i>Внимание! Данное поле участвует в формировании номера ленты. Если в номере ленты вместо краткого наименования используется другая аббревиатура, введите ее здесь</i> </small>
                                </div>-->
                            </div>
                        </div>
                        <div class="list card-header  pt-5 pb-5 mt-5 mb-5">
                            <div class="row">
                                <div class="col-3 col-lg-3 form-group">
                                    {{-- Расч. срок службы --}}
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Расч. срок службы</h4>
                                     <input type="text" class="form-control" name="life_time" value="{{ $type->life_time }}" required>
                                </div>
                                <div class="col-12 col-lg-5 form-group">
                                    {{-- Характеристики --}}
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Характеристики</h4>
                                    <input type="text" class="form-control" name="description" value="{{ $type->description }}" required>
                                </div>
                                <div class="col-12 col-lg-4 form-group">
                                    {{-- Партийный номер --}}
                                    <h4 class="card-title">Партийный номер</h4>
                                    <input type="text" class="form-control" name="partial_number" value="{{ $type->partial_number }}">
                                </div>
                            </div>
                        </div>
                        <div class="list card-header  pt-5 pb-5  mb-5">
                            <div class="row">
                                <div class="col-4 col-lg-3 form-group">
                                    {{-- Этапы оприсовки 1 --}}
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Этап оприсовки 1, МПа/Psi</h4>
                                    <input type="text" id="crimping_1" name="crimping_1" class="form-control" value="{{ $type->crimping_1 }}">
                                </div>
                                <div class="col-12 col-md-3">
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Продолжительность, мин.</h4>
                                    <input type="text" name="period_1" class="form-control" value="{{ $type->period_1 }}">
                                </div>
                                <div class="col-4 col-lg-3 form-group">
                                    {{-- Этапы оприсовки 2 --}}
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Этап оприсовки 2, МПа/Psi</h4>
                                    <input type="text" id="crimping_2" name="crimping_2" class="form-control" value="{{ $type->crimping_2 }}">
                                </div>
                                <div class="col-12 col-md-3">
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Продолжительность, мин.</h4>
                                    <input type="text" name="period_2" class="form-control" value="{{ $type->period_2 }}">
                                </div>
                                <div class="col-4 col-lg-3 form-group">
                                    {{-- Этапы оприсовки 3 --}}
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Этап оприсовки 3, МПа/Psi</h4>
                                    <input type="text" id="crimping_3" name="crimping_3" class="form-control" value="{{ $type->crimping_3 }}">
                                </div>
                                <div class="col-12 col-md-3">
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Продолжительность, мин.</h4>
                                    <input type="text" name="period_3" class="form-control" value="{{ $type->period_3 }}">
                                </div>
                                <div class="col-4 col-lg-3 form-group">
                                    {{-- Этапы оприсовки 4 --}}
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Этап оприсовки 4, МПа/Psi</h4>
                                    <input type="text" id="crimping_4" name="crimping_4" class="form-control" value="{{ $type->crimping_4 }}">
                                </div>
                                <div class="col-12 col-md-3">
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Продолжительность, мин.</h4>
                                    <input type="text" name="period_4" class="form-control" value="{{ $type->period_4 }}">
                                </div>
                                <div class="col-4 col-lg-3 form-group">
                                    {{-- Этапы оприсовки 5 --}}
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Этап оприсовки 5, МПа/Psi</h4>
                                    <input type="text" id="crimping_5" name="crimping_5" class="form-control" value="{{ $type->crimping_5 }}">
                                </div>
                                <div class="col-12 col-md-3">
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Продолжительность, мин.</h4>
                                    <input type="text" name="period_5" class="form-control" value="{{ $type->period_5 }}">
                                </div>
                                <div class="col-4 col-lg-3 form-group">
                                    {{-- Этапы оприсовки 6 --}}
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Этап оприсовки 6, МПа/Psi</h4>
                                    <input type="text" id="crimping_6" name="crimping_6" class="form-control" value="{{ $type->crimping_6 }}">
                                </div>
                                <div class="col-12 col-md-3">
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Продолжительность, мин.</h4>
                                    <input type="text" name="period_6" class="form-control" value="{{ $type->period_6 }}">
                                </div>
                                <div class="col-12 col-lg-4 form-group">
                                     {{-- Рабочее давление --}}
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Рабочее давление, МПа/Psi</h4>
                                    <input type="text" name="pressure" class="form-control" value="{{ $type->pressure }}" required>
                                </div>
                                {{-- Единица измерения --}}
                                <div class="col-12 col-lg-2 form-group">
                                    <h4 class="card-title">&nbsp;</h4>       
                                    <select name="measure"  class="form-control">
                                        <option value="{{ $type->measure }}">{{ $type->measure }}</option>
                                        <option value="МПа">МПа</option>
                                        <option value="Psi">Psi</option>
                                        <!--<option value="кг\см2">кг\см2</option>-->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="list card-header  pt-5 pb-5 mt-5 mb-5">
                            {{-- Минимально-допустимые размеры --}}
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Минимально-допустимые размеры</h4>
                                </div>
                                <div class="col-2 col-md-2">
                                    <label>Сечение 1</label>
                                    <input type="text" name="measure_1" class="form-control" value="{{ $type->measure_1 }}">
                                </div>
                                <div class="col-2 col-md-2">
                                    <label>Сечение 2</label>
                                    <input type="text" name="measure_2" class="form-control" value="{{ $type->measure_2 }}">
                                </div>
                                <div class="col-2 col-md-2">
                                    <label>Сечение 3</label>
                                    <input type="text" name="measure_3" class="form-control" value="{{ $type->measure_3 }}">
                                </div>
                                <div class="col-2 col-md-2">
                                    <label>Сечение 4</label>
                                    <input type="text" name="measure_4" class="form-control" value="{{ $type->measure_4 }}">
                                </div>
                                <div class="col-2 col-md-2">
                                    <label>Сечение 5</label>
                                    <input type="text" name="measure_5" class="form-control" value="{{ $type->measure_5 }}">
                                </div>
                                <div class="col-2 col-md-2">
                                    <label>Сечение 6</label>
                                    <input type="text" name="measure_6" class="form-control" value="{{ $type->measure_6 }}">
                                </div>
                                <div class="col-2 col-md-2">
                                    <label>Сечение 7</label>
                                    <input type="text" name="measure_7" class="form-control" value="{{ $type->measure_7 }}">
                                </div>
                                <div class="col-2 col-md-2">
                                    <label>Сечение 8</label>
                                    <input type="text" name="measure_8" class="form-control" value="{{ $type->measure_8 }}">
                                </div>
                                <div class="col-2 col-md-2">
                                    <label>Сечение 9</label>
                                    <input type="text" name="measure_9" class="form-control" value="{{ $type->measure_9 }}">
                                </div>
                                <div class="col-2 col-md-2">
                                    <label>Сечение 10</label>
                                    <input type="text" name="measure_10" class="form-control" value="{{ $type->measure_10 }}">
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
                                        <input type="text" name="act_1" class="form-control" value="{{ $type->act_1 }}" required>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label>Продолжительность, мин.</label>
                                        <input type="text" name="period_1" class="form-control" value="{{ $type->period_1 }}" required>
                                    </div>
    
                                    <div class="col-12 col-md-6">
                                        <label>Этап 2</label>
                                        <input type="text" name="act_2" class="form-control" value="{{ $type->act_2 }}" required>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label>Продолжительность, мин.</label>
                                        <input type="text" name="period_2" class="form-control" value="{{ $type->period_2 }}" required>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label>Этап 3</label>
                                        <input type="text" name="act_3" class="form-control" value="{{ $type->act_3 }}" required>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label>Продолжительность, мин.</label>
                                        <input type="text" name="period_3" class="form-control" value="{{ $type->period_3 }}" required>
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
                                    <input type="text" class="form-control" name="temperature_mode" value="{{ $type->temperature_mode }}" required>
                                 </div>
                                <div class="col-12 col-lg-4 form-group">
                                    <h4 class="card-title">До</h4>
                                    <input type="text" class="form-control" name="temperature_mode1" value="{{ $type->temperature_mode1 }}" required>
                                 </div>
                                 <!-- <div class="col-12 col-lg-4 form-group">
                                    {{-- Температура окружающей среды --}}
                                    <h4 class="card-title">Температура окружающей среды</h4>
                                    <input type="text" class="form-control" value="{{ $type->temperature }}" name="temperature">
                                </div> -->
                                 <div class="col-12 col-lg-4 form-group">
                                   {{-- Длина ленты --}}
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Длина ленты</h4>
                                    <input type="text" class="form-control" name="tape_length" value="{{ $type->tape_length }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="list card-header  pt-5 pb-5 mb-5">
                            {{-- Изображения --}}
                            <div class="row">
                                <div class="col-12 col-md-12 item-uzt">
                                    <div class="list">
                                        <h4 class="card-title"><span style="color: #ff0000;">*</span>УЗТ</h4>
                                        <input type="file" class="form-control @if($errors->has('image_uzt')) is-invalid @endif" id="uztImg" name="image_uzt" value="{{ old('image_uzt') }}">
                                        <button type="button" class="btn btn-danger delete-img" id="deleteImgUzt" data-type_img="uzt" data-type_id="{{ $type->id }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                          <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                          <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg> Удалить</button>
                                        <div class="col-12 col-md-12 msg-uzt mt-2"></div>
                                        <div class="upload-image image-uzt">
                                            <img src="{{ asset('types_data/'.$type->id.'/uzt.jpg') }}" alt="">
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-12 col-md-12 item-mk">
                                    <div class="list">
                                        <h4 class="card-title"><span style="color: #ff0000;">*</span>МК</h4>
                                        <input type="file" class="form-control @if($errors->has('image_mk')) is-invalid @endif" id="mkImg" name="image_mk" value="{{ old('image_mk') }}">
                                        <button type="button" class="btn btn-danger delete-img" id="deleteImgMk" data-type_img="mk" data-type_id="{{ $type->id }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                          <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                          <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg> Удалить</button>
                                        <div class="col-12 col-md-12 msg-mk mt-2"></div>
                                        <div class="upload-image image-mk">
                                            <img src="{{ asset('types_data/'.$type->id.'/mk.jpg') }}" alt="">
                                        </div>
                                    </div>
                                <hr>
                            </div>
                                <div class="col-12 col-md-12 item-vik">
                                    <div class="list">
                                        <h4 class="card-title"><span style="color: #ff0000;">*</span>ВИК</h4>
                                        <input type="file" class="form-control @if($errors->has('image_vik')) is-invalid @endif" id="vikImg" name="image_vik" value="{{ old('image_vik') }}">
                                        <button type="button" class="btn btn-danger delete-img" id="deleteImgVik" data-type_img="vik" data-type_id="{{ $type->id }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                          <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                          <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg> Удалить</button>
                                        <div class="col-12 col-md-12 msg-vik mt-2"></div>
                                        <div class="upload-image image-vik">
                                            <img src="{{ asset('types_data/'.$type->id.'/vik.jpg') }}" alt="">
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-12 col-md-12 item-uk">
                                    <div class="list">
                                        <h4 class="card-title"><span style="color: #ff0000;"></span>УЗК</h4>
                                        <input type="file" class="form-control @if($errors->has('image_uk')) is-invalid @endif" id="ukImg" name="image_uk" value="{{ old('image_uk') }}">
                                        <button type="button" class="btn btn-danger delete-img" id="deleteImgUzk" data-type_img="uzk" data-type_id="{{ $type->id }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                          <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                          <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg> Удалить</button>
                                        <div class="col-12 col-md-12 msg-uzk mt-2"></div>
                                        <div class="upload-image image-uzk">
                                            <img src="{{ asset('types_data/'.$type->id.'/uk.jpg') }}" alt="">
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-12 col-md-12 item-diagram_crimping">
                                    <div class="list">
                                        <h4 class="card-title"><span style="color: #ff0000;"></span>Диаграмма оприсовки</h4>
                                        <input type="file" class="form-control @if($errors->has('image_diagram_crimping')) is-invalid @endif" id="diagram_crimpingImg" name="image_diagram_crimping" value="{{ old('image_diagram_crimping') }}">
                                        <button type="button" class="btn btn-danger delete-img" id="deleteImgDiagramm" data-type_img="diagram_crimping" data-type_id="{{ $type->id }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                          <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                          <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg> Удалить</button>
                                        <div class="col-12 col-md-12 msg-diagram_crimping mt-2"></div>
                                        <div class="upload-image image-diagram_crimping">
                                            <img src="{{ asset('types_data/'.$type->id.'/diagram_crimping.jpg') }}" alt="">
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12  ">
                                <label>
                                    <input type="checkbox" name="is_non_typical_type" value="1" @if($type->is_non_typical_type == '1') checked @endif> Не типовое оборудование(Позволяет игноировать обязательные поля)
                                </label>
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col-md-2 offset-md-10 col-12 mb-5"> 
                                <button type="submit" class="btn btn-primary">Сохранить</button>
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
            if($('input[name="is_non_typical_type"]').is(':checked'))
                $('#form_type input, #form_type select, #form_type textarea').removeAttr('required');
            else
               // $('#form_type input, #form_type select, #form_type textarea').attr('required', true);

            {{-- Не типовое оборудование --}}
            $('input[name="is_non_typical_type"]').click(function() {
                var obj = $(this);

                if(obj.is(':checked'))
                    $('#form_type input, #form_type select, #form_type textarea').removeAttr('required');
                else {
                    $('#form_type input, #form_type select, #form_type textarea').attr('required', true);
                    $('#uztImg, #mkImg, #vikImg, input[name="is_non_typical_type"]').removeAttr('required');
                }
            });
            {{-- Подгрузка изображений --}}
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
            
            // Удаление картинки
            function deleteImgType(obj)
            {
                var res;
                var token = $('input[name="_token"]').val();
                var type_img = obj.data("type_img");
                var type_id = obj.data("type_id");
                // console.log(type_img);
                $.post('{{ route('types.deleteImgType') }}', {'_token': token, 'type_img': type_img, 'type_id': type_id}, function(response){
                    if(response.result === true) {
                        $('.image-'+type_img).hide();
                        $('.msg-'+type_img).html('<div class="alert alert-success alert-dismissible fade show" role="alert">'+response.msg+'</div>');
                        // location.reload();
                        setTimeout(function() {
                            $('.msg-'+type_img).fadeOut();
                        }, 5000)
                    } else {
                        $('.msg-'+type_img).html('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+response.msg+'</div>');
                        setTimeout(function() {
                            $('.msg-'+type_img).fadeOut();
                        }, 5000)
                    }
                });
            }
            $('#deleteImgUzt').click(function() {
                let obj = $(this);
                if(confirm('Подтвердите удаление эскиза')){
                    deleteImgType(obj);
                }
            });
            $('#deleteImgMk').click(function() {
                let obj = $(this);
                if(confirm('Подтвердите удаление эскиза')){
                    deleteImgType(obj);
                }
            });
            $('#deleteImgVik').click(function() {
                let obj = $(this);
                if(confirm('Подтвердите удаление эскиза')){
                    deleteImgType(obj);
                }
            });
            $('#deleteImgUzk').click(function() {
                let obj = $(this);
                if(confirm('Подтвердите удаление эскиза')){
                    deleteImgType(obj);
                }
            });
            $('#deleteImgDiagramm').click(function() {
                let obj = $(this);
                if(confirm('Подтвердите удаление диаграммы')){
                    deleteImgType(obj);
                }
            });
        });
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