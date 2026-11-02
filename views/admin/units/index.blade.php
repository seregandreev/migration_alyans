@extends('layouts.template')
@section('title', 'Место проведения работ')

@section('header')
    <h4>Место проведения работ</h4>
@endsection

@section('content')

    <a href="{{ route('units.create') }}" class="btn btn-primary">Добавить</a>
    <hr>

    <div class="scroller">
        <table class="table table-bordered">
            <thead>
            @if(count($units) > 0)
                <tr>
                    <th>Название</th>
                    <th>Город</th>
                    <th>#</th>
                </tr>
            @endif
            </thead>
            <tbody>
            @if(count($units) < 1)
                <div class="alert alert-danger" role="alert">
                    Не добавлено ещё ни одной базы
                </div>
            @else
                @foreach($units as $unit)
                    <tr>
                        <td>{{ $unit->name }}</td>
                        <td>{{ $unit->city }}</td>
                        <td>
                            <a href="{{ route('units.edit', ['id' => $unit->id]) }}">🖊️</a>
                            <button type="button" class="btn btn-link" onclick="if(confirm('Подтвердите удаление базы: {{ $unit->name.' ('.$unit->city.')' }}')){$('#item_{{ $unit->id }}_delete').submit();}">🗑️</button>
                            <form action="{{ route('units.destroy', ['id' => $unit->id]) }}" id="item_{{ $unit->id }}_delete" method="POST">
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