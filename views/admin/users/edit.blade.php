@extends('layouts.template')
@section('title', 'Редактирование')


@section('header')
    <h4>
        <a href="{{ route('users.index') }}">Список пользователей системы</a> / Редактирование
    </h4>
@endsection


@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Редактирование информации пользователя</div>
                <div class="card-body">
                    <form action="{{ route('users.update', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Ф.И.О.</h4>
                            <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" name="name" value="{{ $user->name }}" required>
                            @if($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <hr>

                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Логин</h4>
                            <input type="text" class="form-control @if($errors->has('email')) is-invalid @endif" name="email" value="{{ $user->email }}" required>
                            @if($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <hr>

                        <div class="list password">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Пароль</h4>
                            <input type="password" class="form-control @if($errors->has('remember_password')) is-invalid @endif" id="password-input" name="remember_password" value="{{ $user->remember_password }}" required>
                            @if($errors->has('remember_password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('remember_password') }}</strong>
                                </span>
                            @endif
                            <a href="#" class="password-control" for="password-input"></a>
                        </div>
                        <hr>

                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Права</h4>
                            <select name="role" id="role" class="form-control @if($errors->has('remember_password')) is-invalid @endif" required>
                                <option value="Пользователь" @if($user->role == 'Пользователь') selected @endif>Пользователь</option>
                                <option value="Работник лаборатории" @if($user->role == 'Работник лаборатории') selected @endif>Работник лаборатории</option>
                                <option value="Диспетчер" @if($user->role == 'Диспетчер') selected @endif>Диспетчер</option>
                                <option value="Администратор" @if($user->role == 'Администратор') selected @endif>Администратор</option>
                            </select>
                            @if($errors->has('role'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('role') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="list @if($user->inspector_id) inspectors_show @else inspectors @endif">
                            <h4 class="card-title"></span>Выберите инспектора</h4>
                            <select class="form-control" name="inspector_id" id="">
                                <option value=""></option>
                                @if($inspectors->count() > 0)
                                @foreach($inspectors as $inspector)
                                    <option value="{{$inspector->id }}" @if($user->inspector_id == $inspector->id) selected @endif>{{ $inspector->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <hr>

                        <div class="list">
                            <h4 class="card-title">Должность</h4>
                            <input type="text" name="position" id="position" value="{{ $user->position }}" class="form-control @if($errors->has('position')) is-invalid @endif">
                            @if($errors->has('position'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('position') }}</strong>
                                </span>
                            @endif
                        </div>
                        <hr>

                        <div class="list">
                            <h4 class="card-title">Компания</h4>
                            <select name="company_id" id="company_id" class="form-control @if($errors->has('company_id')) is-invalid @endif">
                                <option value="" selected disabled>-- Выберите вариант --</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" @if($company->id == $user->company_id) selected @endif>{{ $company->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('company_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('company_id') }}</strong>
                                </span>
                            @endif
                        </div>
                        <hr>

                        <div class="list">
                            <h4 class="card-title">Доступы</h4>
                            <select name="bases_list[]" class="form-control chosen-select" id="bases_list" multiple>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}" @if(is_array(json_decode($user->bases_list, true)) && in_array($location->id, json_decode($user->bases_list, true))) selected @endif>{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <hr>

                        <div class="list">
                            <h4 class="card-title">Аватар</h4>
                            <input type="file" name="avatar" id="avatar" class="form-control @if($errors->has('avatar')) is-invalid @endif">
                            @if($errors->has('avatar'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('avatar') }}</strong>
                                </span>
                            @endif
                        </div>
                        <br>
                        <br>

                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('js/chosen/chosen.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <style>
        .inspectors {display: none}
        .inspectors_show {display: block}
        
        .password {
            position: relative;
        }
        .password-control {
            position: absolute;
            top: 34px;
            right: 21px;
            display: inline-block;
            width: 30px;
            height: 20px;
            background: url(/../../public/svg/view.svg) 0 0 no-repeat;
        }
        .password-control.view {
            background: url(/../../public/svg/no-view.svg) 0 0 no-repeat;
        }
    </style>
@endsection

@section('js')
    <script src="{{ asset('js/chosen/chosen.jquery.js') }}"></script>
    <script>
        $(".chosen-select").chosen();

        // проверка пользователя на существование
        $('input[name="email"]').keyup(function() {
            var current_obj = $(this);
            var login = current_obj.val();
            var token = $('input[name="_token"]').val();

            if(login != '{{ $user->email }}')
            {
                $.post('{{ route('users.ajax.check_exist_user') }}', {'login': login, '_token': token}, function(data) {
                    if(data == 'true')
                    {
                        $('input[name="email"]').css('border', '1px solid #ff0000');
                        $('button[type="submit"]').attr('disabled', true);
                    } else if(data == 'false')
                    {
                        $('input[name="email"]').css('border', '1px solid #e5e6e7');
                        $('button[type="submit"]').attr('disabled', false);
                    }
                });
            }

        });
        
        {{-- При смене компании подгружаем места проведения работ и установки --}}
            $('select[name="company_id"]').change(function() {
                var obj = $(this);
                var company_id = obj.val();
                var token = $('input[name="_token"]').val();

                {{-- места проведения работ --}}
                $.post('{{ route('users.get_work_locations') }}', {'_token': token, 'company_id': company_id}, function(data) {
                    var locations = '<option></option>';
                    $.each(data, function(key, value) {
                        locations += '<option value="'+value.id+'">'+value.name+'</option>';
                    });
                    $('select[name="bases_list[]"]').html(locations);
                    $('#bases_list').trigger("chosen:updated");
                });
            });
        
            {{-- Инспекторы --}}
            $('select[name="role"]').change(function() {
                var obj = $(this);
                var role = obj.val();
                if(role == "Работник лаборатории") {
                    $('.inspectors').css('display', 'block');
                } else {
                    $('.inspectors').css('display', 'none');
                }

            });
            
             $('body').on('click', '.password-control', function(){
                if ($('#password-input').attr('type') == 'password'){
                    $(this).addClass('view');
                    $('#password-input').attr('type', 'text');
                } else {
                    $(this).removeClass('view');
                    $('#password-input').attr('type', 'password');
                }
                return false;
            });
    </script>
@endsection

@section('css')

@endsection