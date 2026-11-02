<form action="{{ route('conclusions.accept_filters') }}" method="POST">
    @csrf
    @if(Auth::user()->role == 'Администратор' || Auth::user()->role == 'Работник лаборатории')
    <div class="row">
        {{-- Компания --}}
        <div class="col-12 col-md-3">
            <label>Компания</label>
            <select name="conclusions_company_id" id="conclusions_company" class="form-control">
                <option value=""></option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" @if(session()->get('conclusions_company_id') !== null && session()->get('conclusions_company_id') == $company->id) selected @endif>{{ $company->name }}</option>
                @endforeach
            </select>
        </div>
        {{-- Место проведения работ --}}
        <div class="col-12 col-md-3">
            <label>Место проведения работ</label>
            <select name="conclusions_work_locations" id="conclusions_work_locations" class="form-control">
                <option value=""></option>
                @if(!empty($filter_work_locations))
                    @foreach($filter_work_locations as $work_location)
                        <option value="{{ $work_location->id }}" @if(session()->get('conclusions_work_locations') !== null && session()->get('conclusions_work_locations') == $work_location->id) selected @endif>{{ $work_location->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        {{-- Установка --}}
        <div class="col-12 col-md-3">
            <label for="conclusions_facilities">Установка</label>
            <select name="conclusions_facilities" id="conclusions_facilities" class="form-control">
                {{-- Если существует сессия с фильтром, выгружаем сюда данные --}}
                <option value=""></option>
                @if(!empty($filter_facilities))
                    @foreach($filter_facilities as $facility)
                        <option value="{{ $facility->id }}" @if(session()->get('conclusions_facilities') !== null && session()->get('conclusions_facilities') == $facility->id) selected @endif>{{ $facility->number.' '.$facility->gos_number.' '.$facility->area }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        {{-- Дата --}}
        <div class="col-12 col-md-3">
            <label>Дата</label>
            <select name="conclusions_date" class="form-control">
                <option value=""></option>
                @if(!empty($filter_dates))
                    @foreach($filter_dates as $date)
                        <option value="{{ $date->date }}" @if(session()->get('conclusions_date') !== null && session()->get('conclusions_date') == $date->date) selected @endif>{{ $date->get_format_date() }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        {{-- Номер ленты --}}
        <div class="col-12 col-md-3">
            <label for="tape_number">Номер ленты</label>
            <input type="text" name="conclusions_tape_number" value="@if(session()->get('conclusions_tape_number') !== null){{ session()->get('conclusions_tape_number') }}@endif" class="form-control">
        </div>
        {{-- Серийный номер --}}
        <div class="col-12 col-md-3">
            <label for="serial_number">Серийный номер</label>
            <input type="text" name="conclusions_serial_number" value="@if(session()->get('conclusions_serial_number') !== null){{ session()->get('conclusions_serial_number') }}@endif" class="form-control">
        </div>
        {{-- Производитель типа --}}
        <div class="col-12 col-md-3">
            <label for="type_manufacturers">Производитель</label>
            <select name="type_manufacturers" id="type_manufacturers" class="form-control">
                {{-- выгружаем всех производителей --}}
                <option value=""></option>
                @if(!empty($types))
                    @foreach($types as $type)
                        <option value="{{ $type->manufacturer }}" @if(session()->get('type_manufacturers') !== null && session()->get('type_manufacturers') == $type->manufacturer) selected @endif>{{ $type->manufacturer }}</option>
                    @endforeach
                @endif
            </select>
        </div> 
        {{-- ЭЦП --}}
        <!--<div class="col-2">
            <label for="ecp_label" style="padding-top: 30px;">
                <input type="checkbox" id="ecp_label" @if($ecp->value == 'on') checked @endif> ЭЦП
            </label>
        </div>
        <div id="peshat" class="col-2">
           <img width="250px"  src="http://bd.ndc-lab.ru/img/peshat.png"/>
        </div>-->
    </div>

    <div class="row">

        <div class="col-12">
            <div class="row">
                <div class="col-4">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary col-12"><i style="margin-right:6px;" class="fa fa-search" aria-hidden="true"></i>Найти</button>
                </div>
                <div class="col-4">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-warning col-12" onclick="if(confirm('Подтвердите сброс фильтров')){$('#reset_filters').submit();}"><i style="margin-right:6px;"class="fa fa-filter" aria-hidden="true"></i>Сбросить фильтры </button>
                </div>
                <div class="col-4">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-info col-12" onclick="if(confirm('Показать все')){$('#show_all').submit();}"><i style="margin-right:6px;"class="fa fa-list-ul" aria-hidden="true"></i>Показать все записи </button>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row signature-block">
        {{-- Печать --}}
        <div class="col-2">
            <label for="stamp_label" style="padding-top: 30px;">
                <input type="checkbox" id="stamp_label" @if($stamp->value == "on") checked @endif> Печать в заключениях
            </label>
        </div>
        <!--<div id="peshat" class="col-3" @if($stamp->value == "on") checked style="display: block;" @else style="display: none;" @endif>
            <img width="250px" src="{{ asset('config_data/stamp.png') }}">
        </div>-->
        {{-- Отпечаток ЭЦП --}}
        <div class="col-2">
            <label for="ecp_label" style="padding-top: 30px;">
                <input type="checkbox" id="ecp_label" @if($ecp->value == "on") checked @endif> Отпечаток ЭЦП
            </label>
        </div>
        <!--<div id="ecp" class="col-3" @if($ecp->value == "on") checked style="display: block;" @else style="display: none;" @endif>
            <img width="250px" src="{{ asset('config_data/ecpPrint.png') }}">
        </div>-->
        {{-- Факсимиле директора --}}
        <div class="col-2">
            <label for="sign_director_label" style="padding-top: 30px;">
                <input type="checkbox" id="sign_director_label" @if($signDirector->value == "on") checked @endif> Факсимиле директора
            </label>
        </div>
        <!--<div id="sign_director" class="col-2" @if($signDirector->value == "on") checked style="display: block;" @else style="display: none;" @endif>
            <img width="100px" src="{{ asset('config_data/signDirector.png') }}">
        </div>-->
        {{-- Факсимиле инспектора --}}
        <div class="col-2">
            <label for="sign_inspector_label" style="padding-top: 30px;">
                <input type="checkbox" id="sign_inspector_label" @if($signInspector->value == "on") checked @endif> Факсимиле инспектора
            </label>
        </div>
    </div>
    @endif
    <!--<div class="row">
        <div class="col-12">
            <ul class="nav nav-pills" id="reports">
                <li class="nav-item">
                    <a class="btn btn-primary" href="{{ route('reports.general.passport') }}" target="_blank">Паспорт</a>
                </li>
                @if(session()->get('conclusion_unit_id') !== null && session()->get('conclusion_facility') !== null && session()->get('conclusion_date') !== null)
                    <li class="nav-item">
                        <a class="btn btn-primary" href="{{ route('reports.general.all') }}" target="_blank">Общий отчёт</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="btn btn-primary" href="{{ route('reports.general.vik') }}" target="_blank">ВИК</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary" href="{{ route('reports.general.uzt') }}" target="_blank">УЗК</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary" href="{{ route('reports.general.mk') }}" target="_blank">МК</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary" href="{{ route('reports.general.gi') }}" target="_blank">ГИ</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary" href="{{ route('reports.general.excel') }}" target="_blank"><i class="fa fa-file-excel-o"></i>Общий отчёт в Excel</a>
                </li>
                {{-- Печать ленты --}}
                <li class="nav-item">
                    <a class="btn btn-dark" href="{{ route('conclusions.print_lengths') }}" target="_blank"><i class="fas fa-print"></i> Печать ленты</a>
                </li>
                 {{-- Общий отчет --}}
                 <li class="nav-item">
                    <a class="btn btn-secondary" href="{{ route('reports.general.all') }}" target="_blank"><i class="fa fa-gears"></i> Общий отчет</a>
                </li>
            </ul>
        </div>
    </div>-->
    
    @if(Auth::user()->role == 'Пользователь')
    {{-- Фильтр для пользователя --}}
    <div class="row">
        {{-- Компания --}}
        <div class="col-12 col-md-3">
            <label>Компания</label>
            <select name="conclusions_company_id" class="form-control">
                <option value=""></option>
                @foreach($selectCompany as $company)
                    <option value="{{ $company->id }}" @if(session()->get('conclusions_company_id') !== null && session()->get('conclusions_company_id') == $company->id) selected @endif>{{ $company->name }}</option>
                @endforeach
            </select>
        </div>
        {{-- Место проведения работ --}}
        <div class="col-12 col-md-3">
            <label>Место проведения работ</label>
            <select name="conclusions_work_locations" id="conclusions_work_locations" class="form-control">
                <option value=""></option>
                @if(!empty($filter_work_locations))
                    @foreach($filter_work_locations as $work_location)
                        <option value="{{ $work_location->id }}" @if(session()->get('conclusions_work_locations') !== null && session()->get('conclusions_work_locations') == $work_location->id) selected @endif>{{ $work_location->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        {{-- Установка --}}
        <div class="col-12 col-md-3">
            <label for="conclusions_facilities">Установка</label>
            <select name="conclusions_facilities" id="conclusions_facilities"  class="form-control">
                {{-- Если существует сессия с фильтром, выгружаем сюда данные --}}
                <option value=""></option>
                @if(!empty($filter_facilities))
                    @foreach($filter_facilities as $facility)
                        <option value="{{ $facility->id }}" @if(session()->get('conclusions_facilities') !== null && session()->get('conclusions_facilities') == $facility->id) selected @endif>{{ $facility->number.' '.$facility->gos_number.' '.$facility->area }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        {{-- Дата --}}
        <div class="col-12 col-md-3">
            <label>Дата</label>
            <select name="conclusions_date" class="form-control">
                <option value=""></option>
                @if(!empty($filter_dates))
                    @foreach($filter_dates as $date)
                        <option value="{{ $date->date }}" @if(session()->get('conclusions_date') !== null && session()->get('conclusions_date') == $date->date) selected @endif>{{ $date->get_format_date() }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        {{-- Номер ленты --}}
        <div class="col-12 col-md-3">
            <label for="tape_number">Номер ленты</label>
            <input type="text" name="conclusions_tape_number" value="@if(session()->get('conclusions_tape_number') !== null){{ session()->get('conclusions_tape_number') }}@endif" class="form-control">
        </div>
        {{-- Серийный номер --}}
        <div class="col-12 col-md-3">
            <label for="serial_number">Серийный номер</label>
            <input type="text" name="conclusions_serial_number" value="@if(session()->get('conclusions_serial_number') !== null){{ session()->get('conclusions_serial_number') }}@endif" class="form-control">
        </div>
        {{-- Производитель типа --}}
        <div class="col-12 col-md-3">
            <label for="type_manufacturers">Производитель</label>
            <select name="type_manufacturers" id="type_manufacturers" class="form-control">
                {{-- выгружаем всех производителей --}}
                <option value=""></option>
                @if(!empty($types))
                    @foreach($types as $type)
                        <option value="{{ $type->manufacturer }}" @if(session()->get('type_manufacturers') !== null && session()->get('type_manufacturers') == $type->manufacturer) selected @endif>{{ $type->manufacturer }}</option>
                    @endforeach
                @endif
            </select>
        </div> 
    </div>
    <div class="row">
        <div class="col-4">
            <div class="row">
                <div class="col-6">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary col-12"><i style="margin-right:6px;" class="fa fa-search" aria-hidden="true"></i>Найти</button>
                </div>
                <div class="col-6">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-warning col-12" onclick="if(confirm('Подтвердите сброс фильтров')){$('#reset_filters').submit();}"><i style="margin-right:6px;"class="fa fa-filter" aria-hidden="true"></i>Сбросить фильтры </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</form>

{{-- Форма для сброса фильтров --}}
<form action="{{ route('conclusions.reset_filters') }}" method="POST" id="reset_filters">
    @csrf
</form>

{{-- Форма показать все записи --}}
<form action="{{ route('conclusions.show_all') }}" method="POST" id="show_all">
    @csrf
</form>