@extends('layouts.template')
@section('title', 'Пользователи системы')


@section('header')
    <h4>Список пользователей системы</h4>
@endsection


@section('content')
    @if(Auth::user()->role == 'Администратор')
        <a href="{{ route('users.create') }}" class="btn btn-primary">Добавить</a>
        <hr>
    @endif

    <div class="scroller mb-5">
        <table class="table table-bordered datatable">
            <thead>
            @if(count($users) > 0)
                <tr>
                    <th>Логин</th>
                    <!--@if(Auth::user()->role == 'Администратор')-->
              <!--      	<th>Пароль</th>-->
                    <!--@endif-->
                    <th>Ф.И.О.</th>
                    <th>Должность</th>
                    <th>Роль в системе</th>
                    <th>Компания</th>
                    <th>Список баз</th>
                    <th>Компания при регистрации</th>
                    @if(Auth::user()->role == 'Администратор')
                        <th>Блокировка</th>
                        <th>Действия</th>
                    @endif
                </tr>
            @endif
            </thead>
            <tbody>
            @if(count($users) < 1)
                <div class="alert alert-danger" role="alert">
                    Не добавлено ещё ни одного пользователя
                </div>
            @else
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->email }}</td>
                        <!--@if(Auth::user()->role == 'Администратор')-->
               <!--         	<td class="password">-->
               <!--         	    <input class="form-control" type="password" id="password-input_{{$user->id}}" value="{{ $user->remember_password }}">-->
               <!--         	    <a href="#" id="password-control_{{$user->id}}" class="password-control" for="password-input_{{$user->id}}"></a>-->
               <!--         	</td>-->
                        <!--@endif-->
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->position }}</td>
                        <td>{{ $user->role }}</td>
                        <!--<td>
                            @if($user->company() !== null)
                                {{ $user->company()->name.' ('.$user->company()->city.')' }}
                            @endif
                        </td>-->
    
                            @if($user->company() !== null) <td>{{ $user->company()->name }}</td>
                            @else <td>Нет компании</td>
                            @endif
                        
                        <td>
                            {!! $user->bases_list() !!}
                        </td>
                        <td>{{ $user->company_on_register }}</td>
                        @if(Auth::user()->role == 'Администратор')
                            @if(Auth::id() != $user->id)
                                <td>
                                    <span class="form-check text-center align-middle">
                                        <input class="form-check-input" type="checkbox" value="" id="checkBlock_{{ $user->id }}" data-blocking="{{ $user->id }}" @if($user->blocking == 1) checked @endif name="checkBlock">
                                    </span>
                                </td>
                            @else
                                <td></td>
                            @endif
                            <td>
                                <a href="{{ route('users.edit', ['id' => $user->id]) }}">🖊️</a>
                                @if(Auth::id() != $user->id)
                                    <button type="button" class="btn btn-link" onclick="if(confirm('Подтвердите удаление пользователя: {{ $user->name }}')){$('#item_{{ $user->id }}_delete').submit();}">🗑️</button>
                                    <form action="{{ route('users.destroy', ['id' => $user->id]) }}" id="item_{{ $user->id }}_delete" method="POST">
                                        @csrf
                                        @method('delete')
                                    </form>
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.11.4/i18n/ru.json"></script>>
    <script>
           $('.datatable').DataTable({
                language: {
                    processing: "Подождите...",
                    loadingRecords: "Загрузка записей...",
                    emptyTable: "В таблице отсутствуют данные",
                    lengthMenu: "Показать _MENU_ записей",
                    search: "Поиск:",
                    info: "Записи с _START_ до _END_ из _TOTAL_ записей",
                    infoEmpty: "Записи с 0 до 0 из 0 записей",
                    infoFiltered: "",
                    previous: "Предыдущая",
                    next: "Следующая",
                    last: "Последняя",
                    Show: "Показать",
                    paginate: {
                        first: "Первая",
                        previous: "Предыдущая",
                        next: "Следующая",
                        last: "Последняя"
                    },
                }
            });
                // $(document).ready(function() {
                    {{-- Блокировка пользователя --}}
                    $('body').on('click', 'input[name="checkBlock"]', function() {
                        var obj = $(this);
                        var token = $('input[name="_token"]').val();
                        var userId = obj.data('blocking');
                        // console.log(userId);
                        if(obj.is(':checked')){
                            res = 1;
                            $.post('{{ route('users.blocking_user') }}', {'_token': token, 'blocking': res, 'userId': userId}, function(){});       
                        } else {
                            res = 0;
                            $.post('{{ route('users.blocking_user') }}', {'_token': token, 'blocking': res, 'userId': userId}, function(){});
                        }
                    });
                // });   
                
            $('body').on('click', '#password-control_id', function(){
                if ($('#password-input_id').attr('type') == 'password'){
                    console.log($('#password-input_id'));
                    $(this).addClass('view');
                    $('#password-input_id').attr('type', 'text');
                } else {
                    $(this).removeClass('view');
                    $('#password-input_id').attr('type', 'password');
                }
                return false;
            });
    </script>
@endsection


@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <style>
        .password {
            position: relative;
        }
        .password-control {
            position: absolute;
            top: 18px;
            right: 21px;
            display: inline-block;
            width: 24px;
            height: 20px;
            background: url(public/svg/view.svg) 0 0 no-repeat;
        }
        .password-control.view {
            background: url(public/svg/no-view.svg) 0 0 no-repeat;
        }
    </style>
@endsection