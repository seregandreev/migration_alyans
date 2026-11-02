@extends('layouts.template')
@section('title', 'Новый транспорт')

@section('header')

@endsection

@section('content')

    <div class="row justify-content-center">
         <div class="col-md-10 col-12">
            <div class="card">
                <div class="card-header first"><h3>Заполните информацию по новому транспорту</h3> <a class="card-header-link" href="{{ route('transports.index') }}"><i class="fa fa-mail-reply-all" aria-hidden="true"></i>  Вернуться к списку инструментов</a> </div>
                <div class="card-body">
                    <form action="{{ route('transports.store') }}" method="POST" enctype="multipart/form-data">
                      <div class="list card-header  pt-5 pb-5">
                        <div class="row"> 
                            <div class="col-md-12 col-12">
                                @csrf
                                {{-- Название --}}
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Наименование транспорта</h4>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4 col-12">    
                                {{-- тип авто --}}
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Тип авто</h4>
                                <select name="type_avto" class="form-control">
                                        <option value="Легковой">Легковой</option>
                                        <option value="Грузовой">Грузовой</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-12"> 
                                {{-- Гос. номер --}}
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Гос. номер</h4>
                                <input type="text" class="form-control" name="gos_num" required>
                            </div>
                            <div class="col-md-4 col-12"> 
                                {{-- Пробег --}}
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Пробег</h4>
                                <input type="text" class="form-control" name="mileage" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                             <div class="col-md-4 col-12"> 
                                {{-- Год выпуска --}}
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Год выпуска</h4>
                                <input type="text" class="form-control" name="make_year" required>
                            </div>
                            <div class="col-md-4 col-12"> 
                                {{-- Гаражный номер --}}
                                <h4 class="card-title">Гаражный номер</h4>
                                <input type="text" class="form-control" name="garage_number" required>
                            </div>
                            <div class="col-md-4 col-12">    
                                {{-- тип топлива --}}
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Тип топлива</h4>
                                <select name="type_sulder" class="form-control">
                                        <option value="АИ-92">АИ-92</option>
                                        <option value="АИ-95">АИ-95</option>
                                        <option value="АИ-95+">АИ-95+</option>
                                        <option value="АИ-98">АИ-98</option>
                                        <option value="АИ-100">АИ-100</option>
                                        <option value="Газ">Газ</option>
                                        <option value="ДТ">ДТ</option>
                                </select>
                            </div>
                       </div>
                    </div>  
                    <div class="list card-header  pt-5 pb-5 mt-5 mb-5">
                        <div class="row"> 
                            <div class="col-md-4 col-12">    
                                {{-- VIN номер --}}
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>VIN номер</h4>
                                <input type="text" class="form-control " name="vin_num" required>
                            </div>
                            <div class="col-md-4 col-12">    
                                {{-- Номер СТС --}}
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Номер СТС</h4>
                                <input type="text" class="form-control " name="num_sts" required>
                            </div>
                            <div class="col-md-4 col-12">    
                                {{-- Номер ПТС --}}
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Номер ПТС</h4>
                                <input type="text" class="form-control " name="num_pts" required>
                            </div>
                        </div>
                    </div>
                     <div class="list card-header  pt-5 pb-5 mt-5 mb-5">
                        <div class="row"> 
                            <div class="col-md-4 col-12"> 
                                 {{-- Дата тех. обслуживания --}}
                                  <h4 class="card-title">Дата тех. обслуживания</h4>
                                  <input type="date" class="form-control" name="date_service" >
                           </div>
                           <div class="col-md-4 col-12">
                                {{-- Дата тех. осмотра --}}
                               <h4 class="card-title">Дата тех. осмотра</h4>
                                <input type="date" class="form-control" name="date_inspection">
                            </div>
                            <div class="col-md-4 col-12">
                                {{-- Дата страховки --}}
                               <h4 class="card-title">Дата страховки</h4>
                                <input type="date" class="form-control" name="date_insurance">
                            </div>
                        </div>
                    </div>
                <div class="list card-header  pt-5 pb-5  mb-5">
                        <div class="row"> 
                            <div class="col-md-6 col-12"> 
                            {{-- Тех. осмотр  --}}
                             <h4 class="card-title">Скан тех. осмотра(PDF)</h4>
                                <input type="file" class="form-control" name="scan_inspection">
                             <div class="col-12 col-md-4" id="scan_inspection" style="height: 40px;">
                                    <img src="" alt="">
                            </div>
                            </div> 
                            <div class="col-md-6 col-12"> 
                            {{-- Фото страховки --}}
                             <h4 class="card-title">Скан страховки(PDF)</h4>
                                <input type="file" class="form-control" name="scan_insurance">
                             <div class="col-12 col-md-4" id="scan_insurance" style="height: 40px;">
                                    <img src="" alt="">
                            </div>
                            </div> 
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


@section('javascript')
    <script>
        $('input[name="scan_inspection"]').change(function() {
            readPhotoImg(this);
        });

        function readPhotoImg(input) {
            if(input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#scan_inspection img').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection

@section('css')
    <style>
        #scan_inspection img {
            height: 65px;
            position: relative;
            top: -20px;
            border-radius: 5px;
        }
    </style>
@endsection

@section('javascript')
    <script>
        $('input[name="scan_insurance"]').change(function() {
            readPhotoImg(this);
        });

        function readPhotoImg(input) {
            if(input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#scan_insurance img').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection

@section('css')
    <style>
        #scan_insurance img {
            height: 65px;
            position: relative;
            top: -20px;
            border-radius: 5px;
        }
    </style>
@endsection