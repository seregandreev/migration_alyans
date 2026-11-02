<h4>Регистрация нового пользователя в системе:</h4>
<ul>
    <li><b>Компания</b>: {{ $user->company_on_register }}</li>
    <li><b>Ф.И.О.</b>: {{ $user->name }}</li>
    <li><b>Должность</b>: {{ $user->position }}</li>
    <li><b>E-mail</b>: {{ $user->email }}</li>
    <li><b>Номер телефона</b>: {{ $user->phone }}</li>
</ul>

<a href="https://bd.alyansekspert.ru/login">Перейти в личный кабинет</a>