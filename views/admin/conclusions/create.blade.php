@extends('layouts.template')
@section('title', 'Новое заключение')

@section('header')
    <h4>
        <a href="{{ route('conclusions.index') }}">Список заключений</a> / Новое заключение
    </h4>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Заполните информацию по новому заключению</div>
                <div class="card-body">
                    <form action="{{ route('conclusions.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

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
                                        <input type="text" id="company_name" class="form-control" readonly>
                                    </div> --}}
                                    {{-- Дата проведения контроля --}}
                                    <div class="col-12 col-lg-3">
                                        <label for="date">Дата проведения контроля</label>
                                        <input type="date" name="date" class="form-control" value="@if($conclusion_last !== null){{ $conclusion_last->date }}@endif" required>
                                    </div>
                                    {{-- Дата следующего контроля --}}
                                    <div class="col-12 col-lg-3">
                                        <label for="date_next_verification">Дата следующего контроля</label>
                                        <input type="date" name="date_next_verification" class="form-control" value="@if($conclusion_last !== null){{ $conclusion_last->date_next_verification }}@endif" required>
                                    </div>
                                    {{-- Исполнитель --}}
                                    <div class="col-12 col-lg-3">
                                        <label for="inspector_id">Исполнитель</label>
                                        <select name="inspector_id" id="inspector_id" class="form-control">
                                            @foreach($inspectors as $inspector)
                                                <option value="{{ $inspector->id }}" @if($conclusion_last !== null && $inspector->id == $conclusion_last->inspector_id) selected @endif>{{ $inspector->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                {{-- Компания --}}
                                    <div class="col-12 col-md-6">
                                        <h4 class="card-title"><span style="color: #ff0000;">*</span>Организация владелец</h4>
                                        <input type="text" id="company_name" class="form-control" readonly>
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
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                {{-- Установка --}}
                                <div class="col-12 col-md-12">
                                    <div class="list">
                                        <h4 class="card-title"><span style="color: #ff0000;">*</span>Номер флота/установки</h4>
                                        <select name="facility_id" id="facility_id" class="form-control searcher-facility" required>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <div class="row">
                            <!-- Алерты -->
                            <div class="col-12" id="show_conclusion_tape_and_date">
                                <div class="alert alert-danger cheсk-concl-on-date">
                                    
                                </div>
                            </div>
                            
                            <div class="col-12" id="error_if_tape_number_not_found">
                                <div class="alert alert-danger">
                                    Номер ленты в базе не найден. Вы можете добавить <a href="{{ route('components.create') }}" target="_blank">новый компонент</a>
                                </div>
                            </div>

                            <div class="col-12" id="need_print_tape_number">
                                <div class="alert alert-danger">
                                    Необходимо распечатать номер ленты на маркираторе
                                </div>
                            </div>

                            <div class="col-12 col-lg-3">
                                <div class="list">
                                    <h4 class="card-title"><span style="color: #ff0000;">*</span>Номер бандажной ленты</h4>
                                    <input type="text" id="tape_number" class="form-control" value="{{ $tape_number }}" required>
                                    <!--<input type="text" id="ust" class="form-control" readonly>-->
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="list">
                                    <h4 class="card-title">Наименование</h4>
                                    <input type="text" id="type_name" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="list">
                                    <h4 class="card-title">Характеристики</h4>
                                    <input type="text" id="type_description" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="list">
                                    <label>Партийный номер</label>
                                    <input type="text" id="partial_number" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="list">
                                    <label>Серийный номер</label>
                                    <input type="text" id="serial_number" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="list">
                                    <label>Температура окружающей среды</label>
                                    <input type="text" name="temperature" class="form-control" value="@if($conclusion_last !== null){{ $conclusion_last->temperature }} @endif" required>
                                </div>
                            </div>
                            <!-- <div class="col-12 col-lg-3">
                                <div class="list">
                                    <h4 class="card-title">Температурный режим от</h4>
                                    <input type="text" id="temperature_mode" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="list">
                                    <h4 class="card-title">Температурный режим до</h4>
                                    <input type="text" id="temperature_mode1" class="form-control" readonly>
                                </div>
                            </div> -->
                            <div class="col-12 col-lg-3">
                                <div class="list">
                                    <label>Прокаченый пропан (тонн)</label>
                                    <input type="text" name="propan" class="form-control">
                                </div>
                            </div>
                        </div>

                        {{-- ВИК --}}
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                <label>
                                    <input type="checkbox" id="check-vik" name="check_vik" value="1"> Визуально измерительный контроль
                                </label>
                            </legend>
                            <div class="control-group" id="block-vik">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="control-label input-label" for="startTime">Результат ВИК</label>
                                        <select name="vik_result" class="custom-select">
                                            <option value="Состояние поверхности объекта контроля соответствует требованиям 3997-00.001 МУ «Методические указания по определению критериев вывода из эксплуатации нефтепромыслового оборудования»; Недопустимых дефектов не обнаружено">Состояние поверхности объекта контроля соответствует требованиям 3997-00.001 МУ "Методические указания по определению критериев вывода из эксплуатации нефтепромыслового оборудования"; Недопустимых дефектов не обнаружено</option>
                                            <option value="Состояние поверхности объекта контроля не соответствует требованиям 3997-00.001 МУ «Методические указания по определению критериев вывода из эксплуатации нефтепромыслового оборудования»; Обнаружены недопустимые дефекты">Состояние поверхности объекта контроля не соответствует требованиям 3997-00.001 МУ "Методические указания по определению критериев вывода из эксплуатации нефтепромыслового оборудования"; Обнаружены недопустимые дефекты</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="vik_comment">Комментарии</label>
                                        <textarea name="vik_comment" id="vik_comment" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        {{-- УЗТ --}}
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                <label>
                                    <input type="checkbox" id="check-uzt" name="check_uzt" value="1"> Ультразвуковая толщинометрия
                                </label>
                            </legend>
                            <div class="control-group" id="block-uzt">
                                <div class="row">
                                    <div class="col-12"><h4 class="text-center">Измеренная толщина, мм</h4></div>
                                    <div class="col-2">
                                        <label>Сечение 1</label>
                                        <input type="text" class="form-control" name="measure_1">
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 3</label>
                                        <input type="text" class="form-control" name="measure_2">
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 3</label>
                                        <input type="text" class="form-control" name="measure_3">
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 4</label>
                                        <input type="text" class="form-control" name="measure_4">
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 5</label>
                                        <input type="text" class="form-control" name="measure_5">
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 6</label>
                                        <input type="text" class="form-control" name="measure_6">
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 7</label>
                                        <input type="text" class="form-control" name="measure_7">
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 8</label>
                                        <input type="text" class="form-control" name="measure_8">
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 9</label>
                                        <input type="text" class="form-control" name="measure_9">
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 10</label>
                                        <input type="text" class="form-control" name="measure_10">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12"><h4 class="text-center">Предельно-допустимая толщина, мм</h4></div>
                                    <div class="col-2">
                                        <label>Сечение 1</label>
                                        <input type="text" id="type_measure_1" class="form-control" readonly>
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 2</label>
                                        <input type="text" id="type_measure_2" class="form-control" readonly>
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 3</label>
                                        <input type="text" id="type_measure_3" class="form-control" readonly>
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 4</label>
                                        <input type="text" id="type_measure_4" class="form-control" readonly>
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 5</label>
                                        <input type="text" id="type_measure_5" class="form-control" readonly>
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 6</label>
                                        <input type="text" id="type_measure_6" class="form-control" readonly>
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 7</label>
                                        <input type="text" id="type_measure_7" class="form-control" readonly>
                                    </div>
                                    <div class="col-2">
                                        <label>Сечение 8</label>
                                        <input type="text" id="type_measure_8" class="form-control" readonly>
                                    </div>
                                    <div class="col-2">
                                    <label>Сечение 9</label>
                                        <input type="text" id="type_measure_9" class="form-control" readonly>
                                    </div>
                                    <div class="col-2">
                                    <label>Сечение 10</label>
                                        <input type="text" id="type_measure_10" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label class="control-label input-label" for="startTime">Результат УЗТ</label>
                                        <select name="uzt_result" class="custom-select">
                                            <option value="Обнаруженные толщины не менее допустимых значений. Годен">Обнаруженные толщины не менее допустимых значений. Годен</option>
                                            <option value="Обнаруженные толщины менее допустимых значений. Негоден">Обнаруженные толщины менее допустимых значений. Негоден</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        {{-- УЗК --}}
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                <label>
                                    <input type="checkbox" id="check-uzk" name="check_uzk" value="1"> УЗК
                                </label>
                            </legend>
                            <div class="control-group" id="block-uzk">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="control-label input-label" for="startTime">Результат УЗК</label>
                                        <select name="uzk_result" class="custom-select">
                                            <option value="Годен">Годен</option>
                                            <option value="Не годен">Не годен</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        {{-- МК --}}
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                <label>
                                    <input type="checkbox" id="check-mk" name="check_mk" value="1"> Магнитно-порошковый контроль
                                </label>
                            </legend>
                            <div class="control-group" id="block-mk">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="area_deffects">Участки с дефектами</label>
                                        <textarea name="area_deffects" id="area_deffects" class="form-control">Отсутствуют</textarea>
                                    </div>
                                    <div class="col-6">
                                        <label for="deffects_size">Дефекты и их размеры</label>
                                        <input type="text" name="deffects_size" id="deffects_size" class="form-control" value="Не обнаружены">
                                    </div>
                                    <div class="col-6">
                                        <label for="mk_result">Вывод МК</label>
                                        <select name="mk_result" id="mk_result" class="form-control">
                                            <option value="Годен">Годен</option>
                                            <option value="Не годен">Не годен</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        {{-- ГИ --}}
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                <label>
                                    <input type="checkbox" id="check-gi" name="check_gi" value="1"> Гидравлическое испытание
                                </label>
                            </legend>
                            <div class="control-group" id="block-gi">
                                <div class="row">
                                    <!--<div class="col-12">
                                        <label for="graph">График</label>
                                        <input type="text" name="graph" class="form-control">
                                    </div>-->
                                    <div class="col-3">
                                        <label>Этап опрессовки 1, МПа/Psi<span class="component-measure"></span></label>
                                        <input type="text" id="crimping_1" value="" class="form-control" readonly>
                                    </div>
                                    <div class="col-3">
                                        <label>Продолжительность, мин.</label>
                                        <input type="text" id="period_1" value="5" class="form-control" readonly>
                                    </div>
                                    <div class="col-3">
                                        <label>Этап опрессовки 2, МПа/Psi<span class="component-measure"></span></label>
                                        <input type="text" id="crimping_2" value="" class="form-control" readonly>
                                    </div>
                                    <div class="col-3">
                                        <label>Продолжительность, мин.</label>
                                        <input type="text" id="period_2" value="5" class="form-control" readonly>
                                    </div>
                                    <div class="col-3">
                                        <label>Этап опрессовки 3, МПа/Psi<span class="component-measure"></span></label>
                                        <input type="text" id="crimping_3" value="" class="form-control" readonly>
                                    </div>
                                    <div class="col-3">
                                        <label>Продолжительность, мин.</label>
                                        <input type="text" id="period_3" value="10" class="form-control" readonly>
                                    </div>
                                    <div class="col-3">
                                        <label>Этап опрессовки 4, МПа/Psi<span class="component-measure"></span></label>
                                        <input type="text" id="crimping_4" value="" class="form-control" readonly>
                                    </div>
                                    <div class="col-3">
                                        <label>Продолжительность, мин.</label>
                                        <input type="text" id="period_4" value="5" class="form-control" readonly>
                                    </div>
                                    <div class="col-3">
                                        <label>Этап опрессовки 5, МПа/Psi<span class="component-measure"></span></label>
                                        <input type="text" id="crimping_5" value="" class="form-control" readonly>
                                    </div>
                                    <div class="col-3">
                                        <label>Продолжительность, мин.</label>
                                        <input type="text" id="period_5" value="5" class="form-control" readonly>
                                    </div>
                                    <div class="col-3">
                                        <label>Этап опрессовки 6, МПа/Psi<span class="component-measure"></span></label>
                                        <input type="text" id="crimping_6" value="" class="form-control" readonly>
                                    </div>
                                    <div class="col-3">
                                        <label>Продолжительность, мин.</label>
                                        <input type="text" id="period_6" value="10" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label class="control-label input-label" for="startTime">Результат</label>
                                        <select name="gi_result" id="gi_result" class="custom-select">
                                            <option value="" selected disabled> -- Выберите результат -- </option>
                                            <option value="Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность">Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность.</option>
                                            <option value="Узел (объект) не признается выдержавшим гидравлическое испытание на прочность и герметичность">Узел (объект) не признается выдержавшим гидравлическое испытание на прочность и герметичность.</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        {{-- опресовка --}}
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                <label>
                                    <input type="checkbox" id="crimping-gi"> Опрессовка превентора
                                </label>
                            </legend>
                            <div class="control-group" id="crimping-gi">
                                <div class="row mb-2">
                                    <div class="col-2">Диаметр плашки, мм.</div>
                                    <div class="col-2">
                                        <input type="text" id="diameter_plashki" name="diameter_plashki" value="" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="diagramma_crimping_1">Диаграмма №1</label>
                                        <input type="file" class="form-control" name="diagramma_crimping_1">
                                    </div>
                                    <div class="col-4">
                                        <label for="diagramma_crimping_2">Диаграмма №2</label>
                                        <input type="file" class="form-control" name="diagramma_crimping_2">
                                    </div>
                                    <div class="col-4">
                                        <label for="diagramma_crimping_3">Диаграмма №3</label>
                                        <input type="file" class="form-control" name="diagramma_crimping_3">
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
                                            <input type="checkbox" id="calibration-gi"> Тарировка
                                        </label>
                                    </legend>
                                    <div class="control-group" id="calibration-gi">
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <input type="text" id="calibration_pressure" name="calibration_pressure" value="" class="form-control" placeholder="70.0">
                                            </div>
                                            <div class="col-6">Давление тарировки(МПа)</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="diagramma_calibration">Диаграмма</label>
                                                <input type="file" class="form-control" name="diagramma_calibration">
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
                                            <input type="checkbox" id="bgrp-gi"> ПРОБНОЕ ДАВЛЕНИЕ
                                        </label>
                                    </legend>
                                    <div class="control-group" id="bgrp-gi">
                                        <div class="row">
                                            <div class="col-3 text-center">
                                                <input class="form-check-input" type="radio" name="coefficient" value="1.25" id="one_twenty_five">
                                                <label class="form-check-label" for="one_twenty_five">
                                                  1.25x
                                                </label>
                                            </div>
                                            <div class="col-3 text-center">
                                                <input class="form-check-input" type="radio" name="coefficient" value="1.5" id="one_and_five">
                                                <label class="form-check-label" for="one_and_five">
                                                  1.5x
                                                </label>
                                            </div>
                                            <div class="col-3 text-center">
                                                <input class="form-check-input" type="radio" name="coefficient" value="2" id="two">
                                                <label class="form-check-label" for="two">
                                                  2x
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 item-diagramma_bgrp">
                                                <label for="diagramma_bgrp">Диаграмма</label>
                                                <input type="file" class="form-control" name="diagramma_bgrp">
                                                <div class="upload-image">
                                                    <img src="" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-6 passport_create">
                                <label>Оформление паспорта</label>
                                <label>
                                    <input type="checkbox" name="passport" @if($conclusion_last !== null) value="{{ $conclusion_last->passport }}" @elseif('checked') value="1" @else value="0" @endif data-toggle="toggle" data-onstyle="success" data-offstyle="danger" @if($conclusion_last !== null && $conclusion_last->passport == 1) checked @endif> Оформлен паспорт
                                </label>
                                <label>
                                    <input type="checkbox" name="repair" @if($conclusion_last !== null) value="{{ $conclusion_last->repair }}" @elseif('checked') value="1" @else value="0" @endif data-toggle="toggle" data-onstyle="success" data-offstyle="danger" @if($conclusion_last !== null && $conclusion_last->repair == 1) checked @endif> Произведён ремонт
                                </label>
                                <label>
                                    <input type="checkbox" name="no_passportization" @if($conclusion_last !== null) value="{{ $conclusion_last->no_passportization }}" @elseif('checked') value="1" @else value="0" @endif data-toggle="toggle" data-onstyle="success" data-offstyle="danger" @if($conclusion_last !== null && $conclusion_last->no_passportization == 1) checked @endif> Не паспортизируется
                                </label>
                                <label>
                                    <input type="checkbox" name="installing_tape" @if($conclusion_last != null && $conclusion_last->installing_tape == 1) checked @endif data-toggle="toggle" data-onstyle="success" data-offstyle="danger" value="1"> Установка бандажной ленты
                                </label>
                            </div>
                        </div>



                        <br>

                        {{-- Компания (из типов) --}}
                        <input type="hidden" id="company_id" name="company_id" value="">
                        {{--<input type="hidden" id="unit_id" name="unit_id" value="">--}}
                        <input type="hidden" id="component_id" name="component_id" value="">
                        {{--<input type="hidden" id="type_id" name="type_id" value="">--}}
                        <button type="submit" class="btn btn-primary">Добавить</button>
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
        {{-- Проверка срока номера ленты по последнему заключению (12 мес.) --}}
        $('input[name="date"]').change(function() {
            check_date_tape_number();
            check_conclusion_on_tape_and_date();
        });
        
        $('input[name="date_next_verification"]').change(function() {
            check_conclusion_on_tape_and_date();
        });

        setTimeout(function() {
            var tape_number = $('#tape_number').val();
            if(tape_number !== '')
                $('#tape_number').change();
        }, 500);

        function check_date_tape_number()
        {
            var date = $('input[name="date"]').val();
            var tape_number = $('#tape_number').val();

            if(date !== '' && tape_number !== '')
            {
                $.post('{{ route('conclusions.get_last_conclusion_on_tape_number') }}', {'date': date, 'tape_number': tape_number}, function(data) {
                    if(data === 'yes')
                        $('#need_print_tape_number').css('display', 'block');
                    else
                        $('#need_print_tape_number').css('display', 'none');
                });
            } else
                $('#need_print_tape_number').css('display', 'none');
        }
        
        {{-- Проверка заключения по номеру ленты и датам --}}
        function check_conclusion_on_tape_and_date()
        {
            var date = $('input[name="date"]').val();
            var date_next_verification = $('input[name="date_next_verification"]').val();
            var tape_number = $('#tape_number').val();

            if(date !== '' && date_next_verification !== '' && tape_number !== '')
            {
                $.post('{{ route('conclusions.get_conclusion_on_tape_number_and_date') }}', {'date': date, 'date_next_verification': date_next_verification,'tape_number': tape_number, '_token': "{{ csrf_token() }}" }, function(data) {
                    if(data['success'] === 'true')
                    {
                        $('#show_conclusion_tape_and_date').css('display', 'block');
                        $('.cheсk-concl-on-date').html("<a href='"+data['conclusionMatchId']+"/edit'>Заключение</a> с указанными датами проведения уже существует!");
                    } else {
                        $('#show_conclusion_tape_and_date').css('display', 'none');
                    }
                });
            } else {
                $('#show_conclusion_tape_and_date').css('display', 'none');
            }
        }
        
        {{-- Подгрузка данных по номеру ленты --}}
        $('#tape_number').change(function() {
            var current_obj = $(this);
            var tape_number = current_obj.val();
            
            $.post('{{ route('ajax.conclusions.get_data_on_type_number') }}', {'tape_number': tape_number}, function(data) {
                if(data === 'false')
                {
                    $('#error_if_tape_number_not_found').css('display', 'block');
                    $('#need_print_tape_number').css('display', 'block');
                    current_obj.css('border', '1px solid #ff0000');
                } else {
                    {{-- Проверка даты номера ленты --}}
                    check_date_tape_number();
                    check_conclusion_on_tape_and_date();
                    $('#error_if_tape_number_not_found').css('display', 'none');
                    current_obj.css('border', '1px solid green');
                    $('#type_name').val(data['type'].name);
                    $('#type_description').val(data['type'].description + ' ' + '(' + data['type'].manufacturer + ')');
                    $('#partial_number').val(data['type'].partial_number);
                    //$('#company').val(data['component'].company_id);
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
                    //$('#temperature').val(data['last_conclusion'].temperature);
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
                    $('#component_id').val(data['component'].id);
                    $('#companyIdComponent').val(data['company'].id);
                    $('#company_name').val(data['company'].name);

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
                    
                    if(data['last_conclusion'] !== null && data['last_conclusion'].measure_1 !== null) { 
                        $('input[name="measure_1"]').attr('placeholder', data['last_conclusion'].measure_1.replace(',', '.')); 
                        var prev_measure_1 = data['last_conclusion'].measure_1.replace(',', '.');
                    } else {prev_measure_1 = data['last_conclusion'] ? data['last_conclusion'].measure_1 : 0}
                    if(data['last_conclusion'] !== null && data['last_conclusion'].measure_2 !== null) {
                        $('input[name="measure_2"]').attr('placeholder', data['last_conclusion'].measure_2.replace(',', '.'));
                        var prev_measure_2 = data['last_conclusion'].measure_2.replace(',', '.');
                    } else {prev_measure_2 = data['last_conclusion'] ? data['last_conclusion'].measure_2 : 0}
                    if(data['last_conclusion'] !== null && data['last_conclusion'].measure_3 !== null) {
                        $('input[name="measure_3"]').attr('placeholder', data['last_conclusion'].measure_3.replace(',', '.'));
                        var prev_measure_3 = data['last_conclusion'].measure_3.replace(',', '.');
                    } else {prev_measure_3 = data['last_conclusion'] ? data['last_conclusion'].measure_3 : 0}
                    if(data['last_conclusion'] !== null && data['last_conclusion'].measure_4 !== null) {
                        $('input[name="measure_4"]').attr('placeholder', data['last_conclusion'].measure_4.replace(',', '.'));
                        var prev_measure_4 = data['last_conclusion'].measure_4.replace(',', '.');
                    } else {prev_measure_4 = data['last_conclusion'] ? data['last_conclusion'].measure_4 : 0}
                    if(data['last_conclusion'] !== null && data['last_conclusion'].measure_5 !== null) {
                        $('input[name="measure_5"]').attr('placeholder', data['last_conclusion'].measure_5.replace(',', '.'));
                        var prev_measure_5 = data['last_conclusion'].measure_5.replace(',', '.');
                    } else {prev_measure_5 = data['last_conclusion'] ? data['last_conclusion'].measure_5 : 0}
                    if(data['last_conclusion'] !== null && data['last_conclusion'].measure_6 !== null) {
                        $('input[name="measure_6"]').attr('placeholder', data['last_conclusion'].measure_6.replace(',', '.'));
                        var prev_measure_6 = data['last_conclusion'].measure_6.replace(',', '.');
                    } else {prev_measure_6 = data['last_conclusion'] ? data['last_conclusion'].measure_6 : 0}
                    if(data['last_conclusion'] !== null && data['last_conclusion'].measure_7 !== null) {
                        $('input[name="measure_7"]').attr('placeholder', data['last_conclusion'].measure_7.replace(',', '.'));
                        var prev_measure_7 = data['last_conclusion'].measure_7.replace(',', '.');
                    } else {prev_measure_7 = data['last_conclusion'] ? data['last_conclusion'].measure_7 : 0}
                    if(data['last_conclusion'] !== null && data['last_conclusion'].measure_8 !== null) {
                        $('input[name="measure_8"]').attr('placeholder', data['last_conclusion'].measure_8.replace(',', '.'));
                        var prev_measure_8 = data['last_conclusion'].measure_8.replace(',', '.');
                    } else {prev_measure_8 = data['last_conclusion'] ? data['last_conclusion'].measure_8 : 0}
                    if(data['last_conclusion'] !== null && data['last_conclusion'].measure_9 !== null) {
                        $('input[name="measure_9"]').attr('placeholder', data['last_conclusion'].measure_9.replace(',', '.'));
                        var prev_measure_9 = data['last_conclusion'].measure_9.replace(',', '.');
                    } else {prev_measure_9 = data['last_conclusion'] ? data['last_conclusion'].measure_9 : 0}
                    if(data['last_conclusion'] !== null && data['last_conclusion'].measure_10 !== null) {
                        $('input[name="measure_10"]').attr('placeholder', data['last_conclusion'].measure_10.replace(',', '.'));
                        var prev_measure_10 = data['last_conclusion'].measure_10.replace(',', '.');
                    } else {prev_measure_10 = data['last_conclusion'] ? data['last_conclusion'].measure_10 : 0}
                    
                    // сверяем введенные данные
                    $('input[name="measure_1"]').on("input",function(ev){
                        let next_measure_1 = $(ev.target).val().replace(',', '.');
                        if(Number(next_measure_1) > Number(prev_measure_1))
                        {
                            $('input[name="measure_1"]').css('border', '1px solid #ff0000');
                        } else {
                            $('input[name="measure_1"]').css('border', '1px solid #28a745');
                        }
                    });
                    $('input[name="measure_2"]').on("input",function(ev){
                        let next_measure_2 = $(ev.target).val().replace(',', '.');
                        if(Number(next_measure_2) > Number(prev_measure_2))
                        {
                            $('input[name="measure_2"]').css('border', '1px solid #ff0000');
                        } else {
                            $('input[name="measure_2"]').css('border', '1px solid #28a745');
                        }
                    });
                    $('input[name="measure_3"]').on("input",function(ev){
                        let next_measure_3 = $(ev.target).val().replace(',', '.');
                        if(Number(next_measure_3) > Number(prev_measure_3))
                        {
                            $('input[name="measure_3"]').css('border', '1px solid #ff0000');
                        } else {
                            $('input[name="measure_3"]').css('border', '1px solid #28a745');
                        }
                    });
                    $('input[name="measure_4"]').on("input",function(ev){
                        let next_measure_4 = $(ev.target).val().replace(',', '.');
                        if(Number(next_measure_4) > Number(prev_measure_4))
                        {
                            $('input[name="measure_4"]').css('border', '1px solid #ff0000');
                        } else {
                            $('input[name="measure_4"]').css('border', '1px solid #28a745');
                        }
                    });
                    $('input[name="measure_5"]').on("input",function(ev){
                        let next_measure_5 = $(ev.target).val().replace(',', '.');
                        if(Number(next_measure_5) > Number(prev_measure_5))
                        {
                            $('input[name="measure_5"]').css('border', '1px solid #ff0000');
                        } else {
                            $('input[name="measure_5"]').css('border', '1px solid #28a745');
                        }
                    });
                    $('input[name="measure_6"]').on("input",function(ev){
                        let next_measure_6 = $(ev.target).val().replace(',', '.');
                        if(Number(next_measure_6) > Number(prev_measure_6))
                        {
                            $('input[name="measure_6"]').css('border', '1px solid #ff0000');
                        } else {
                            $('input[name="measure_6"]').css('border', '1px solid #28a745');
                        }
                    });
                    $('input[name="measure_7"]').on("input",function(ev){
                        let next_measure_7 = $(ev.target).val().replace(',', '.');
                        if(Number(next_measure_7) > Number(prev_measure_7))
                        {
                            $('input[name="measure_7"]').css('border', '1px solid #ff0000');
                        } else {
                            $('input[name="measure_7"]').css('border', '1px solid #28a745');
                        }
                    });
                    $('input[name="measure_8"]').on("input",function(ev){
                        let next_measure_8 = $(ev.target).val().replace(',', '.');
                        if(Number(next_measure_8) > Number(prev_measure_8))
                        {
                            $('input[name="measure_8"]').css('border', '1px solid #ff0000');
                        } else {
                            $('input[name="measure_8"]').css('border', '1px solid #28a745');
                        }
                    });
                    $('input[name="measure_9"]').on("input",function(ev){
                        let next_measure_9 = $(ev.target).val().replace(',', '.');
                        if(Number(next_measure_9) > Number(prev_measure_9))
                        {
                            $('input[name="measure_9"]').css('border', '1px solid #ff0000');
                        } else {
                            $('input[name="measure_9"]').css('border', '1px solid #28a745');
                        }
                    });
                    $('input[name="measure_10"]').on("input",function(ev){
                        let next_measure_10 = $(ev.target).val().replace(',', '.');
                        if(Number(next_measure_10) > Number(prev_measure_10))
                        {
                            $('input[name="measure_10"]').css('border', '1px solid #ff0000');
                        } else {
                            $('input[name="measure_10"]').css('border', '1px solid #28a745');
                        }
                    });
                    
                    // $('#unit_id').val(data['type'].unit_id);
                    // $('#type_id').val(data['type'].id);
                    $('.component-measure').html(data['component'].measure);
                    // $('#ust').html(data['component'].data-facility_name);

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
        $('#block-mk input').attr('disabled','true');
        $('#block-mk select').attr('disabled','true');
        $('#block-mk textarea').attr('disabled','true');

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
        } else {
            $('#block-vik input').attr('disabled','true');
            $('#block-vik select').attr('disabled','true');
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
        $('#crimping-gi').attr('disabled','true');
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
        $('#calibration-gi').attr('disabled','true');
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
        $('#bgrp-gi').attr('disabled','true');
        $('#bgrp-gi input').attr('disabled','true');
        $('#bgrp-gi select').attr('disabled','true');

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
        #error_if_tape_number_not_found, #need_print_tape_number, #show_conclusion_tape_and_date {
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