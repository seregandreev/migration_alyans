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
	<div class="conclusion">
		<div class="header-data"></div>
		<br>
		<br>
		<br>
		<div class="logotype"><img src="{{ asset('logo.jpg') }}" alt=""></div>
			<div style="position: absolute; right: 15px; top: 15px;">
			ИНН 8602282043
			<br>
			КПП 860201001
			<br>
			ОГРН 1178617022440
		</div>
		<div class="title">
			<h2>АКТ ПРОВЕДЕНИЯ</h2>
			<h2>НЕРАЗРУШАЮЩЕГО КОНТРОЛЯ НАГНЕТАТЕЛЬНЫХ</h2>
			<h2>ЧАСТЕЙ ЛИНИИ ВЫСОКОГО ДАВЛЕНИЯ</h2>
		</div>
		<div class="facility">Установка \ комплект № {{ session()->get('conclusion_facility') }}</div>
		<div class="date">
			@php($date = explode('-', session()->get('conclusion_date')))
			Дата проведения: {{ implode('.', array_reverse($date)) }}
		</div>
		<div class="city">{{ $unit->city }}</div>
		<div class="report">
			<table border="2" style="width: 100%;">
				<thead>
					<tr>
						<th colspan="2">Номер установки</th>
						<th>Дата</th>
						<th colspan="4" rowspan="2">Фактическая толщина</th>
						<th colspan="4" rowspan="2">Мин. толщина</th>
						<th colspan="5" rowspan="2">
							<span class="key">{{ $director->value }}</span>
						</th>
					</tr>
					<tr>
						<th colspan="2">{{ session()->get('conclusion_facility') }}</th>
						<th>{{ session()->get('conclusion_date') }}</th>
					</tr>
					<tr>
						<th>№ ленты</th>
						<th>Тип</th>
						<th>Описание</th>
						<th>1</th>
						<th>2</th>
						<th>3</th>
						<th>4</th>
						<th>1</th>
						<th>2</th>
						<th>3</th>
						<th>4</th>
						<th>ВИК</th>
						<th>УЗТ</th>
						<th>МК</th>
						<th>ГИ</th>
						<th>№ производителя</th>
					</tr>
				</thead>
				<tbody>
					@php($count_mk = 0)
					@php($count_uzt = 0)
					@php($count_vik = 0)
					@php($count_gi = 0)
					@foreach($conclusions as $conclusion)
						{{-- ВИК --}}
						@if($conclusion->vik_result === "Состояние поверхности объекта контроля соответствует требованиям 3997-00.001 МУ 'Методические указания по определению критериев вывода из эксплуатации нефтепромыслового оборудования'; Недопустимых дефектов не обнаружено.")
							@php($count_vik++)
							@php($conclusion->vik_result = 'Годен')
						@elseif(empty($conclusion->vik_result))
							@php($conclusion->vik_result = '-')
						@else
							@php($conclusion->vik_result = 'Не Годен')
						@endif
						{{-- УЗТ --}}
						@if($conclusion->uzt_result === 'Обнаруженные толщины не менее допустимых значений. Годен')
							@php($count_uzt++)
							@php($conclusion->uzt_result = 'Годен')
						@elseif(empty($conclusion->uzt_result))
							@php($conclusion->uzt_result = '-')
						@else
							@php($conclusion->uzt_result = 'Не Годен')
						@endif
						{{-- ГИ --}}
						@if($conclusion->gi_result === 'Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность.')
							@php($count_gi++)
							@php($conclusion->gi_result = 'Годен')
						@elseif(empty($conclusion->gi_result))
							@php($conclusion->gi_result = '-')
						@else
							@php($conclusion->gi_result = 'Не Годен')
						@endif
						{{-- МК --}}
						@if($conclusion->mk_result === 'Годен')
							@php($count_mk++)
							@php($conclusion->mk_result = 'Годен')
						@elseif(empty($conclusion->mk_result))
							@php($conclusion->mk_result = '-')
						@else
							@php($conclusion->mk_result = 'Не Годен')
						@endif

						<tr>
							<td>{{ $conclusion->component()->tape_number }}</td>
							<td>{{ $conclusion->type()->name }}</td>
							<td>{{ $conclusion->type()->description }}</td>
							<td>{{ $conclusion->type()->measure_1 }}</td>
							<td>{{ $conclusion->type()->measure_2 }}</td>
							<td>{{ $conclusion->type()->measure_3 }}</td>
							<td>{{ $conclusion->type()->measure_4 }}</td>
							<td>{{ $conclusion->measure_1 }}</td>
							<td>{{ $conclusion->measure_2 }}</td>
							<td>{{ $conclusion->measure_3 }}</td>
							<td>{{ $conclusion->measure_4 }}</td>
							<td>{{ $conclusion->vik_result }}</td>
							<td>{{ $conclusion->uzt_result }}</td>
							<td>{{ $conclusion->mk_result }}</td>
							<td>{{ $conclusion->gi_result }}</td>
							<td>{{ $conclusion->type()->manufacturer }}</td>
						</tr>
					@endforeach
					<tr>
						<td colspan="11" style="text-align: right;">Итого: </td>
						<td>{{ $count_vik }}</td>
						<td>{{ $count_uzt }}</td>
						<td>{{ $count_mk }}</td>
						<td>{{ $count_gi }}</td>
						<td> - </td>
					</tr>
				</tbody>
			</table>
			<div style="position: relative;">
				<div style="position: absolute; top: 40px; left: 0px; font-size: 16px;"><b>Передал:</b> ___________________________</div>
				<div style="position: absolute; top: 40px; right: 0px; font-size: 16px;"><b>Принял:</b> ___________________________</div>

			</div>
		</div>
	</div>

	<div style="text-align: center;">
		@if($ecp->value == 'on')
			<img src="{{ asset('print.png') }}" alt="" class="ecp_image">
		@endif
	</div>
</body>
</html>