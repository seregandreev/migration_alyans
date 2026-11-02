<form action="{{ route('instruments.accept_filters') }}" method="POST">
    @csrf
    <div class="row">
        <!--{{-- Компания --}}
        <div class="col-12 col-md-3">
            <label>Компания</label>
            <select name="conclusions_company_id" class="form-control">
                <option value=""></option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" @if(session()->get('conclusions_company_id') !== null && session()->get('conclusions_company_id') == $company->id) selected @endif>{{ $company->name }}</option>
                @endforeach
            </select>
        </div>
        {{-- Место проведения работ --}}
        <div class="col-12 col-md-3">
            <label>Место проведения работ</label>
            <select name="conclusions_work_locations" class="form-control">
                <option value=""></option>
                @if(!empty($filter_work_locations))
                    @foreach($filter_work_locations as $work_location)
                        <option value="{{ $work_location->id }}" @if(session('conclusions_work_locations') !== null && session('conclusions_work_locations') == $work_location->id) selected @endif>{{ $work_location->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>-->
        {{-- Метод контроля --}}
        <div class="col-12 col-md-3">
            <label for="control_method">Метод контроля</label>
            <select name="control_method" class="form-control">
                {{-- Если существует сессия с фильтром, выгружаем сюда данные --}}
                <option value=""></option>
                @if(!empty($control_method))
                    <option value="МК" @if(session('control_method') !== null && session('control_method') == 'МК') selected @endif>МК</option>
                    <option value="ВИК" @if(session('control_method') !== null && session('control_method') == 'ВИК') selected @endif>ВИК</option>
                    <option value="УЗТ" @if(session('control_method') !== null && session('control_method') == 'УЗТ') selected @endif>УЗТ</option>
                    <option value="ГИ" @if(session('control_method') !== null && session('control_method') == 'ГИ') selected @endif>ГИ</option>
                    <option value="УЗК" @if(session('control_method') !== null && session('control_method') == 'УЗК') selected @endif>УЗК</option>
                    <option value="ПВК" @if(session('control_method') !== null && session('control_method') == 'ПВК') selected @endif>ПВК</option>
                @endif
            </select>
        </div>
        {{-- Дата поверки --}}
        <div class="col-12 col-md-3">
            <label>Дата поверки</label>
            <select name="instruments_verification_date" class="form-control">
                <option value=""></option>
                @if(!empty($filter_verification_dates))
                    @foreach($filter_verification_dates as $verification_date)
                        <option value="{{ $verification_date->verification_date }}" @if(session('instruments_verification_date') !== null && session('instruments_verification_date') == $verification_date->verification_date) selected @endif>{{ $verification_date->get_format_date() }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        {{-- Дата следующей поверки --}}
        <div class="col-12 col-md-3">
            <label>Дата следующей поверки</label>
            <select name="instruments_next_verification_date" class="form-control">
                <option value=""></option>
                @if(!empty($filter_next_verification_dates))
                    @foreach($filter_next_verification_dates as $next_verification_date)
                        <option value="{{ $next_verification_date->next_verification_date }}" @if(session('instruments_next_verification_date') !== null && session('instruments_next_verification_date') == $next_verification_date->next_verification_date) selected @endif>{{ $next_verification_date->get_format_date() }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        {{-- Инвентарный номер --}}
        <div class="col-12 col-md-3">
            <label for="tape_number">Инвентарный номер</label>
            <input type="text" name="instruments_inventory_number" value="@if(session()->get('instruments_inventory_number') !== null){{ session()->get('instruments_inventory_number') }}@endif" class="form-control">
        </div>
        {{-- Серийный номер --}}
        <div class="col-12 col-md-3">
            <label for="serial_number">Серийный номер</label>
            <input type="text" name="instruments_serial_number" value="@if(session()->get('instruments_serial_number') !== null){{ session()->get('instruments_serial_number') }}@endif" class="form-control">
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
                    <button type="button" class="btn btn-warning col-12" onclick="if(confirm('Подтвердите сброс фильтров')){$('#reset_filters').submit();}"><i style="margin-right:6px;"class="fa fa-filter" aria-hidden="true"></i>Сбросить фильтры</button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- Форма для сброса фильтров --}}
<form action="{{ route('instruments.reset_filters') }}" method="POST" id="reset_filters">
    @csrf
</form>