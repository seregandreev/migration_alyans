@extends('layouts.template')
@section('title', 'Редактирование')


@section('header')
    <h4>
        <a href="{{ route('configs.index') }}">Список параметров</a> / Редактирование
    </h4>
@endsection


@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Редактирование</div>
                <div class="card-body">
                    <form action="{{ route('configs.update', $config->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Тип</h4>
                            <input type="text" class="form-control" name="type" value="{{ $config->type }}" required>
                        </div>
                        <hr>

                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Название</h4>
                            <input type="text" class="form-control" name="name" value="{{ $config->name }}" required>
                        </div>
                        <hr>

                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Ключ</h4>
                            <input type="text" class="form-control" name="key" value="{{ $config->key }}" required>
                        </div>
                        <hr>

                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Значение</h4>
                            <input type="text" class="form-control" name="value" value="{{ $config->value }}" required>
                        </div>

                        <br>

                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection