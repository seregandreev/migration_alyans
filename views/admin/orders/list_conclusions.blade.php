@extends('layouts.template')
@section('title', 'Список заявок')

@section('header')
    <h4>
        <a href="{{ route('orders.index') }}">Список заявок</a> / Заявка №{{ $order->id }}
    </h4>
@endsection

@section('content')

    <table class="table">
        <thead>
        <tr>
            <th>№ заключения</th>
            <th>Дата</th>
            <th>Заказчик</th>
            <th>Компания</th>
            <th>Ответственный</th>
            <th>Железо</th>
        </tr>
        </thead>
        <tbody>
        @foreach($conclusions as $conclusion)
            <tr>
                <td><a href="{{ route('conclusions.edit', $conclusion->conclusion()->id) }}">{{ $conclusion->conclusion()->id }}</a></td>
                <td>{{ $conclusion->conclusion()->get_format_date() }}</td>
                <td>
                    @if($conclusion->conclusion()->component()->company()->user() !== null)
                        {{ $conclusion->conclusion()->component()->company()->user()->email }}
                        <br>
                        {{ $conclusion->conclusion()->component()->company()->user()->phone }}
                    @else
                        <i>Не назначен</i>
                    @endif
                </td>
                <td>{{ $conclusion->conclusion()->component()->company()->name }}</td>
                <td>{{ $conclusion->order()->responsible()->name }}</td>
                <td>{{ $conclusion->conclusion()->component()->type()->name.' / '.$conclusion->conclusion()->component()->type()->description.' / '.$conclusion->conclusion()->component()->type()->manufacturer.' / '.$conclusion->conclusion()->component()->type()->partial_number }}</td>
                <td></td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection