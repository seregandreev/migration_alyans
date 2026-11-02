@extends('layouts.template')
@section('title', 'Список изменений')

@section('header')
    <h4>Список изменений</h4>
@endsection

@section('content')

    <a href="{{ route('news.create') }}" class="btn btn-primary">Добавить</a>
    <hr>

    <div class="scroller">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Дата</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @if($news->count() == 0)
                    <tr>
                        <th colspan="3">Список новостей пуст</th>
                    </tr>
                @else
                    @foreach($news as $news_data)
                        <tr>
                            <td>{{ $news_data->title }}</td>
                            <td>{{ $news_data->created_at }}</td>
                            <td>
                                <a href="{{ route('news.edit', ['id' => $news_data->id]) }}" class="btn btn-success">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger" onclick="if(confirm('Подтвердите удаление новости: {{ $news_data->created_at }}')){$('#item_{{ $news_data->id }}_delete').submit();}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <form action="{{ route('news.destroy', ['id' => $news_data->id]) }}" id="item_{{ $news_data->id }}_delete" method="POST">
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