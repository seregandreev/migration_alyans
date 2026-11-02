<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title></title>
	<link rel="stylesheet" href="{{ asset('css/print.css') }}">
</head>
<body>
	@foreach($conclusions as $conclusion)
		<div class="passport">
			<div class="tape_number">{{ $conclusion->component()->tape_number }}</div>
				<div style="position: absolute; right: 15px; top: 15px;">
			</div>
			<div class="title centered"><br>ПАСПОРТ</div>
			<div class="data-product">
				<table border="0" class="centered-data">
					<tr class="name_product_title">
						<td>Наименование изделия</td>
						<td>{{ $conclusion->component()->type()->name }}</td>
					</tr>
					<!--<tr>
						<td>Номер партии</td>
						<td>{{ $conclusion->component()->type()->partial_number }}</td>
					</tr>-->
					<tr>
						<td>Серийный номер</td>
						<td>{{ $conclusion->component()->serial_number }}</td>
					</tr>
					<tr>
						<td>Номер ленты</td>
						<td>{{ $conclusion->component()->tape_number }}</td>
					</tr>
					<tr>
						<td colspan="2">
							<img class="eskiz-vik" src="{{ asset('types_data/'.$conclusion->component()->type()->id.'/vik.jpg') }}" alt="">
						</td>
					</tr>
				</table>
			</div>
			<br>
			<div class="footer_title footer_title_main centered">Изготовитель:</div>
			<div class="footer_title centered">{{ $conclusion->component()->type()->manufacturer }}</div>
		</div>
		<div class="breaker"></div>
		<div class="passport-info" style="margin-left: 40px;">
			<div class="tape_number">{{ $conclusion->component()->tape_number }}</div>
			<div class="table-data">
				<table border="1">
					<tr>
						<th style="width: 40%; text-align: left;">1. Наименование компании производителя</th>
						<td>{{ $conclusion->component()->type()->manufacturer }}</td>
					</tr>
					<tr>
						<th style="text-align: left;">2. Компания владелец</th>
						<td>{{ $conclusion->component()->company()->name }}</td>
					</tr>
					<tr>
						<th style="text-align: left;">3. Наименование/Тип изделия</th>
						<td>{{ $conclusion->component()->type()->name }}</td>
					</tr>
					<tr>
						<th style="text-align: left;">4. Описание/Модель изделия</th>
						<td>{{ $conclusion->component()->type()->description }}</td>
					</tr>
					<tr>
						<th style="text-align: left;">5. Назначение</th>
						<td>
							<span>Рекомендовано при проведении операции по обработке скважин:</span>
							<ul>
								<li>Цементирование</li>
								<li>Гидроразрыв пласта </li>
								<li>Кислотная обработка </li>
								<li>Для транспортировки воды, масел, нефти, жидких неагрессивных нефтепродуктов, и неагрессивных жидких сред по отношению, к которым материалы коррозионностойкие</li>
							</ul>
						</td>
					</tr>
					<tr>
						<th style="text-align: left;">6. Номер партии</th>
						<td>{{ $conclusion->component()->type()->partial_number }}</td>
					</tr>
					<tr>
						<th style="text-align: left;">7. Серийный номер</th>
						<td>{{ $conclusion->component()->serial_number }}</td>
					</tr>
					<tr>
						<th style="text-align: left;">8. Номер маркировочной ленты/Инвентарный номер</th>
						<td>{{ $conclusion->component()->tape_number }}</td>
					</tr>
					<tr>
						<th style="text-align: left;">9. Рабочее давление</th>
						<td>{{ $conclusion->component()->type()->pressure }} {{ $conclusion->component()->type()->measure }}</td>
					</tr>
					<tr>
						<th style="text-align: left;">10. Температурный режим работы</th>
						<td>От {{ $conclusion->component()->type()->temperature_mode }} °С До {{ $conclusion->component()->type()->temperature_mode1 }} °С</td>
					</tr>
					<tr>
						<th style="text-align: left;">11. Материал изделия</th>
						<td>Легированная сталь/РТИ</td>
					</tr>
					<tr>
						<th style="text-align: left;">12. Расчётный срок службы, лет</th>
						<td>{{ $conclusion->component()->type()->life_time }}</td>
					</tr>
					<tr>
						<th style="text-align: left;">13. Дата ввода в эксплуатацию</th>
						<td>{{ date('d.m.Y', strtotime($conclusion->component()->date_start_expluatation)) }}</td>

					</tr>
					<tr>
						<th style="text-align: left;">14. Паспортизация</th>
						<td>Оборудование соответствует требованиям Российской Федерации, предъявляемых к данному оборудованию, что подтверждено Обоснованием безопасности в соответствии с требованиями {{ $gost_passport->value }}</td>
					</tr>
					<tr>
						<th style="text-align: left;">15. Гарантия изготовителя</th>
						<td>Изготовитель гарантирует соответствие оборудования всем требованиям технической документации при условии соблюдения инструкции по монтажу, техническом обслуживании, условий хранения и транспортировки. Гарантия изготовителя не распространяется на детали подверженные естественному износу.</td>
					</tr>
					<tr>
						<th style="text-align: left;">16. Консервация</th>
						<td></td>
					</tr>
				</table>
			</div>
			<br>
			<br>
			<div class="date passport-table-naming">
				<table border="1">
					<tr>
						<th style="text-align: center;">Дата</th>
						<th style="text-align: center;">Наименование работ</th>
						<th style="text-align: center;">Должность, Ф.И.О., подпись</th>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="breaker"></div>
		<div class="table-form-passport">
			<table border="1" style="text-align: center;">
				<tr>
					<th>Дата проведения</th>
					<th>Прокаченый пропан (Тонн)</th>
					<th>Перечень работ, проведённых при ремонте и техническом обслуживании (ВИК | УЗК | МК | ГИ)</th>
					<th>Результат / заключение</th>
					<th>Ф.И.О. инспектора</th>
					<th>Подпись</th>
				</tr>

				<tr>
					<td>{{ $conclusion->date }}</td>
					<td>{{ $conclusion->propan }}</td>
					<td>
						@php($result_conclusion = 'Годен')
						<p style="text-align: center;">Проведен неразрушающий контроль методами:</p><hr>
						{{-- ВИК --}}
						@if($conclusion->vik_result === "Состояние поверхности объекта контроля соответствует требованиям 3997-00.001 МУ 'Методические указания по определению критериев вывода из эксплуатации нефтепромыслового оборудования'; Недопустимых дефектов не обнаружено.")
							ВИК: Годен<hr>
						@elseif(!empty($conclusion->vik_result))
							ВИК: Не годен<hr>
							@php($result_conclusion = 'Не годен')
						@endif
						{{-- УЗК --}}
						@if($conclusion->uzt_result === 'Обнаруженные толщины не менее допустимых значений. Годен')
							УЗК: Годен <hr>
						@elseif(!empty($conclusion->uzt_result))
							УЗК: Не годен <hr>
							@php($result_conclusion = 'Не годен')
						@endif
						{{-- ГИ --}}
						@if($conclusion->gi_result === 'Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность.')
							ГИ: Годен <hr>
						@elseif(!empty($conclusion->gi_result))
							ГИ: Не годен <hr>
							@php($result_conclusion = 'Не годен')
						@endif
						{{-- МК --}}
						@if($conclusion->mk_result === 'Годен')
							МК: Годен <br>
						@elseif(!empty($conclusion->mk_result))
							МК: Не годен <br>
							@php($result_conclusion = 'Не годен')
						@endif
					</td>
					<td>{{ $result_conclusion }}</td>
					<td>{{ $conclusion->inspector()->name }} <img src="{{ asset('') }}" alt="" style="width: 90px; position: relative; top: -10px;" class="pechat"></td>
					<td></td>
				</tr>

				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>

			</table>
		</div>
		<!-- <div class="breaker"></div>
		<div class="table-form-passport">
			<table border="1" style="text-align: center;">
				<tr>
					<th>Дата проведения</th>
					<th>Прокаченый пропан (Тонн)</th>
					<th>Перечень работ, проведённых при ремонте и техническом обслуживании</th>
					<th>Результат / заключение</th>
					<th>Ф.И.О. инспектора</th>
					<th>Подпись</th>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</table>
		</div> -->

		<div style="text-align: center;">
			@if($ecp->value == 'on')
				<img src="{{ asset('print.png') }}" alt="" class="ecp_image">
			@endif
		</div>
	@endforeach
</body>
</html>