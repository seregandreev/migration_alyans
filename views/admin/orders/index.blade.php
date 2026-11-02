@extends('layouts.template')
@section('title', 'Список заявок')

@section('header')
    <h4>Список заявок</h4>
@endsection

@section('content')
    <a href="{{ route('orders.create') }}" class="btn btn-primary">Добавить</a>
    <hr>

    <div class="scroller">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>№ заявки</th>
                    <th>Ответственный</th>
                    <th>Кол-во заключений</th>
                    <th>Статус</th>
                    <th>Комментарий</th>
                    <th>Архив</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr data-order_id="{{ $order->id }}">
                        <td><a href="{{  route('orders.list_conclusions', ['order_id' => $order->id])  }}">{{ $order->id }}</a></td>
                        <td>{{ $order->responsible()->name }}</td>
                        <td>{{ $order->count_conclusions() }}</td>
                        <td>
                            <select name="status" data-order_id="{{ $order->id }}">
                                <option value="Не обработана" @if($order->status == 'Не обработана') selected @endif>Не обработана</option>
                                <option value="В работе" @if($order->status == 'В работе') selected @endif>В работе</option>
                                <option value="В ожидании" @if($order->status == 'В ожидании') selected @endif>В ожидании</option>
                                <option value="Готова" @if($order->status == 'Готова') selected @endif>Готова</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="comment" value="{{ $order->comment }}" placeholder="Комментарий" data-order_id="{{ $order->id }}">
                        </td>
                        <td>
                            <form action="{{ route('admin.orders.archive', $order->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    @if(file_exists(public_path('uploads/orders/'.$order->id.'/archive.zip')))
                                        <div class="col-12 col-lg-12">
                                            <a href="{{ asset('uploads/orders/'.$order->id.'/archive.zip') }}" target="_blank">Скачать</a>
                                        </div>
                                    @endif
                                    <div class="col-12 col-lg-12">
                                        <input type="file" name="archive" class="form-control" accept="application/zip" required>
                                        <button type="submit" class="btn btn-success btn-xs">Загрузить</button>
                                    </div>
                                </div>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('orders.list_conclusions', ['order_id' => $order->id]) }}" class="btn btn-warning" title="Список заключений">
                                <i class="fas fa-clipboard-list"></i>
                            </a>
                            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-success">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-danger" onclick="if(confirm('Подтвердите удаление')){$('#item_{{ $order->id }}_delete').submit();}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <form action="{{ route('orders.destroy', ['id' => $order->id]) }}" id="item_{{ $order->id }}_delete" method="POST">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            {{-- Обновление статуса и комментария заявки --}}
            $('select[name="status"], input[name="comment"]').change(function() {
                var obj = $(this);
                var order_id = obj.data('order_id');
                var status = obj.parent().parent().find('select[name="status"]').val();
                var comment = obj.parent().parent().find('input[name="comment"]').val();

                $.post('{{ route('orders.update_info') }}', {'order_id': order_id, 'status': status, 'comment': comment}, function(data) {});
            });
        });
    </script>
@endsection