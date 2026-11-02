@extends('layouts.template')
@section('title', 'QR')

@section('header')
    <h4>Список qr-кодов</h4>
@endsection

@section('content')
    <div class="mt-2 mb-4">
        <form action="{{ route('qrs.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg tape-number was-validated">
                    <label for="tape_number" class="form-label">Номер ленты</label>
                    <input class="form-control" type="text" name="tape_number" id="tape_number" required>
                    <div id="search_tape_number-result"></div>
                    <div class="invalid-feedback">Заполните номер ленты </div>
                </div>
                <div class="col-lg">
                    <label for="company_id" class="form-label">Компания</label>
                    <select class="form-control" name="company_id" id="company_id" disabled>
                    </select>
                    <div class="invalid-feedback">Выберите компанию </div>
                </div>
                <div class="col-lg">
                    <label for="work_location_id" class="form-label">Место проведения работ</label>
                    <select class="form-control" name="work_location_id" id="work_location_id" disabled>
                    </select>
                    <div class="invalid-feedback">Выберите место </div>
                </div>
                <div class="col-lg">
                    <label for="facility_id" class="form-label">Установка</label>
                    <select class="form-control" name="facility_id" id="facility_id" disabled>
                    </select>
                    <div class="invalid-feedback">Выберите установку</div>
                </div>
                <input type="hidden" name="component_id">
                <div class="col-auto">
                    <label for="" class="form-label">&nbsp;</label><br>
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </div>

            </div>

        </form>
    </div>

    <div class="cmt-2" id="error_if_tape_number_not_found">
        <div class="alert alert-danger">
            Номер ленты в базе не найден. Вы можете добавить <a href="{{ route('components.create') }}" target="_blank">новый компонент</a>
        </div>
    </div>

    <div class="alert alert-danger yes-qr-in-db" role="alert">
        <i class="bi bi-exclamation-triangle"></i>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif    
    
    <div class="scroller">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>№/ID</th>
                    <th>Компания</th>
                    <th>Место проведения работ</th>
                    <th>Установка</th>
                    <th>Номер ленты</th>
                    <th>QR</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @if(count($qrs) < 1)
                    <div class="alert alert-danger" role="alert">
                        Не добавлено ещё ни одного QR-кода
                    </div>
                @else
                    @foreach($qrs as $qr)
                        <tr>
                            <td>{{ $qr->id }}</td>
                            <td>{{ $qr->components()->company()->name }}</td>
                            <td>{{ $qr->components()->work_location()->name }}</td>
                            <td>{{ $qr->components()->facility()->number.' '.$qr->components()->facility()->gos_number.' '.$qr->components()->facility()->area }}</td>
                            <td>{{ $qr->components()->tape_number }}</td>
                            <td>                                
                                @if(file_exists(public_path('qr_files/'.$qr->id.'.png')))
                                    <a href="{{ asset('qr_files/'.$qr->id.'.png') }}" data-fancybox="gallery">{{$qr->qr_url}}</a>
                                @endif
                            </td>
                            <td>
                                <input type="checkbox" role="switch" id="isActive" data-qr_id_active="{{ $qr->id }}" @if($qr->status_exp == 'yes') checked Активен @endif>
                                <p id="isActiveTd"></p>
                            </td>
                            <td>                       
                                 {{-- Редактирование --}}
                                <button type="button" class="btn btn-success qr-edit" data-toggle="modal" data-qr_id="{{ $qr->id }}" data-target="#qrEditModel" title="Редактирование">
                                    <i class="fas fa-edit"></i>
                                </button>
                                {{-- Удаление --}}
                                <button name="deleteQr" type="button" class="btn btn-danger" onclick="if(confirm('Подтвердите удаление заключения')){$('#item_{{ $qr->id }}_delete').submit();}" @if($qr->status_exp == 'yes') disabled @endif>
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <form action="{{ route('qrs.destroy', ['id' => $qr->id]) }}" id="item_{{ $qr->id }}_delete" method="POST">
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

    {{-- Редактирование qr--}}
    @include('admin.qrs.edit')

@endsection


@section('js')
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script>

    $('.yes-qr-in-db-edit').hide();
    $('.yes-qr-in-db').hide();
    {{-- Подгрузка данных по номеру ленты --}}
        $('input[name="tape_number"]').keyup(function() {
            var current_obj = $(this);
            var tapeNumber = current_obj.val();
            if(tapeNumber != '' && tapeNumber.length > 0)
            {
                $.post('{{ route('ajax.qrs.get_type_number') }}', {'tape_number': tapeNumber, '_token': "{{ csrf_token() }}"}, function(data) {
                    if(data['status'] === 'bad')
                    {
                        $('#error_if_tape_number_not_found').css('display', 'block');
                        $('#search_tape_number-result').html('');
                        $('#search_tape_number-result').fadeOut(100);
                    } else {
                        $('#error_if_tape_number_not_found').css('display', 'none');
                        var tape_numbers = '<select class="form-control" id="select_tape_number"><option selected disabled>-- Выберите из списка --</option>';
                        $.each(data['components'], function(key, value) {
                            tape_numbers += '<option value="'+value.tape_number+'">'+value.tape_number+'</option>';
                        });
                        tape_numbers += '</select>';
                        $('#search_tape_number-result').html(tape_numbers);
                        if(data != ''){	
                            $('#search_tape_number-result').fadeIn();
                        } else {
                            $('#search_tape_number-result').fadeOut(100);
                        }
                    }
                });
            } else {
                $('#search_tape_number-result').html('');
                $('#search_tape_number-result').fadeOut(100);
                $('select[name="company_id"]').html('');
                $('select[name="work_location_id"]').html('');
                $('select[name="facility_id"]').html('');
            }

        });

        $(document).on('click', function(e){
            if (!$(e.target).closest('.tape-number').length){
                $('#search_tape_number-result').html('');
                $('#search_tape_number-result').fadeOut(100);
            }
        });

        $(document).on('change', '#select_tape_number', function(){
            var selectTapeNumber = $(this).val();
            $('#tape_number').val(selectTapeNumber);
            $('#search_tape_number-result').fadeOut(100);

            $.post('{{ route('ajax.qrs.get_data_on_type_number') }}', {'tape_number': selectTapeNumber, '_token': "{{ csrf_token() }}"}, function(data) {

                var company = '<option value="'+data['company'].id+'" selected>'+data['company'].name+'</option>';
                var location = '<option value="'+data['work_location'].id+'" selected>'+data['work_location'].name+'</option>';
                var facility = '<option value="'+data['facility'].id+'" selected data-facility_name="'+data['facility'].number+'">'+data['facility'].number+' '+data['facility'].gos_number+' '+data['facility'].area+'</option>';
                
                var componentId = data['component'].id;
                $('input[name="component_id"]').val(componentId);

                $.post('{{ route('qrs.checkComponentId') }}', {'component_id': componentId, '_token': "{{ csrf_token() }}"}, function(data) {
                    if(data['status'] == 'yes' && data['qr'])
                    {
                        $('.yes-qr-in-db').show();
                        $('.yes-qr-in-db').html('<div>У выбравнного компонента есть QR №<b>'+data['qr'].id+'</b></div>');
                    } else {
                        $('.yes-qr-in-db').hide();
                    }
                });

                $('select[name="company_id"]').html(company);
                $('select[name="work_location_id"]').html(location);
                $('select[name="facility_id"]').html(facility);

            });
            // return false;
        });

        {{-- Редактирование --}}
            $('.qr-edit').click(function() {
                var obj = $(this);
                var qr_id = obj.data('qr_id');
                $.post('{{ route('qrs.editQr') }}', {'id': qr_id, '_token': "{{ csrf_token() }}"}, function(data) {
                    
                    $('input[name="tape_number_edit"]').val(data['component'].tape_number);
                    var company_edit = '<option value="'+data['company'].id+'" selected>'+data['company'].name+'</option>';
                    var location_edit = '<option value="'+data['work_location'].id+'" selected>'+data['work_location'].name+'</option>';
                    var facility_edit = '<option value="'+data['facility'].id+'" selected data-facility_name="'+data['facility'].number+'">'+data['facility'].number+' '+data['facility'].gos_number+' '+data['facility'].area+'</option>';
                    
                    var componentId = data['component'].id;
                    $('input[name="component_id_edit"]').val(componentId);

                    $('select[name="company_id_edit"]').html(company_edit);
                    $('select[name="work_location_id_edit"]').html(location_edit);
                    $('select[name="facility_id_edit"]').html(facility_edit);
                });
                $('input[name="qr_id_edit"]').val(qr_id);
            });


            {{-- Подгрузка данных по номеру ленты при редактировании--}}

            $('input[name="tape_number_edit"]').keyup(function() {
                var current_obj = $(this);
                var tapeNumberEdit = current_obj.val();
                if(tapeNumberEdit != '' && tapeNumberEdit.length > 0)
                {
                    $.post('{{ route('ajax.qrs.get_type_number') }}', {'tape_number': tapeNumberEdit, '_token': "{{ csrf_token() }}"}, function(data) {
                        if(data['status'] === 'bad')
                        {
                            // $('#error_if_tape_number_not_found').css('display', 'block');
                            $('#search_tape_number_edit-result').html('');
                            $('#search_tape_number_edit-result').fadeOut(100);
                        } else {
                            // $('#error_if_tape_number_not_found').css('display', 'none');
                            var tape_numbers_edit = '<select class="form-control" id="select_tape_number_edit"><option selected disabled>-- Выберите из списка --</option>';
                            $.each(data['components'], function(key, value) {
                                tape_numbers_edit += '<option value="'+value.tape_number+'">'+value.tape_number+'</option>';
                            });
                            tape_numbers_edit += '</select>';
                            $('#search_tape_number_edit-result').html(tape_numbers_edit);
                            if(data != ''){	
                                $('#search_tape_number_edit-result').fadeIn();
                            } else {
                                $('#search_tape_number_edit-result').fadeOut(100);
                            }
                        }
                    });
                } else {
                    $('#search_tape_number_edit-result').html('');
                    $('#search_tape_number_edit-result').fadeOut(100);
                    $('select[name="company_id_edit"]').html('');
                    $('select[name="work_location_id_edit"]').html('');
                    $('select[name="facility_id_edit"]').html('');
                }

            });

            $(document).on('click', function(e){
                if (!$(e.target).closest('.tape-number-edit').length){
                    $('#search_tape_number_edit-result').html('');
                    $('#search_tape_number_edit-result').fadeOut(100);
                }
            });
            $(document).on('change', '#select_tape_number_edit', function(){
                var selectTapeNumberEdit = $(this).val();
                $('#tape_number_edit').val(selectTapeNumberEdit);
                $('#search_tape_number_edit-result').fadeOut(100);

                $.post('{{ route('ajax.qrs.get_data_on_type_number') }}', {'tape_number': selectTapeNumberEdit, '_token': "{{ csrf_token() }}"}, function(data) {

                    var company_edit = '<option value="'+data['company'].id+'" selected>'+data['company'].name+'</option>';
                    var location_edit = '<option value="'+data['work_location'].id+'" selected>'+data['work_location'].name+'</option>';
                    var facility_edit = '<option value="'+data['facility'].id+'" selected>'+data['facility'].number+' '+data['facility'].gos_number+' '+data['facility'].area+'</option>';

                    var componentId = data['component'].id;
                    $('input[name="component_id_edit"]').val(componentId);

                    $.post('{{ route('qrs.checkComponentId') }}', {'component_id': componentId, '_token': "{{ csrf_token() }}"}, function(data) {
                    if(data['status'] == 'yes' && data['qr'])
                        {
                            $('.yes-qr-in-db-edit').show();
                            $('.yes-qr-in-db-edit').html('<div>У выбравнного компонента есть QR №<b>'+data['qr'].id+'</b></div>');
                        } else {
                            $('.yes-qr-in-db-edit').hide();
                        }
                    });                   

                    $('select[name="company_id_edit"]').html(company_edit);
                    $('select[name="work_location_id_edit"]').html(location_edit);
                    $('select[name="facility_id_edit"]').html(facility_edit);

                });
                // return false;
            });

        // активация qr
        $('#isActive').click(function() {
                var obj = $(this);
                var res;
                var qr_id = obj.data('qr_id_active');
                var token = $('input[name="_token"]').val();
                if(obj.is(':checked'))
                {
                    res = 'yes';
                    $.post('{{ route('qrs.activeChange') }}', {'_token': token, 'qr_id': qr_id, 'status_exp': res}, function(data){
                    if(data['status'] === 'ok')
                        {
                            $('#isActiveTd').text('Активен');
                            $('#deleteQr').attr('disabled', true);
                        } else {
                            $('#isActiveTd').text('Ошибка активации');
                        }
                    });
                } else {
                    res = 'no';
                    $.post('{{ route('qrs.activeChange') }}', {'_token': token, 'qr_id': qr_id, 'status_exp': res}, function(data){
                    if(data['status'] === 'ok')
                        {
                            $('#isActiveTd').text('Не активен');
                            $('#deleteQr').attr('disabled', false);
                        } else {
                            $('#isActiveTd').text('Ошибка активации');
                        }
                    });
                }

            });
    </script>
@endsection


@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
    <style>
        #error_if_tape_number_not_found
        {
            display: none;
        }
        /* .yes-qr-in-db, .yes-qr-in-db-edit
        {
            display: none;
        } */
    </style>
@endsection