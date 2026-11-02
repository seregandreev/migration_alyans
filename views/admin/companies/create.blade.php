@extends('layouts.template')
@section('title', 'Новая компания')
@section('header')
  
@endsection

@section('content')

     <div class="row justify-content-center">
        <div class="col-md-10 col-12">
            <div class="card">
                <div class="card-header first"><h3>Заполните информацию по новой компании</h3><a class="card-header-link"  href="{{ route('companies.index') }}"><i class="fa fa-mail-reply-all" aria-hidden="true"></i>  Вернуться к списку компаний</a></div>
                <div class="card-body">
                    <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- Название --}}
                        <div class="card-header pt-3 pb-3">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Название</h4>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <h4 class="card-title">Сокращение</h4>
                                    <input type="text" class="form-control" name="abbr">
                                     <small><i>Внимание! Данное поле участвует в формировании номера ленты. Если в номере ленты вместо краткого наименования используется другая аббревиатура, введите ее здесь</i> </small>
                                </div>
                            </div>
                        </div>
                        <div class="card-header pt-3 pb-3 mt-5 mb-5">
                            {{-- Логотип --}}
                            <div class="list">
                                <h4 class="card-title">Логотип</h4>
                                <input type="file" class="form-control @if($errors->has('logo')) is-invalid @endif" name="logo" value="{{ old('logo') }}">
                            </div>
                        </div>
                        <div class="card-header mt-5 mb-5 pt-3 pb-3">
                            {{-- Места проведения работ --}}
                            <div class="row" id="location_works">
                                <div class="col-9">
                                    <h4>Места проведения работ</h4>
                                </div>    
                                <div class="col-md-3 col-12 d-flex justify-content-md-end">
                                    <button type="button" class="btn btn-success new_work_location"> 
                                        Добавить место <i class="fas fa-plus-square"></i> 
                                    </button>
                                </div>
                                <hr>
                                <div class="col-12 mt-3 mb-3">
                                    <div class="row items">
                                        <div class="col-12 items-data">
                                            <div class="row mb-2">
                                                <div class="col-10">
                                                    <input type="text" name="work_locations[]" class="form-control" placeholder="Укажите название места проведения работ">
                                                    <br>
                                                </div>
                                                <div class="col-2 d-flex align-items-center justify-content-center">
                                                    <button type="button" class="btn btn-danger remove_item">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-header pt-3 pb-3 mb-2">
                            {{-- Установки --}}
                            <div class="row" id="facilities">
                                <div class="col-md-9 col-12 ">
                                    <h4>Установки\Бригада\Склад</h4>
                                </div>
                                <div class="col-md-3 col-12 d-flex justify-content-md-end">
                                    <button type="button" class="btn btn-success new_facility">
                                        Добавить установку <i class="fas fa-plus-square"></i>
                                    </button>
                                </div>
                                <hr>
                                <div class="col-12 mt-3 mb-3">
                                     <div class="row items">
                                        <div class="col-12 items-data">
                                            <div class="row">
                                                <div class="col-2">
                                                    <label for="num">&nbsp</label>
                                                    <input type="text" name="facility_number[]" class="form-control" placeholder="Номер">
                                                    <br>
                                                </div>
                                                <div class="col-3">
                                                    <label for="gnum">&nbsp</label>
                                                    <input type="text" name="facility_gos_number[]" class="form-control" placeholder="Гос. номер">
                                                    <br>
                                                </div>
                                                <div class="col-2">
                                                    <label for="uchastok">&nbsp</label>
                                                    <input type="text" name="facility_area[]" class="form-control" placeholder="Участок">
                                                <br>
                                                </div>
                                            <div class="col-4">
                                                <label for="inspector">Ответственный</label>
                                                <select name="facility_responsible_id[]" class="form-control">
                                                    @foreach($responsibles as $responsible)
                                                        <option value="{{ $responsible->id }}">{{ $responsible->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-1 d-flex align-items-center justify-content-center">
                                                <button type="button" class="btn btn-danger remove_item">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="d-flex justify-content-end mb-5">
                        <button type="submit" class="btn btn-primary">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="helper-data" style="display: none;">
        {{-- Ответственный --}}
        <div class="col-4">
            <select style="visibility: visible;" name="facility_responsible_id[]" class="form-control">
                @foreach($responsibles as $responsible)
                    <option value="{{ $responsible->id }}">{{ $responsible->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
@endsection


@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet">
@endsection


@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $('.searcher').select2();

        $(document).ready(function() {
            {{-- Добавление нового места проведения работ --}}
            $('.new_work_location').click(function() {
                var obj = $(this);
                var item = '<div class="row mb-2"><div class="col-10"><input type="text" name="work_locations[]" class="form-control" placeholder="Укажите название места проведения работ"></div><div class="col-2 d-flex align-items-center justify-content-center"><button type="button" class="btn btn-danger remove_item"><i class="fas fa-trash-alt"></i></button></div></div>';

                $('#location_works .items-data').append(item);
            });
            {{-- Удаление элемента --}}
            $(document).on('click', '#location_works .remove_item', function() {
                var obj = $(this);
                obj.parent().parent().remove();
            });


            {{-- Добавление новой установки --}}
            $('.new_facility').click(function() {
                var obj = $(this);
                var responsibles = $('.helper-data').html();
                var item = '<hr><div class="row mb-2"><div class="col-2"><input type="text" name="facility_number[]" class="form-control" placeholder="Номер"></div><div class="col-3"><input type="text" name="facility_gos_number[]" class="form-control" placeholder="Гос. номер"></div><div class="col-2"><input type="text" name="facility_area[]" class="form-control" placeholder="Участок"></div>'+responsibles+'<div class="col-1 d-flex align-items-center justify-content-center"><button type="button" class="btn btn-danger remove_item"><i class="fas fa-trash-alt"></i></button></div></div>';

                $('#facilities .items-data').append(item);
            });
            {{-- Удаление элемента --}}
            $(document).on('click', '#facilities .remove_item', function() {
                var obj = $(this);
                obj.parent().parent().remove();
            });
        });
    </script>
@endsection