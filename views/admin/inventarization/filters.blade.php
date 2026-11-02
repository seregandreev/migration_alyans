<div id="filters">
    {{-- Применение фильтров --}}
    <form action="{{ route('admin.inventarization.accept_filters') }}" method="POST">
        @csrf
        <div class="row">
            {{-- Компания --}}
            <div class="col-3">
                <label>Компания</label>
                <select name="filters_inventarization_company_id" class="form-control">
                    <option value=""></option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" @if(session('filters_inventarization_company_id')) selected @endif()>{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>
            {{-- Дата от --}}
            <div class="col-2">
                <label>От</label>
                <input type="date" name="filters_inventarization_date_begin" class="form-control" value="@if(session('filters_inventarization_date_begin')){{ session('filters_inventarization_date_begin') }}@endif">
            </div>
            {{-- Дата до --}}
            <div class="col-2">
                <label>До</label>
                <input type="date" name="filters_inventarization_date_end" class="form-control" value="@if(session('filters_inventarization_date_end')){{ session('filters_inventarization_date_end') }}@endif">
            </div>

            <div class="col-1">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary col-12">
                    <i class="fas fa-check"></i>
                </button>
            </div>
            <div class="col-1">
                <label>&nbsp;</label>
                <button type="button" class="btn btn-danger col-12" onclick="$('#reset_filters').submit();">
                    <i class="fas fa-trash-restore"></i>
                </button>
            </div>
            <div class="col-1">
                <label>&nbsp;</label>
                <a href="{{ route('admin.inventarization.export_xlsx') }}" target="_blank" class="btn btn-warning col-12">
                    <i class="far fa-file-excel"></i>
                </a>
            </div>
        </div>
    </form>

    {{-- Сброс фильтров --}}
    <form action="{{ route('admin.inventarization.reset_filters') }}" id="reset_filters" method="POST">
        @csrf
    </form>
</div>