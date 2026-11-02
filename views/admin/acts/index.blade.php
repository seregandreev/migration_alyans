@extends('layouts.template')
@section('title', 'Список актов')

@section('header')
    <h4>Акты проделанных работ</h4>
@endsection

@section('content')

    <h4>Поиск</h4>
    @include('admin.acts.filter')
    <hr>
    <table border="0" class="table">
        <thead>
        <tr>
            <th>№ акта</th>
            <th>Дата формирования</th>
            <th>Установка</th>
            <th>Компания</th>
            <th></th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($acts as $act)
            <tr>
                <td>{{ $act->id }}</td>
                <td>{{ $act->get_formed_date_act() }}</td>
                @if($act->facility_id)
                    <td>{{ $act->facility()->number }} {{ $act->facility()->gos_number }} {{ $act->facility()->area }}</td>
                @else
                    <td> - </td>
                @endif
                <td>{{ $act->company()->name }}</td>
                <td>
                    <div class="form-check">
                        <input type="checkbox" class="signInspector" id="signInspector_{{ $act->id }}" data-act_id_sign="{{ $act->id }}" @if($act->sign_inspector == 'yes') checked Подписан @endif>
                        <label class="form-check-label" for="signInspector_{{ $act->id }}">Факсимиле</label>
                        <p id="msgSign_{{ $act->id }}"></p>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="stamp" id="stamp_{{ $act->id }}" data-act_id_stamp="{{ $act->id }}" @if($act->stamp == 'yes') checked Пропечатан @endif>
                        <label class="form-check-label" for="stamp_{{ $act->id }}">Печать</label>
                        <p id="msgStamp_{{ $act->id }}"></p>
                    </div>
                </td>
                <td>
                    <a href="{{ route('acts.show', ['act_id' => $act->id]) }}" target="_blank" class="btn btn-primary">
                        <i class="fas fa-print"></i>
                    </a>
                    <button type="button" class="btn btn-danger" onclick="if(confirm('Подтвердите удаление акта № {{ $act->id }}')){$('#item_{{ $act->id }}_delete').submit();}">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @foreach($acts as $act) 
        <form action="{{ route('act.deleteAct', ['id' => $act->id]) }}" id="item_{{ $act->id }}_delete" method="GET">
            @csrf
            @method('delete')
        </form>
    @endforeach
@endsection


@section('js')
    <script>
        $(document).ready(function() {
            // получаем список установок по компании
            $('.filters select[name="company_id"]').change(function() {
                var obj = $(this);
                var company_id = obj.val();
                // установки
                $.post('{{ route('acts.get_facilities') }}', {'company_id': company_id}, function(data) {
                    var facilities = '<option value=""></option>';
                    $.each(data, function(key, value) {
                        facilities += '<option value="'+value.id+'">'+value.number+' '+value.gos_number+' '+value.area+'</option>';
                    });
                    $('.filters select[name="facility_id"]').html(facilities);
                });
                // локации
                $.post('{{ route('acts.get_work_locations') }}', {'company_id': company_id}, function(data) {
                    var work_locations = '<option value=""></option>';
                    $.each(data, function(key, value) {
                        work_locations += '<option value="'+value.id+'">'+value.name+'</option>';
                    });
                    $('.filters select[name="work_location_id"]').html(work_locations);
                });
                // даты
                check_dates();
            });

            $('.filters select[name="work_location_id"], .filters select[name="facility_id"]').change(function() {
                check_dates();
            });

            function check_dates()
            {
                var company_id = $('.filters select[name="company_id"]').val();
                var facility_id = $('.filters select[name="facility_id"]').val();
                var work_location_id = $('.filters select[name="work_location_id"]').val();

                $.post('{{ route('acts.get_dates') }}', {'company_id': company_id, 'facility_id': facility_id, 'work_location_id': work_location_id}, function(data) {
                    var dates = '<option value=""></option>';
                    $.each(data, function(key, value) {
                        date = value.date.split('-');
                        dates += '<option value="'+value.date+'">'+date[2]+'.'+date[1]+'.'+date[0]+'</option>';
                    });
                    $('.filters select[name="date"]').html(dates);
                });
            }
            
            // подпись
            $('.signInspector').click(function() {
                var obj = $(this);
                var res;
                var act_id = obj.data('act_id_sign');
                if(obj.is(':checked'))
                {
                    res = 'yes';
                    $.post('{{ route('act.signChange') }}', {'act_id': act_id, 'sign_inspector': res, '_token': "{{ csrf_token() }}"}, function(data){
                    if(data['status'] === 'ok')
                        {
                            $('#msgSign').text('Подписан');
                        } else {
                            $('#msgSign').text('Ошибка подписания');
                        }
                    });
                } else {
                    res = 'not';
                    $.post('{{ route('act.signChange') }}', {'act_id': act_id, 'sign_inspector': res,  '_token': "{{ csrf_token() }}"}, function(data){
                    if(data['status'] === 'ok')
                        {
                            $('#msgSign').text('Не подписан');
                        } else {
                            $('#msgSign').text('Ошибка подписания');
                        }
                    });
                }

            });
            
            // печать
            $('.stamp').click(function() {
                var obj = $(this);
                var res;
                var act_id = obj.data('act_id_stamp');
                console.log(act_id);
                if(obj.is(':checked'))
                {
                    res = 'yes';
                    $.post('{{ route('act.stampChange') }}', {'_token': "{{ csrf_token() }}", 'act_id': act_id, 'stamp': res}, function(data){
                    if(data['status'] === 'ok')
                        {
                            $('#msgStamp').text('Печать установлена');
                        } else {
                            $('#msgStamp').text('Ошибка печати');
                        }
                    });
                } else {
                    res = 'not';
                    $.post('{{ route('act.stampChange') }}', { '_token': "{{ csrf_token() }}", 'act_id': act_id, 'stamp': res}, function(data){
                    if(data['status'] === 'ok')
                        {
                            $('#msgStamp').text('Печать снята');
                        } else {
                            $('#msgStamp').text('Ошибка печати');
                        }
                    });
                }

            });
        });
    </script>
@endsection