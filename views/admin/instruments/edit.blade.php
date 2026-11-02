@extends('layouts.template')
@section('title', 'Редактирование инструмента')

@section('header')

@endsection

@section('content')

    <div class="row justify-content-center">
         <div class="col-md-10 col-12">
            <div class="card">
                <div class="card-header first"><h3>Изменение информации инструмента</h3><a class="card-header-link"  href="{{ route('instruments.index') }}"><i class="fa fa-mail-reply-all" aria-hidden="true"></i>  Вернуться к списку инструментов</a></div>
                <div class="card-body">
                    <form action="{{ route('instruments.update', ['id' => $instrument->id]) }}" method="POST" enctype="multipart/form-data">
                        <div class="list card-header  pt-5 pb-5">
                            <div class="row"> 
                                <div class="col-md-6 col-12">
                                    @csrf
                                    @method('put')
                                    {{-- Название --}}
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Наименование прибора</h4>
                                    <input type="text" class="form-control" value="{{ $instrument->name }}" name="name" required>
                                </div>
                                <div class="col-md-6 col-12">    
                                    {{-- Модель --}}
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Модель</h4>
                                    <input type="text" class="form-control " value="{{ $instrument->model }}" name="model" required>
                                </div>
                            </div>
                        </div>
                        <div class="list card-header  pt-5 pb-5 mt-5 mb-5">
                    <div class="row">
                    <div class="col-md-6 col-12">
                                    {{-- Назначение --}}
                                     <h4 class="card-title"><span style="color: #ff0000;">*</span>Назначение</h4>
                                     <textarea class="form-control" name="purpose">{{ $instrument->purpose }}</textarea>
                                </div>
                    <div class="col-md-6 col-12">
                                {{-- Метод контроля --}}
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Метод проведения контроля</h4>
                                    <select name="control_method" class="form-control">
                                        <option value="УЗТ" @if($instrument->control_method == 'УЗТ') selected @endif>УЗТ</option>
                                        <option value="ВИК" @if($instrument->control_method == 'ВИК') selected @endif>ВИК</option>
                                        <option value="МК" @if($instrument->control_method == 'МК') selected @endif>МК</option>
                                        <option value="ГИ" @if($instrument->control_method == 'ГИ') selected @endif>ГИ</option>
                                        <option value="УЗК" @if($instrument->control_method == 'УЗК') selected @endif>УЗК</option>
                                        <option value="ПВК" @if($instrument->control_method == 'ПВК') selected @endif>ПВК</option>
                                    </select>
                                </div>
                        </div>
                    </div>
                        <div class="list card-header  pt-5 pb-5 mt-5 mb-5">
                            <div class="row"> 
                                <div class="col-md-6 col-12">
                                    {{-- Серийный номер --}}
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Заводской номер</h4>
                                    <input type="text" class="form-control" name="serial_number" value="{{ $instrument->serial_number }}" required>
                                </div>
                                <!--<div class="col-md-6 col-12">
                                    {{-- Описание --}}
                                     <h4 class="card-title">Описание</h4>
                                    <textarea class="form-control" name="serial_number">{{ $instrument->serial_number }}</textarea>
                                </div>-->
                            <div class="col-md-6 col-12">    
                                {{-- Инвентарный номер номер --}}
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Инвентарный номер номер</h4>
                                <input type="text" class="form-control " value="{{ $instrument->inventory_number }}" name="inventory_number" required>
                            </div>
                            </div>
                        </div>
                        <div class="list card-header  pt-5 pb-5 mt-5 mb-5">
                            <div class="row"> 
                            <div class="col-md-6 col-12">
                                 {{-- Предел измерений --}}
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Предел измерений</h4>
                                <input type="text" class="form-control" name="meter_limit" value="{{ $instrument->meter_limit }}">
                            </div>
                                <div class="col-md-6 col-12">
                                    {{-- Номер свидетельства о поверки --}}
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Номер свидетельства о поверки</h4>
                                    <input type="text" class="form-control" name="sertificate_number" value="{{ $instrument->sertificate_number }}" >
                                </div>
                            </div>
                        </div>
                        <div class="list card-header  pt-5 pb-5 mt-5 mb-5">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                 {{-- Поверитель --}}
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Организация поверитель</h4>
                                <input type="text" class="form-control" name="verifier" value="{{ $instrument->verifier }}" required>
                            </div>
                        </div>
                    </div>
                        <div class="list card-header  pt-5 pb-5 mt-5 mb-5">
                            <div class="row"> 
                                <div class="col-md-6 col-12">
                                     {{-- Дата поверки --}}
                                    <h4 class="card-title">Дата поверки</h4>
                                    <input type="date" class="form-control" name="verification_date" value="{{ $instrument->verification_date }}" >
                                </div>
                                <div class="col-12 col-lg-6">
                                    {{-- Дата сдедующей поверки --}}
                                     <h4 class="card-title">Дата следующей поверки</h4>
                                    <input type="date" class="form-control" name="next_verification_date" value="{{ $instrument->next_verification_date }}" >
                                </div>
                            </div>
                        </div>
                        <div class="list card-header  pt-5 pb-5  mb-5">
                            <div class="row"> 
                                <div class="col-md-6 col-6">
                                    {{-- Скан паспорта прибора --}}
                                    <div class="col-md-12 col-12">
                                        <h4 class="card-title">Скан паспорта прибора</h4>
                                        <input type="file" class="form-control" name="scan_instrument">
                                    </div>
                                    @if(isset($instrument->scan_passport) && file_exists(public_path($instrument->scan_passport)))
                                    <div class="col-12 col-md-12" id="scan_instrument" style="height: 40px;">
                                        <a href="{{ asset($instrument->scan_passport) }}" target="_blank">Скан паспорта прибора</a>
                                        <!--<img src="{{ asset($instrument->scan_passport) }}" alt="">-->
                                    </div>
                                    @endif
                                </div>

                                <div class="col-md-6 col-6">
                                    {{-- Скан свидетельства о поверки --}}
                                    <div class="col-md-12 col-12">
                                        <h4 class="card-title">Скан свидетельства о поверки</h4>
                                        <input type="file" class="form-control" name="scan_sertificate">
                                    </div>
                                    @if(isset($instrument->scan_sertificate) && file_exists(public_path($instrument->scan_sertificate)))
                                    <div class="col-12 col-md-12" id="scan_sertificate" style="height: 40px;">
                                        <a href="{{ asset($instrument->scan_sertificate) }}" target="_blank">Скан свидетельства о поверки</a>
                                        <!--<img src="{{ asset($instrument->scan_sertificate) }}" alt="">-->
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 instrument_create">
                                <!--<label>Эксплуатация инструмента</label>-->
                                <label>
                                    <input type="checkbox" name="yes_instrument" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" @if($instrument->yes_instrument == 1) checked @endif> Инструмент применяется
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
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script>
        $('input[name="scan_instrument"]').change(function() {
            readPhotoImg(this);
        });

        function readPhotoImg(input) {
            if(input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#scan_instrument img').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $('input[name="scan_sertificate"]').change(function() {
            readPhotoImg(this);
        });

        function readPhotoImg(input) {
            if(input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#scan_sertificate img').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css">
    <style>
        #scan_instrument img {
            height: 65px;
            position: relative;
            top: -20px;
            border-radius: 5px;
        }
        #scan_sertificate img {
            height: 65px;
            position: relative;
            top: -20px;
            border-radius: 5px;
        }
        .instrument_create label {
            display: block;
        }
    </style>
@endsection