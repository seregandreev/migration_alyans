<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Путевой лист</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/print_waybill.css') }}">
</head>
<body>
    <div class="container">
        <div class="row">
          <div class="col-4 header-text">
            Место для штампа<br> организации
          </div>
          <div class="col-4">
            &nbsp;
          </div>
          <div class="col-4 mb-3 header-text">
            Типовая межотраслевая форма № 3<br>
            Утверждена постановлением <br>
            Госкомстата России от 28.11.97 №78 
          </div>
        </div>
        <div class="row">
            <div class="col-8 header-title">
                ПУТЕВОЙ ЛИСТ ЛЕГКОВОГО АВТОМОБИЛЯ
            </div>
            <div class="col-2 text-center">
                <u>АЭ</u><br>
                <span class="text-under">(серия)</span>
            </div>
            <div class="col-2 text-center">
                № <u>{{ $number }}</u><br>
                <span class="text-under">(номер)</span>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                Срок действия
            </div>
            <div class="col-10">
            @if(isset($waybill->date_from) || isset($waybill->date_to))
              {{ $waybill->get_formed_date_from($waybill->date_from) }} - {{ $waybill->get_formed_date_to($waybill->date_to) }}
            @else "______________________________________"
            @endif
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                Организация 
            </div>
            <div class="col-6">
                <div class="col-12 border-bottom">
                    ООО «АЛЬЯНСЭКСПЕРТ» г. Мегион ул. Губкина, 32, строение 1 тел. 8(34643)4-27-94, 1088605000230 
                </div>
                <div class="mt-0 text-center text-under">
                    (наименование, адрес, номер телефона, ОГРН)
                </div>
            </div>
            <div class="col-4">
                <table class="w-100">
                    <tr>
                        <td class="text-end">Форма по:</td>
                        <td class="border col-6 text-center">Коды</td>
                    </tr>
                    <tr>
                        <td class="text-end">ОКУД</td>
                        <td class="border">0345005</td>
                    </tr>
                    <tr>
                        <td class="text-end">ОКПО</td>
                        <td class="border">86041741</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                Тип и марка автомобиля 
            </div>
            <div class="col-5 text-center border-bottom">
                @if(!empty($transport->name)) {{ $transport->name }} @endif 
            </div>
            <div class="col-4">
                <table class="w-100">
                    <tr>
                        <td class="text-center">Сведения о перевозке</td>
                        <td class="border text-center">Перевозка для собственных нужд</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                Государственный номерной знак 
            </div>
            <div class="col-4 text-center border-bottom">
                @if(!empty( $transport->gos_num )) {{ $transport->gos_num }} @endif
            </div>
            <div class="col-4 text-end">
                <table class="w-100">
                    <tr>
                        <td>Номер парковки</td>
                        <td class="col-6 border text-center">@if(!empty( $transport->garage_number )) {{ $transport->garage_number }} @endif</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                Водитель 
            </div>
            <div class="col-6 text-center">
                <div class="col-12 border-bottom text-center">
                    @if(!empty( $driver->name )) {{ $nameDriver }} @endif
                </div>
                <div class="mt-0 text-under">
                    (фамилия, имя, отчество)
                </div>
            </div>
            <div class="col-4 text-end">
                <table class="w-100">
                    <tr>
                        <td class="col-6">Табельный номер</td>
                        <td class="col-6 border text-center">@if($driver->pers_number) {{ $driver->pers_number }} @endif</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                Удостоверение № 
            </div>
            <div class="col-3 text-center border-bottom">
                @if($driver->num_vu) {{ $driver->num_vu }} @endif
            </div>
            <div class="col-2 text-end">
              Класс 
            </div>
            <div class="col-3 text-center border-bottom">
                @if($driver->class_vu) {{ $driver->class_vu }} @endif
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                Лицензионная карточка
            </div>
            <div class="col-4 border-bottom">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-3">
                Регистрационный №
            </div>
            <div class="col-3 border-bottom">
            </div>
            <div class="col-1 text-end">
                Серия
            </div>
            <div class="col-2 border-bottom">
            </div>
            <div class="col-1 text-end">
                № 
            </div>
            <div class="col-1 border-bottom">
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <table class="w-100 table-med">
                    <tr>
                        <th>ФИО водителя</th>
                        <th>Время и дата</th>
                        <th>Должность</th>
                        <th>Подпись</th>
                        <th>Расшифровка подписи</th>
                    </tr>
                    @if(isset($waybill->doctor_name_before))
                    <tr>
                        <td colspan="5">{{ $waybill->medical_check_before }}</td>
                    </tr>
                    <tr>
                        <td>{{ $nameDriver }}</td>
                        <td>{{ $waybill->date_medical_check_before }}, {{ $waybill->time_medical_check_before }}</td>
                        <td>Фельдшер</td>
                        <td></td>
                        <td>{{ $waybill->doctor_name_before }}</td>
                    </tr>
                    @else
                    <tr>
                        <td colspan="5">&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    @endif
                    @if(isset($waybill->doctor_name_after))
                    <tr>
                        <td colspan="5">{{ $waybill->medical_check_after }}</td>
                    </tr>
                    <tr>
                        <td>{{ $nameDriver }}</td>
                        <td>{{ $waybill->date_medical_check_after }}, {{ $waybill->time_medical_check_after }}</td>
                        <td>Фельдшер</td>
                        <td></td>
                        <td>{{ $waybill->doctor_name_after }}</td>
                    </tr>
                    @else
                    <tr>
                        <td colspan="5">&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-3">Предрейсовый (предсменный) контроль</div>
            <div class="col-3">Автомобиль прошел предрейсовый контроль технического состояния</div>
            <div class="col-3">
                <div class="col-6 text-center border-bottom">
                    @if($waybill->date_transport_check_before) {{ $waybill->date_transport_check_before }}
                    @else &nbsp
                    @endif
                </div>
                <div class="col-6 text-under">
                    (дата)
                </div>
            </div>
            <div class="col-3">
                <div class="col-6 text-center border-bottom">
                    @if($waybill->time_transport_check_before) {{ $waybill->time_transport_check_before }}
                    @else &nbsp
                    @endif
                </div>
                <div class="col-6 text-under">
                    (время)
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                Контролер технического состояния автотранспортных средств<br>
                {{ $waybill->transport_check_before }}
            </div>
            <div class="col-2">
                <div class="col-12 border-bottom">
                    &nbsp;
                </div>
                <div class="col-12 text-under">
                    (подпись)
                </div>
            </div>
            <div class="col-4">
                <div class="col-12 text-center border-bottom">
                    {{ $nameMechanic }}
                </div>
                <div class="col-12 text-under">
                    (расшифр. подп.)
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6 header-title text-center">
                Задание водителю
            </div>
            <div class="col-6">
                <table class="w-100">
                    <tr>
                        <td class="col-8 text-end">Показания одометра, км</td>
                        <td class="col-4 border text-center">{{ $waybill->transport_meliage_before }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col-4">
                        В распоряжение
                    </div>
                    <div class="col-8">
                        <div class="col-12 border-bottom">
                            {{ $waybill->disposition_organization_name }}
                        </div>
                        <div class="col-12 text-center text-under">
                            (наименование организации)
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-12">
                        @if($waybill->transport_check_before === "Выпуск на линию разрешен") 
                            Выезд разрешен
                        @elseif($waybill->transport_check_before === "Выпуск на линию не разрешен") 
                            Выезд не разрешен
                        @else "_____________"
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                         Механик
                    </div>
                    <div class="col-2">
                        <div class="col-12 border-bottom">
                            &nbsp;
                        </div>
                        <div class="col-12 text-under">
                            (подпись)
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="col-12 text-center border-bottom">
                            {{ $nameMechanic }}
                        </div>
                        <div class="col-12 text-under">
                            (расшифр. подп.)
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col-4">Адрес подачи</div>
                    <div class="col-8 border-bottom">{{ $waybill->address_departure }}</div>
                </div>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-12 text-under">
                        @if($waybill->transport_check_before === "Выпуск на линию разрешен") 
                            Автомобиль в технически исправном состоянии принял
                        @elseif($waybill->transport_check_before === "Выпуск на линию не разрешен") 
                            Автомобиль в технически не исправном состоянии не принял
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                         Водитель
                    </div>
                    <div class="col-2">
                        <div class="col-12 border-bottom">
                            &nbsp;
                        </div>
                        <div class="col-12 text-under">
                            (подпись)
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="col-12 text-center border-bottom">
                            {{ $nameDriver }}
                        </div>
                        <div class="col-12 text-under">
                            (расшифр. подп.)
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col-8">
                        Дата, время выезда с парковки, ч. мин
                    </div>
                    <div class="col-4">
                        <table class="w-100 border text-center">
                            @if($waybill->date_transport_departure)
                            <tr>
                                <td>{{ $waybill->date_transport_departure }}</td>
                            </tr>
                            <tr>
                                <td>{{ $waybill->time_transport_departure }}</td>
                            </tr>
                            @else
                            <tr>
                                <td>&nbsp</td>
                            </tr>
                            <tr>
                                <td>&nbsp</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-4 text-end">
                        Горючее
                    </div>
                    <div class="col-8">
                        <table class="w-100 table-med">
                            <tr>
                                <th class="col-6 text-center">марка</th>
                                <th class="col-6 text-center">код</th>
                            </tr>
                            <tr>
                                <td>{{ $transport->type_sulder }}</td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- левая колонка -->
            <div class="col-6">
                <div class="row">
                    <div class="col-4">
                        Диспетчер-нарядчик
                    </div>
                    <div class="col-2">
                        <div class="col-12 border-bottom">
                            &nbsp;
                        </div>
                        <div class="col-12 text-under">
                            (подпись)
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="col-12 text-center border-bottom">
                            {{ $nameDispetcher }}
                        </div>
                        <div class="col-12 text-under">
                            (расшифр. подп.)
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        Дата, время возвращения на парковку, ч. мин.
                    </div>
                    <div class="col-4">
                        <table class="w-100 border text-center">
                            @if($waybill->date_transport_return)
                            <tr>
                                <td>{{ $waybill->date_transport_return }}</td>
                            </tr>
                            <tr>
                                <td>{{ $waybill->time_transport_return }}</td>
                            </tr>
                            @else
                            <tr>
                                <td>&nbsp</td>
                            </tr>
                            <tr>
                                <td>&nbsp</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Диспетчер-нарядчик
                    </div>
                    <div class="col-2">
                        <div class="col-12 border-bottom">
                            &nbsp;
                        </div>
                        <div class="col-12 text-under">
                            (подпись)
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="col-12 text-center border-bottom">
                            {{ $nameDispetcher }}
                        </div>
                        <div class="col-12 text-under">
                            (расшифр. подп.)
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-10">
                        Опоздания, ожидания, простои в пути, заезды на парковку и прочие отметки
                    </div>
                    <div class="col-2">&nbsp</div>
                </div>
                <div class="row">
                    <div class="col-12 border-bottom">
                        {{ $waybill->other_marks }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 border-bottom">
                        &nbsp
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 border-bottom">
                        &nbsp
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 border-bottom">
                        &nbsp
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Автомобиль сдал водитель
                    </div>
                    <div class="col-2">
                        <div class="col-12 border-bottom">
                            &nbsp;
                        </div>
                        <div class="col-12 text-under">
                            (подпись)
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="col-12 text-center border-bottom">
                            &nbsp;
                        </div>
                        <div class="col-12 text-under">
                            (расшифр. подп.)
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 text-center">М.П.</div>
                </div>
            </div>
            <!-- Правая колонка -->
            <div class="col-6">
                <div class="row">
                    <div class="col-12 header-title text-center">Движение горючего</div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="w-100">
                            <tr>
                                <td class="col-2">&nbsp</td>
                                <td class="col-4">&nbsp</td>
                                <td class="col-6 border">количество, л</td>
                            </tr>
                            <tr>
                                <td class="text-end">Выдано по заправочному листу № </td>
                                <td class="border-bottom"></td>
                                <td class="border">{{ $waybill->sulder_issued }}</td>
                            </tr>
                            <tr>
                                <td class="text-end">Остаток: </td>
                                <td class="text-end">при выезде</td>
                                <td class="border">{{ $waybill->sulder_departure }}</td>
                            </tr>
                            <tr>
                                <td>&nbsp</td>
                                <td class="text-end">возвращении</td>
                                <td class="border">{{ $waybill->sulder_return }}</td>
                            </tr>
                            <tr>
                                <td class="text-end">Расход: </td>
                                <td class="text-end">по норме</td>
                                <td class="border">{{ $waybill->expense_sulder_norm }}</td>
                            </tr>
                            <tr>
                                <td>&nbsp</td>
                                <td class="text-end">фактичческий</td>
                                <td class="border">{{ $waybill->expense_sulder_fact }}</td>
                            </tr>
                            <tr>
                                <td>&nbsp</td>
                                <td class="text-end">экономия</td>
                                <td class="border">{{ $waybill->economy_sulder }}</td>
                            </tr>
                            <tr>
                                <td>&nbsp</td>
                                <td class="text-end">перерасход</td>
                                <td class="border">{{ $waybill->overspending }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="w-100">
                            <tr>
                                <td class="col-8">Автомобиль принял. Показания одометра при возвращении на парковку, км</td>
                                <td class="col-4 border">{{ $waybill->transport_meliage_after }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        Механик
                    </div>
                    <div class="col-2">
                        <div class="col-12 border-bottom">
                            &nbsp;
                        </div>
                        <div class="col-12 text-under">
                            (подпись)
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="col-12 text-center border-bottom">
                            &nbsp;
                        </div>
                        <div class="col-12 text-under">
                            (расшифр. подп.)
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Оборотная сторона --}}
        <div class="page-2 mt-3">
            <div class="row">
                <div class="col-12 mb-3 text-end">Оборотная сторона формы № 3</div>
            </div>
            <table class="w-100 table-page-2">
                <thead>
                    <tr>
                        <th rowspan='3'>Номер по порядку</th>
                        <th rowspan='3'>Код заказчика</th>
                        <th colspan='2'>Место</th>
                        <th colspan='4'>Время</th>
                        <th rowspan='3'>Пройдено, км</th>
                        <th rowspan='3'>Подпись лица, пользовавшегося автомобилем</th>
                    </tr>
                    <tr>
                        <th rowspan='2'>отправления</th>
                        <th rowspan='2'>назначения</th>
                        <th colspan='2'>выезда</th>
                        <th colspan='2'>возвращения</th>
                    </tr>
                    <tr>
                        <th>ч.</th>
                        <th>мин.</th>
                        <th>ч.</th>
                        <th>мин.</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                </tbody>
            </table>
            <div class="row mt-3">
                <!--  -->
                <div class="col-6">
                    <div class="row">
                        <div class="col-12 header-title">
                            Результат работы автомобиля за смену:
                        </div>
                    </div>
                    <div class="row mt-3 mb-3">
                        <div class="col-6">
                            всего в наряде, ч.
                        </div>
                        <div class="col-6 border">
                            &nbsp
                        </div>
                    </div>
                    <div class="row mt-3 mb-3">
                        <div class="col-6">
                            пройдено, км
                        </div>
                        <div class="col-6 border">
                            &nbsp
                        </div>
                    </div>
                </div>
                <!--  -->
                <div class="col-6">
                    <div class="row">
                        <div class="col-12 header-title">
                            Расчет заработной платы:
                        </div>
                    </div>
                    <div class="row mt-3 mb-3">
                        <div class="col-6">
                            за километраж, руб. коп.
                        </div>
                        <div class="col-6 border">
                            &nbsp
                        </div>
                    </div>
                    <div class="row mt-3 mb-3">
                        <div class="col-6">
                            за часы, руб. коп.
                        </div>
                        <div class="col-6 border">
                            &nbsp
                        </div>
                    </div>
                    <div class="row mt-3 mb-3">
                        <div class="col-6">
                            Итого, руб. коп.
                        </div>
                        <div class="col-6 border">
                            &nbsp
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">Расчет произвел</div>
                <div class="col-3">
                    <div class="row">
                        <div class="col-10 border-bottom">
                            &nbsp
                        </div>
                        <div class="col-12 text-under">
                            (должность)
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="row">
                        <div class="col-10 border-bottom">
                            &nbsp
                        </div>
                        <div class="col-12 text-under">
                            (подпись)
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="row">
                        <div class="col-10 border-bottom">
                            &nbsp
                        </div>
                        <div class="col-12 text-under">
                            (расшифровка подписи)
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>

    <script>
		window.print();
	</script>
</body>
</html>

