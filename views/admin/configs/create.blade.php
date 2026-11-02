@extends('layouts.template')
@section('title', 'Новый параметр')


@section('header')
    <h4>
        <a href="{{ route('configs.index') }}">Список параметров</a> / Новый
    </h4>
@endsection


@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Заполните информацию по новому параметру</div>
                <div class="card-body">
                    <form action="{{ route('configs.store') }}" method="POST">
                        @csrf
                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Тип</h4>
                            <input type="text" class="form-control" name="type" required>
                        </div>
                        <hr>

                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Название</h4>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <hr>

                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Ключ</h4>
                            <input type="text" class="form-control" name="key" required>
                        </div>
                        <hr>

                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Значение</h4>
                            <input type="text" class="form-control" name="value" required>
                        </div>

                        <br>

                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection