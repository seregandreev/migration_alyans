@extends('layouts.template')
@section('title', 'Список инструментов')

@section('header')
    <h4>Список инструментов</h4>
@endsection

@section('content')

    @if(Auth::user()->role == 'Администратор' || Auth::user()->role == 'Работник лаборатории')
        <a href="{{ route('instruments.create') }}" class="btn btn-primary">Добавить</a>
        <hr>
    @endif

    <form action="{{route('instruments.index')}}" method="get">
    <div class="row">
        <div class="col-12 col-md-4">
            <label for="search_field" class="form-label">Наименование</label>
            <input name="search_field" @if(isset($_GET['search_field'])) value="{{$_GET['search_field']}}" @endif type="text" class="form-control" id="exampleFormControlInput1" placeholder="Введите наименование инструмента">
        </div>
        <div class="col-12 col-md-3">
            <label>Выберите метод</label>
            <select name="control_method" class="form-control">
                <option></option>
                    <option value="МК" @if(isset($_GET['control_method'])) @if($_GET['control_method'] == "МК") selected @endif @endif>МК</option>
                    <option value="ВИК" @if(isset($_GET['control_method'])) @if($_GET['control_method'] == "ВИК") selected @endif @endif>ВИК</option>
                    <option value="УЗТ" @if(isset($_GET['control_method'])) @if($_GET['control_method'] == "УЗТ") selected @endif @endif>УЗТ</option>
                    <option value="ГИ" @if(isset($_GET['control_method'])) @if($_GET['control_method'] == "ГИ") selected @endif @endif>ГИ</option>
                    <option value="УЗК" @if(isset($_GET['control_method'])) @if($_GET['control_method'] == "УЗК") selected @endif @endif>УЗК</option>
                    <option value="ПВК" @if(isset($_GET['control_method'])) @if($_GET['control_method'] == "ПВК") selected @endif @endif>ПВК</option>
            </select>
        </div>
        <div class="col-12 col-md-2">
            <label>Применяется</label><br>
            <input class="form-cotrol" type="radio" name="is_active" value="1" id="is_active" {{ request()->is_active == 1 ? 'checked' : '' }}>
            <label for="is_active">Да</label>
            <label>&nbsp</label>
            <input class="form-cotrol" type="radio" name="is_active" value="0" id="is_not_active" {{ ! request()->is_active ? 'checked' : '' }}>
            <label for="is_not_active">Нет</label>
        </div>
        <div class="col-12 col-md-3">
            <label>&nbsp</label><br>
            <button type="submit" class="btn btn-primary">Поиск</button>
            <label>&nbsp</label>
            <a href="{{route('instruments.index')}}" class="btn btn-warning">Сброс</a>
        </div>
    </div>
    </form>
    <hr>
    <div class="scroller mb-5">
        <table class="table table-bordered datatable">
            <thead>
            @if(count($instruments) > 0)
                <tr>
                    <th>№</th>
                    <th>Наименование</th>
                    <th>Модель</th>
                    <th>Метод контроля</th>
                    <th>Заводской номер</th>
                    <th>Инвентарный номер</th>
                    <th>Назначение</th>
                    <th>Номер свидетельства</th>
                    <th>Дата поверки</th>
                    <th>Дата следующей поверки</th>
                    <th>Скан паспорта прибора</th>
                    <th>Скан свидетельства</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            @endif
            </thead>
            <tbody>
            @if(count($instruments) < 1)
                <div class="alert alert-danger" role="alert">
                    Не добавлено ещё ни одного инструмента
                </div>
            @else
                @foreach($instruments as $idx => $instrument)
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td>{{ $instrument->name }}</td>
                        <td>{{ $instrument->model }}</td>
                        <td>{{ $instrument->control_method }}</td>
                        <td>{{ $instrument->serial_number }}</td>
                        <td>{{ $instrument->inventory_number }}</td>
                        <td>{{ $instrument->purpose }}</td>
                        <td>{{ $instrument->sertificate_number }}</td>
                        <td>{{ $instrument->format_date($instrument->verification_date) }}</td>
                        <td>{{ $instrument->format_date($instrument->next_verification_date) }}</td>
                        <td style="text-align: center;">
                            @if(isset($instrument->scan_passport) && file_exists(public_path($instrument->scan_passport)))
                                <a href="{{ asset($instrument->scan_passport) }}" data-fancybox="gallery" target="_blank">Просмотреть паспорт</a>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if(isset($instrument->scan_sertificate) && file_exists(public_path($instrument->scan_sertificate)))
                                <a href="{{ asset($instrument->scan_sertificate) }}" data-fancybox="gallery" target="_blank">Просмотреть сертификат</a>
                            @endif
                        </td>
                        <td>
                            @if($instrument->yes_instrument == 1)<span style="font-weight: 700; color: #28a745;"> Применяется </span>
                            @else<span style="font-weight: 700; color: #ff0000;"> Не применяется </span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('instruments.edit', ['id' => $instrument->id]) }}" class="btn btn-success">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" onclick="if(confirm('Подтвердите удаление инструмента: {{ $instrument->name }}')){$('#item_{{ $instrument->id }}_delete').submit();}" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <form action="{{ route('instruments.destroy', ['id' => $instrument->id]) }}" id="item_{{ $instrument->id }}_delete" method="POST">
                                @csrf
                                @method('delete')
                            </form>
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
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.11.4/i18n/ru.json"></script>>
    <script>
           $('.datatable').DataTable({
                language: {
                    processing: "Подождите...",
                    loadingRecords: "Загрузка записей...",
                    emptyTable: "В таблице отсутствуют данные",
                    lengthMenu: "Показать _MENU_ записей",
                    search: "Поиск:",
                    info: "Записи с _START_ до _END_ из _TOTAL_ записей",
                    infoEmpty: "Записи с 0 до 0 из 0 записей",
                    infoFiltered: "",
                    previous: "Предыдущая",
                    next: "Следующая",
                    last: "Последняя",
                    Show: "Показать",
                    paginate: {
                        first: "Первая",
                        previous: "Предыдущая",
                        next: "Следующая",
                        last: "Последняя"
                    },
                }
            });
    </script>
@endsection


@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <style>
    .instrument_yes{
        background: #28a745;
    }
    .instrument_no{
        background: #f80b24;
    }
    </style>
@endsection