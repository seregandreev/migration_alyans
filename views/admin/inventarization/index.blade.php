@extends('layouts.template')
@section('title', 'Инвентаризация')
@section('header', 'Инвентаризация')

@section('content')
    @include('admin.inventarization.filters')

    <table class="table">
        <thead>
        <tr>
            <th>Дата</th>
            <th>Установки</th>
            <th>Компоненты</th>
            <th>Место проведения</th>
            <th>Итоговый результат</th>
        </tr>
        </thead>
        <tbody>
            @foreach($conclusions as $conclusion)
                <tr>
                    <td>{{ $conclusion->date }}</td>
                    <td>{{ $conclusion->component()->facility()->number.' ('.$conclusion->component()->facility()->gos_number.', '.$conclusion->component()->facility()->area.')' }}</td>
                    <td>
                        {{ $conclusion->component()->type()->name }}
                        <br>
                        {{ $conclusion->component()->type()->description }}
                        <br>
                        {{ $conclusion->component()->tape_number }}
                    </td>
                    <td>{{ $conclusion->component()->work_location()->name }}</td>
                    <td>
                        @php
                            $result = 'Годен';
                            $itog_uzt = 0;
                            // результат заключения общий
                            if($conclusion->mk_result == 'Не годен') {
                                $fGenReport['enter_mk'] = 'МК Годен';
                                $result = 'Не годен';
                            } elseif(strripos($conclusion->mk_result, 'Годен'))
                            {
                                $conclusion->mk_result = 'МК не годен';
                            } else
                                $conclusion->mk_result = ' ';


                            if(strripos($conclusion->vik_result, 'Недопустимых дефектов не обнаружено'))
                                $itog_uzt++;
                            elseif(empty($conclusion->vik_result))
                                $conclusion->vik_result = ' ';
                            else
                                $result = 'Не годен';

                            if(strripos($conclusion->uzt_result, 'не менее допустимых значений. Годен'))
                            {
                                $conclusion->uzt_result = 'Годен';
                                $itog_uzt++;
                            } elseif(empty($conclusion->uzt_result))
                                $conclusion->uzt_result = ' ';
                            else
                                $result = 'Не годен';


                            if(strripos($conclusion->gi_result, 'не признается выдержавшим гидравлическое испытание'))
                                $result = 'Не годен';
                            elseif(empty($conclusion->gi_result))
                                $conclusion->gi_result = '-';
                        @endphp
                        {{ $result }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection