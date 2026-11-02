@extends('layouts.template')
@section('title', 'Редактирование места проведения работ')


@section('header')
    <h4>
        <a href="{{ route('units.index') }}">Место проведения работ</a> / Редактирование
    </h4>
@endsection


@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Изменение информации</div>
                <div class="card-body">
                    <form action="{{ route('units.update', ['id' => $unit->id]) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Название</h4>
                            <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" name="name" value="{{ $unit->name }}" required>
                            @if($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <hr>

                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Город</h4>
                            <input type="text" class="form-control @if($errors->has('city')) is-invalid @endif" name="city" value="{{ $unit->city }}" required>
                            @if($errors->has('city'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('city') }}</strong>
                                </span>
                            @endif
                        </div>

                        <br>
                        <br>

                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection