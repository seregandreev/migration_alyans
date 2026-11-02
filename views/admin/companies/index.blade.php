@extends('layouts.template')
@section('title', 'Список компаний')

@section('header')
    <h4>Список компаний</h4>
@endsection

@section('content')

    <a href="{{ route('companies.create') }}" class="btn btn-primary">Добавить</a>
    <hr>

    <div class="scroller">
        <table class="table table-bordered">
            <thead>
            @if(count($companies) > 0)
                <tr>
                    <th>Название</th>
                    <th>Сокращение</th>
                    <th>Логотип</th>
                    <th>Действия</th>
                </tr>
            @endif
            </thead>
            <tbody>
            @if(count($companies) < 1)
                <div class="alert alert-danger" role="alert">
                    Не добавлено ещё ни одной компании
                </div>
            @else
                @foreach($companies as $company)
                    <tr>
                        <td class="show_facilities" data-company_id="{{ $company->id }}">{{ $company->name }}</td>
                        <td>{{ $company->abbr }}</td>
                        <td>
                            @if(file_exists(public_path('companies_data/'.$company->id.'/logo.jpg')))
                                <a href="{{ asset('companies_data/'.$company->id.'/logo.jpg') }}" data-fancybox="gallery">
                                    <img src="{{ asset('companies_data/'.$company->id.'/logo.jpg') }}" alt="" style="height: 50px; border-radius: 5px;">
                                </a>
                            @else
                                <i>Отсутствует</i>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-dark show_facilities" data-company_id="{{ $company->id }}" title="Установки"><i class="fas fa-kaaba"></i></button>
                            <button type="button" class="btn btn-warning show_work_locations" data-company_id="{{ $company->id }}" title="Места проведения работ"><i class="fas fa-warehouse"></i></button>
                            {{-- Редактирование --}}
                            <a href="{{ route('companies.edit', ['id' => $company->id]) }}" class="btn btn-success col-xs">
                                <i class="fas fa-edit"></i>
                            </a>
                            {{-- Удаление --}}
                            <button type="button" class="btn btn-danger col-xs" onclick="if(confirm('Подтвердите удаление компании: {{ $company->name }}')){$('#item_{{ $company->id }}_delete').submit();}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <form action="{{ route('companies.destroy', ['id' => $company->id]) }}" id="item_{{ $company->id }}_delete" method="POST">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                    {{-- Установки --}}
                    <tr style="display: none;" class="facilities_{{ $company->id }}_company">
                        <td colspan="4">
                            <div class="row">
                                <div class="col-2" style="font-weight: 700;">Номер</div>
                                <div class="col-2" style="font-weight: 700;">Гос. номер</div>
                                <div class="col-2" style="font-weight: 700;">Участок</div>
                                <div class="col-2" style="font-weight: 700;">Ответственный</div>
                                <!--<div class="col-2" style="font-weight: 700;">Гарантия</div>-->
                            </div>
                            @foreach($company->facilities() as $facility)
                                <div class="row">
                                    <div class="col-2">{{ $facility->number }}</div>
                                    <div class="col-2">{{ $facility->gos_number }}</div>
                                    <div class="col-2">{{ $facility->area }}</div>
                                    <div class="col-2">@if(isset($facility->responsible()->id)) {{ $facility->responsible()->name }} @endif</div>
                                    <!--<div class="col-2">{{ $facility->garante }}</div>-->
                                </div>
                            @endforeach
                        </td>
                    </tr>
                    {{-- Места проведения работ --}}
                    <tr style="display: none;" class="work_locations_{{ $company->id }}_company">
                        <td colspan="4">
                            <div class="row">
                                <div class="col-2" style="font-weight: 700;">Название</div>
                            </div>
                            @foreach($company->work_locations() as $work_location)
                                <div class="row">
                                    <div class="col-2">{{ $work_location->name }}</div>
                                </div>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>

@endsection


@section('js')
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script>
        $(document).ready(function() {
            {{-- Установки --}}
            $('.show_facilities').click(function() {
                var obj = $(this);
                var company_id = obj.data('company_id');
                $('.facilities_'+company_id+'_company').toggle(400);
            });
            {{-- Места проведения работ --}}
            $('.show_work_locations').click(function() {
                var obj = $(this);
                var company_id = obj.data('company_id');
                $('.work_locations_'+company_id+'_company').toggle(400);
            });
        });
    </script>
@endsection


@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
@endsection