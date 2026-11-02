@extends('layouts.template')
@section('title', 'Список оповещений')
@section('header')
    <h4>Список оповещений</h4>
@endsection

@section('content')
    <div class="row">
        <div class="col-3">
            <a href="{{ route('cron.alarm_processing') }}" class="btn btn-primary">Проверить уведомления</a>
        </div>
        @if(Auth::user()->role == 'Администратор')
        <div class="col-3">
            <a href="{{ route('alarms.changeReading') }}" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-all" viewBox="0 0 16 16">
            <path d="M8.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992a.252.252 0 0 1 .02-.022zm-.92 5.14.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486-.943 1.179z"/>
            </svg> Отметить все как прочитанные </a>
        </div>
        @endif
    </div>
    <hr>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    
<div class="scroller">
    <table class="table">
        <thead>
        <tr>
            <th>№</th>
            <th>Тема</th>
            <th>Дата</th>
        </tr>
        </thead>
        <tbody>
        @if(count($alarms) == 0)
            <tr>
                <th colspan="2">У Вас нет новых оповещений</th>
            </tr>
        @else
            @foreach($alarms as $idx => $alarm)
                <tr>
                    <td>{{ $idx + 1 }}</td>
                    <td data-toggle="modal" data-target="#show_alarm" class="get_alarm_data" data-alarm_id="{{ $alarm->id }}" style="cursor: pointer; @if($alarm->is_reading == 0) color: green; font-weight: 700; @else color: #444; @endif">
                        @if($alarm->level == 1) <span style="color: #ff0000; font-weight: 700;">!</span>@endif
                        {{ $alarm->title }}
                    </td>
                    <td>{{ $alarm->get_formed_data() }}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    <input id="userRole" type="hidden" value="{{ Auth::user()->role }}">
</div>

    @include('alarms.show')
@endsection


@section('js')
    <script>
        $(document).ready(function() {
            $('.get_alarm_data').click(function() {
                var obj = $(this);
                obj.css({'color': '#444', 'font-weight': 'normal'});

                var alarm_id = obj.data('alarm_id');
                $('#show_alarm .modal-body').html('');

                $.post('{{ route('alarms.show') }}', {'alarm_id': alarm_id}, function(data) {
                    $('#show_alarm .modal-title').html(data.title);
                    if($('#userRole').val() == "Администратор" || $('#userRole').val() == "Работник лаборатории") {
                        $('#show_alarm .modal-body').html(data.content + '<br><br><a href="' + data.link + '" target="_blank"><button type="button" class="btn btn-warning">Выполнить</button></a>');
                    } else {
                        $('#show_alarm .modal-body').html(data.content);
                    }
                });
            });

        });
    </script>
@endsection
