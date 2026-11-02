@extends('layouts.template')
@section('title', 'Список компонентов')

@section('header')
    <h4>Список компонентов</h4>
@endsection

@section('content')
    @if(Auth::user()->role == 'Администратор' || Auth::user()->role == 'Работник лаборатории')
    <div class="row">
        <div class="col-2">
            <a href="{{ route('components.create') }}" class="btn btn-primary">Добавить</a>
        </div>
   
    </div>
    <hr>
     @endif
    <h4>Фильтры</h4>
    @include('admin.components.filter')
    <hr>

    <div class="scroller mb-5" style="text-align: center;">
        <table class="table table-bordered datatable" id="viewTable">
            <thead>
            @if(count($components) > 0)
                <tr>
                    <th>№</th>
                    <th>Наименование</th>
                    <th>Характеристики</th>
                    <th>Партийный номер</th>
                    <th>Серийный номер</th>
                    <th>Организация владелец</th>
                    <th>Номер флота/установки</th>
                    <th>Номер бандажной ленты</th>
                    <!--<th>Замеры</th>-->
                    <th>Дата начала</th>
                    <!--<th>Эскиз</th>-->
                    <!--<th>Комментарий</th>-->
                    @if(Auth::user()->role == 'Администратор' || Auth::user()->role == 'Работник лаборатории')
                        <th>Действия</th>
                    @endif
                </tr>
            @endif
            </thead>
            <tbody>
            @if(count($components) < 1)
                <div class="alert alert-danger" role="alert">
                    Не добавлено ещё ни одного компонента
                </div>
            @else
                @foreach($components as $idx => $component)
                @if(isset($component->company()->id))
                    <tr> 
                        <td>{{ $idx + 1 }}</td>
                        <td>{{ $component->type()->name }}</td>
                        <td>{{ $component->type()->description }}</td>
                        <td>{{ $component->type()->partial_number }}</td>
                        <td>{{ $component->serial_number }}</td>
                        <td>{{ $component->company()->name }}</td>
                        <td>{{ $component->facility()->number. ' '.$component->facility()->gos_number.' '  .$component->facility()->area }}</td>
                        <td>{{ $component->tape_number }}</td>
                        <td>{{ $component->get_formed_date_component($component->date_start_expluatation) }}</td>
                        
                        <!--<td>{{ $component->comment }}</td>-->
                        @if(Auth::user()->role == 'Администратор' || Auth::user()->role == 'Работник лаборатории')
                        <td>
                            <button type="button" class="btn btn-dark btn-xs get-histories" data-toggle="modal" data-component_id="{{ $component->id }}" data-target="#histories"><i class="fas fa-history"></i></button>
                            <a class="btn btn-xs btn-dark" href="{{ route('conclusions.create.tape_number', ['tape_number' => $component->tape_number]) }}">
                                <i class="fas fa-folder-plus"></i>
                            </a>
                            <a class="btn btn-xs btn-success" href="{{ route('components.edit', ['id' => $component->id]) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-xs btn-danger" onclick="if(confirm('Подтвердите удаление компонента: {{ $component->name }}')){$('#item_{{ $component->id }}_delete').submit();}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <form action="{{ route('components.destroy', ['id' => $component->id]) }}" id="item_{{ $component->id }}_delete" method="POST">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                        @endif
                    </tr>
                    @endif
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    </table>
   @include('admin.components.histories')
@endsection


@section('js')
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.11.4/i18n/ru.json"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {

            {{-- Смена компании --}}
            $('select[name="components_company_id"]').change(function() {
                var company_id = $('select[name="components_company_id"]').val();
                var work_location_id = $('select[name="components_work_locations"]').val();
                var facility_id = $('select[name="components_facilities"]').val();
                var token = $('input[name="_token"]').val();
                if(company_id !== '')
                {
                    var token = $('input[name="_token"]').val();
                    $.post('{{ route('components.get_info_for_filters') }}', {'_token': token, 'company_id': company_id, 'work_location_id': work_location_id, 'facility_id': facility_id}, function(data) {
                        set_work_locations(data);
                        set_facilities(data);
                        //set_dates(data);
                        // ++ 02/09/2026
                        set_manufacturers(data);
                    });
                }
            });
            
            {{-- Смена места проведения работ --}}
            $('select[name="components_work_locations"]').change(function() {
                var company_id = $('select[name="components_company_id"]').val();
                var work_location_id = $('select[name="components_work_locations"]').val();
                var facility_id = $('select[name="components_facilities"]').val();
                var token = $('input[name="_token"]').val();
                $.post('{{ route('components.get_info_for_filters') }}', {'_token': token, 'company_id': company_id, 'work_location_id': work_location_id, 'facility_id': facility_id}, function(data) {
                    set_facilities(data);
                    //set_dates(data);
                     // ++ 02/09/2026
                    set_manufacturers(data);
                });
            });
            
            {{-- Смена установки --}}
            $('select[name="components_facilities"]').change(function() {
                var company_id = $('select[name="components_company_id"]').val();
                var work_location_id = $('select[name="components_work_locations"]').val();
                var facility_id = $('select[name="components_facilities"]').val();
                var token = $('input[name="_token"]').val();

                $.post('{{ route('components.get_info_for_filters') }}', {'_token': token, 'company_id': company_id, 'work_location_id': work_location_id, 'facility_id': facility_id}, function(data) {
                    //set_dates(data);
                    // ++ 02/09/2026
                    set_manufacturers(data);
                });
            });

            {{-- Подстановка мест проведения работ --}}
            function set_work_locations(data)
            {
                var locations = '<option value=""></option>';
                $.each(data['work_locations'], function(key, value) {
                    locations += '<option value="'+value.id+'">'+value.name+'</option>';
                });
                $('select[name="components_work_locations"]').html(locations);
            }

            {{-- Подстановка установок --}}
            function set_facilities(data)
            {
                var facilities = '<option value=""></option>';
                $.each(data['facilities'], function(key, value) {
                    facilities += '<option value="'+value.id+'">'+value.number+' '+value.gos_number+' '+value.area+'</option>';
                });
                $('select[name="components_facilities"]').html(facilities);
            }

            {{-- Подстановка дат заключений --}}
            function set_dates(data)
            {
                var dates = '<option value=""></option>';
                $.each(data['dates'], function(key, value) {
                    date = value.date.split('-');
                    dates += '<option value="'+value.date+'">'+date[2]+'.'+date[1]+'.'+date[0]+'</option>';
                });
                $('select[name="components_date"]').html(dates);
            }
            
            // ++ 02/09/2026 Подстановка производителей
            function set_manufacturers(data)
            {
                var manufacturers = '<option value=""></option>';
                $.each(data['manufacturers'], function(key, value) {
                    manufacturers += '<option value="'+value.manufacturer+'">'+value.manufacturer+'</option>';
                });
                $('select[name="type_manufacturers"]').html(manufacturers);
            }
            // -- 02/09/2026

            {{-- История компонента --}}
            $('.get-histories').click(function() {
                var obj = $(this);
                var component_id = obj.data('component_id');
                var token = $('input[name="_token"]').val();
                $.post('{{ route('components.histories') }}', {'_token': token, 'component_id': component_id}, function(data) {
                    let date_update = data['component'].date_update !== null ? data['component'].date_update : '-';
                    let user_action = data['component'].user_action !== null ? data['component'].user_action : '-';
                    let user_update_name = data['component'].user_id_update !== null ? data['user_update'].name : '-';
                    var result = '<tr><td>' + date_update + '</td><td>'+ user_action +'</td><td>' + user_update_name + '</td></tr>';
                    //console.log(data['component'].date_update);
                    $('#histories tbody').html(result);
                });
            });
            
            // ++ 01/09/2026
            $('#type_manufacturers').select2();
            $('#components_facilities').select2();
            $('#components_work_locations').select2();
            $('#components_company_id').select2();
            // -- 01/09/2026

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
        });

    </script>
@endsection


@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet">
@endsection