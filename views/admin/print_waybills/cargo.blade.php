<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Путевой лист</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/print_cargo.css') }}">
</head>
<body>
    <div class='w-100'>
        <div class="row mb-2">
          <div class="col-2 text-center header-text">
            Место для штампа<br> организации
          </div>
          <div class="col-6 text-center">
              <div class='row'>
                <div class='col-12 header-title'>
                    ПУТЕВОЙ ЛИСТ
                </div>
              </div>
              <div class='row'>
                    <div class='col-8 header-title' style='margin-right: -6px;'>
                        грузового автомобиля
                    </div>
                    <div class="col-2">
                        <div class='row' style='margin-right: 6px;'>
                            <div class='col-12 border-bottom'>
                                АЭ
                            </div>
                            <div class='col-12 text-under'>
                                (серия)
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class='row'>
                            <div class='col-12 border-bottom'>
                                № {{ $number }}
                            </div>
                            <div class='col-12 text-under'>
                                (номер)
                            </div>
                        </div>
                    </div>
                </div>
          </div>
          <div class='col-1'>&nbsp</div>
          <div class="col-3 header-text">
            Типовая межотраслевая форма № 4-П<br>
            Утверждена постановлением <br>
            Госкомстата России от 28.11.97 №78 
          </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
            @if(isset($waybill->date_from) || isset($waybill->date_to))
              {{ $waybill->get_formed_date_from($waybill->date_from) }} - {{ $waybill->get_formed_date_to($waybill->date_to) }}
            @else «_____» _____________________ ______ г.
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
                        <td class="border text-center">0345005</td>
                    </tr>
                    <tr>
                        <td class="text-end">ОКПО</td>
                        <td class="border text-center">86041741</td>
                    </tr>
                </table>
            </div>
        </div>


        
        <div class='row'>
        {{-- левая колонка --}}
            <div class='col-6'>
                <div class='row'>
                    <div class='col-10'>&nbsp</div>
                    <div class='col-2'>
                        <table class='w-100 table-med'>
                            <tr>
                                <td>&nbsp</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-10 text-before text-end'>Режим работы</div>
                    <div class='col-2'>
                        <table class='w-100 table-med'>
                            <tr>
                                <td>&nbsp</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-10 text-before text-end'>Колонна</div>
                    <div class='col-2'>
                        <table class='w-100 table-med'>
                            <tr>
                                <td>&nbsp</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-10 text-before text-end'>Бригада</div>
                    <div class='col-2'>
                        <table class='w-100 table-med'>
                            <tr>
                                <td>&nbsp</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-2 text-before'>Марка автомобиля</div>
                    <div class='col-8 text-center header-title border-bottom'>
                        @if(!empty($transport->name)) {{ $transport->name }} @endif
                    </div>
                    <div class='col-2'>
                        <table class='w-100 table-med'>
                            <tr>
                                <td>&nbsp</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-4 text-before'>Государственный номерной знак</div>
                    <div class='col-4 text-center header-title border-bottom'>
                        @if(!empty($transport->gos_num)) {{ $transport->gos_num }} @endif
                    </div>
                    <div class='col-2 text-before text-end'>Гаражный номер</div>
                    <div class='col-2'>
                        <table class='w-100 table-med'>
                            <tr>
                                <td>@if(!empty($transport->garage_number)) {{ $transport->garage_number }} @endif</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-2 text-before'>Водитель</div>
                    <div class='col-6'>
                        <div class='row'>
                            <div class='col-12 text-center border-bottom'>
                                @if(!empty($driver->name)) {{ $nameDriver }} @endif
                            </div>
                        </div>
                        <div class='col-12 text-under-over'>
                            (фамилия, имя, отчество)
                        </div>
                    </div>
                    <div class='col-2 text-before text-end'>Табельный номер</div>
                    <div class='col-2'>
                        <table class='w-100 table-med'>
                            <tr>
                                <td>@if(!empty($driver->pers_number)) {{ $driver->pers_number }} @endif</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-3 text-before'>
                        Удостоверение №
                    </div>
                    <div class="col-2 text-center border-bottom">
                        @if($driver->num_vu) {{ $driver->num_vu }} @endif
                    </div>
                    <div class='col-2 text-before text-end'>Класс</div>
                    <div class='col-2 text-center border-bottom'>
                        @if($driver->class_vu) {{ $driver->class_vu }} @endif
                    </div>
                </div>
                <div class='row'>
                    <div class='col-4 text-before'>Лицензионная карточка</div>
                    <div class='col-4'>
                        <div class='row'>
                            <div class='col-12 text-before text-center border-bottom'>
                                стандартная, ограниченная
                            </div>
                            <div class='col-12 text-under-over'>
                                (ненужное зачеркнуть)
                            </div>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-3 text-before'>
                        Регистрационный №
                    </div>
                    <div class='col-2 border-bottom'>
                        &nbsp
                    </div>
                    <div class='col-1 text-before'>
                        Серия
                    </div>
                    <div class='col-2 border-bottom'>
                        &nbsp
                    </div>
                    <div class='col-1'>№</div>
                    <div class='col-2 border-bottom'>&nbsp</div>
                </div>
                <div class='row'>
                    <div class='col-1 text-before'>Прицеп 1</div>
                    <div class='col-2'>
                        <div class='row'>
                            <div class='col-12 border-bottom'>&nbsp</div>
                            <div class='col-12 text-under-over'>(марка)</div>
                        </div>
                    </div>
                    <div class='col-3 text-before'>Государственный номерной знак</div>
                    <div class='col-2 border-bottom'>&nbsp</div>
                    <div class='col-2 text-before text-end'>Гаражный номер</div>
                    <div class='col-2'>
                        <table class='w-100 table-med'>
                            <tr>
                                <td>&nbsp</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-1 text-before'>Прицеп 2</div>
                    <div class='col-2'>
                        <div class='row'>
                            <div class='col-12 border-bottom'>&nbsp</div>
                            <div class='col-12 text-under-over'>(марка)</div>
                        </div>
                    </div>
                    <div class='col-3 text-before'>Государственный номерной знак</div>
                    <div class='col-2 border-bottom'>&nbsp</div>
                    <div class='col-2 text-before text-end'>Гаражный номер</div>
                    <div class='col-2'>
                        <table class='w-100 table-med'>
                            <tr>
                                <td>&nbsp</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class='row mb-2'>
                    <div class='col-4 text-before'>Сопровождающие лица:</div>
                    <div class='col-8 border-bottom'>&nbsp</div>
                </div>
                <div class='row'>
                    <div class='col-12 text-center text-before'>
                        <table class='w-100 table-med' style='border-style: double; border-color: black;'>
                            <tr>
                                <td colspan='5'>З А Д А Н И Е &nbsp;&nbsp; В О Д И Т Е Л Ю</td>
                            </tr>
                            <tr>
                                <td rowspan='2' class='col-6'>в чье распоряжение (наименование и адрес заказчика)</td>
                                <td colspan='2'>время, ч. мин.</td>
                                <td colspan='2'>количество</td>
                            </tr>
                            <tr>
                                <td>прибытия</td>
                                <td>убытия</td>
                                <td>часов </td>
                                <td>ездок</td>
                            </tr>
                            <tr>
                                <td>18</td>
                                <td>19</td>
                                <td>20</td>
                                <td>21</td>
                                <td>22</td>
                            </tr>
                            <tr>
                                <td>{{ $waybill->disposition_organization_name }}</td>
                                <td>&nbsp</td>
                                <td>&nbsp</td>
                                <td>&nbsp</td>
                                <td>&nbsp</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-6'>Водительское удостоверение проверил, задание выдал, выдать горючего</div>
                    <div class='col-3 border-bottom'>&nbsp</div>
                    <div class='col-1'>литр.</div>
                </div>
                <div class='row'>
                    <div class='col-3'>Диспетчер</div>
                    <div class="col-2">
                        <div class="col-12 border-bottom">
                            &nbsp;
                        </div>
                        <div class="col-12 text-under-over">
                            (подпись)
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="col-12 text-center border-bottom">
                            {{ $nameDispetcher }}
                        </div>
                        <div class="col-12 text-under-over">
                            (расшифр. подп.)
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-4'>Водитель по состоянию здоровья к управлению допущен</div>
                    <div class="col-2">
                        <div class="col-12 border-bottom">
                            &nbsp;
                        </div>
                        <div class="col-12 text-under-over">
                            (подпись)
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="col-12 text-center border-bottom">
                            @if($waybill->doctor_name_before) {{ $waybill->doctor_name_before }}
                            @else &nbsp
                            @endif
                        </div>
                        <div class="col-12 text-under-over">
                            (расшифр. подп.)
                        </div>
                    </div>
                </div>
            </div>

            {{-- Правая колонка --}}
            <div class='col-6'>
                <div class='col-12 text-center text-before mb-3'>
                    <table class='w-100 table-page-2'>
                        <tr>
                            <td colspan='8'>Р А Б О Т А &nbsp;&nbsp; В О Д И Т Е Л Я &nbsp;&nbsp; И &nbsp;&nbsp; А В Т О М О Б И Л Я</td>
                        </tr>
                        <tr>
                            <td rowspan='2'>операция</td>
                            <td colspan='4'>время по графику</td>
                            <td rowspan='2'>нулевой пробег, км</td>
                            <td rowspan='2'>показание спидометра, км</td>
                            <td rowspan='2'>время фактическое, число, месяц, ч. мин.</td>
                        </tr>
                        <tr>
                            <td class='col-1'>число</td>
                            <td class='col-1'>месяц</td>
                            <td class='col-1'>ч.</td>
                            <td class='col-1'>мин.</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>6</td>
                            <td>7</td>
                            <td>8</td>
                        </tr>
                        <tr>
                            <td>выезд из гаража</td>
                            <td>&nbsp</td>
                            <td>&nbsp</td>
                            <td>&nbsp</td>
                            <td>&nbsp</td>
                            <td>&nbsp</td>
                            <td>
                                @if($waybill->transport_meliage_before) {{ $waybill->transport_meliage_before }}
                                @else &nbsp
                                @endif
                            </td>
                            <td>&nbsp</td>
                        </tr>
                        <tr>
                            <td>возвращение в гараж</td>
                            <td>&nbsp</td>
                            <td>&nbsp</td>
                            <td>&nbsp</td>
                            <td>&nbsp</td>
                            <td>&nbsp</td>
                            <td>
                                @if($waybill->transport_meliage_after) {{ $waybill->transport_meliage_after }}
                                @else &nbsp
                                @endif
                            </td>
                            <td>&nbsp</td>
                        </tr>
                    </table>
                </div>

                <div class='col-12 text-center text-before mb-2'>
                    <table class='w-100 table-page-2'>
                        <tr>
                            <td colspan='7'>Д в и ж е н и е &nbsp; г о р ю ч е г о</td>
                            <td colspan='2' rowspan='2'>Время работы, ч. мин.</td>
                        </tr>
                        <tr>
                            <td colspan='2'>горючее</td>
                            <td rowspan='2'>выдано, л</td>
                            <td colspan='2'>остаток при</td>
                            <td rowspan='2'>сдано, л</td>
                            <td rowspan='2'>коэффициент изменения нормы</td>
                        </tr>
                        <tr>
                            <td>марка</td>
                            <td>код марки</td>
                            <td>выезде, л</td>
                            <td>возвращении, л</td>
                            <td>спецоборудования</td>
                            <td>двигателя</td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>10</td>
                            <td>11</td>
                            <td>12</td>
                            <td>13</td>
                            <td>14</td>
                            <td>15</td>
                            <td>16</td>
                            <td>17</td>
                        </tr>
                        <tr>
                            <td>
                                @if($transport->type_sulder) {{ $transport->type_sulder }}
                                @else &nbsp
                                @endif
                            </td>
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
                        </tr>
                    </table>
                    <table class='w-100 table-med'>
                        <tr>
                            <td colspan='5'>ПОДПИСЬ</td>
                        </tr>
                        <tr>
                            <td>заправщика</td>
                            <td>механика</td>
                            <td>механика</td>
                            <td>заправщика</td>
                            <td>диспетчера</td>
                        </tr>
                        <tr>
                            <td>&nbsp</td>
                            <td>&nbsp</td>
                            <td>&nbsp</td>
                            <td>&nbsp</td>
                            <td>&nbsp</td>
                        </tr>
                    </table>
                </div>

                <div class='row'>
                    <div class='col-6'>
                        <div class='row'>
                            <div class='col-6 text-before'>
                                @if($waybill->transport_check_before == 'Выпуск на линию разрешен') Автомобиль технически исправен.
                                @elseif($waybill->transport_check_before == 'Выпуск на линию не разрешен') Автомобиль технически не исправен.
                                @endif
                            </div>
                            <div class='col-6 border-bottom'></div>
                        </div>
                        <div class='row'>
                            <div class='col-3 text-before'>
                                @if($waybill->transport_check_before == 'Выпуск на линию разрешен') Выезд разрешен.
                                @elseif($waybill->transport_check_before == 'Выпуск на линию не разрешен') Выезд не разрешен.
                                @endif
                            </div>
                            <div class='col-2 text-before'>Механик</div>
                            <div class='col-2'>
                                <div class='col-12 border-bottom'></div>
                                <div class='col-12 text-under-over'>(подпись)</div>
                            </div>
                            <div class='col-5'>
                                <div class='col-12 border-bottom'>{{ $nameMechanic }}</div>
                                <div class='col-12 text-under-over'>(расшифр. подп.)</div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-3 text-before'>
                                Автомобиль принял.
                            </div>
                            <div class='col-2 text-before'>Водитель</div>
                            <div class='col-2'>
                                <div class='col-12 border-bottom'></div>
                                <div class='col-12 text-under-over'>(подпись)</div>
                            </div>
                            <div class='col-5'>
                                <div class='col-12 border-bottom'>{{ $nameDriver }}</div>
                                <div class='col-12 text-under-over'>(расшифр. подп.)</div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-6 text-before'>При возвращении автомобиль</div>
                            <div class='col-6'>
                                <div class='col-12 text-center border-bottom'>исправен</div>
                                <div class='col-12 text-center'>неисправен</div>
                            </div>
                        </div>
                    </div>
                    <div class='col-6'>
                        <div class='row'>
                            <div class='col-6 text-end'>Особые отметки</div>
                            <div class='col-6 border-bottom'>&nbsp;</div>
                        </div>
                        <div class='row'>
                            <div class='col-12 border-bottom'>&nbsp;</div>
                        </div>
                        <div class='row'>
                            <div class='col-12 border-bottom'>&nbsp;</div>
                        </div>
                        <div class='row'>
                            <div class='col-12 border-bottom'>&nbsp;</div>
                        </div>
                        <div class='row'>
                            <div class='col-12 border-bottom'>&nbsp;</div>
                        </div>
                        <div class='row'>
                            <div class='col-12 border-bottom'>&nbsp;</div>
                        </div>
                    </div>
                </div>

                <div class='row mt-3'>
                    <div class='col-2 text-before'>Сдал водитель</div>
                    <div class='col-2'>
                        <div class='col-12 border-bottom'></div>
                        <div class='col-12 text-under-over'>(подпись)</div>
                    </div>
                    <div class='col-2'>
                        <div class='col-12 border-bottom'></div>
                        <div class='col-12 text-under-over'>(расшифр. подп.)</div>
                    </div>
                    <div class='col-2 text-before'>Принял механик</div>
                    <div class='col-2'>
                        <div class='col-12 border-bottom'></div>
                        <div class='col-12 text-under-over'>(подпись)</div>
                    </div>
                    <div class='col-2'>
                        <div class='col-12 border-bottom'></div>
                        <div class='col-12 text-under-over'>(расшифр. подп.)</div>
                    </div>
                </div>
            </div>
        </div>

        <div class='row mb-1'>
            <div class='col-12 text-center border-bottom'>Л  И  Н  И  Я   &nbsp;  О  Т  Р  Е  З  А</div>
        </div>

        {{-- ТАЛОН ВТОРОГО ЗАКАЗЧИКА --}}
        <div class='row'>
            <div class='col-6' style='padding-right: 0px;'>
                <!--<div class='col-12 border'>-->
                    <table class='w-100 table-med' style='border-style: double; border-color: black;'>
                        <tr>
                            <td colspan='11' class='text-center'>ТАЛОН ВТОРОГО ЗАКАЗЧИКА
                                <span class='text-under-over'>(заполняется в организации - владельце автотранспорта)</span><br>
                                К путевому листу __________ № ________ от «_____» ________________ ______ г.
                            </td>
                        </tr>
                        <tr class='text-center'>
                            <td rowspan='3'>Результат по второму заказчику</td>
                            <td rowspan='2'>Время оплачиваемое</td>
                            <td rowspan='2'>Ездки</td>
                            <td rowspan='2'>Экспедитор</td>
                            <td colspan='2'>Пробег</td>
                            <td rowspan='2'>Перепробег</td>
                            <td rowspan='2'>Тонны</td>
                            <td rowspan='2'>Т-км</td>
                            <td rowspan='2'>&nbsp</td>
                            <td rowspan='2'>Всего к оплате</td>
                        </tr>
                        <tr class='text-center'>
                            <td>всего</td>
                            <td>с грузом</td>
                        </tr>
                        <tr class='text-center'>
                            <td>33</td>
                            <td>34</td>
                            <td>35</td>
                            <td>36</td>
                            <td>37</td>
                            <td>38</td>
                            <td>39</td>
                            <td>40</td>
                            <td>41</td>
                            <td>42</td>
                        </tr>
                        <tr>
                            <td style='text-align: left!important;'>Единица измерения</td>
                            <td>ч. мин.</td>
                            <td>ед.</td>
                            <td>да/нет</td>
                            <td>км</td>
                            <td>км</td>
                            <td>км</td>
                            <td>т</td>
                            <td>ткм</td>
                            <td>&nbsp;&nbsp;</td>
                            <td>руб. коп.</td>
                        </tr>
                        <tr>
                            <td style='text-align: left!important;'>Выполнено</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>X</td>
                        </tr>
                        <tr>
                            <td style='text-align: left!important;'>Тариф, руб. коп.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>X</td>
                        </tr>
                        <tr>
                            <td style='text-align: left!important;'>К оплате, руб. коп.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                <!--</div>-->
                <div class='row'>
                    <div class='col-2'>Таксировщик</div>
                    <div class='col-2'>
                        <div class='col-12 border-bottom'>&nbsp;</div>
                        <div class='col-12 text-under-over'>(подпись)</div>
                    </div>
                    <div class='col-2'>
                        <div class='col-12 border-bottom'>&nbsp;</div>
                        <div class='col-12 text-under-over'>(расшифр. подп.)</div>
                    </div>
                    <div class='col-2'>Начальник эксплуатации</div>
                    <div class='col-2'>
                        <div class='col-12 border-bottom'>&nbsp;</div>
                        <div class='col-12 text-under-over'>(подпись)</div>
                    </div>
                    <div class='col-2'>
                        <div class='col-12 border-bottom'>&nbsp;</div>
                        <div class='col-12 text-under-over'>(расшифр. подп.)</div>
                    </div>
                </div>
            </div>
            {{-- ТАЛОН ПЕРВОГО ЗАКАЗЧИКА --}}
            <div class='col-6'>
                <!--<div class='col-12 border'>-->
                    <table class='w-100 table-med' style='border-style: double; border-color: black;'>
                        <tr>
                            <td colspan='11' class='text-center'>ТАЛОН ПЕРВОГО ЗАКАЗЧИКА
                                <span class='text-under-over'>(заполняется в организации - владельце автотранспорта)</span><br>
                                К путевому листу __________ № ________ от «_____» ________________ ______ г.
                            </td>
                        </tr>
                        <tr class='text-center'>
                            <td rowspan='3'>Результат по первому заказчику</td>
                            <td rowspan='2'>Время оплачиваемое</td>
                            <td rowspan='2'>Ездки</td>
                            <td rowspan='2'>Экспедитор</td>
                            <td colspan='2'>Пробег</td>
                            <td rowspan='2'>Перепробег</td>
                            <td rowspan='2'>Тонны</td>
                            <td rowspan='2'>Т-км</td>
                            <td rowspan='2'>&nbsp</td>
                            <td rowspan='2'>Всего к оплате</td>
                        </tr>
                        <tr class='text-center'>
                            <td>всего</td>
                            <td>с грузом</td>
                        </tr>
                        <tr class='text-center'>
                            <td>43</td>
                            <td>44</td>
                            <td>45</td>
                            <td>46</td>
                            <td>47</td>
                            <td>48</td>
                            <td>49</td>
                            <td>50</td>
                            <td>51</td>
                            <td>52</td>
                        </tr>
                        <tr>
                            <td style='text-align: left!important;'>Единица измерения</td>
                            <td>ч. мин.</td>
                            <td>ед.</td>
                            <td>да/нет</td>
                            <td>км</td>
                            <td>км</td>
                            <td>км</td>
                            <td>т</td>
                            <td>ткм</td>
                            <td>&nbsp;&nbsp;</td>
                            <td>руб. коп.</td>
                        </tr>
                        <tr>
                            <td style='text-align: left!important;'>Выполнено</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>X</td>
                        </tr>
                        <tr>
                            <td style='text-align: left!important;'>Тариф, руб. коп.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>X</td>
                        </tr>
                        <tr>
                            <td style='text-align: left!important;'>К оплате, руб. коп.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                <!--</div>-->
                <div class='row'>
                    <div class='col-2'>Таксировщик</div>
                    <div class='col-2'>
                        <div class='col-12 border-bottom'>&nbsp;</div>
                        <div class='col-12 text-under-over'>(подпись)</div>
                    </div>
                    <div class='col-2'>
                        <div class='col-12 border-bottom'>&nbsp;</div>
                        <div class='col-12 text-under-over'>(расшифр. подп.)</div>
                    </div>
                    <div class='col-2'>Начальник эксплуатации</div>
                    <div class='col-2'>
                        <div class='col-12 border-bottom'>&nbsp;</div>
                        <div class='col-12 text-under-over'>(подпись)</div>
                    </div>
                    <div class='col-2'>
                        <div class='col-12 border-bottom'>&nbsp;</div>
                        <div class='col-12 text-under-over'>(расшифр. подп.)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Оборотная сторона --}}
    <div class='w-100 page-2'>
        <div class='col-12 text-end mt-2 mb-2'>Оборотная сторона формы № 4-П</div>
        
        <div class='col-12'>
            <div class='row'>
                <div class='col-6'>
                    <div class='row'>
                        <div class='col-12 text-end'>В  Ы  П  О  Л  Н  Е  Н  И  Е</div>
                    </div>
                    <table class='w-100 border'>
                        <tr class='border'>
                            <td colspan='2' class='text-start'>Первый заказчик:</td>
                            <td class='text-end'>код</td>
                            <td class='col-1 border'>&nbsp;</td>
                        </tr>
                        <tr>
                            <td rowspan='2'>При прибытии к заказчику:</td>
                            <td class='text-end'><span class='text-under-over'>(наименование)</span>&nbsp;
                                <span>показание спидометра</span></td>
                            <td colspan='2' class='col-2 border'>&nbsp</td>
                        </tr>
                        <tr class='border-bottom'>
                            <td class='text-end'>дата (число, месяц), время, ч. мин.</td>
                            <td colspan='2' class='col-2 border'>&nbsp</td>
                        </tr>
                        <tr class='border-top'>
                            <td rowspan='2'>При убытии от заказчика:</td>
                            <td class='text-end'>показание спидометра</td>
                            <td colspan='2' class='col-2 border'>&nbsp</td>
                        </tr>
                        <tr class='border-bottom'>
                            <td class='text-end'>дата (число, месяц), время, ч. мин.</td>
                            <td colspan='2' class='col-2 border'>&nbsp</td>
                        </tr>
                        <tr class='border-top'>
                            <td class='text-start'>Приложенные ТТД: № №</td>
                            <td colspan='2' class='text-end'>количество<br>ТТД</td>
                            <td class='col-1 border'></td>
                        </tr>
                        <tr class='border'>
                            <td class='text-start'>Маршрут движения<br>(откуда-куда):</td>
                            <td class='col-6'>&nbsp;</td>
                            <td class='text-end'>количество<br>ездок</td>
                            <td class='col-1 border'></td>
                        </tr>
                        <tr class='border'>
                            <td colspan='2' class='text-start'>Место для штампа Заказчика</td>
                            <td class='text-end'>код вида<br>груза</td>
                            <td class='col-1 border'></td>
                        </tr>
                    </table>
                </div>
        
                <div class='col-6'>
                    <div class='row'>
                        <div class='col-12 text-start'>З  А  Д  А  Н  И  Я &nbsp;&nbsp;&nbsp;&nbsp; (заполняется заказчиком)</div>
                    </div>
                    <table class='w-100 border'>
                        <tr class='border'>
                            <td colspan='2' class='text-start'>Первый заказчик:</td>
                            <td class='text-end'>код</td>
                            <td class='col-1 border'>&nbsp;</td>
                        </tr>
                        <tr>
                            <td rowspan='2'>При прибытии к заказчику:</td>
                            <td class='text-end'><span class='text-under-over'>(наименование)</span>&nbsp;
                                <span>показание спидометра</span></td>
                            <td colspan='2' class='col-2 border'>&nbsp</td>
                        </tr>
                        <tr class='border-bottom'>
                            <td class='text-end'>дата (число, месяц), время, ч. мин.</td>
                            <td colspan='2' class='col-2 border'>&nbsp</td>
                        </tr>
                        <tr class='border-top'>
                            <td rowspan='2'>При убытии от заказчика:</td>
                            <td class='text-end'>показание спидометра</td>
                            <td colspan='2' class='col-2 border'>&nbsp</td>
                        </tr>
                        <tr class='border-bottom'>
                            <td class='text-end'>дата (число, месяц), время, ч. мин.</td>
                            <td colspan='2' class='col-2 border'>&nbsp</td>
                        </tr>
                        <tr class='border-top'>
                            <td class='text-start'>Приложенные ТТД: № №</td>
                            <td colspan='2' class='text-end'>количество<br>ТТД</td>
                            <td class='col-1 border'></td>
                        </tr>
                        <tr class='border'>
                            <td class='text-start'>Маршрут движения<br>(откуда-куда):</td>
                            <td class='col-6'>&nbsp;</td>
                            <td class='text-end'>количество<br>ездок</td>
                            <td class='col-1 border'></td>
                        </tr>
                        <tr class='border'>
                            <td colspan='2' class='text-start'>Место для штампа Заказчика</td>
                            <td class='text-end'>код вида<br>груза</td>
                            <td class='col-1 border'></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class='col-12 mt-4'>
            <div class='row'>
                <div class='col-6'>
                    <table class='w-100 table-med' style='border-style: double; border-color: black;'>
                        <tr>
                            <td colspan='4'>Простои на линии</td>
                            <td rowspan='3'>Подпись ответственного лица</td>
                        </tr>
                        <tr>
                            <td colspan='2'>причина</td>
                            <td colspan='2'>дата (число, месяц), время, ч. мин.</td>
                        </tr>
                        <tr>
                            <td>наименование</td>
                            <td>код</td>
                            <td>начало</td>
                            <td>оканчание</td>
                        </tr>
                        <tr>
                            <td>23</td>
                            <td>24</td>
                            <td>25</td>
                            <td>26</td>
                            <td>27</td>
                        </tr>
                        <tr>
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
                        </tr>
                        <tr>
                            <td>&nbsp</td>
                            <td>&nbsp</td>
                            <td>&nbsp</td>
                            <td>&nbsp</td>
                            <td>&nbsp</td>
                        </tr>
                    </table>
                </div>

                <div class='col-6'>
                    <div class='row'>
                        <div class='col-8'>
                            <div class='row'>
                                <div class='col-6'>
                                    <div class='col-12 mb-2'>Таксировка:</div>
                                    <table class='w-100'>
                                        <tr class='border-bottom'>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr class='border-bottom'>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr class='border-bottom'>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr class='border-bottom'>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class='col-6'>
                                    <table class='w-100 table-med' style='border-style: double; border-color: black;'>
                                        <tr>
                                            <td colspan='3'>Расход горючего</td>
                                        </tr>
                                        <tr>
                                            <td class='col-4'>Марка</td>
                                            <td class='col-4'>по норме</td>
                                            <td class='col-4'>фактиччески</td>
                                        </tr>
                                        <tr>
                                            <td>28</td>
                                            <td>29</td>
                                            <td>30</td>
                                        </tr>
                                    </table>
                                    <table class='w-100 table-med'>
                                        <tr>
                                            <td class='col-4'>&nbsp;</td>
                                            <td class='col-4'>&nbsp;</td>
                                            <td class='col-4'>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-12'>
                                    <table class='w-100'>
                                        <tr class='border-bottom'>
                                            <td>&nbsp</td>
                                        </tr>
                                        <tr class='border-bottom'>
                                            <td>&nbsp</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
    
                        <div class='col-4'>
                            <table class='w-100 table-med' style='border-style: double; border-color: black;'>
                                <tr>
                                    <td colspan='2'>Зарплата</td>
                                </tr>
                                <tr>
                                    <td class='col-6'>код</td>
                                    <td class='col-6'>сумма, руб. коп.</td>
                                </tr>
                                <tr>
                                    <td class='col-6'>31</td>
                                    <td class='col-6'>32</td>
                                </tr>
                            </table>
                            <table class='w-100 table-med'>
                                <tr>
                                    <td class='col-6'>&nbsp;</td>
                                    <td class='col-6'>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class='col-6'>&nbsp;</td>
                                    <td class='col-6'>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class='col-6'>&nbsp;</td>
                                    <td class='col-6'>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class='col-6'>&nbsp;</td>
                                    <td class='col-6'>&nbsp;</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Блок --}}
        <div class='col-12 mt-4 mb-2'>
            <div class='row'>
                {{-- ТАЛОН ВТОРОГО ЗАКАЗЧИКА --}}
                <div class='col-6'>
                    <!--<div class='col-12 border'>-->
                        <table class='w-100 table-med' style='border-style: double; border-color: black;'>
                            <tr class='text-center'>
                                <td rowspan='3'>Результат по второму заказчику</td>
                                <td rowspan='2'>Время оплачиваемое</td>
                                <td rowspan='2'>Ездки</td>
                                <td rowspan='2'>Экспедитор</td>
                                <td colspan='2'>Пробег</td>
                                <td rowspan='2'>Перепробег</td>
                                <td rowspan='2'>Тонны</td>
                                <td rowspan='2'>Т-км</td>
                                <td rowspan='2'>&nbsp</td>
                                <td rowspan='2'>Всего к оплате</td>
                            </tr>
                            <tr class='text-center'>
                                <td>всего</td>
                                <td>с грузом</td>
                            </tr>
                            <tr class='text-center'>
                                <td>33</td>
                                <td>34</td>
                                <td>35</td>
                                <td>36</td>
                                <td>37</td>
                                <td>38</td>
                                <td>39</td>
                                <td>40</td>
                                <td>41</td>
                                <td>42</td>
                            </tr>
                            <tr>
                                <td style='text-align: left!important;'>Единица измерения</td>
                                <td>ч. мин.</td>
                                <td>ед.</td>
                                <td>да/нет</td>
                                <td>км</td>
                                <td>км</td>
                                <td>км</td>
                                <td>т</td>
                                <td>ткм</td>
                                <td>&nbsp;&nbsp;</td>
                                <td>руб. коп.</td>
                            </tr>
                            <tr>
                                <td style='text-align: left!important;'>Выполнено</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td style='text-align: left!important;'>Тариф, руб. коп.</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td style='text-align: left!important;'>К оплате, руб. коп.</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    <!--</div>-->
                    <div class='row'>
                        <div class='col-2'>Таксировщик</div>
                        <div class='col-2'>
                            <div class='col-12 border-bottom'>&nbsp;</div>
                            <div class='col-12 text-under-over'>(подпись)</div>
                        </div>
                        <div class='col-2'>
                            <div class='col-12 border-bottom'>&nbsp;</div>
                            <div class='col-12 text-under-over'>(расшифр. подп.)</div>
                        </div>
                        <div class='col-2'>Начальник эксплуатации</div>
                        <div class='col-2'>
                            <div class='col-12 border-bottom'>&nbsp;</div>
                            <div class='col-12 text-under-over'>(подпись)</div>
                        </div>
                        <div class='col-2'>
                            <div class='col-12 border-bottom'>&nbsp;</div>
                            <div class='col-12 text-under-over'>(расшифр. подп.)</div>
                        </div>
                    </div>
                </div>
                {{-- ТАЛОН ПЕРВОГО ЗАКАЗЧИКА --}}
                <div class='col-6'>
                    <!--<div class='col-12 border'>-->
                        <table class='w-100 table-med' style='border-style: double; border-color: black;'>
                            <tr class='text-center'>
                                <td rowspan='3'>Результат по первому заказчику</td>
                                <td rowspan='2'>Время оплачиваемое</td>
                                <td rowspan='2'>Ездки</td>
                                <td rowspan='2'>Экспедитор</td>
                                <td colspan='2'>Пробег</td>
                                <td rowspan='2'>Перепробег</td>
                                <td rowspan='2'>Тонны</td>
                                <td rowspan='2'>Т-км</td>
                                <td rowspan='2'>&nbsp</td>
                                <td rowspan='2'>Всего к оплате</td>
                            </tr>
                            <tr class='text-center'>
                                <td>всего</td>
                                <td>с грузом</td>
                            </tr>
                            <tr class='text-center'>
                                <td>43</td>
                                <td>44</td>
                                <td>45</td>
                                <td>46</td>
                                <td>47</td>
                                <td>48</td>
                                <td>49</td>
                                <td>50</td>
                                <td>51</td>
                                <td>52</td>
                            </tr>
                            <tr>
                                <td style='text-align: left!important;'>Единица измерения</td>
                                <td>ч. мин.</td>
                                <td>ед.</td>
                                <td>да/нет</td>
                                <td>км</td>
                                <td>км</td>
                                <td>км</td>
                                <td>т</td>
                                <td>ткм</td>
                                <td>&nbsp;&nbsp;</td>
                                <td>руб. коп.</td>
                            </tr>
                            <tr>
                                <td style='text-align: left!important;'>Выполнено</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td style='text-align: left!important;'>Тариф, руб. коп.</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td style='text-align: left!important;'>К оплате, руб. коп.</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    <!--</div>-->
                    <div class='row'>
                        <div class='col-2'>Таксировщик</div>
                        <div class='col-2'>
                            <div class='col-12 border-bottom'>&nbsp;</div>
                            <div class='col-12 text-under-over'>(подпись)</div>
                        </div>
                        <div class='col-2'>
                            <div class='col-12 border-bottom'>&nbsp;</div>
                            <div class='col-12 text-under-over'>(расшифр. подп.)</div>
                        </div>
                        <div class='col-2'>Начальник эксплуатации</div>
                        <div class='col-2'>
                            <div class='col-12 border-bottom'>&nbsp;</div>
                            <div class='col-12 text-under-over'>(подпись)</div>
                        </div>
                        <div class='col-2'>
                            <div class='col-12 border-bottom'>&nbsp;</div>
                            <div class='col-12 text-under-over'>(расшифр. подп.)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class='row mt-4 mb-2'>
            <div class='col-12 text-center border-bottom'>Л  И  Н  И  Я   &nbsp;  О  Т  Р  Е  З  А</div>
        </div>

        <div class='row'>
            {{-- Первый заказчик --}}
            <div class='col-6'>
                <div class='col-12 border' style='padding: 0px 15px 0px 10px;'>
                    <div class='row'>
                        <div class='text-end' style='font-size: 8px;'>(заполняется заказчиком)</div>
                    </div>
                    <div class='row'>
                        <div class='col-3 text-before'>Организация</div>
                        <div class='col-9'>
                            <div class='col-12 border-bottom'>&nbsp</div>
                            <div class='col-12 text-under-over'>(наименование)</div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-3'>Марка автомобиля</div>
                        <div class='col-2 border-bottom'>&nbsp</div>
                        <div class='col-4 text-end'>Государственный номерной знак</div>
                        <div class='col-2 border-bottom'>&nbsp</div>
                    </div>
                    <div class='row'>
                        <div class='col-3'>Прицепы</div>
                        <div class='col-2 border-bottom'>&nbsp</div>
                        <div class='col-4 text-end'>Государственный номерной знак</div>
                        <div class='col-2 border-bottom'>&nbsp</div>
                    </div>
                    <div class='row'>
                        <div class='col-3 text-before'>Первый заказчик</div>
                        <div class='col-9'>
                            <div class='col-12 border-bottom'>&nbsp</div>
                            <div class='col-12 text-under-over'>(наименование организации, фамилия, имя, отчество, должность ответственного лица)</div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-4 text-before'>Прибытие к заказчику</div>
                        <div class='col-5'>
                            <div class='col-12 border-bottom'>&nbsp</div>
                            <div class='col-12 text-under-over'>(дата, время, ч. мин.)</div>
                        </div>
                        <div class='col-3'>
                            <div class='col-12 border-bottom'>&nbsp</div>
                            <div class='col-12 text-under-over'>(показание спидометра)</div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-4 text-before'>Убытие от заказчика</div>
                        <div class='col-5'>
                            <div class='col-12 border-bottom'>&nbsp</div>
                            <div class='col-12 text-under-over'>(дата, время, ч. мин.)</div>
                        </div>
                        <div class='col-3'>
                            <div class='col-12 border-bottom'>&nbsp</div>
                            <div class='col-12 text-under-over'>(показание спидометра)</div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-5'>Приложенные ТТД: № №</div>
                        <div class='col-7 border-bottom'>&nbsp</div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-12'>
                        <table class='w-100 table-med'>
                            <tr>
                                <td>Количество ТТД</td>
                                <td class='col-1'>&nbsp</td>
                                <td>Количество ездок</td>
                                <td class='col-1'>&nbsp</td>
                                <td>Экспедитор</td>
                                <td>да/нет</td>
                                <td>Место для штампа Заказчика</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Второй заказчик --}}
            <div class='col-6'>
                <div class='col-12 border' style='padding: 0px 15px 0px 10px;'>
                    <div class='row'>
                        <div class='text-end' style='font-size: 8px;'>(заполняется заказчиком)</div>
                    </div>
                    <div class='row'>
                        <div class='col-3 text-before'>Организация</div>
                        <div class='col-9'>
                            <div class='col-12 border-bottom'>&nbsp</div>
                            <div class='col-12 text-under-over'>(наименование)</div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-3'>Марка автомобиля</div>
                        <div class='col-2 border-bottom'>&nbsp</div>
                        <div class='col-4 text-end'>Государственный номерной знак</div>
                        <div class='col-2 border-bottom'>&nbsp</div>
                    </div>
                    <div class='row'>
                        <div class='col-3'>Прицепы</div>
                        <div class='col-2 border-bottom'>&nbsp</div>
                        <div class='col-4 text-end'>Государственный номерной знак</div>
                        <div class='col-2 border-bottom'>&nbsp</div>
                    </div>
                    <div class='row'>
                        <div class='col-3 text-before'>Первый заказчик</div>
                        <div class='col-9'>
                            <div class='col-12 border-bottom'>&nbsp</div>
                            <div class='col-12 text-under-over'>(наименование организации, фамилия, имя, отчество, должность ответственного лица)</div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-4 text-before'>Прибытие к заказчику</div>
                        <div class='col-5'>
                            <div class='col-12 border-bottom'>&nbsp</div>
                            <div class='col-12 text-under-over'>(дата, время, ч. мин.)</div>
                        </div>
                        <div class='col-3'>
                            <div class='col-12 border-bottom'>&nbsp</div>
                            <div class='col-12 text-under-over'>(показание спидометра)</div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-4 text-before'>Убытие от заказчика</div>
                        <div class='col-5'>
                            <div class='col-12 border-bottom'>&nbsp</div>
                            <div class='col-12 text-under-over'>(дата, время, ч. мин.)</div>
                        </div>
                        <div class='col-3'>
                            <div class='col-12 border-bottom'>&nbsp</div>
                            <div class='col-12 text-under-over'>(показание спидометра)</div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-5'>Приложенные ТТД: № №</div>
                        <div class='col-7 border-bottom'>&nbsp</div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-12'>
                        <table class='w-100 table-med'>
                            <tr>
                                <td>Количество ТТД</td>
                                <td class='col-1'>&nbsp</td>
                                <td>Количество ездок</td>
                                <td class='col-1'>&nbsp</td>
                                <td>Экспедитор</td>
                                <td>да/нет</td>
                                <td>Место для штампа Заказчика</td>
                            </tr>
                        </table>
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

