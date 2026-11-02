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
		@if(empty($conclusion->gi_result))
			@continue
		@endif
		<div class="conclusion">
			<div class="header-data">{!! $header->value !!}</div>
			<br>
			<br>
			<div class="conclusion_right_info">
				ИНН 8602282043
				<br>
				КПП 860201001
				<br>
				ОГРН 1178617022440
			</div>
			<br>
			<br>
			<br>
			<div class="logotype"><img src="{{ asset('logo.jpg') }}" alt=""></div>
			<div class="title">
				<div>Акт гидравлического испытания № {{ $conclusion->id }}</div>
			</div>
			<div class="date">От:
				<span>
				@php($conclusion->date = implode('.', array_reverse(explode('-', $conclusion->date))))
					{{ $conclusion->date }}
			</span>
			</div>
			<div class="name-object"><span>Наименование объекта контроля: </span> {{ $conclusion->component()->type()->name }}</div>
			<div class="data-object">
				<div class="tape_number"><b>Номер ленты:</b> {{ $conclusion->component()->tape_number }}</div>
				<div class="serial_number"><b>Серийный номер:</b> {{ $conclusion->component()->serial_number }}</div>
				<br>
				<div class="manufacturer"><b>Производитель:</b> {{ $conclusion->component()->type()->manufacturer }}</div>
			</div>
			<div class="part_num"><b>Партийный номер:</b> {{ $conclusion->component()->type()->partial_number }}</div>
			<div class="city"><span>Место проведения контроля:</span> {{ $conclusion->component()->work_location()->name }}. Компания владелец: {{ $conclusion->component()->company()->name }}</div>
			<div class="gi">
				<span><b>Гидравлическое испытание проводились специалистами ООО «» в три этапа</b></span>
				<br>
				<table border="0">
					<tr>
						<td>1 этап P={{ $conclusion->component()->type()->act_1 }} {{ $conclusion->component()->type()->measure }}, выдержано {{ $conclusion->component()->type()->period_1 }} минут</td>
					</tr>
					<tr>
						<td>2 этап P={{ $conclusion->component()->type()->act_2 }} {{ $conclusion->component()->type()->measure }}, выдержано {{ $conclusion->component()->type()->period_2 }} минут</td>
					</tr>
					<tr>
						<td>3 этап P={{ $conclusion->component()->type()->act_3 }} {{ $conclusion->component()->type()->measure }}, выдержано {{ $conclusion->component()->type()->period_3 }} минут</td>
					</tr>
				</table>
			</div>
			<div class="conditions_controls">
				<span>Условия:</span>
				<span>Испытательная среда - вода, температура - 10 °С</span>
				<br>
				<span>Во время выдержки под давлением и снижения давления до нуля, выполняется осмотр каждой сборочной единицы (объекта) и комплектующих частей на отсутствие остаточных деформаций, трещин, разрывов, течей, отпотеваний основного метала, пропусков в разъёмных соединениях.</span>
				<br>
				<span>температура окружающей среды: </span>{{ $conclusion->temperature}} °С
			</div>
			<div class="gost"><span>Нормативная документация </span>{{ $gost_gi->value }}</div>
			<div class="result-control">
				<div><b>Заключение:</b></div>
				<div class="result">
					@if($conclusion->gi_result == 'Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность.')
						Герметичен. {{ $conclusion->gi_result }}
					@else
						Не герметичен. {{ $conclusion->gi_result }}
					@endif
				</div>
			</div>
			<div class="chief">
				<span class="key"><b>Начальник ЛНК:</b><br></span>
				<span class="value">{{ $director->value }}</span>
			</div>
			<div class="executor"  style="height: 130px;">
				<div class="datas">
					<span><b>Исполнитель:</b><br></span>
					<span class="value">{!! $conclusion->inspector()->name.' '.$conclusion->inspector()->level.'<br>'.$conclusion->inspector()->document !!}</span>
					<div class="data-podpis" style="position: relative; left: 250px; top: -40px;">
						<br>
						@if($ecp->value == 'on')
							<img src="{{ asset('print.png') }}" alt="" class="ecp_image">
						@endif
					</div>
				</div>
				<div class="podpis" style="position: relative; left: 306px; top: -75px">
					{{--{{%podpis%}}--}}
					{{--<img src="{{ asset('print.png') }}" alt="" style="width: 220px;">--}}
				</div>
			</div>
		</div>
		@if($loop->index > 0)
			<div class="breaker"></div>
		@endif
	@endforeach
	<script>
		window.print();
	</script>
</body>
</html>