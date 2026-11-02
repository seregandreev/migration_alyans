@extends('layouts.template')
@section('title', 'Редактирование сотрудника')

@section('header')
    <h4>
        <a href="{{ route('inspectors.index') }}">Список сотрудников</a> / Редактирование
    </h4>
@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Изменение информации</div>
                <div class="card-body">
                    <form action="{{ route('inspectors.update', ['id' => $inspector->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <input type="hidden" name="inspectorId" value="{{$inspector->id}}">
                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Ф.И.О.</h4>
                            <input type="text" class="form-control" name="name" value="{{ $inspector->name }}" required>
                        </div>
                        <hr>

                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Должность</h4>
                            <input type="text" class="form-control" name="position" value="{{ $inspector->position }}" required>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-6">
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Уровень квалификации</h4>
                                <input type="text" class="form-control" name="level" value="{{ $inspector->level }}" required>
                            </div>
                            <div class="col-6">
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Метод контроля</h4>
                                <input type="text" class="form-control" name="control_method" value="{{ $inspector->control_method }}" required>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-6">
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>№ удостоверения</h4>
                                <input type="text" class="form-control" name="num_document" value="{{ $inspector->num_document }}" required>
                            </div>
                            <div class="col-6">
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Срок действия удостоверения</h4>
                                <input type="date" class="form-control" name="document_validity" value="{{ $inspector->document_validity }}" required>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-6">
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Номер телефона</h4>
                                <input type="text" class="form-control" name="phone" value="{{ $inspector->phone }}" required>
                            </div>
                            <div class="col-6">
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Дата рождения</h4>
                                <input type="date" class="form-control" name="birth_day" value="{{ $inspector->birth_day }}" required>
                            </div>
                        </div>
                        <hr>
                        <!--<div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Документ</h4>
                            <input type="text" class="form-control" name="document" value="{{ $inspector->document }}" required>
                        </div>-->
                        <div class="list card-header  pt-5 pb-5  mb-5">
                            <div class="row"> 
                                <div class="col-md-12 col-12">
                                    {{-- Скан удостоверения инспектора --}}
                                    <div class="col-md-12 col-12">
                                        <h4 class="card-title">Скан удостоверения инспектора(.pdf)</h4>
                                        <input type="file" class="form-control" name="scan_document">
                                    </div>
                                    @if(file_exists(public_path('inspectors_data/'.$inspector->id.'/scan_document.pdf')))
                                    <div class="col-12 col-md-12" id="scan_document" style="height: 40px;">
                                    <a href="{{ asset('inspectors_data/'.$inspector->id.'/scan_document.pdf') }}" target="_blank">Скан удостоверения инспектора</a>
                                        <!--<img src="{{ asset('inspectors_data/'.$inspector->id.'/scan_document.pdf') }}" alt="">-->
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-md-12 col-12">
                                    {{-- Факсимиле специалиста --}}
                                    <div class="col-md-12 col-12">
                                        <h4 class="card-title">Факсимиле специалиста(.png)</h4>
                                        <input type="file" class="form-control" name="signInspector">
                                    </div>
                                    @if(file_exists(public_path('inspectors_data/'.$inspector->id.'/signInspector.png')))
                                    <div class="col-12 col-md-12" id="signInspector" style="height: 40px;">
                                        <a href="{{ asset('inspectors_data/'.$inspector->id.'/signInspector.png') }}" target="_blank">Факсимиле специалиста</a>
                                        <br><br>
                                        <img src="{{ asset('inspectors_data/'.$inspector->id.'/signInspector.png') }}" alt="">
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script>
        $('input[name="scan_document"]').change(function() {
            readPhotoImg(this);
        });

        function readPhotoImg(input) {
            if(input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#scan_document img').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('input[name="signInspector"]').change(function() {
            readPhotoImg(this);
        });

        function readSignImg(input) {
            if(input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#signInspector img').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        
    </script>
@endsection

@section('css')
    <style>
        #signInspector img {
            height: 65px;
            position: relative;
            top: -20px;
            border-radius: 5px;
        }
    </style>
@endsection