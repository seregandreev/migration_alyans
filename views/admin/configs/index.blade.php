@extends('layouts.template')
@section('title', 'Параметры')

@section('header')
    <h4>Список параметров</h4>
@endsection

@section('content')

    <div class="row mb-4">
        <div class="col-md-4 col-4"> 
            <h4 class="card-title">&nbsp</h4>
            <a href="{{ route('configs.create') }}" class="btn btn-primary">Добавить</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-4"> 
            {{-- Печать --}}
            <h4 class="card-title">Печать</h4>
            <input type="file" class="form-control mb-4" name="stamp">
            @if(isset($stamp) && file_exists(public_path($stamp)))
            <div class="col-4 col-md-4" id="stamp" style="height: 50px;">
                <img src="{{ asset($stamp) }}" alt="">
            </div>
            @endif
        </div>
        <div class="col-md-4 col-4"> 
            {{-- Отпечаток ЭЦП --}}
            <h4 class="card-title">Отпечаток ЭЦП</h4>
            <input type="file" class="form-control mb-4" name="ecpPrint">
            <div class="col-4 col-md-4" id="ecpPrint" style="height: 50px;">
                @if(isset($ecpPrint) && file_exists(public_path($ecpPrint)))
                    <img src="{{ asset($ecpPrint) }}" alt="">
                @endif
            </div>
        </div>
        <div class="col-md-4 col-4"> 
            {{-- Факсимиле директора --}}
            <h4 class="card-title">Факсимиле директора</h4>
                <input type="file" class="form-control mb-4" name="signDirector">
            <div class="col-4 col-md-4" id="signDirector" style="height: 50px;">
                @if(isset($signDirector) && file_exists(public_path($signDirector)))
                    <img src="{{ asset($signDirector) }}" alt="">
                @endif
            </div>
        </div>
    </div>
    <hr>
    
    <div class="scroller">
        <table class="table table-bordered">
            <thead>
            @if(count($configs) > 0)
                <tr>
                    <th>Тип</th>
                    <th>Название</th>
                    <th>Ключ</th>
                    <th>Значение</th>
                    <th>#</th>
                </tr>
            @endif
            </thead>
            <tbody>
            @if(count($configs) < 1)
                <div class="alert alert-danger" role="alert">
                    Не добавлено ещё ни одного параметра
                </div>
            @else
                @foreach($configs as $config)
                    <tr>
                        <td>{{ $config->type }}</td>
                        <td>{{ $config->name }}</td>
                        <td>{{ $config->key }}</td>
                        <td>{{ $config->value }}</td>
                        <td>
                            <a href="{{ route('configs.edit', ['id' => $config->id]) }}">🖊️</a>
                            <button type="button" class="btn btn-link" onclick="if(confirm('Подтвердите удаление параметра: {{ $config->name }}')){$('#item_{{ $config->id }}_delete').submit();}">🗑️</button>
                            <form action="{{ route('configs.destroy', ['id' => $config->id]) }}" id="item_{{ $config->id }}_delete" method="POST">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>

@endsection

@section('js')
    <script>
        $.ajaxSetup({
            headers: {'X-CSRF-Token': '{{csrf_token()}}'}
        });

        $('input[name="stamp"]').change(function() {
            var stamp = $(this)[0].files[0];
            var formData = new FormData();
            formData.append('stamp', stamp);
            //console.log(stamp);
            $.ajax({
                url: '{{route('configs.uploadStamp')}}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    //if(!res.success){alert(res.error)}
                }
            })
            readStampImg(this);
        });

        function readStampImg(input) {
            if(input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#stamp img').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('input[name="ecpPrint"]').change(function() {
            var ecp_print = $(this)[0].files[0];
            var formData = new FormData();
            formData.append('ecpPrint', ecp_print);
            //console.log(stamp);
            $.ajax({
                url: '{{route('configs.uploadEcpPrint')}}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    //if(!res.success){alert(res.error)}
                }
            })
            readEcpPrintImg(this);
        });

        function readEcpPrintImg(input) {
            if(input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#ecpPrint img').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('input[name="signDirector"]').change(function() {
            var sign_director = $(this)[0].files[0];
            var formData = new FormData();
            formData.append('signDirector', sign_director);
            //console.log(stamp);
            $.ajax({
                url: '{{route('configs.uploadSignDiretor')}}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    //if(!res.success){alert(res.error)}
                }
            })
            readSignDirectorImg(this);
        });

        function readSignDirectorImg(input) {
            if(input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#signDirector img').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection

@section('css')
    <style>
        #signDirector img {
            height: 65px;
            position: relative;
            top: -20px;
            border-radius: 5px;
        }
        #stamp img {
            height: 65px;
            position: relative;
            top: -20px;
            border-radius: 5px;
        }
        #ecpPrint img {
            height: 65px;
            position: relative;
            top: -20px;
            border-radius: 5px;
        }
    </style>
@endsection