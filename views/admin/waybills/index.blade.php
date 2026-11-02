@extends('layouts.template')
@section('title', 'Путевые листы')

@section('header')
    <h4>Список путевых листов</h4>
@endsection

@section('content')

    <div class="row">
        <div class="col-2">
            <a href="{{ route('waybills_legkovoy.create') }}" class="btn btn-primary">Добавить легковой</a>
        </div>
        <div class="col-2">
            <a href="{{ route('waybills_cargo.create') }}" class="btn btn-primary">Добавить грузовой</a>
        </div>
        <div class="col-8">
            <form action="{{route('waybills.index')}}" method="get">
                <div class="row">
                    <div class="col-6">
                        <select class="form-control" name="type_waybill">
                            <option value="Легковой">Легковой</option>
                            <option value="Грузовой">Грузовой</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary col-3">Показать</button>
                        <a href="{{route('waybills.index')}}" class="btn btn-warning col-3">Все</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <hr>

    <div class="scroller">
        <table class="table table-bordered" style="font-size: 13px;" id="viewTable">
            <thead>
            @if(count($waybills) > 0)
                <tr>
                    <th>Номер</th>
                    <th>Тип</th>
                    <th>Автомобиль</th>
                    <th>ФИО водителя</th>
                    <th>Срок действия</th>
                    <th>#</th>
                </tr>
            @endif
            </thead>
            <tbody>
            @if(count($waybills) < 1)
                <div class="alert alert-danger" role="alert">
                    Не добавлено ещё ни одного путевого листа
                </div>
            @else
                @foreach($waybills as $waybill)
                    <tr>
                        <td>{{ $waybill->id }}</td>
                        <td>{{ $waybill->type_waybill }}</td>
                        <td>{{ $waybill->transport()->name }}</td>
                        <td>{{ $waybill->driver()->name }}</td>
                        <td>{{ $waybill->get_formed_date_from($waybill->date_from) }} - {{ $waybill->get_formed_date_to($waybill->date_to) }}</td>
                        @if($waybill->type_waybill == 'Легковой')
                        <td class="text-center">
                            <a href="{{ route('print_waybills.legkovoy', ['id' => $waybill->id]) }}" target="_blank" class="btn btn-primary">
                                <i class="fas fa-print"></i>
                            </a>
                            <a href="{{ route('waybills_legkovoy.edit', ['id' => $waybill->id]) }}" class="btn btn-success">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if(Auth::user()->role == 'Администратор')
                            <button type="button" onclick="if(confirm('Подтвердите удаление путевого листа: № {{ $waybill->id }}')){$('#item_{{ $waybill->id }}_delete').submit();}" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <form action="{{ route('waybills_legkovoy.destroy', ['id' => $waybill->id]) }}" id="item_{{ $waybill->id }}_delete" method="POST">
                                @csrf
                                @method('delete')
                            </form>
                            @endif
                        </td>
                        @elseif($waybill->type_waybill == 'Грузовой')
                        <td class="text-center">
                            <a href="{{ route('print_waybills.cargo', ['id' => $waybill->id]) }}" target="_blank" class="btn btn-primary">
                                <i class="fas fa-print"></i>
                            </a>
                            <a href="{{ route('waybills_cargo.edit', ['id' => $waybill->id]) }}" class="btn btn-success">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if(Auth::user()->role == 'Администратор')
                            <button type="button" onclick="if(confirm('Подтвердите удаление путевого листа: № {{ $waybill->id }}')){$('#item_{{ $waybill->id }}_delete').submit();}" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <form action="{{ route('waybills_cargo.destroy', ['id' => $waybill->id]) }}" id="item_{{ $waybill->id }}_delete" method="POST">
                                @csrf
                                @method('delete')
                            </form>
                            @endif
                        </td>
                        @endif
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
<script>
            $(document).ready(function() {
            $('.datatable').DataTable({
                //'paging': false
            });
        });
</script>
@endsection


@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js">
@endsection