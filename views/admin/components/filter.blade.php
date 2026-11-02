<form action="{{ route('components.accept_filters') }}" method="POST">
    @csrf
    <div class="row">
        {{-- Номер ленты --}}
        <div class="col-12 col-md-3">
            <label for="tape_name">Наименование</label>
            <input type="text" name="components_type_name" value="@if(session()->get('components_type_name') !== null){{ session()->get('components_type_name') }}@endif" class="form-control">
        </div>
        {{-- Компания --}}
        <div class="col-12 col-md-3">
            <label>Компания</label>
            <select name="components_company_id" id="components_company_id" class="form-control">
                <option value=""></option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" @if(session()->get('components_company_id') !== null && session()->get('components_company_id') == $company->id) selected @endif>{{ $company->name }}</option>
                @endforeach
            </select>
        </div>
        {{-- Место проведения работ --}}
        <div class="col-12 col-md-3">
            <label>Место проведения работ</label>
            <select name="components_work_locations" id="components_work_locations" class="form-control">
                <option value=""></option>
                @if(!empty($filter_work_locations))
                    @foreach($filter_work_locations as $work_location)
                        <option value="{{ $work_location->id }}" @if(session('components_work_locations') !== null && session('components_work_locations') == $work_location->id) selected @endif>{{ $work_location->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        {{-- Установка --}}
        <div class="col-12 col-md-3">
            <label for="components_facilities">Установка</label>
            <select name="components_facilities" id="components_facilities" class="form-control">
                {{-- Если существует сессия с фильтром, выгружаем сюда данные --}}
                <option value=""></option>
                @if(!empty($filter_facilities))
                    @foreach($filter_facilities as $facility)
                        <option value="{{ $facility->id }}" @if(session('components_facilities') !== null && session('components_facilities') == $facility->id) selected @endif>{{ $facility->number.' '.$facility->gos_number.' '.$facility->area }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        {{-- Дата 
        <div class="col-12 col-md-3">
            <label>Дата</label>
            <select name="components_date" class="form-control">
                <option value=""></option>
                @if(!empty($filter_dates))
                    @foreach($filter_dates as $date)
                        <option value="{{ $date->date_start_expluatation }}" @if(session('components_date') !== null && session('components_date') == $date->date_start_expluatation) selected @endif>{{ $date->get_formed_date_component() }}</option>
                    @endforeach
                @endif
            </select>
        </div> --}}
        {{-- Номер ленты --}}
        <div class="col-12 col-md-3">
            <label for="tape_number">Номер ленты</label>
            <input type="text" name="components_tape_number" value="@if(session()->get('components_tape_number') !== null){{ session()->get('components_tape_number') }}@endif" class="form-control">
        </div>
        {{-- Партийный номер --}}
        <div class="col-12 col-md-3">
            <label for="partial_number">Партийный номер</label>
            <input type="text" name="components_partial_number" value="@if(session()->get('components_partial_number') !== null){{ session()->get('components_partial_number') }}@endif" class="form-control">
        </div>
        {{-- Серийный номер --}}
        <div class="col-12 col-md-3">
            <label for="serial_number">Серийный номер</label>
            <input type="text" name="components_serial_number" value="@if(session()->get('components_serial_number') !== null){{ session()->get('components_serial_number') }}@endif" class="form-control">
        </div>

        {{-- 01/09/2026 Производитель типа --}}
        <div class="col-12 col-md-3">
            <label for="type_manufacturers">Производитель</label>
            <select name="type_manufacturers" id="type_manufacturers" class="form-control">
                {{-- выгружаем всех производителей --}}
                <option value=""></option>
                @if(!empty($filter_manufacturers))
                    @foreach($filter_manufacturers as $type)
                        <option value="{{ $type->manufacturer }}" @if(session()->get('type_manufacturers') !== null && session()->get('type_manufacturers') == $type->manufacturer) selected @endif>{{ $type->manufacturer }}</option>
                    @endforeach
                @endif
            </select>
        </div> 

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
                    <button type="button" class="btn btn-warning col-12" onclick="if(confirm('Подтвердите сброс фильтров')){$('#reset_filters').submit();}"><i style="margin-right:6px;"class="fa fa-filter" aria-hidden="true"></i>Сбросить фильтры</button>
                </div>
                @if(Auth::user()->role == 'Администратор' || Auth::user()->role == 'Работник лаборатории')
                <div class="col-4">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-info col-12" onclick="if(confirm('Показать все')){$('#show_all').submit();}"><i style="margin-right:6px;"class="fa fa-list-ul" aria-hidden="true"></i>Показать все записи</button>
                </div>
                @endif
            </div>
        </div>
    </div>
</form>

{{-- Форма для сброса фильтров --}}
<form action="{{ route('components.reset_filters') }}" method="POST" id="reset_filters">
    @csrf
</form>

{{-- Показать все записи --}}
<form action="{{ route('components.show_all') }}" method="POST" id="show_all">
    @csrf
</form>