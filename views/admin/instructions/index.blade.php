@extends('layouts.template')
@section('title', 'Список инструкций')

@section('header')
    <h4>Список инструкций</h4>
@endsection

@section('content')
    @if(Auth::user()->role == 'Администратор' || Auth::user()->role == 'Работник лаборатории')
    <a href="{{ route('admin.instructions.create') }}" class="btn btn-primary">Добавить</a>
    <hr>
    @endif

    <div class="scroller">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Описание</th>
                    @if(Auth::user()->role == 'Администратор' || Auth::user()->role == 'Работник лаборатории')
                        <th>#</th>
                    @endif
                </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->content }}</td>
                    @if(Auth::user()->role == 'Администратор' || Auth::user()->role == 'Работник лаборатории')
                    <td>
                        <a href="{{ route('admin.instructions.edit', $item->id) }}" class="btn btn-success">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-danger" onclick="if(confirm('Подтвердите удаление: {{ $item->name }}')){$('#item_{{ $item->id }}_delete').submit();}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        <form action="{{ route('admin.instructions.destroy', ['id' => $item->id]) }}" id="item_{{ $item->id }}_delete" method="POST">
                            @csrf
                            @method('delete')
                        </form>
                    </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection