@extends('layouts.template')
@section('title', 'Новая заявка')
@section('header')
    <h4>
        <a href="{{ route('orders.index') }}">Список заявок</a> / Новая
    </h4>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Заполните информацию по новой заявке</div>
                <div class="card-body">
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <label>Ответственный</label>
                                <select name="responsible_id" class="form-control" required>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <br>
                        <br>

                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection