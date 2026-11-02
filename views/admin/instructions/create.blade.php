@extends('layouts.template')
@section('title', 'Список инструкций. Новая')

@section('header')
    <h4><a href="{{ route('admin.instructions') }}">Список инструкций</a> / Новая</h4>
@endsection

@section('content')
    <div class="col-12 col-md-6 offset-md-3">
        <div class="card">
            <div class="card-header">Новая инструкция</div>
            <div class="card-body">
                <form action="{{ route('admin.instructions.store') }}" method="POST">
                    @csrf
                    {{-- Название --}}
                    <div class="row">
                        <div class="col-12">
                            <label>Название</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                    </div>
                    {{-- Инструкция --}}
                    <div class="row">
                        <div class="col-12">
                            <label>Содержание</label>
                            <textarea name="content" class="form-control summernote" required></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <br>
                            <button type="submit" class="btn btn-primary">Добавить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/summernote/summernote.css') }}">
@endsection

@section('js')
    <script src="{{ asset('css/summernote/summernote.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote();
        });
    </script>
@endsection
