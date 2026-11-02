@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="text-align: center;">
                    <img src="{{ asset('logo.png') }}" height="70px" alt=""><br>
                </div>

                @if(session('register_success'))
                    <div class="alert alert-success">
                        {{ session('register_success') }}
                    </div>
                @endif
                
                @if ($errors->has('g-recaptcha-response'))
                    <div class="alert alert-danger text-center">
                        {{ $errors->first('g-recaptcha-response') }}
                    </div>
                @endif
                
                <div class="card-body">
                    <form method="POST" action="{{ route('register.store') }}">
                        @csrf
                        {{-- Компания --}}
                        <div class="row">
                            <div class="col-12">
                                <label>Компания</label>
                                <input type="text" name="company_on_register" class="form-control" required>
                            </div>
                        </div>
                        {{-- Ф.И.О. --}}
                        <div class="row">
                            <div class="col-12">
                                <label>Ф.И.О.</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                        {{-- Должность --}}
                        <div class="row">
                            <div class="col-12">
                                <label>Должность</label>
                                <input type="text" name="position" class="form-control" required>
                            </div>
                        </div>
                        {{-- E-mail адрес --}}
                        <div class="row">
                            <div class="col-12">
                                <label>E-mail адрес</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>
                        {{-- Номер телефона --}}
                        <div class="row mb-3">
                            <div class="col-12">
                                <label>Номер телефона</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                {!! NoCaptcha::renderJs() !!}
                                {!! NoCaptcha::display() !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <br>
                                <button type="submit" class="btn btn-success">Отправить заявку</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
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
        });
    </script>
@endsection