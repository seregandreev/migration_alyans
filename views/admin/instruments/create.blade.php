@extends('layouts.template')
@section('title', 'Новый инструмент')

@section('header')

@endsection

@section('content')

    <div class="row justify-content-center">
         <div class="col-md-10 col-12">
            <div class="card">
                <div class="card-header first"><h3>Заполните информацию по новому инструменту</h3> <a class="card-header-link" href="{{ route('instruments.index') }}"><i class="fa fa-mail-reply-all" aria-hidden="true"></i>  Вернуться к списку инструментов</a> </div>
                <div class="card-body">
                    <form action="{{ route('instruments.store') }}" method="POST" enctype="multipart/form-data">
                      <div class="list card-header  pt-5 pb-5">
                        <div class="row"> 
                            <div class="col-md-6 col-12">
                                @csrf
                                {{-- Название --}}
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Наименование прибора</h4>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="col-md-6 col-12">    
                                {{-- Модель --}}
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Модель</h4>
                                <input type="text" class="form-control " name="model" required>
                            </div>
                        </div>
                    </div>

                    <div class="list card-header  pt-5 pb-5 mt-5 mb-5">
                    <div class="row">
                        <div class="col-md-6 col-12"> 
                                    {{-- Назначение --}}
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Назначение</h4>
                                    <textarea class="form-control" name="purpose"></textarea>
                                </div>
                                <div class="col-md-6 col-12">
                                    {{-- Метод контроля --}}
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Тип прибора</h4>
                                <select name="control_method" class="form-control">
                                        <option value="УЗТ">УЗТ</option>
                                        <option value="ВИК">ВИК</option>
                                        <option value="МК">МК</option>
                                        <option value="ГИ">ГИ</option>
                                        <option value="УЗК">УЗК</option>
                                        <option value="ПВК">ПВК</option>
                                </select>
                            </div>
                    </div>
                    </div>  
                    <div class="list card-header  pt-5 pb-5 mt-5 mb-5">
                        <div class="row"> 
                            <div class="col-md-6 col-12">    
                                {{-- Серийный номер --}}
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Заводской номер</h4>
                                <input type="text" class="form-control " name="serial_number" required>
                            </div>
                            <!--<div class="col-md-6 col-12"> 
                                {{-- Описание --}}
                                <h4 class="card-title">Описание</h4>
                                <textarea class="form-control" name=""></textarea>
                            </div>-->
                            <div class="col-md-6 col-12">    
                                {{-- Инвентарный номер номер --}}
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Инвентарный номер номер</h4>
                                <input type="text" class="form-control " name="inventory_number" required>
                            </div>
                        </div>
                    </div>
                    <div class="list card-header  pt-5 pb-5 mt-5 mb-5">
                        <div class="row"> 
                        <div class="col-md-6 col-12">
                                 {{-- Предел измерений --}}
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Предел измерений</h4>
                                <input type="text" class="form-control" name="meter_limit" value="0" required>
                            </div>
                            <div class="col-md-6 col-12">
                                 {{-- Номер свидетельства о поверки --}}
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Номер свидетельства о поверки</h4>
                                <input type="text" class="form-control" name="sertificate_number" required>
                            </div>
                        </div>
                    </div>
                    <div class="list card-header  pt-5 pb-5 mt-5 mb-5">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                 {{-- Поверитель --}}
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Организация поверитель</h4>
                                <input type="text" class="form-control" name="verifier" required>
                            </div>
                        </div>
                    </div>
                     <div class="list card-header  pt-5 pb-5 mt-5 mb-5">
                        <div class="row"> 
                            <div class="col-md-6 col-12"> 
                                 {{-- Дата поверки --}}
                                  <h4 class="card-title">Дата поверки</h4>
                                  <input type="date" class="form-control" name="verification_date" >
                           </div>
                           <div class="col-md-6 col-12">
                                {{-- Дата следующей поверки --}}
                               <h4 class="card-title">Дата следующей поверки</h4>
                                <input type="date" class="form-control" name="next_verification_date">
                            </div>
                        </div>
                    </div>
                <div class="list card-header  pt-5 pb-5  mb-5">
                        <div class="row"> 
                            <div class="col-md-6 col-12"> 
                            {{-- Фото инструмента --}}
                             <h4 class="card-title">Скан паспорта прибора</h4>
                                <input type="file" class="form-control" name="scan_instrument">
                             <div class="col-12 col-md-4" id="scan_instrument" style="height: 40px;">
                                    <a href=""></a>
                            </div>
                            </div> 
                            <div class="col-md-6 col-12"> 
                            {{-- Фото свидетельства --}}
                             <h4 class="card-title">Скан свидетельства о поверки</h4>
                                <input type="file" class="form-control" name="scan_sertificate">
                             <div class="col-12 col-md-4" id="scan_sertificate" style="height: 40px;">
                                    <!--<img src="" alt="">-->
                                    <a href=""></a>
                            </div>
                            </div> 
                        </div>

                </div>
                <div class="row">
                            <div class="col-6 instrument_create">
                                <!--<label>Эксплуатация инструмента</label>-->
                                <label>
                                    <input type="checkbox" name="yes_instrument" value="1" data-toggle="toggle" data-onstyle="success" data-offstyle="danger"> Инструмент применяется
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
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script>
        $('input[name="scan_instrument"]').change(function() {
            readPhotoImg(this);
        });

        function readPhotoImg(input) {
            if(input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#scan_instrument a').attr('href', e.target.result);
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
                    $('#scan_sertificate a').attr('href', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css">
    <style>
        #scan_instrument a {
            height: 65px;
            position: relative;
            top: -20px;
            border-radius: 5px;
        }
        #scan_sertificate a {
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