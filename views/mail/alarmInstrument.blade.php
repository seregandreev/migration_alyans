<h2>ООО "АльянсЭксперт" <br>Лаборатория неразрушающего контроля</h2>

<table border=1>
    <thead>
        <tr>
            <th>Наименование</th>
            <th>Модель</th>
            <th>Метод</th>
            <th>№ сертификата</th>
            <th>Дата поверки</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        @for($i = 0; $i < count($dataInstruments['names']); $i++)
        <tr>
            <td>{{ $dataInstruments['names'][$i] }}</td>
            <td>{{ $dataInstruments['models'][$i] }}</td>
            <td>{{ $dataInstruments['methods'][$i] }}</td>
            <td>{{ $dataInstruments['sertificate_numbers'][$i] }}</td>
            @php($date = implode('.', array_reverse(explode('-', $dataInstruments['next_verification_dates'][$i]))))
            <td>{{ $date }} г.</td>
            <td><a href="https://bd.alyansekspert.ru/instruments/{{ $dataInstruments['ids'][$i] }}/edit" target="_blank">Перейти</a></td>
        </tr>
        @endfor
    </tbody>
</table>
