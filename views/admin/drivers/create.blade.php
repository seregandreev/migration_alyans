@extends('layouts.template')
@section('title', 'Новый водитель')


@section('header')
    <h4>
        <a href="{{ route('drivers.index') }}">Список водителей</a> / Новый водитель
    </h4>
@endsection


@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Заполните информацию по новому водителю</div>
                <div class="card-body">
                    <form action="{{ route('drivers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Табельный номер</h4>
                            <input type="text" class="form-control" name="pers_number" required>
                        </div>
                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Ф.И.О.</h4>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <hr>
                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>№ удостоверения</h4>
                            <input type="text" class="form-control" name="num_vu" required>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Категория ВУ</h4>
                                <select name="class_vu" class="form-control">
                                        <option value="B">B</option>
                                        <option value="B,C">B,C</option>
                                        <option value="A,B,C,D">A,B,C,D</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Срок действия удостоверения</h4>
                                <input type="date" class="form-control" name="vu_validity" required>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Номер телефона</h4>
                                <input type="text" class="form-control" name="phone" required>
                            </div>
                            <div class="col-6">
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Дата рождения</h4>
                                <input type="date" class="form-control" name="birth_day" required>
                            </div>
                        </div>
                        <hr>
                        <div class="list card-header  pt-5 pb-5  mb-5">
                        <div class="row"> 
                            <div class="col-md-12 col-12"> 
                            {{-- скан документа --}}
                             <h4 class="card-title">Скан ВУ(PDF)</h4>
                                <input type="file" class="form-control" name="scan_document">
                             <div class="col-12 col-md-6" id="scan_document" style="height: 40px;">
                                    <!--<img src="" alt="">-->
                            </div>
                            </div> 
                        </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('javascript')
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