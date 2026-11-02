<h3>ООО "АльянсЭксперт" <br>Лаборатория неразрушающего контроля</h3>

<p>У компаний подходит или просрочен срок заключений.</p>

<table border=1>
    <thead>
        <tr>
            <th>Компания</th>
            <th>Кол-во заключений</th>
        </tr>
    </thead>
    <tbody>
        @for($i = 0; $i < count($dataConclusionsVerif['userCompanyIds']); $i++)
        <tr>
            @if(isset($dataConclusionsVerif['userCompanyIds'][$i]))
                <td>{{ $dataConclusionsVerif['userCompanyNames'][$i] }}</td>
                <td>{{ $dataConclusionsVerif['cnts'][$i] }}</td>
            @endif
        </tr>
        @endfor
    </tbody>
</table>
<br>

<p>Ознакомиться подробно в <a href="http://bd.alyansekspert.ru/alarms"> личном кабинете.</a></p>

<b>Адрес:</b> ул. Губкина, 35/1, Мегион, Ханты-Мансийский автономный округ, 628684<br>
<b>Телефон:</b> 8 (346) 434-27-94