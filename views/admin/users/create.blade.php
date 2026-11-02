@extends('layouts.template')
@section('title', 'Новый пользователь')


@section('header')
    <h4>
        <a href="{{ route('users.index') }}">Список пользователей системы</a> / Новый пользователь
    </h4>
@endsection


@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Заполните информацию по новому пользователю</div>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Ф.И.О.</h4>
                            <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" name="name" value="{{ old('name') }}" required>
                            @if($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <hr>

                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Логин</h4>
                            <input type="text" class="form-control @if($errors->has('email')) is-invalid @endif" name="email" value="{{ old('email') }}" required>
                            @if($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <hr>

                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Пароль</h4>
                            <input type="text" class="form-control @if($errors->has('remember_password')) is-invalid @endif" name="remember_password" value="{{ old('remember_password') }}" required>
                            @if($errors->has('remember_password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('remember_password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <hr>

                        <div class="list">
                            <h4 class="card-title"><span style="color: #ff0000;">*</span>Права</h4>
                            <select name="role" id="role" class="form-control @if($errors->has('remember_password')) is-invalid @endif" required>
                                <option value="Пользователь">Пользователь</option>
                                <option value="Работник лаборатории">Работник лаборатории</option>
                                <option value="Диспетчер">Диспетчер</option>
                                <option value="Администратор">Администратор</option>
                            </select>
                            @if($errors->has('role'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('role') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="list inspectors">
                            <h4 class="card-title"></span>Выберите инспектора</h4>
                            <select class="form-control" name="inspector_id" id="">
                                <option value=""></option>
                                @if($inspectors->count() > 0)
                                @foreach($inspectors as $inspector)
                                    <option value="{{$inspector->id }}">{{ $inspector->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <hr>

                        <div class="list">
                            <h4 class="card-title">Должность</h4>
                            <input type="text" name="position" id="position" class="form-control @if($errors->has('position')) is-invalid @endif">
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
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
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

                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('js/chosen/chosen.css') }}">
    <style>
        .inspectors {display: none}
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

            $.post('{{ route('users.ajax.check_exist_user') }}', {'login': login, '_token': token}, function(data) {
                if(data === 'true')
                {
                    $('input[name="email"]').css('border', '1px solid #ff0000');
                    $('button[type="submit"]').attr('disabled', true);
                } else if(data === 'false')
                {
                    $('input[name="email"]').css('border', '1px solid #e5e6e7');
                    $('button[type="submit"]').attr('disabled', false);
                }
            });

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
    </script>
@endsection