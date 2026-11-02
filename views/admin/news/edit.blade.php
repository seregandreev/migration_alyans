@extends('layouts.template')
@section('title', 'Список изменений. Редактирование')
@section('header')
    <h4>
        <a href="{{ route('news.index') }}">Список изменений</a> / {{ $news->title }} (редактирование)
    </h4>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Изменение информации</div>
                <div class="card-body">
                    <form action="{{ route('news.update', $news->id) }}" method="POST">
                        @csrf
                        @method('put')
                        {{-- Заголовок --}}
                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Заголовок</h4>
                            <input type="text" class="form-control" name="title" value="{{ $news->title }}" required>
                        </div>
                        {{-- Изменения --}}
                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Изменения</h4>
                            <textarea name="content" class="form-control summernote" required>{{ $news->content }}</textarea>
                        </div>
                        <br>
                        <br>

                        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                    </form>
                </div>
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
