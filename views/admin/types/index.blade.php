@extends('layouts.template')
@section('title', 'Список оборудований')

@section('header')
    <h4>Список оборудований</h4>
@endsection

@section('content')

@php
/*if (extension_loaded('libphpcades.so')) {
	exit;
}



function SetupStore($location, $name, $mode)
{
    $store = new CPStore();
    $store->Open($location, $name, $mode);
    return $store;
}

function SetupCertificates($location, $name, $mode)
{
    $store = SetupStore($location, $name, $mode);
    return $store->get_Certificates();
}

function SetupCertificate($location, $name, $mode,
                           $find_type, $query, $valid_only,
                           $number)
{
    $certs = SetupCertificates($location, $name, $mode);
    if(!is_null($find_type)) 
    {
        $certs = $certs->Find($find_type, $query, $valid_only);
        if (is_string($certs))
            return $certs;
        else
            return $certs->Item($number);
    }
    else
    {
        $cert = $certs->Item($number);
        return $cert;
    }
}

try
{
    $content = "test content";
    $tsp_addres = "http://testca.cryptopro.ru/tsp/tsp.srf";
    $cert = SetupCertificate('alyansekspert', "My", 'STORE_OPEN_READ_ONLY',
                             'CERTIFICATE_FIND_SUBJECT_NAME', "test", 0,
                             1);

    if (!$cert)
    {
        printf("Certificate not found\n");
        return;
    }

    $signer = new CPSigner();
    $signer->set_TSAAddress($tsp_addres);
    $signer->set_Certificate($cert);

    $sd = new CPSignedData();
    $sd->set_Content($content);

    $sm = $sd->Sign($signer, 0, ENCODE_BASE64);
    printf("Signature is:\n");
    printf($sm);
    printf("\n");
    $sd->Verify($sm, 0, VERIFY_SIGNATURE_ONLY);
    printf("Verify OK\n");
}
catch (Exception $e)
{
    printf($e->getMessage());
} */
@endphp

    <div class="row">
        <div class="col-3">
            <a href="{{ route('types.create') }}" class="btn btn-primary">Добавить</a>
        </div>
    </div>
    <hr>
    <form action="{{route('types.index')}}" method="get">
    <div class="row">
        <div class="col-12 col-md-4">
            <label for="search_field" class="form-label">Наименование</label>
            <input name="search_field" @if(isset($_GET['search_field'])) value="{{$_GET['search_field']}}" @endif type="text" class="form-control" id="exampleFormControlInput1" placeholder="Наименование типа">
        </div>
        <div class="col-12 col-md-3">
            <label>Производитель</label>
            <select name="selected_manufacturer" class="form-control">
                <option></option>
                @if(count($types) > 0)
                    @foreach($types_manufacturers as $type)
                        <option value="{{ $type->manufacturer }}">{{ $type->manufacturer }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-12 col-md-2">
            <label>&nbsp</label><br>
            <button type="submit" class="btn btn-primary">Поиск</button>
            <label>&nbsp</label>
            <a href="{{route('types.index')}}" class="btn btn-warning">Сброс</a>
        </div>
    </div>
    </form>
    <hr>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="scroller">
        <table class="table table-bordered datatable" id="viewTable">
            <thead>
            @if(count($types) > 0)
                <tr>
                    <th>№</th>
                    <th>Наименование</th>
		            <!--<th>Сокращение</th>-->
                    <th>Характеристики</th>
                    <th>Производитель</th>
                    <th>Партийный номер</th>
                    <!--<th>Замеры 1</th>
                    <th>Замеры 2</th>
                    <th>Замеры 3</th>
                    <th>Замеры 4</th>-->
                    <th>Изображения</th>
                    <th>Действия</th>
                </tr>
            @endif
            </thead>
            <tbody>
            @if(count($types) < 1)
                <div class="alert alert-danger" role="alert">
                    Не добавлено ещё ни одного типа
                </div>
            @else
                @foreach($types as $idx => $type)
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td>{{ $type->name }}</td>
			            <!--<td>{{ $type->abbr_name_type }}</td>-->
                        <td>{{ $type->description }}</td>
                        <td>{{ $type->manufacturer }}</td>
                        <td>{{ $type->partial_number }}</td>
                        <!--<td>{{ $type->measure_1 }}</td>
                        <td>{{ $type->measure_2 }}</td>
                        <td>{{ $type->measure_3 }}</td>
                        <td>{{ $type->measure_4 }}</td>-->
                        <td>
                            <ul style="padding-left: 15px;">
                                @if(file_exists(public_path('types_data/'.$type->id.'/uzt.jpg')))
                                    <li>
                                        <a href="{{ asset('types_data/'.$type->id.'/uzt.jpg') }}" data-fancybox="gallery">УЗТ</a>
                                    </li>
                                @endif

                                @if(file_exists(public_path('types_data/'.$type->id.'/mk.jpg')))
                                    <li>
                                        <a href="{{ asset('types_data/'.$type->id.'/mk.jpg') }}" data-fancybox="gallery">МК</a>
                                    </li>
                                @endif

                                @if(file_exists(public_path('types_data/'.$type->id.'/vik.jpg')))
                                    <li>
                                        <a href="{{ asset('types_data/'.$type->id.'/vik.jpg') }}" data-fancybox="gallery">ВИК</a>
                                    </li>
                                @endif

                                @if(file_exists(public_path('types_data/'.$type->id.'/uk.jpg')))
                                    <li>
                                        <a href="{{ asset('types_data/'.$type->id.'/uk.jpg') }}" data-fancybox="gallery">УЗК</a>
                                    </li>
                                @endif

                                @if(file_exists(public_path('types_data/'.$type->id.'/diagram_crimping.jpg')))
                                    <li>
                                        <a href="{{ asset('types_data/'.$type->id.'/diagram_crimping.jpg') }}" data-fancybox="gallery">Диаграмма оприсовки</a>
                                    </li>
                                @endif
                            </ul>
                        </td>
                        <td>
                            <a class="btn btn-success" href="{{ route('types.edit', ['id' => $type->id]) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                            <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="Перед удалением проверьте его в компанентах, возможно он применяется">
                                <button type="button" class="btn btn-danger" @if(isset($type->components()->type_id) && $type->id == $type->components()->type_id) disabled @endif onclick="if(confirm('Подтвердите удаление типа: {{ $type->name }}')){$('#item_{{ $type->id }}_delete').submit();}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </span>
                            <form action="{{ route('types.destroy', ['id' => $type->id]) }}" id="item_{{ $type->id }}_delete" method="POST">
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
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script>
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })

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
    </script>
@endsection


@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">

@endsection