@extends('layouts.template')
@section('title', 'Список страниц')

@section('header')
    <h4>Список страниц</h4>
@endsection

@section('content')

    <div class="scroller">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pages as $page)
                    <tr>
                        <td>{{ $page->title }}</td>
                        <td>
                            <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-success">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection