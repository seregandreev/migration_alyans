@extends('layouts.template')

@section('title', 'Главная страница')

@section('header')
    <h4>Главная страница</h4>
@endsection

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />
  
@section('content')
@if(Auth::user()->role == 'Администратор' || Auth::user()->role == 'Работник лаборатории')
<div class="scroller">
    <div class="row">
        <div class="col-12 col-md-3">
            <label for="showChart" class="form-label">Графики выполненных работ</label>
            <select class="form-control" name="showChart" id="showChart">
                <option value=""> -- </option>
                <option value="Заключения">Заключения</option>
                <option value="Акты">Акты</option>
            </select>
        </div>
    </div>
    <div class="row chartConclusions chart">
        <div class="col-lg-12">
            <canvas id="chartConclusions"></canvas>
        </div>
    </div>
    <div class="row chartActs chart">
        <div class="col-lg-12">
            <canvas id="chartActs"></canvas>
        </div>
    </div>
    <hr>
    
    <div class="justify-content-center" style="margin-bottom: 2%;">
        <h2>График работ на месяц</h2>
        @if(count($conclusions) < 1))
                <div class="alert alert-danger" role="alert">
                    Не добавлено ещё ни одного заключения
                </div>
            @else
            <table class="table table-bordered" id="tableConclusions">
                <thead>
                
                    <tr>
                        <th>Заключение №</th>
                        <!--<th>Компания</th>-->
                        <th>Установка</th>
                        <th>Номер ленты</th>
                        <th>Серийный номер</th>
                        <th>Дата следующего контроля</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($conclusions as $conclusion)
                <!--@if(isset($conclusion->date_next_verification) && strtotime($conclusion->date_next_verification) < strtotime('+1 month'))-->
                    <tr>
                        <td>{{ $conclusion->id }}</td>
                        
                        <td>@if(isset($conclusion->component()->id)) {{ $conclusion->component()->facility()->number.' '.$conclusion->component()->facility()->gos_number.' '.$conclusion->component()->facility()->area }} @endif</td>
                        <td>@if(isset($conclusion->component()->id)) {{ $conclusion->component()->tape_number }} @endif</td>
                        <td>@if(isset($conclusion->component()->id)) {{ $conclusion->component()->serial_number }} @endif</td>
                        <td>
                            <span style="@if(strtotime($conclusion->date_next_verification) < time()) font-weight: 700; color: #ff0000; @endif">{{ $conclusion->get_formed_data_validity($conclusion->date_next_verification) }}</span>
                        </td>
                        <td>
                            <a href="{{ route('conclusions.edit', ['id' => $conclusion->id]) }}" class="btn btn-success">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" onclick="if(confirm('Подтвердите удаление заключения: {{ $conclusion->id }}')){$('#item_{{ $conclusion->id }}_delete').submit();}" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <form action="{{ route('conclusions.destroy', ['id' => $conclusion->id]) }}" id="item_{{ $conclusion->id }}_delete" method="POST">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                    <!--@endif-->
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
<nav class="pagination justify-content-end">
    {{ $conclusions->links() }}
</nav>
    <hr>
    <div class="justify-content-center">
        <!--<div class="col-lg-6 col-xl-6">-->
        <div>
        <h2>График окончания поверки на оборудования</h2>
        <table class="table table-bordered">
            <thead>
            @if(count($instruments) > 0)
                <tr>
                    <th>Название</th>
                    <th>Метод контроля</th>
                    <th>Дата следующей поверки</th>
                    <th>Действия</th>
                </tr>
            @endif
            </thead>
            <tbody>
            @if(count($instruments) < 1)
                <div class="alert alert-danger" role="alert">
                    Не добавлено ещё ни одного инструмента
                </div>
            @else
                @foreach($instruments as $instrument)
                @if(strtotime($instrument->next_verification_date) < strtotime('+1 month'))
                    <tr>
                        <td>{{ $instrument->name }}</td>
                        <td>{{ $instrument->control_method }}</td>
                        <td>
                            <span style="@if(strtotime($instrument->next_verification_date) < time()) font-weight: 700; color: #ff0000; @endif">{{ $instrument->format_date($instrument->next_verification_date) }}</span>
                        </td>
                        <td>
                            <a href="{{ route('instruments.edit', ['id' => $instrument->id]) }}" class="btn btn-success">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" onclick="if(confirm('Подтвердите удаление инструмента: {{ $instrument->name }}')){$('#item_{{ $instrument->id }}_delete').submit();}" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <form action="{{ route('instruments.destroy', ['id' => $instrument->id]) }}" id="item_{{ $instrument->id }}_delete" method="POST">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                    @endif
                @endforeach
            @endif
            </tbody>
        </table>
        </div>
        <hr>
        <!--<div class="col-lg-6 col-xl-6">-->
        <div>
        <h2>График окончания срока удостоверения специалистов</h2>
        <table class="table table-bordered">
            <thead>
            @if(count($inspectors) > 0)
                <tr>
                    <th>Ф.И.О.</th>
                    <th>Срок действия</th>
                    <th>Действия</th>
                </tr>
            @endif
            </thead>
            <tbody>
            @if(count($inspectors) < 1)
                <div class="alert alert-danger" role="alert">
                    Не добавлено ещё ни одного инспектора
                </div>
            @else
                @foreach($inspectors as $inspector)
                @if(strtotime($inspector->document_validity) < strtotime('+1 month'))
                    <tr>
                        <td>{{ $inspector->name }}</td>
                        <td>
                            <span style="@if(strtotime($inspector->document_validity) < time()) font-weight: 700; color: #ff0000; @endif">{{ $inspector->get_formed_data_document_validity() }}</span>
                        </td>
                        <td>
                            <a href="{{ route('inspectors.edit', ['id' => $inspector->id]) }}" class="btn btn-success">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-danger" onclick="if(confirm('Подтвердите удаление инспектора: {{ $inspector->name }}')){$('#item_{{ $inspector->id }}_delete').submit();}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <form action="{{ route('inspectors.destroy', ['id' => $inspector->id]) }}" id="item_{{ $inspector->id }}_delete" method="POST">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                    @endif
                @endforeach
            @endif
            </tbody>
        </table>
        </div>
    </div>
    <hr>
    <div class="justify-content-center" style="margin-bottom: 3%;">
    <h2>График дней рождений специалистов</h2>
    <table class="table table-bordered">
            <thead>
            @if(count($inspectors) > 0)
                <tr>
                    <th>Ф.И.О.</th>
                    <th>Номер телефона</th>
                    <th>Дата рождения</th>
                    <th>Должность</th>
                </tr>
            @endif
            </thead>
            <tbody>
            @if(count($inspectors) < 1)
                <div class="alert alert-danger" role="alert">
                    Не добавлено ещё ни одного инспектора
                </div>
            @else
                @foreach($inspectors as $inspector)
                    <tr>
                        <td>{{ $inspector->name }}</td>
                        <td>{{ $inspector->phone }}</td>
                        <td>{{ $inspector->get_formed_data_birth_day($inspector->birth_day) }}</td>
                        <td>{{ $inspector->position }}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
@section('css')
    <!--<link rel="stylesheet" href="https://cdn.oesmith.co.uk/morris-0.4.3.min.css">-->
    <style>
        .chart {
            display: none;
        }
    </style>
@endsection


@section('js')
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>-->
<!--<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>-->
<!--<script src="https://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js"></script>

<script>
    $(document).ready(function() {
        const ctxConclusions = document.getElementById('chartConclusions');
        const ctxActs = document.getElementById('chartActs');
        var token = $('input[name="_token"]').val();
        $('#showChart').change(function() {
            if($('#showChart').val() == 'Заключения') 
            {
                $('.chartActs').addClass('chart');
                $('.chartConclusions').removeClass('chart');
                $.post('{{ route('main.chartCreate') }}', {'_token': token}, function(dataConclusions){
                    //console.log(data);
                    var labels = [];
                    var dataCount = [];
                    $.each(dataConclusions, function(key, value) {
                        labels.push(value.name);
                        dataCount.push(value.count);
                    });
                    new Chart(ctxConclusions, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Заключения',
                                barPercentage: 1.1,
                                data: dataCount,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                    }
                });
                });
            }
            
            else if($('#showChart').val() == 'Акты') 
            {
                $('.chartConclusions').addClass('chart');
                $('.chartActs').removeClass('chart');
                $.post('{{ route('main.chartCreateAct') }}', {'_token': token}, function(dataActs){
                    //console.log(data);
                    var labels = [];
                    var dataCount = [];
                    $.each(dataActs, function(key, value) {
                        labels.push(value.name);
                        dataCount.push(value.count);
                    });
                    new Chart(chartActs, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Акты',
                                barPercentage: 1.1,
                                data: dataCount,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                    }
                });
                });
            } else {
                $('.chartConclusions').addClass('chart');
                $('.chartActs').addClass('chart');
            }
        });
        
        // $('#tableConclusions').DataTable({
        //     language: {
        //         url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/ru.json',
        //     },
        //     processing: true,
        //     serverSide: true,
        //     ajax: "{{ route('main.getConclusions') }}",
        //     columns: [
        //         {data: 'id', name: 'id'},
        //         {data: 'propan', name: 'propan'},

        //     ]

        // });

    });
</script>
@endsection