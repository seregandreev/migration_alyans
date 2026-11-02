@extends('layouts.template')
@section('title', 'Редактирование')
@section('header')
   
@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-10 col-12">
            <div class="card">
                <div class="card-header first"><h3>Редактирование компании {{ $company->name }}</h3><a class="card-header-link"  href="{{ route('companies.index') }}"><i class="fa fa-mail-reply-all" aria-hidden="true"></i>  Вернуться к списку компаний</a></div>
                <div class="card-body">
                    <form action="{{ route('companies.update', ['id' => $company->id]) }}" method="POST" class="mb-5" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        {{-- Название --}}
                        <div class="list card-header  pt-5 pb-5">
                            <div class="row">
                                <div class="col-12 col-lg-6 form-group">
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Название</h4>
                                    <input type="text" class="form-control" name="name" value="{{ $company->name }}" required>
                                </div>
                                <div class="col-12 col-lg-6 form-group">
                                    <h4 class="card-title"><span style="color: #ff0000;"></span>Сокращение</h4>
                                    <input type="text" class="form-control" name="abbr" value="{{ $company->abbr }}" >
                                    <small><i>Внимание! Данное поле участвует в формировании номера ленты. Если в номере ленты вместо краткого наименования используется другая аббревиатура, введите ее здесь</i> </small>
                                </div>
                            </div>
                        </div>
                      
                        {{-- Логотип --}}
                        <div class="card-header row list mt-5 mb-5 pt-5 pb-5">
                                <div class="col-12">
                                    <h4 class="card-title">Логотип</h4>
                                    </div>
                                    <div class="col-md-6 col-12">
                                     @if(file_exists(public_path('companies_data/'.$company->id.'/logo.jpg')))
                                        <a href="{{ asset('companies_data/'.$company->id.'/logo.jpg') }}" data-fancybox="gallery">
                                           <img src="{{ asset('companies_data/'.$company->id.'/logo.jpg') }}" alt="" style="height: 50px; border-radius: 5px;">
                                        </a>
                                     @else
                                    <i>Отсутствует</i>
                                    @endif
                                    </div>
                                    <div class="col-md-6 col-12">
                                        Заменить логотип
                                    <input style="background-color: rgba(0,0,0,.03)" type="file" class="" name="logo" value="{{ old('logo') }}">
                                    </div>
                        </div>
                        {{-- Места проведения работ --}}
                        <div class="card-header row mt-5 pt-3 pb-3" id="location_works">
                            
                                <div class="col-md-9">
                                    <h4>
                                        Места проведения работ
                                    </h4>
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
                                        @if($company->work_locations()->count() == 0)
                                            <div class="row mb-2">
                                                <div class="col-10">
                                                    <input type="text" name="work_locations[]" class="form-control" placeholder="Укажите название места проведения работ">
                                                </div>
                                                <div class="col-2 d-flex align-items-center justify-content-center">
                                                    <button type="button" class="btn btn-danger remove_item">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @else
                                            @foreach($company->work_locations() as $location)
                                                <div class="row mb-2">
                                                    <div class="col-10">
                                                        <input type="text" name="location_current_name" class="form-control" value="{{ $location->name }}" data-location_id="{{ $location->id }}">
                                                    </div>
                                                    <div class="col-2 d-flex align-items-center justify-content-center">
                                                        <button type="button" class="btn btn-danger" onclick="if(confirm('Перед удалением убедитесь что - {{ $location->name }} не используется в формировании компанента')){$('#item_{{ $location->id }}_delete').submit();}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
           
                        {{-- Установки --}}
                        <div class="card-header row pt-3 pb-3 mt-5" id="facilities">
                            <div class="col-md-9 col-12">
                                <h4>
                                    Установки\Бригада\Склад
                                </h4>
                            </div>
                            <div class="col-md-3 col-12 d-flex justify-content-md-end">
                                <button type="button" class="btn btn-success new_facility">
                                    Добавить установку <i class="fas fa-plus-square"></i>
                                </button>
                            </div>
                            <div class="col-12">
                                <div class="row items">
                                    <div class="col-12 items-data">
                                        @if($company->facilities()->count() == 0)
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
                                        @else
                                            @foreach($company->facilities() as $facility)
                                                <hr>
                                                <div class="row mb-2">
                                                    <div class="col-2">
                                                        <label for="num">&nbsp</label>
                                                        <input type="text" id="num" name="facility_current_number" class="form-control" value="{{ $facility->number }}" data-facility_id="{{ $facility->id }}">
                                                        <br>
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="gnum">&nbsp</label>
                                                        <input type="text" id="gnum" name="facility_current_gos_number" class="form-control" value="{{ $facility->gos_number }}" data-facility_id="{{ $facility->id }}">
                                                        <br>
                                                    </div>
                                                    <div class="col-2">
                                                        <label for="uchastok">&nbsp</label>
                                                        <input type="text" id="uchastok" name="facility_current_area" class="form-control" value="{{ $facility->area }}" data-facility_id="{{ $facility->id }}">
                                                        <br>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="inspector">Ответственный</label>
                                                        <select name="facility_current_responsible_id" id="inspector" class="form-control" data-facility_id="{{ $facility->id }}">
                                                            @foreach($responsibles as $responsible)
                                                                <option value="{{ $responsible->id }}" @if($responsible->id == $facility->responsible_id) selected @endif>{{ $responsible->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-1 d-flex align-items-center justify-content-center">
                                                        <button type="button" class="btn btn-danger" onclick="if(confirm('Перед удалением убедитесь что - {{ $facility->number }} {{ $facility->gos_number }} {{ $facility->area }} не используется в формировании компанента')){$('#item_{{ $facility->id }}_delete').submit();}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="d-flex justify-content-end">
                        <button type="submit" class="btn  btn-dark">Сохранить компанию</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @foreach($company->work_locations() as $location) 
        <form action="{{ route('workLocation.delete', ['id' => $location->id]) }}" id="item_{{ $location->id }}_delete" method="GET">
            @csrf
            @method('delete')
        </form>
    @endforeach
    @foreach($company->facilities() as $facility)
        <form action="{{ route('facilityDelete.delete', ['id' => $facility->id]) }}" id="item_{{ $facility->id }}_delete" method="GET">
            @csrf
            @method('delete')
        </form>
    @endforeach

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
            
            {{-- Обновление наименования места проведения работ --}}
            $('input[name="location_current_name"]').change(function() {
                var obj = $(this);
                var token = $('input[name="_token"]').val();
                var location_id = obj.data('location_id');
                var location_current_name = obj.parent().parent().find('input[name="location_current_name"]').val();

                $.post('{{ route('companies.setLocation') }}', {'_token': token, 'location_id': location_id, 'location_current_name': location_current_name}, function(data) {});
            });

            {{-- Обновление полей установки --}}
            $('input[name="facility_current_number"], input[name="facility_current_gos_number"], input[name="facility_current_area"], select[name="facility_current_responsible_id"]').change(function() {
                var obj = $(this);
                var token = $('input[name="_token"]').val();
                var facility_id = obj.data('facility_id');
                var facility_current_number = obj.parent().parent().find('input[name="facility_current_number"]').val();
                var facility_current_gos_number = obj.parent().parent().find('input[name="facility_current_gos_number"]').val();
                var facility_current_area = obj.parent().parent().find('input[name="facility_current_area"]').val();
                var facility_current_responsible_id = obj.parent().parent().find('select[name="facility_current_responsible_id"]').val();

                $.post('{{ route('companies.setFacility') }}', {'_token': token, 'facility_id': facility_id, 'facility_current_number': facility_current_number, 'facility_current_gos_number': facility_current_gos_number, 'facility_current_area': facility_current_area, 'facility_current_responsible_id': facility_current_responsible_id}, function(data) {});
            });
        });
    </script>
@endsection