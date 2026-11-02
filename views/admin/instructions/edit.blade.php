@extends('layouts.template')
@section('title', 'Список инструкций. Редактирование')

@section('header')
    <h4><a href="{{ route('admin.instructions') }}">Список инструкций</a> / {{ $item->title }} (редактирование)</h4>
@endsection

@section('content')
    <div class="col-12 col-md-6 offset-md-3">
        <div class="card">
            <div class="card-header">Редактирование</div>
            <div class="card-body">
                <form action="{{ route('admin.instructions.update', $item->id) }}" method="POST">
                    @csrf
                    @method('put')
                    {{-- Название --}}
                    <div class="row">
                        <div class="col-12">
                            <label>Название</label>
                            <input type="text" name="title" class="form-control" value="{{ $item->title }}" required>
                        </div>
                    </div>
                    {{-- Инструкция --}}
                    <div class="row">
                        <div class="col-12">
                            <label>Содержание</label>
                            <textarea name="content" class="form-control summernote" required>{!! $item->content !!}</textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <br>
                            <button type="submit" class="btn btn-primary">Сохранить</button>
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
