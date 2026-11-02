@extends('layouts.template')
@section('title', 'Редактирование')

@section('header')
    <h4>
        <a href="{{ route('conclusions.index') }}">Список заключений</a> / Редактирование
    </h4>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
            <div class="card">
                <div class="card-header">Редактирование информации по заключению</div>
                <div class="card-body">
                    <form action="{{ route('conclusions.update', $conclusion->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        {{-- ВИК --}}
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                <label>Информация по заключению</label>
                            </legend>
                            <div class="control-group">
                                <div class="row">
                                    {{-- Компания --}}
                                    {{-- <div class="col-12 col-lg-3">
                                        <label for="company_name">Компания/владелец</label>
                                        <input type="text" id="company_name" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->company()->name }} @endif" class="form-control" readonly>
                                    </div> --}}
                                    {{-- Дата проведения контроля --}}
                                    <div class="col-12 col-lg-3">
                                        <label for="date">Дата проведения контроля</label>
                                        <input type="date" name="date" class="form-control" value="{{ $conclusion->date }}" required>
                                    </div>
                                    {{-- Дата следующего контроля --}}
                                    <div class="col-12 col-lg-3">
                                        <label for="date_next_verification">Дата следующего контроля</label>
                                        <input type="date" name="date_next_verification" class="form-control" value="{{ $conclusion->date_next_verification }}" required>
                                    </div>
                                    {{-- Исполнитель --}}
                                    <div class="col-12 col-lg-3">
                                        <label for="inspector_id">Исполнитель</label>
                                        <select name="inspector_id" id="inspector_id" class="form-control">
                                            @foreach($inspectors as $inspector)
                                                <option value="{{ $inspector->id }}" @if($conclusion->inspector_id == $inspector->id) selected @endif>{{ $inspector->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                {{-- Компания --}}
                                    <div class="col-12 col-md-6">
                                        <h4 class="card-title">Организация владелец</h4>
                                        <input type="text" id="company_name" class="form-control" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->company()->name }} @endif" readonly>
                                        <input type="hidden" id="companyIdComponent">
                                    </div>
                                {{-- <div class="col-12 col-md-6">
                                    <div class="list">
                                        <h4 class="card-title"><span style="color: #ff0000;">*</span>Организация владелец</h4>
                                        <select name="companyIdComponent" id="companyIdComponent" class="form-control" required>
                                        </select>
                                    </div>
                                </div> --}}
                                {{-- Место проведения работ --}}
                                <div class="col-12 col-md-6">
                                    <div class="list">
                                        <h4 class="card-title"><span style="color: #ff0000;">*</span>Место пров. работ</h4>
                                        <select name="work_location_id" id="work_location_id" class="form-control searcher-work-location" required>
                                            @foreach($work_locations as $work_location)
                                                <option value="{{ $work_location->id }}" @if($work_location->id == $conclusion->component()->work_location_id) selected @endif>{{ $work_location->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- Установка --}}
                                <div class="col-12 col-md-12">
                                    <div class="list">
                                        <h4 class="card-title"><span style="color: #ff0000;">*</span>Номер флота/установки</h4>
                                        <select name="facility_id" id="facility_id" class="form-control searcher-facility" required>
                                            @foreach($facilities as $facility)
                                                <option value="{{ $facility->id }}" @if($conclusion->component()->facility_id == $facility->id) selected @endif>{{ $facility->number.' '.$facility->gos_number.' '.$facility->area }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            
                        </fieldset>

                        <div class="row">
                            <div class="col-12" id="error_if_tape_number_not_found">
                                <div class="alert alert-danger">
                                    Номер ленты в базе не найден. Вы можете добавить <a href="{{ route('components.create') }}" target="_blank">новый компонент</a>. Необходимо распечатать номер ленты на маркираторе
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="list">
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Номер бандажной ленты</h4>
                                    <input type="text" id="tape_number" value="@if(isset($conclusion->component()->id)) {{ $typeNumber }} @endif" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="list">
                                    <h4 class="card-title">Наименование</h4>
                                    <input type="text" id="type_name" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->type()->name }} @endif" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="list">
                                    <h4 class="card-title">Характеристики</h4>
                                    <input type="text" id="type_description" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->type()->description }} ({{ $conclusion->component()->type()->manufacturer }}) @endif" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="list">
                                    <label>Партийный номер</label>
                                    <input type="text" id="partial_number" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->type()->partial_number }} @endif" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="list">
                                    <label>Серийный номер</label>
                                    <input type="text" id="serial_number" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->serial_number }} @endif" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="list">
                                    <label>Температура окружающей среды</label>
                                    <input type="text" name="temperature" id="temperature" value="{{ $conclusion->temperature }}" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-12 col-lg-3">
                                <div class="list">
                                    <label>Прокаченый пропан (тонн)</label>
                                    <input type="text" name="propan" value="{{ $conclusion->propan }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        {{-- ВИК --}}
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                <label>
                                    <input type="checkbox" id="check-vik" @if($conclusion->check_vik == 1 && $conclusion->vik_result != '') checked @endif name="check_vik"> Визуально измерительный контроль
                                </label>
                            </legend>
                            <div class="control-group" id="block-vik">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="control-label input-label" for="startTime">Результат ВИК</label>
                                        <select name="vik_result" class="custom-select">
                                            <option value="Состояние поверхности объекта контроля соответствует требованиям 3997-00.001 МУ «Методические указания по определению критериев вывода из эксплуатации нефтепромыслового оборудования»; Недопустимых дефектов не обнаружено" @if($conclusion->vik_result == 'Состояние поверхности объекта контроля соответствует требованиям 3997-00.001 МУ «Методические указания по определению критериев вывода из эксплуатации нефтепромыслового оборудования»; Недопустимых дефектов не обнаружено') selected @endif>Состояние поверхности объекта контроля соответствует требованиям 3997-00.001 МУ "Методические указания по определению критериев вывода из эксплуатации нефтепромыслового оборудования"; Недопустимых дефектов не обнаружено.</option>
                                            <option value="Состояние поверхности объекта контроля не соответствует требованиям 3997-00.001 МУ «Методические указания по определению критериев вывода из эксплуатации нефтепромыслового оборудования»; Обнаружены недопустимые дефекты" @if($conclusion->vik_result == 'Состояние поверхности объекта контроля не соответствует требованиям 3997-00.001 МУ «Методические указания по определению критериев вывода из эксплуатации нефтепромыслового оборудования»; Обнаружены недопустимые дефекты') selected @endif>Состояние поверхности объекта контроля не соответствует требованиям 3997-00.001 МУ "Методические указания по определению критериев вывода из эксплуатации нефтепромыслового оборудования"; Обнаружены недопустимые дефекты.</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="vik_comment">Комментарии</label>
                                        <textarea name="vik_comment" id="vik_comment" class="form-control">{{ $conclusion->vik_comment }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        {{-- УЗТ --}}
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                <label>
                                    <input type="checkbox" id="check-uzt" @if($conclusion->check_uzt == 1 && $conclusion->uzt_result != '') checked @endif name="check_uzt"> Ультразвуковая толщинометрия
                                </label>
                            </legend>
                            <div class="control-group" id="block-uzt">
                                <div class="row">
                                    <div class="col-12"><h4 class="text-center">Измеренная толщина, мм</h4></div>
                                    <div class="col-2">
                                        <label>Сечение 1</label>
                                        <input type="text" class="form-control" name="measure_1" value="{{ $conclusion->measure_1 }}">
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 2</label>
                                        <input type="text" class="form-control" name="measure_2" value="{{ $conclusion->measure_2 }}">
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 3</label>
                                        <input type="text" class="form-control" name="measure_3" value="{{ $conclusion->measure_3 }}">
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 4</label>
                                        <input type="text" class="form-control" name="measure_4" value="{{ $conclusion->measure_4 }}">
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 5</label>
                                        <input type="text" class="form-control" name="measure_5" value="{{ $conclusion->measure_5 }}">
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 6</label>
                                        <input type="text" class="form-control" name="measure_6" value="{{ $conclusion->measure_6 }}">
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 7</label>
                                        <input type="text" class="form-control" name="measure_7" value="{{ $conclusion->measure_7 }}">
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 8</label>
                                        <input type="text" class="form-control" name="measure_8" value="{{ $conclusion->measure_8 }}">
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 9</label>
                                        <input type="text" class="form-control" name="measure_9" value="{{ $conclusion->measure_9 }}">
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 10</label>
                                        <input type="text" class="form-control" name="measure_10" value="{{ $conclusion->measure_10 }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12"><h4 class="text-center">Предельно-допустимая толщина, мм</h4></div>
                                    <div class="col-2">
                                        <label>Сечение 1</label>
                                        <input type="text" id="type_measure_1" class="form-control" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->type()->measure_1 }} @endif" readonly>
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 2</label>
                                        <input type="text" id="type_measure_2" class="form-control" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->type()->measure_2 }} @endif" readonly>
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 3</label>
                                        <input type="text" id="type_measure_3" class="form-control" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->type()->measure_3 }} @endif" readonly>
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 4</label>
                                        <input type="text" id="type_measure_4" class="form-control" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->type()->measure_4 }} @endif" readonly>
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 5</label>
                                        <input type="text" id="type_measure_5" class="form-control" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->type()->measure_5 }} @endif" readonly>
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 6</label>
                                        <input type="text" id="type_measure_6" class="form-control" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->type()->measure_6 }} @endif" readonly>
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 7</label>
                                        <input type="text" id="type_measure_7" class="form-control" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->type()->measure_7 }} @endif" readonly>
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 8</label>
                                        <input type="text" id="type_measure_8" class="form-control" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->type()->measure_8 }} @endif" readonly>
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 9</label>
                                        <input type="text" id="type_measure_9" class="form-control" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->type()->measure_9 }} @endif" readonly>
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 10</label>
                                        <input type="text" id="type_measure_10" class="form-control" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->type()->measure_10 }} @endif" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label class="control-label input-label" for="startTime">Результат УЗТ</label>
                                        <select name="uzt_result" class="custom-select">
                                            <option value="Обнаруженные толщины не менее допустимых значений. Годен" @if($conclusion->uzt_result == 'Обнаруженные толщины не менее допустимых значений. Годен') selected @endif>Обнаруженные толщины не менее допустимых значений. Годен</option>
                                            <option value="Обнаруженные толщины менее допустимых значений. Негоден" @if($conclusion->uzt_result == 'Обнаруженные толщины менее допустимых значений. Негоден') selected @endif>Обнаруженные толщины менее допустимых значений. Негоден</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        {{-- УЗК --}}
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                <label>
                                    <input type="checkbox" id="check-uzk" @if($conclusion->check_uzk == 1 && $conclusion->uzk_result != '') checked @endif name="check_uzk"> УЗК
                                </label>
                            </legend>
                            <div class="control-group" id="block-uzk">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="control-label input-label" for="startTime">Результат УЗК</label>
                                        <select name="uzk_result" class="custom-select">
                                            <option value="Годен" @if($conclusion->uzk_result == 'Годен') selected @endif>Годен</option>
                                            <option value="Не годен" @if($conclusion->uzk_result == 'Не годен') selected @endif>Не годен</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        {{-- МК --}}
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                <label>
                                    <input type="checkbox" id="check-mk" @if($conclusion->check_mk == 1 && $conclusion->mk_result != '') checked @endif name="check_mk"> Магнитно-порошковый контроль
                                </label>
                            </legend>
                            <div class="control-group" id="block-mk">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="area_deffects">Участки с дефектами</label>
                                        <textarea name="area_deffects" id="area_deffects" class="form-control">{{ (empty($conclusion->mk_result)) ? 'Отсутствуют' : $conclusion->area_deffects }}</textarea>
                                    </div>
                                    <div class="col-6">
                                        <label for="deffects_size">Дефекты и их размеры</label>
                                        <input type="text" name="deffects_size" id="deffects_size" class="form-control" value="{{ (empty($conclusion->mk_result)) ? 'Не обнаружены' : $conclusion->deffects_size }}">
                                    </div>
                                    <div class="col-6">
                                        <label for="mk_result">Вывод МК</label>
                                        <select name="mk_result" id="mk_result" class="form-control">
                                            <option value="Годен" @if($conclusion->mk_result == 'Годен') selected @endif>Годен</option>
                                            <option value="Не годен" @if($conclusion->mk_result == 'Не годен') selected @endif>Не годен</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        {{-- ГИ --}}
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                <label>
                                    <input type="checkbox" id="check-gi" @if($conclusion->check_gi == 1 && $conclusion->gi_result != '') checked @endif name="check_gi"> Гидравлическое испытание
                                </label>
                            </legend>
                            <div class="control-group" id="block-gi">
                                <!--<div class="row">
                                    <div class="col-12">
                                        <label for="graph">График</label>
                                        <input type="text" name="graph" value="{{ $conclusion->graph }}" class="form-control">
                                    </div>
                                </div>-->
                                <div class="row">
                                    <div class="col-3">
                                        <label>Этап опрессовки 1, МПа/Ps<span class="component-measure"></span></label>
                                        <input type="text" id="crimping_1" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->type()->crimping_1 }} @endif" class="form-control" readonly>
                                    </div>
                                    <div class="col-3">
                                        <label>Продолжительность, мин.</label>
                                        <input type="text" id="period_1" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->type()->period_1 }} @endif" class="form-control" readonly>
                                    </div>
                                    <div class="col-3">
                                        <label>Этап опрессовки 2, МПа/Psi<span class="component-measure"></span></label>
                                        <input type="text" id="crimping_2" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->type()->crimping_2 }} @endif" class="form-control" readonly>
                                    </div>
                                    <div class="col-3">
                                        <label>Продолжительность, мин.</label>
                                        <input type="text" id="period_2" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->type()->period_2 }} @endif" class="form-control" readonly>
                                    </div>
                                    <div class="col-3">
                                        <label>Этап опрессовки 3, МПа/Psi<span class="component-measure"></span></label>
                                        <input type="text" id="crimping_3" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->type()->crimping_3 }} @endif" class="form-control" readonly>
                                    </div>
                                    <div class="col-3">
                                        <label>Продолжительность, мин.</label>
                                        <input type="text" id="period_3" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->type()->period_3 }} @endif" class="form-control" readonly>
                                    </div>
                                    <div class="col-3">
                                        <label>Этап опрессовки 4, МПа/Ps<span class="component-measure"></span></label>
                                        <input type="text" id="crimping_4" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->type()->crimping_4 }} @endif" class="form-control" readonly>
                                    </div>
                                    <div class="col-3">
                                        <label>Продолжительность, мин.</label>
                                        <input type="text" id="period_4" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->type()->period_4 }} @endif" class="form-control" readonly>
                                    </div>
                                    <div class="col-3">
                                        <label>Этап опрессовки 5, МПа/Psi<span class="component-measure"></span></label>
                                        <input type="text" id="crimping_5" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->type()->crimping_5 }} @endif" class="form-control" readonly>
                                    </div>
                                    <div class="col-3">
                                        <label>Продолжительность, мин.</label>
                                        <input type="text" id="period_5" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->type()->period_5 }} @endif" class="form-control" readonly>
                                    </div>
                                    <div class="col-3">
                                        <label>Этап опрессовки 6, МПа/Psi<span class="component-measure"></span></label>
                                        <input type="text" id="crimping_6" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->type()->crimping_6 }} @endif" class="form-control" readonly>
                                    </div>
                                    <div class="col-3">
                                        <label>Продолжительность, мин.</label>
                                        <input type="text" id="period_6" value="@if(isset($conclusion->component()->id)) {{ $conclusion->component()->type()->period_6 }} @endif" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label class="control-label input-label" for="startTime">Результат</label>
                                        <select name="gi_result" id="gi_result" class="custom-select">
                                            <option value="" selected disabled> -- Выберите результат -- </option>
                                            <option value="Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность" @if($conclusion->gi_result == 'Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность') selected @endif>Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность.</option>
                                            <option value="Узел (объект) не признается выдержавшим гидравлическое испытание на прочность и герметичность" @if($conclusion->gi_result == 'Узел (объект) не признается выдержавшим гидравлическое испытание на прочность и герметичность') selected @endif>Узел (объект) не признается выдержавшим гидравлическое испытание на прочность и герметичность.</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        {{-- опресовка --}}
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                <label>
                                    <input type="checkbox" id="crimping-gi" @if($conclusion->gi_result == 'Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность' && $conclusion->diameter_plashki != '') checked @endif name="check_crimpingGi"> Опрессовка превентора
                                </label>
                            </legend>
                            <div class="control-group" id="crimping-gi">
                                <div class="row mb-2">
                                    <div class="col-2">Диаметр плашки, мм.</div>
                                    <div class="col-2">
                                        <input type="text" id="diameter_plashki" name="diameter_plashki" value="@if(isset($conclusion->diameter_plashki)) {{ $conclusion->diameter_plashki }} @endif" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 item-diagramma_crimping_1">
                                        <label for="diagramma_crimping_1">Диаграмма №1</label>
                                        <input type="file" class="form-control @if($errors->has('diagramma_crimping_1')) is-invalid @endif" id="diagramma_crimping_1" name="diagramma_crimping_1" value="{{ old('diagramma_crimping_1') }}">
                                        <div class="upload-image">
                                            @if(file_exists(public_path('conclusions_data/'.$conclusion->id.'/diagramma_crimping_1.jpg')))
                                                <a href="{{ asset('conclusions_data/'.$conclusion->id.'/diagramma_crimping_1.jpg') }}" data-fancybox="gallery">
                                                    <img src="{{ asset('conclusions_data/'.$conclusion->id.'/diagramma_crimping_1.jpg') }}" alt="">
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-4 item-diagramma_crimping_2">
                                        <label for="diagramma_crimping_2">Диаграмма №2</label>
                                        <input type="file" class="form-control @if($errors->has('diagramma_crimping_2')) is-invalid @endif" id="diagramma_crimping_2" name="diagramma_crimping_2" value="{{ old('diagramma_crimping_2') }}">
                                        <div class="upload-image">
                                            @if(file_exists(public_path('conclusions_data/'.$conclusion->id.'/diagramma_crimping_2.jpg')))
                                                <a href="{{ asset('conclusions_data/'.$conclusion->id.'/diagramma_crimping_2.jpg') }}" data-fancybox="gallery">
                                                    <img src="{{ asset('conclusions_data/'.$conclusion->id.'/diagramma_crimping_2.jpg') }}" alt="">
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-4 item-diagramma_crimping_3">
                                        <label for="diagramma_crimping_3">Диаграмма №3</label>
                                        <input type="file" class="form-control @if($errors->has('diagramma_crimping_3')) is-invalid @endif" id="diagramma_crimping_3" name="diagramma_crimping_3" value="{{ old('diagramma_crimping_3') }}">
                                        <div class="upload-image">
                                            @if(file_exists(public_path('conclusions_data/'.$conclusion->id.'/diagramma_crimping_3.jpg')))
                                                <a href="{{ asset('conclusions_data/'.$conclusion->id.'/diagramma_crimping_3.jpg') }}" data-fancybox="gallery">
                                                    <img src="{{ asset('conclusions_data/'.$conclusion->id.'/diagramma_crimping_3.jpg') }}" alt="">
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        {{-- тарировка --}}
                        <div class="row">
                            <div class="col-6">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">
                                        <label>
                                            <input type="checkbox" id="calibration-gi" @if($conclusion->gi_result == 'Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность' && $conclusion->calibration_pressure != '') checked @endif name="check_calibration"> Тарировка
                                        </label>
                                    </legend>
                                    <div class="control-group" id="calibration-gi">
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <input type="text" id="calibration_pressure" name="calibration_pressure" value="@if(isset($conclusion->calibration_pressure)) {{ $conclusion->calibration_pressure }} @endif" class="form-control">
                                            </div>
                                            <div class="col-6">Давление тарировки(МПа)</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 item-diagramma_calibration">
                                                <label for="diagramma_calibration">Диаграмма</label>
                                                <input type="file" class="form-control @if($errors->has('diagramma_calibration')) is-invalid @endif" id="diagramma_calibration" name="diagramma_calibration" value="{{ old('diagramma_calibration') }}">
                                                <div class="upload-image">
                                                    @if(file_exists(public_path('conclusions_data/'.$conclusion->id.'/diagramma_calibration.jpg')))
                                                        <a href="{{ asset('conclusions_data/'.$conclusion->id.'/diagramma_calibration.jpg') }}" data-fancybox="gallery">
                                                            <img src="{{ asset('conclusions_data/'.$conclusion->id.'/diagramma_calibration.jpg') }}" alt="">
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
    
                            {{-- бгрп --}}
                            <div class="col-6">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">
                                        <label>
                                            <input type="checkbox" id="bgrp-gi" @if($conclusion->gi_result == 'Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность' && $conclusion->coefficient != '') checked @endif name="check_bgrp"> ПРОБНОЕ ДАВЛЕНИЕ
                                        </label>
                                    </legend>
                                    <div class="control-group" id="bgrp-gi">
                                        <div class="row">
                                            <div class="col-3 text-center">
                                                <input class="form-check-input" type="radio" name="coefficient" @if($conclusion->coefficient == 1.25) checked @endif value="1.25" id="one_twenty_five">
                                                <label class="form-check-label" for="one_twenty_five">
                                                  1.25x
                                                </label>
                                            </div>
                                            <div class="col-3 text-center">
                                                <input class="form-check-input" type="radio" name="coefficient" @if($conclusion->coefficient == 1.5) checked @endif value="1.5" id="one_and_five">
                                                <label class="form-check-label" for="one_and_five">
                                                  1.5x
                                                </label>
                                            </div>
                                            <div class="col-3 text-center">
                                                <input class="form-check-input" type="radio" name="coefficient" @if($conclusion->coefficient == 2) checked @endif value="2" id="two">
                                                <label class="form-check-label" for="two">
                                                  2x
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 item-diagramma_bgrp">
                                                <label for="diagramma_bgrp">Диаграмма</label>
                                                <input type="file" class="form-control @if($errors->has('diagramma_bgrp')) is-invalid @endif" id="diagramma_bgrp" name="diagramma_bgrp" value="{{ old('diagramma_bgrp') }}">
                                                <div class="upload-image">
                                                    @if(file_exists(public_path('conclusions_data/'.$conclusion->id.'/diagramma_bgrp.jpg')))
                                                        <a href="{{ asset('conclusions_data/'.$conclusion->id.'/diagramma_bgrp.jpg') }}" data-fancybox="gallery">
                                                            <img src="{{ asset('conclusions_data/'.$conclusion->id.'/diagramma_bgrp.jpg') }}" alt="">
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3 passport_create">
                                <label>Оформление паспорта</label>
                                <label>
                                    <input type="checkbox" name="passport" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" @if($conclusion->passport == 1) checked @endif> Оформлен паспорт
                                </label>
                                <label>
                                    <input type="checkbox" name="repair" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" @if($conclusion->repair == 1) checked @endif> Произведён ремонт
                                </label>
                                <label>
                                    <input type="checkbox" name="no_passportization" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" @if($conclusion->no_passportization == 1) checked @endif> Не паспортизируется
                                </label>
                                <label>
                                    <input type="checkbox" name="installing_tape" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" @if($conclusion->installing_tape == 1) checked @endif> Установка бандажной ленты
                                </label>
                            </div>
                        </div>



                        <br>

                        {{-- Компания (из типов) --}}
                        <input type="hidden" id="company_id" name="company_id" value="{{ $conclusion->company_id }}">
                        {{--<input type="hidden" id="unit_id" name="unit_id" value="">--}}
                        <input type="hidden" id="component_id" name="component_id" value="{{ $conclusion->component_id }}">
                        {{--<input type="hidden" id="type_id" name="type_id" value="">--}}
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.searcher-work-location').select2();
            $('.searcher-facility').select2();
        });

        $('#tape_number').change(function() {
            var current_obj = $(this);
            var tape_number = current_obj.val();

            $.post('{{ route('ajax.conclusions.get_data_on_type_number') }}', {'tape_number': tape_number}, function(data) {
                if(data === 'false')
                {
                    $('#error_if_tape_number_not_found').css('display', 'block');
                    current_obj.css('border', '1px solid #ff0000');
                } else {
                    $('#error_if_tape_number_not_found').css('display', 'none');
                    current_obj.css('border', '1px solid green');
                    $('#type_name').val(data['type'].name);
                    $('#type_description').val(data['type'].description + ' ' + '(' + data['type'].manufacturer + ')');
                    $('#partial_number').val(data['type'].partial_number);
                    $('#serial_number').val(data['component'].serial_number);
                    $('#type_measure_1').val(data['type'].measure_1);
                    $('#type_measure_2').val(data['type'].measure_2);
                    $('#type_measure_3').val(data['type'].measure_3);
                    $('#type_measure_4').val(data['type'].measure_4);
                    $('#type_measure_5').val(data['type'].measure_5);
                    $('#type_measure_6').val(data['type'].measure_6);
                    $('#type_measure_7').val(data['type'].measure_7);
                    $('#type_measure_8').val(data['type'].measure_8);
                    $('#type_measure_9').val(data['type'].measure_9);
                    $('#type_measure_10').val(data['type'].measure_10);
                    $('#temperature').val(data['type'].temperature);
                    $('#temperature_mode').val(data['type'].temperature_mode);
                    $('#temperature_mode1').val(data['type'].temperature_mode1);

                    $('#act_1').val(data['type'].act_1);
                    $('#act_2').val(data['type'].act_2);
                    $('#act_3').val(data['type'].act_3);
                    $('#crimping_1').val(data['type'].crimping_1);
                    $('#crimping_2').val(data['type'].crimping_2);
                    $('#crimping_3').val(data['type'].crimping_3);
                    $('#crimping_4').val(data['type'].crimping_4);
                    $('#crimping_5').val(data['type'].crimping_5);
                    $('#crimping_6').val(data['type'].crimping_6);
                    $('#period_1').val(data['type'].period_1);
                    $('#period_2').val(data['type'].period_2);
                    $('#period_3').val(data['type'].period_3);
                    $('#period_4').val(data['type'].period_4);
                    $('#period_5').val(data['type'].period_5);
                    $('#period_6').val(data['type'].period_6);
                    $('#companyIdComponent').val(data['company'].id);

                    // var companies = '<option></option>';
                    // console.log(data['company'].name);
                    // $.each(data['company'], function(key, value) {
                    //     companies += '<option value="'+value.id+'">'+value.name+'</option>';
                    // });
                    // $('select[name="companyIdComponent"]').html(companies);

                    var locations = '<option value="'+data['current_work_location'].id+'" selected>'+data['current_work_location'].name+'</option>';
                    $.each(data['work_locations'], function(key, value) {
                        locations += '<option value="'+value.id+'">'+value.name+'</option>';
                    });
                    $('select[name="work_location_id"]').html(locations);
                    
                    var facilities = '<option value="'+data['current_facility'].id+'">'+data['current_facility'].number+' '+data['current_facility'].gos_number+' '+data['current_facility'].area+'</option>';
                    $.each(data['facilities'], function(key, value) {
                        facilities += '<option value="'+value.id+'">'+value.number+' '+value.gos_number+' '+value.area+'</option>';
                    });
                    $('select[name="facility_id"]').html(facilities);
                    $('#company_name').val(data['company'].name);
                    // $('#company_id').val(data['type'].company_id);
                    // $('#unit_id').val(data['type'].unit_id);
                    $('#component_id').val(data['component'].id);
                    // $('#type_id').val(data['type'].id);
                    $('.component-measure').html(data['component'].measure);

                    /*if(data['component'].measure === 'Psi')
                    {
                        $('input[name="act_1"]').val('5000');
                        $('input[name="act_2"]').val('10000');
                        $('input[name="act_3"]').val('12100');
                    } else if(data['component'].measure === 'кг\\см2') {
                        $('input[name="act_1"]').val('30');
                        $('input[name="act_2"]').val('70');
                        $('input[name="act_3"]').val('32.42');
                    } else if(data['component'].measure === 'Мпа') {
                        $('input[name="act_1"]').val('30');
                        $('input[name="act_2"]').val('70');
                        $('input[name="act_3"]').val('103.4');
                    }*/
                }
            });
        });

        // MK
        // $('#block-mk input').attr('disabled','true');
        // $('#block-mk select').attr('disabled','true');
        // $('#block-mk textarea').attr('disabled','true');

        $('#check-mk').click(function(){
            if($('#check-mk').is(':checked')) {
                $('#block-mk input').removeAttr('disabled','false');
                $('#block-mk select').removeAttr('disabled','false');
                $('#block-mk textarea').removeAttr('disabled','false');
            } else {
                $('#block-mk input').attr('disabled','true');
                $('#block-mk select').attr('disabled','true');
                $('#block-mk textarea').attr('disabled','true');
            }
        });

        if($('#check-mk').is(':checked')) {
            $('#block-mk input').removeAttr('disabled','false');
            $('#block-mk select').removeAttr('disabled','false');
        } else {
            $('#block-mk input').attr('disabled','true');
            $('#block-mk select').attr('disabled','true');
        }

        // VIK
        $('#block-vik input').attr('disabled','true');
        $('#block-vik select').attr('disabled','true');
        $('#block-vik textarea').attr('disabled','true');

        $('#check-vik').click(function(){
            if($('#check-vik').is(':checked')) {
                $('#block-vik input').removeAttr('disabled','false');
                $('#block-vik select').removeAttr('disabled','false');
                $('#block-vik textarea').removeAttr('disabled','false');
            } else {
                $('#block-vik input').attr('disabled','true');
                $('#block-vik select').attr('disabled','true');
                $('#block-vik textarea').attr('disabled','true');
            }
        });

        if($('#check-vik').is(':checked')) {
            $('#block-vik input').removeAttr('disabled','false');
            $('#block-vik select').removeAttr('disabled','false');
            $('#block-vik textarea').removeAttr('disabled','false');
        } else {
            $('#block-vik input').attr('disabled','true');
            $('#block-vik select').attr('disabled','true');
            $('#block-vik textarea').attr('disabled','true');
        }

        // UZT
        $('#block-uzt input').attr('disabled','true');
        $('#block-uzt select').attr('disabled','true');

        $('#check-uzt').click(function(){
            if($('#check-uzt').is(':checked')) {
                $('#block-uzt input').removeAttr('disabled','false');
                $('#block-uzt select').removeAttr('disabled','false');
            } else {
                $('#block-uzt input').attr('disabled','true');
                $('#block-uzt select').attr('disabled','true');
            }
        });

        if($('#check-uzt').is(':checked')) {
            $('#block-uzt input').removeAttr('disabled','false');
            $('#block-uzt select').removeAttr('disabled','false');
        } else {
            $('#block-uzt input').attr('disabled','true');
            $('#block-uzt select').attr('disabled','true');
        }
        
        // UZK
        $('#block-uzk select').attr('disabled','true');

        $('#check-uzk').click(function(){
            if($('#check-uzk').is(':checked')) {
                $('#block-uzk select').removeAttr('disabled','false');
            } else {
                $('#block-uzk select').attr('disabled','true');
            }
        });

        if($('#check-uzk').is(':checked')) {
            $('#block-uzk select').removeAttr('disabled','false');
        } else {
            $('#block-uzk select').attr('disabled','true');
        }
        
        // GI
        $('#block-gi input').attr('disabled','true');
        $('#block-gi select').attr('disabled','true');

        $('#check-gi').click(function(){
            if($('#check-gi').is(':checked')) {
                $('#block-gi input').removeAttr('disabled','false');
                $('#block-gi select').removeAttr('disabled','false');
            } else {
                $('#block-gi input').attr('disabled','true');
                $('#block-gi select').attr('disabled','true');
            }
        });
        if($('#check-gi').is(':checked')) {
            $('#block-gi input').removeAttr('disabled','false');
            $('#block-gi select').removeAttr('disabled','false');
        } else {
            $('#block-gi input').attr('disabled','true');
            $('#block-gi select').attr('disabled','true');
        }

        // опрессовка превентора
        //$('#crimping-gi').attr('disabled','true');
        $('#crimping-gi input').attr('disabled','true');
        $('#crimping-gi select').attr('disabled','true');

        $('#gi_result').click(function(){
            if($('#gi_result').val() == "Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность") {
                $('#crimping-gi').removeAttr('disabled','false');
                $('#calibration-gi').removeAttr('disabled','false');
                $('#bgrp-gi').removeAttr('disabled','false');
            } else {
                $('#crimping-gi').attr('disabled','true');
                $('#calibration-gi').attr('disabled','true');
                $('#bgrp-gi').attr('disabled','true');
            }
        });

        $('#crimping-gi').click(function(){
            if($('#crimping-gi').is(':checked')) {
                $('#crimping-gi input').removeAttr('disabled','false');
                $('#crimping-gi select').removeAttr('disabled','false');
            } else {
                $('#crimping-gi input').attr('disabled','true');
                $('#crimping-gi select').attr('disabled','true');
            }
        });

        if($('#crimping-gi').is(':checked')) {
            $('#crimping-gi input').removeAttr('disabled','false');
            $('#crimping-gi select').removeAttr('disabled','false');
        } else {
            $('#crimping-gi input').attr('disabled','true');
            $('#crimping-gi select').attr('disabled','true');
        }

        // торировка
        //$('#calibration-gi').attr('disabled','true');
        $('#calibration-gi input').attr('disabled','true');

        $('#calibration-gi').click(function(){
            if($('#calibration-gi').is(':checked')) {
                $('#calibration-gi input').removeAttr('disabled','false');
            } else {
                $('#calibration-gi input').attr('disabled','true');
            }
        });

        if($('#calibration-gi').is(':checked')) {
            $('#calibration-gi input').removeAttr('disabled','false');
        } else {
            $('#calibration-gi input').attr('disabled','true');
        }

        // БГРП
        //$('#bgrp-gi').attr('disabled','true');
        $('#bgrp-gi input').attr('disabled','true');

        $('#bgrp-gi').click(function(){
            if($('#bgrp-gi').is(':checked')) {
                $('#bgrp-gi input').removeAttr('disabled','false');
            } else {
                $('#bgrp-gi input').attr('disabled','true');
            }
        });

        if($('#bgrp-gi').is(':checked')) {
            $('#bgrp-gi input').removeAttr('disabled','false');
        } else {
            $('#bgrp-gi input').attr('disabled','true');
        }

        {{-- Подгрузка изображений --}}
            $("#diagramma_crimping_1").change(function(){
                readURLDiagramma1(this);
            });
            function readURLDiagramma1(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.item-diagramma_crimping_1 .upload-image img').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#diagramma_crimping_2").change(function(){
                readURLDiagramma2(this);
            });
            function readURLDiagramma2(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.item-diagramma_crimping_2 .upload-image img').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#diagramma_crimping_3").change(function(){
                readURLDiagramma3(this);
            });
            function readURLDiagramma3(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.item-diagramma_crimping_3 .upload-image img').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#diagramma_calibration").change(function(){
                readURLCalibration(this);
            });
            function readURLCalibration(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.item-diagramma_calibration .upload-image img').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#diagram_bgrp").change(function(){
                readURLbgrp(this);
            });
            function readURLbgrp(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.item-diagram_bgrp .upload-image img').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
    </script>
@endsection


@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css">
    <style>
        fieldset.scheduler-border {
            border: 1px groove #ddd !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
        }
        legend.scheduler-border {
            font-size: 1.2em !important;
            font-weight: bold !important;
            text-align: left !important;
        }
        legend.scheduler-border label {
            position: relative;
            top: 5px;
        }
        .passport_create label {
            display: block;
        }
        #error_if_tape_number_not_found {
            display: none;
        }

        .upload-image {
            /*height: 150px;*/
            text-align: center;
        }

        .upload-image img {
            height: 150px;
            border-radius: 4px;
        }
    </style>
@endsection