@extends('layouts.template')
@section('title')
    {{ $page->title }}
@endsection

@section('header')
    <h4>{{ $page->title }}</h4>
@endsection

@section('content')

    <div class="content-page">
        {!! $page->content !!}
    </div>

@endsection