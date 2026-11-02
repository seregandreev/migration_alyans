<form action="{{ route('acts.accept_filters') }}" method="POST" class="filters">
    @csrf
    <div class="row">
        <div class="col-3">
            <label for="unit_id">Компания</label>
            <select name="company_id" id="company_id" class="form-control" required>
                <option value=""></option>
                @foreach($companies as $company)
{{--                    <option value="{{ $company->id }}" @if(session()->get('filters_acts_company_id') !== null && session()->get('filters_acts_company_id') == $company->id) selected @endif>{{ $company->name }}</option>--}}
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-3">
            <label for="facility">Место пр. контроля</label>
            <select name="work_location_id" class="form-control">
                {{-- Если существует сессия с фильтром, выгружаем сюда данные --}}
                <option value=""></option>
                @foreach($work_locations as $work_location)
{{--                    <option value="{{ $work_location->id }}" @if(session('filters_acts_work_location_id') !== null && session('filters_acts_work_location_id') == $work_location->id) selected @endif>{{ $work_location->name }}</option>--}}
                    <option value="{{ $work_location->id }}">{{ $work_location->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-3">
            <label for="facility">Установка</label>
            <select name="facility_id" class="form-control">
                {{-- Если существует сессия с фильтром, выгружаем сюда данные --}}
                <option value=""></option>
                @foreach($facilities as $facility)
                    {{--<option value="{{ $facility->id }}" @if(session('filters_acts_facility_id') !== null && session('filters_acts_facility_id') == $facility->id) selected @endif>{{ $facility->area }}</option>--}}
                    <option value="{{ $facility->id }}">{{ $facility->number }} {{ $facility->gos_number }} {{ $facility->area }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-3">
            <label for="date">Дата</label>
            <select name="date" id="date" class="form-control">
                <option value=""></option>
                @foreach($conclusions as $conclusion)
                    <option value="{{ $conclusion->date }}">{{ $conclusion->get_format_date() }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-3">
            <label>&nbsp;</label>
            <button type="submit" class="btn btn-primary col-12">Сформировать акт</button>
        </div>
    </div>
</form>

{{-- Форма для сброса фильтров --}}
<form action="{{ route('conclusions.reset_filters') }}" method="POST" id="reset_filters">
    @csrf
</form>