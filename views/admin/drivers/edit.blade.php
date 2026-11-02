@extends('layouts.template')
@section('title', 'Редактирование водителя')

@section('header')
    <h4>
        <a href="{{ route('drivers.index') }}">Список водителей</a> / Редактирование
    </h4>
@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Изменение информации</div>
                <div class="card-body">
                    <form action="{{ route('drivers.update', ['id' => $driver->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Табельный номер</h4>
                            <input type="text" class="form-control" name="pers_number" value="{{ $driver->pers_number }}" required>
                        </div>
                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Ф.И.О.</h4>
                            <input type="text" class="form-control" name="name" value="{{ $driver->name }}" required>
                        </div>
                        <hr>
                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>№ удостоверения</h4>
                            <input type="text" class="form-control" name="num_vu" value="{{ $driver->num_vu }}" required>
                        </div>
                        <hr>
                        
                        <div class="row">
                            <div class="col-6">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Категория ВУ</h4>
                                <select name="class_vu" class="form-control">
                                        <option value="B" @if($driver->class_vu == 'B') selected @endif>B</option>
                                        <option value="B,C" @if($driver->class_vu == 'B,C') selected @endif>B,C</option>
                                        <option value="A,B,C,D" @if($driver->class_vu == 'A,B,C,D') selected @endif>A,B,C,D</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Срок действия удостоверения</h4>
                                <input type="text" class="form-control" name="vu_validity" value="{{ $driver->vu_validity }}" required>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-6">
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Номер телефона</h4>
                                <input type="text" class="form-control" name="phone" value="{{ $driver->phone }}" required>
                            </div>
                            <div class="col-6">
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Дата рождения</h4>
                                <input type="date" class="form-control" name="birth_day" value="{{ $driver->birth_day }}" required>
                            </div>
                        </div>
                        <hr>

                        <div class="list card-header  pt-5 pb-5  mb-5">
                            <div class="row"> 
                                <div class="col-md-12 col-12">
                                    {{-- Скан удостоверения --}}
                                    <div class="col-md-12 col-12">
                                        <h4 class="card-title">Скан удостоверения(PDF)</h4>
                                        <input type="file" class="form-control" name="scan_document">
                                    </div>
                                    @if(file_exists(public_path('drivers_data/'.$driver->id.'/scan_document.pdf')))
                                    <div class="col-12 col-md-12" id="scan_document" style="height: 40px;">
                                    <a href="{{ asset('drivers_data/'.$driver->id.'/scan_document.pdf') }}" target="_blank">Скан удостоверения</a>
                                        <img src="{{ asset('drivers_data/'.$driver->id.'/scan_document.pdf') }}" alt="">
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
    </script>
@endsection

@section('css')
    <style>
        #scan_document img {
            height: 65px;
            position: relative;
            top: -20px;
            border-radius: 5px;
        }
    </style>
@endsection