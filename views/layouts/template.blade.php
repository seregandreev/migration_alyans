<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <link href="{{ asset('template/css/bootstrap.min.css') }}" rel="stylesheet">
    {{--<link href="{{ asset('template/font-awesome/css/font-awesome.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('template/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/js/plugins/gritter/jquery.gritter.css') }}" rel="stylesheet">
    <link href="{{ asset('template/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('template/css/style.css') }}" rel="stylesheet">
    @yield('css')
</head>

<body>
<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <img alt="image" style="width: 50px;" class="rounded-circle" src="@if(file_exists(public_path('avatars/'.Auth::id().'.jpg'))){{ asset('avatars/'.Auth::id().'.jpg') }}@else{{ asset('img/noavatar.svg') }}@endif">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="block m-t-xs font-bold">{{ Auth::user()->name}}</span>
                            <span class="text-muted text-xs block">{{ Auth::user()->position }} <b class="caret"></b></span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <!--<li><a class="dropdown-item" href="">Профиль</a></li>
                            <li><a class="dropdown-item" href="">Настройки</a></li>
                            <li><a class="dropdown-item" href="">Сообщения</a></li>
                            <li class="dropdown-divider"></li>-->
                            <li>
                                <button type="button" class="dropdown-item btn btn-link" style="width: 100%; line-height: 25px;" onclick="$('#logout').submit();">Выйти</button>

                                <form method="POST" action="{{ route('logout') }}" id="logout" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>


                @if(Auth::user()->role == 'Администратор')
                    <li><a href="{{ route('main.index') }}"><i class="fa fa-home"></i><span class="nav-label">Главная</span></a></li>
                    {{-- Лаборатория --}}
                    <li @if(Request::is('instruments') || Request::is('instruments/*') || Request::is('inspectors') || Request::is('inspectors/*') || Request::is('configs') || Request::is('configs/*')) class="active" @endif>
                    <a href=""><i class="fa fa-thermometer-half"></i><span class="nav-label">Лаборатория</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li @if(Request::is('instruments') || Request::is('instruments/*')) class="active" @endif><a href="{{ route('instruments.index') }}">Поверка инструмента</a></li>
                            {{-- Госты и РД --}}
                            <li @if(Request::is('configs') || Request::is('configs/*')) class="active" @endif><a href="{{ route('configs.index') }}">Госты и РД</a></li>
                            <li @if(Request::is('inspectors') || Request::is('inspectors/*')) class="active" @endif><a href="{{ route('inspectors.index') }}">Сотрудники</a></li>
                            <!--<li><a href="">Шаблон заключений</a></li>-->
                            <li><a href="">Табель сотрудников</a></li>
                        </ul>
                    </li>

                    {{-- Организации --}}
                    <li @if(Request::is('companies') || Request::is('companies/*')) class="active" @endif><a href="{{ route('companies.index') }}"><i class="fa fa-file"></i><span class="nav-label">Организации</span></a></li>
                    
                    {{-- Заключения --}}
                    <li @if(Request::is('types') || Request::is('types/*') || Request::is('components') || Request::is('components/*') || Request::is('conclusions') || Request::is('conclusions/*') || Request::is('acts') || Request::is('acts/*') || Request::is('admin/inventarization') || Request::is('admin/inventarization/*') || Request::is('qrs') || Request::is('qrs/*')) class="active" @endif>
                        <a href=""><i class="fa fa-paste"></i> <span class="nav-label">Заключения</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li @if(Request::is('types') || Request::is('types/*')) class="active" @endif><a href="{{ route('types.index') }}">Перечень типов оборудования</a></li>
                            {{-- Компоненты --}}
                            <li @if(Request::is('components') || Request::is('components/*')) class="active" @endif>
                                <a href="{{ route('components.index') }}">Реестр оборудования</a>
                            </li>
                            <li @if(Request::is('conclusions') || Request::is('conclusions/*')) class="active" @endif><a href="{{ route('conclusions.index') }}">Оформление заключений</a></li>
                            <!--<li @if(Request::is('admin/inventarization') || Request::is('admin/inventarization/*')) class="active" @endif><a href="{{ route('admin.inventarization') }}">Инвентаризация</a></li>-->
                            <li @if(Request::is('acts') || Request::is('acts/*')) class="active" @endif><a href="{{ route('acts.index') }}">Акты</a></li>
                            <li @if(Request::is('qrs') || Request::is('qrs/*')) class="active" @endif><a href="{{ route('qrs.index') }}">QR</a></li>
                        </ul>
                    </li>

                    {{-- Оповещения --}}
                    <li @if(Request::is('alarms') || Request::is('alarms/*')) class="active" @endif>
                        <a href="{{ route('alarms.index') }}"><i class="fa fa-lightbulb"></i> <span class="nav-label">Оповещения</span> @if(UserHelper::unreading_alarms() > 0) <span style="color: #ff0000;">({{ UserHelper::unreading_alarms() }})</span> @endif</a>
                    </li>
                    <!--{{-- Изменения --}}
                    <li @if(Request::is('news') || Request::is('news/*')) class="active" @endif>
                        <a href="{{ route('news.index') }}"><i class="fa fa-newspaper"></i> <span class="nav-label">Изменения</span></a>
                    </li>
                    {{-- Страницы --}}
                    <li @if(Request::is('admin/pages') || Request::is('admin/pages/*')) class="active" @endif>
                        <a href="{{ route('admin.pages') }}"><i class="fa fa-credit-card-alt"></i> <span class="nav-label">Страницы</span></a>
                    </li>
                    {{-- Заявки --}}
                    <li @if(Request::is('orders') || Request::is('orders/*')) class="active" @endif>
                        <a href="{{ route('orders.index') }}"><i class="fas fa-clipboard-list"></i> <span class="nav-label">Заявки</span></a>
                    </li>-->
                    {{-- Инструкции --}}
                    <li @if(Request::is('admin/instructions') || Request::is('admin/instructions/*')) class="active" @endif>
                        <a href="{{ route('admin.instructions') }}"><i class="fas fa-clipboard-list"></i> <span class="nav-label">Инструкции</span></a>
                    </li>
                    <!--{{-- Обратная связь --}}
                    <li @if(Request::is('pages/3/show')) class="active" @endif>
                        <a href="{{ route('pages.show', 3) }}"><i class="fas fa-comment"></i> <span class="nav-label">Обратная связь</span></a>
                    </li>-->
                    <li @if(Request::is('users') || Request::is('users/*')) @endif><a href="{{ route('users.index') }}"><i class="fa fa-users"></i><span class="nav-label">Пользователи базы</span></a></li>
                    
                    {{-- Автотранспорт --}}
                    <li @if(Request::is('drivers') || Request::is('drivers/*') || Request::is('waybills') || Request::is('waybills/*') || Request::is('transports') || Request::is('transports/*')) class="active" @endif>
                    <a href=""><i class="fa fa-truck"></i><span class="nav-label">Автотранспорт</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li @if(Request::is('drivers') || Request::is('drivers/*')) class="active" @endif>
                                <a href="{{ route('drivers.index') }}">Водители</a>
                            </li>
                            <li @if(Request::is('transports') || Request::is('transports/*')) class="active" @endif>
                                <a href="{{ route('transports.index') }}">Транспорт</a>
                            </li>
                            <li @if(Request::is('waybills') || Request::is('waybills/*')) class="active" @endif>
                                <a href="{{ route('waybills.index') }}">Путевые листы</a>
                            </li>
                        </ul>
                    </li>

                @elseif(Auth::user()->role == 'Работник лаборатории')
                <li><a href="{{ route('main.index') }}"><i class="fa fa-home"></i><span class="nav-label">Главная</span></a></li>
                {{-- Лаборатория --}}
                    <li @if(Request::is('instruments') || Request::is('instruments/*') || Request::is('inspectors') || Request::is('inspectors/*') || Request::is('configs') || Request::is('configs/*')) || Request::is('transports') || Request::is('transports/*')) class="active" @endif>
                    <a href=""><i class="fa fa-thermometer-half"></i><span class="nav-label">Лаборатория</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li @if(Request::is('instruments') || Request::is('instruments/*')) class="active" @endif><a href="{{ route('instruments.index') }}">Поверка инструментов</a></li>
                            {{-- Госты и РД --}}
                            <!--<li @if(Request::is('configs') || Request::is('configs/*')) class="active" @endif><a href="{{ route('configs.index') }}">Госты и РД</a></li> -->
                            <li @if(Request::is('inspectors') || Request::is('inspectors/*')) class="active" @endif><a href="{{ route('inspectors.index') }}">Сотрудники</a></li>
                            <!--<li><a href="">Шаблон заключений</a></li>
                            <li><a href="">Табель сотрудников</a></li>-->
                        </ul>
                    </li>

                    {{-- Организации --}}
                    <li @if(Request::is('companies') || Request::is('companies/*')) class="active" @endif><a href="{{ route('companies.index') }}"><i class="fa fa-file"></i><span class="nav-label">Организации</span></a></li>
                    
                    {{-- Заключения --}}
                    <li @if(Request::is('types') || Request::is('types/*') || Request::is('components') || Request::is('components/*') || Request::is('conclusions') || Request::is('conclusions/*') || Request::is('acts') || Request::is('acts/*') || Request::is('admin/inventarization') || Request::is('admin/inventarization/*') || Request::is('qrs') || Request::is('qrs/*')) class="active" @endif>
                        <a href=""><i class="fa fa-paste"></i> <span class="nav-label">Заключения</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li @if(Request::is('types') || Request::is('types/*')) class="active" @endif>
                                <a href="{{ route('types.index') }}">Перечень типов оборудования</a>
                            </li>
                            {{-- Компоненты --}}
                            <li @if(Request::is('components') || Request::is('components/*')) class="active" @endif>
                                <a href="{{ route('components.index') }}">Реестр оборудования</a>
                            </li>
                            <li @if(Request::is('conclusions') || Request::is('conclusions/*')) class="active" @endif>
                                <a href="{{ route('conclusions.index') }}">Оформление заключений</a>
                            </li>
                            <!--<li @if(Request::is('admin/inventarization') || Request::is('admin/inventarization/*')) class="active" @endif><a href="{{ route('admin.inventarization') }}">Инвентаризация</a></li>-->
                            <li @if(Request::is('acts') || Request::is('acts/*')) class="active" @endif><a href="{{ route('acts.index') }}">Акты</a></li>
                            <li @if(Request::is('qrs') || Request::is('qrs/*')) class="active" @endif><a href="{{ route('qrs.index') }}">QR</a></li>
                        </ul>
                    </li>
                    {{-- Оповещения --}}
                    <li @if(Request::is('alarms') || Request::is('alarms/*')) class="active" @endif>
                        <a href="{{ route('alarms.index') }}"><i class="fa fa-lightbulb"></i> <span class="nav-label">Оповещения</span> @if(UserHelper::unreading_alarms() > 0) <span style="color: #ff0000;">({{ UserHelper::unreading_alarms() }})</span> @endif</a>
                    </li>
                    <!--{{-- Изменения --}}
                    <li @if(Request::is('news') || Request::is('news/*')) class="active" @endif>
                        <a href="{{ route('news.index') }}"><i class="fa fa-newspaper"></i> <span class="nav-label">Изменения</span></a>
                    </li>
                    {{-- Страницы --}}
                    <li @if(Request::is('admin/pages') || Request::is('admin/pages/*')) class="active" @endif>
                        <a href="{{ route('admin.pages') }}"><i class="fa fa-credit-card-alt"></i> <span class="nav-label">Страницы</span></a>
                    </li>
                    {{-- Заявки --}}
                    <li @if(Request::is('orders') || Request::is('orders/*')) class="active" @endif>
                        <a href="{{ route('orders.index') }}"><i class="fas fa-clipboard-list"></i> <span class="nav-label">Заявки</span></a>
                    </li>-->
                    {{-- Инструкции --}}
                    <li @if(Request::is('admin/instructions') || Request::is('admin/instructions/*')) class="active" @endif>
                        <a href="{{ route('admin.instructions') }}"><i class="fas fa-clipboard-list"></i> <span class="nav-label">Инструкции</span></a>
                    </li>
                    <!--{{-- Обратная связь --}}
                    <li @if(Request::is('pages/3/show')) class="active" @endif>
                        <a href="{{ route('pages.show', 3) }}"><i class="fas fa-comment"></i> <span class="nav-label">Обратная связь</span></a>
                    </li>-->
                    <li @if(Request::is('users') || Request::is('users/*')) @endif><a href="{{ route('users.index') }}"><i class="fa fa-users"></i><span class="nav-label">Пользователи базы</span></a></li>

                @elseif(Auth::user()->role == 'Пользователь')
                    {{-- Заключения --}}
                    <li @if(Request::is('conclusions') || Request::is('conclusions/*') || Request::is('acts') || Request::is('acts/*')) class="active" @endif>
                        <a href=""><i class="fa fa-paste"></i> <span class="nav-label">Документы</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li @if(Request::is('conclusions') || Request::is('conclusions/*')) class="active" @endif>
                                <a href="{{ route('conclusions.index') }}">Заключения</a>
                            </li>
                            <!--<li @if(Request::is('acts') || Request::is('acts/*')) class="active" @endif><a href="{{ route('acts.index') }}">Акты</a></li>-->
                            {{-- Компоненты --}}
                            <li @if(Request::is('components') || Request::is('components/*')) class="active" @endif>
                                <a href="{{ route('components.index') }}">Реестр оборудования</a>
                            </li>
                        </ul>
                    </li>
                    {{-- Оповещения --}}
                    <li @if(Request::is('alarms') || Request::is('alarms/*')) class="active" @endif>
                        <a href="{{ route('alarms.index') }}"><i class="fa fa-lightbulb"></i> <span class="nav-label">Оповещения</span> @if(UserHelper::unreading_alarms() > 0) <span style="color: #ff0000;">({{ UserHelper::unreading_alarms() }})</span> @endif</a>
                    </li>
                    <!--{{-- Изменения --}}
                    <li @if(Request::is('news') || Request::is('news/*')) class="active" @endif>
                        <a href="{{ route('news.index') }}"><i class="fa fa-newspaper"></i> <span class="nav-label">Изменения</span></a>
                    </li>
                    {{-- Заявки --}}
                    <li @if(Request::is('orders') || Request::is('orders/*')) class="active" @endif>
                        <a href="{{ route('orders.index') }}"><i class="fas fa-clipboard-list"></i> <span class="nav-label">Заявки</span></a>
                    </li>-->
                    {{-- Инструкции --}}
                    <li @if(Request::is('admin/instructions') || Request::is('admin/instructions/*')) class="active" @endif>
                        <a href="{{ route('admin.instructions') }}"><i class="fas fa-clipboard-list"></i> <span class="nav-label">Инструкции</span></a>
                    </li>
                    <!--{{-- Обратная связь --}}
                    <li @if(Request::is('pages/3/show')) class="active" @endif>
                        <a href="{{ route('pages.show', 3) }}"><i class="fas fa-comment"></i> <span class="nav-label">Обратная связь</span></a>
                    </li>-->
                @elseif(Auth::user()->role == 'Диспетчер')
                {{-- Автотранспорт --}}
                    <li @if(Request::is('drivers') || Request::is('drivers/*') || Request::is('waybills') || Request::is('waybills/*') || Request::is('transports') || Request::is('transports/*')) class="active" @endif>
                    <a href=""><i class="fa fa-truck"></i><span class="nav-label">Автотранспорт</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li @if(Request::is('drivers') || Request::is('drivers/*')) class="active" @endif>
                                <a href="{{ route('drivers.index') }}">Водители</a>
                            </li>
                            <li @if(Request::is('transports') || Request::is('transports/*')) class="active" @endif>
                                <a href="{{ route('transports.index') }}">Транспорт</a>
                            </li>
                            <li @if(Request::is('waybills') || Request::is('waybills/*')) class="active" @endif>
                                <a href="{{ route('waybills.index') }}">Путевые листы</a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>

        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom btn_toggle">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    {{--<form role="search" class="navbar-form-custom" action="search_results.html">--}}
                        {{--<div class="form-group">--}}
                            {{--<input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">--}}
                        {{--</div>--}}
                    {{--</form>--}}
                </div>
                {{--<ul class="nav navbar-top-links navbar-right">--}}
                    {{--<li style="padding: 20px">--}}
                    {{--<span class="m-r-sm text-muted welcome-message">Test text</span>--}
                    {{--</li>--}}
                    {{--<li class="dropdown">--}}
                        {{--<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">--}}
                            {{--<i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>--}}
                        {{--</a>--}}
                        {{--<ul class="dropdown-menu dropdown-messages dropdown-menu-right">--}}
                            {{--<li>--}}
                                {{--<div class="dropdown-messages-box">--}}
                                    {{--<a class="dropdown-item float-left" href="profile.html">--}}
                                        {{--<img alt="image" class="rounded-circle" src="img/a7.jpg">--}}
                                    {{--</a>--}}
                                    {{--<div class="media-body">--}}
                                        {{--<small class="float-right">46h ago</small>--}}
                                        {{--<strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>--}}
                                        {{--<small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</li>--}}
                            {{--<li class="dropdown-divider"></li>--}}
                            {{--<li>--}}
                                {{--<div class="dropdown-messages-box">--}}
                                    {{--<a class="dropdown-item float-left" href="profile.html">--}}
                                        {{--<img alt="image" class="rounded-circle" src="img/a4.jpg">--}}
                                    {{--</a>--}}
                                    {{--<div class="media-body ">--}}
                                        {{--<small class="float-right text-navy">5h ago</small>--}}
                                        {{--<strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>--}}
                                        {{--<small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</li>--}}
                            {{--<li class="dropdown-divider"></li>--}}
                            {{--<li>--}}
                                {{--<div class="dropdown-messages-box">--}}
                                    {{--<a class="dropdown-item float-left" href="profile.html">--}}
                                        {{--<img alt="image" class="rounded-circle" src="img/profile.jpg">--}}
                                    {{--</a>--}}
                                    {{--<div class="media-body ">--}}
                                        {{--<small class="float-right">23h ago</small>--}}
                                        {{--<strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>--}}
                                        {{--<small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</li>--}}
                            {{--<li class="dropdown-divider"></li>--}}
                            {{--<li>--}}
                                {{--<div class="text-center link-block">--}}
                                    {{--<a href="mailbox.html" class="dropdown-item">--}}
                                        {{--<i class="fa fa-envelope"></i> <strong>Read All Messages</strong>--}}
                                    {{--</a>--}}
                                {{--</div>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                    {{--<li class="dropdown">--}}
                        {{--<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">--}}
                            {{--<i class="fa fa-bell"></i>  <span class="label label-primary">8</span>--}}
                        {{--</a>--}}
                        {{--<ul class="dropdown-menu dropdown-alerts">--}}
                            {{--<li>--}}
                                {{--<a href="mailbox.html" class="dropdown-item">--}}
                                    {{--<div>--}}
                                        {{--<i class="fa fa-envelope fa-fw"></i> You have 16 messages--}}
                                        {{--<span class="float-right text-muted small">4 minutes ago</span>--}}
                                    {{--</div>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            {{--<li class="dropdown-divider"></li>--}}
                            {{--<li>--}}
                                {{--<a href="profile.html" class="dropdown-item">--}}
                                    {{--<div>--}}
                                        {{--<i class="fa fa-twitter fa-fw"></i> 3 New Followers--}}
                                        {{--<span class="float-right text-muted small">12 minutes ago</span>--}}
                                    {{--</div>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            {{--<li class="dropdown-divider"></li>--}}
                            {{--<li>--}}
                                {{--<a href="grid_options.html" class="dropdown-item">--}}
                                    {{--<div>--}}
                                        {{--<i class="fa fa-upload fa-fw"></i> Server Rebooted--}}
                                        {{--<span class="float-right text-muted small">4 minutes ago</span>--}}
                                    {{--</div>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            {{--<li class="dropdown-divider"></li>--}}
                            {{--<li>--}}
                                {{--<div class="text-center link-block">--}}
                                    {{--<a href="notifications.html" class="dropdown-item">--}}
                                        {{--<strong>See All Alerts</strong>--}}
                                        {{--<i class="fa fa-angle-right"></i>--}}
                                    {{--</a>--}}
                                {{--</div>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}


                    {{--<li>--}}
                        {{--<a href="#" onclick="$('#logout').submit();">--}}
                            {{--<i class="fa fa-sign-out"></i> Выйти--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a class="right-sidebar-toggle">--}}
                            {{--<i class="fa fa-tasks"></i>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}

            </nav>
        </div>
       <!-- <div class="row  border-bottom  dashboard-header">-->
       <div>
            @yield('header')
        </div>
        <div class="wrapper wrapper-content">
            @yield('content')
        </div>
        <div class="footer">
            <div class="links">
                <a href="{{ route('pages.show', 1) }}">Политика конфиденциальности</a>
                |
                <a href="{{ route('pages.show', 2) }}">Соглашение на обработку персональных данных</a>
            </div>
            {{--<div class="float-right">--}}
                {{--10GB of <strong>250GB</strong> Free.--}}
            {{--</div>--}}
            <div>
                <strong>&copy;</strong> 2008. ООО "АльянсЭксперт". All Rights Reserved.
            </div>
        </div>
    </div>
    <div class="small-chat-box fadeInRight animated">

        <div class="heading" draggable="true">
            <small class="chat-date float-right">
                02.19.2015
            </small>
            Small chat
        </div>

        <div class="content">

            <div class="left">
                <div class="author-name">
                    Monica Jackson <small class="chat-date">
                        10:02 am
                    </small>
                </div>
                <div class="chat-message active">
                    Lorem Ipsum is simply dummy text input.
                </div>

            </div>
            <div class="right">
                <div class="author-name">
                    Mick Smith
                    <small class="chat-date">
                        11:24 am
                    </small>
                </div>
                <div class="chat-message">
                    Lorem Ipsum is simpl.
                </div>
            </div>
            <div class="left">
                <div class="author-name">
                    Alice Novak
                    <small class="chat-date">
                        08:45 pm
                    </small>
                </div>
                <div class="chat-message active">
                    Check this stock char.
                </div>
            </div>
            <div class="right">
                <div class="author-name">
                    Anna Lamson
                    <small class="chat-date">
                        11:24 am
                    </small>
                </div>
                <div class="chat-message">
                    The standard chunk of Lorem Ipsum
                </div>
            </div>
            <div class="left">
                <div class="author-name">
                    Mick Lane
                    <small class="chat-date">
                        08:45 pm
                    </small>
                </div>
                <div class="chat-message active">
                    I belive that. Lorem Ipsum is simply dummy text.
                </div>
            </div>


        </div>
        <div class="form-chat">
            <div class="input-group input-group-sm">
                <input type="text" class="form-control">
                <span class="input-group-btn"> <button
                            class="btn btn-primary" type="button">Send
                </button> </span></div>
        </div>

    </div>
    {{--<div id="small-chat">--}}

        {{--<span class="badge badge-warning float-right">5</span>--}}
        {{--<a class="open-small-chat" href="">--}}
            {{--<i class="fa fa-comments"></i>--}}

        {{--</a>--}}
    {{--</div>--}}
    <div id="right-sidebar" class="animated">
        <div class="sidebar-container">

            <ul class="nav nav-tabs navs-3">
                <li>
                    <a class="nav-link active" data-toggle="tab" href="#tab-1"> Notes </a>
                </li>
                <li>
                    <a class="nav-link" data-toggle="tab" href="#tab-2"> Projects </a>
                </li>
                <li>
                    <a class="nav-link" data-toggle="tab" href="#tab-3"> <i class="fa fa-gear"></i> </a>
                </li>
            </ul>

            <div class="tab-content">


                <div id="tab-1" class="tab-pane active">

                    <div class="sidebar-title">
                        <h3> <i class="fa fa-comments-o"></i> Latest Notes</h3>
                        <small><i class="fa fa-tim"></i> You have 10 new message.</small>
                    </div>

                    {{--<div>--}}

                        {{--<div class="sidebar-message">--}}
                            {{--<a href="#">--}}
                                {{--<div class="float-left text-center">--}}
                                    {{--<img alt="image" class="rounded-circle message-avatar" src="img/a1.jpg">--}}

                                    {{--<div class="m-t-xs">--}}
                                        {{--<i class="fa fa-star text-warning"></i>--}}
                                        {{--<i class="fa fa-star text-warning"></i>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="media-body">--}}

                                    {{--There are many variations of passages of Lorem Ipsum available.--}}
                                    {{--<br>--}}
                                    {{--<small class="text-muted">Today 4:21 pm</small>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                        {{--<div class="sidebar-message">--}}
                            {{--<a href="#">--}}
                                {{--<div class="float-left text-center">--}}
                                    {{--<img alt="image" class="rounded-circle message-avatar" src="img/a2.jpg">--}}
                                {{--</div>--}}
                                {{--<div class="media-body">--}}
                                    {{--The point of using Lorem Ipsum is that it has a more-or-less normal.--}}
                                    {{--<br>--}}
                                    {{--<small class="text-muted">Yesterday 2:45 pm</small>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                        {{--<div class="sidebar-message">--}}
                            {{--<a href="#">--}}
                                {{--<div class="float-left text-center">--}}
                                    {{--<img alt="image" class="rounded-circle message-avatar" src="img/a3.jpg">--}}

                                    {{--<div class="m-t-xs">--}}
                                        {{--<i class="fa fa-star text-warning"></i>--}}
                                        {{--<i class="fa fa-star text-warning"></i>--}}
                                        {{--<i class="fa fa-star text-warning"></i>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="media-body">--}}
                                    {{--Mevolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).--}}
                                    {{--<br>--}}
                                    {{--<small class="text-muted">Yesterday 1:10 pm</small>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                        {{--<div class="sidebar-message">--}}
                            {{--<a href="#">--}}
                                {{--<div class="float-left text-center">--}}
                                    {{--<img alt="image" class="rounded-circle message-avatar" src="img/a4.jpg">--}}
                                {{--</div>--}}

                                {{--<div class="media-body">--}}
                                    {{--Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the--}}
                                    {{--<br>--}}
                                    {{--<small class="text-muted">Monday 8:37 pm</small>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                        {{--<div class="sidebar-message">--}}
                            {{--<a href="#">--}}
                                {{--<div class="float-left text-center">--}}
                                    {{--<img alt="image" class="rounded-circle message-avatar" src="img/a8.jpg">--}}
                                {{--</div>--}}
                                {{--<div class="media-body">--}}

                                    {{--All the Lorem Ipsum generators on the Internet tend to repeat.--}}
                                    {{--<br>--}}
                                    {{--<small class="text-muted">Today 4:21 pm</small>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                        {{--<div class="sidebar-message">--}}
                            {{--<a href="#">--}}
                                {{--<div class="float-left text-center">--}}
                                    {{--<img alt="image" class="rounded-circle message-avatar" src="img/a7.jpg">--}}
                                {{--</div>--}}
                                {{--<div class="media-body">--}}
                                    Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
                                    {{--<br>--}}
                                    {{--<small class="text-muted">Yesterday 2:45 pm</small>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                        {{--<div class="sidebar-message">--}}
                            {{--<a href="#">--}}
                                {{--<div class="float-left text-center">--}}
                                    {{--<img alt="image" class="rounded-circle message-avatar" src="img/a3.jpg">--}}

                                    {{--<div class="m-t-xs">--}}
                                        {{--<i class="fa fa-star text-warning"></i>--}}
                                        {{--<i class="fa fa-star text-warning"></i>--}}
                                        {{--<i class="fa fa-star text-warning"></i>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="media-body">--}}
                                    {{--The standard chunk of Lorem Ipsum used since the 1500s is reproduced below.--}}
                                    {{--<br>--}}
                                    {{--<small class="text-muted">Yesterday 1:10 pm</small>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                        {{--<div class="sidebar-message">--}}
                            {{--<a href="#">--}}
                                {{--<div class="float-left text-center">--}}
                                    {{--<img alt="image" class="rounded-circle message-avatar" src="img/a4.jpg">--}}
                                {{--</div>--}}
                                {{--<div class="media-body">--}}
                                    {{--Uncover many web sites still in their infancy. Various versions have.--}}
                                    {{--<br>--}}
                                    {{--<small class="text-muted">Monday 8:37 pm</small>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                </div>

                <div id="tab-2" class="tab-pane">

                    <div class="sidebar-title">
                        <h3> <i class="fa fa-cube"></i> Latest projects</h3>
                        <small><i class="fa fa-tim"></i> You have 14 projects. 10 not completed.</small>
                    </div>

                    <ul class="sidebar-list">
                        <li>
                            <a href="#">
                                <div class="small float-right m-t-xs">9 hours ago</div>
                                <h4>Business valuation</h4>
                                It is a long established fact that a reader will be distracted.

                                <div class="small">Completion with: 22%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 22%;" class="progress-bar progress-bar-warning"></div>
                                </div>
                                <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="small float-right m-t-xs">9 hours ago</div>
                                <h4>Contract with Company </h4>
                                Many desktop publishing packages and web page editors.

                                <div class="small">Completion with: 48%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 48%;" class="progress-bar"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="small float-right m-t-xs">9 hours ago</div>
                                <h4>Meeting</h4>
                                By the readable content of a page when looking at its layout.

                                <div class="small">Completion with: 14%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 14%;" class="progress-bar progress-bar-info"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="label label-primary float-right">NEW</span>
                                <h4>The generated</h4>
                                There are many variations of passages of Lorem Ipsum available.
                                <div class="small">Completion with: 22%</div>
                                <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="small float-right m-t-xs">9 hours ago</div>
                                <h4>Business valuation</h4>
                                It is a long established fact that a reader will be distracted.

                                <div class="small">Completion with: 22%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 22%;" class="progress-bar progress-bar-warning"></div>
                                </div>
                                <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="small float-right m-t-xs">9 hours ago</div>
                                <h4>Contract with Company </h4>
                                Many desktop publishing packages and web page editors.

                                <div class="small">Completion with: 48%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 48%;" class="progress-bar"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="small float-right m-t-xs">9 hours ago</div>
                                <h4>Meeting</h4>
                                By the readable content of a page when looking at its layout.

                                <div class="small">Completion with: 14%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 14%;" class="progress-bar progress-bar-info"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="label label-primary float-right">NEW</span>
                                <h4>The generated</h4>
                                <!--<div class="small float-right m-t-xs">9 hours ago</div>-->
                                There are many variations of passages of Lorem Ipsum available.
                                <div class="small">Completion with: 22%</div>
                                <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                            </a>
                        </li>

                    </ul>

                </div>

                <div id="tab-3" class="tab-pane">

                    <div class="sidebar-title">
                        <h3><i class="fa fa-gears"></i> Settings</h3>
                        <small><i class="fa fa-tim"></i> You have 14 projects. 10 not completed.</small>
                    </div>

                    <div class="setings-item">
                    <span>
                        Show notifications
                    </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example">
                                <label class="onoffswitch-label" for="example">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
                    <span>
                        Disable Chat
                    </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="collapsemenu" checked class="onoffswitch-checkbox" id="example2">
                                <label class="onoffswitch-label" for="example2">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
                    <span>
                        Enable history
                    </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example3">
                                <label class="onoffswitch-label" for="example3">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
                    <span>
                        Show charts
                    </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example4">
                                <label class="onoffswitch-label" for="example4">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
                    <span>
                        Offline users
                    </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" checked name="collapsemenu" class="onoffswitch-checkbox" id="example5">
                                <label class="onoffswitch-label" for="example5">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
                    <span>
                        Global search
                    </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" checked name="collapsemenu" class="onoffswitch-checkbox" id="example6">
                                <label class="onoffswitch-label" for="example6">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
                    <span>
                        Update everyday
                    </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example7">
                                <label class="onoffswitch-label" for="example7">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="sidebar-content">
                        <h4>Settings</h4>
                        <div class="small">
                            I belive that. Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            And typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                            Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mainly scripts -->
<script src="{{ asset('template/js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('template/js/popper.min.js') }}"></script>
<script src="{{ asset('template/js/bootstrap.js') }}"></script>
<script src="{{ asset('template/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('template/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('template/js/plugins/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('template/js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
<script src="{{ asset('template/js/plugins/flot/jquery.flot.spline.js') }}"></script>
<script src="{{ asset('template/js/plugins/flot/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('template/js/plugins/flot/jquery.flot.pie.js') }}"></script>
<script src="{{ asset('template/js/plugins/peity/jquery.peity.min.js') }}"></script>
<script src="{{ asset('template/js/demo/peity-demo.js') }}"></script>
<script src="{{ asset('template/js/inspinia.js') }}"></script>
<script src="{{ asset('template/js/plugins/pace/pace.min.js') }}"></script>
<script src="{{ asset('template/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('template/js/plugins/gritter/jquery.gritter.min.js') }}"></script>
<script src="{{ asset('template/js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('template/js/demo/sparkline-demo.js') }}"></script>
<script src="{{ asset('template/js/plugins/chartJs/Chart.min.js') }}"></script>
<script src="{{ asset('template/js/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('js/fa.js') }}" crossorigin="anonymous"></script>
@yield('js')

</body>
</html>
