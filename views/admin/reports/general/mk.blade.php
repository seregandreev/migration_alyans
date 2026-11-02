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
	@if(empty($conclusion->mk_result))
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

		<div class="logotype">
			<img src="{{ asset('logo.jpg') }}" alt="">
		</div>

		<div class="title">
			<div>Заключение МК № {{ $conclusion->id }}</div>
			<div>по результатам магнитопорошкового контроля</div>
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
		<div class="gost"><span>Контроль проводился в соответствии с </span>{{ $gost_mk->value }}</div>
		@if(!empty($instruments) && count($instruments) > 0)
			<div class="measure_instruments">
				Применяемые средства измерений:<br>
				<table border="0">
					<thead>
					<tr>
						<th style="text-align: left;">Название</th>
						<th>s/n</th>
						<th>След. поверка</th>
					</tr>
					</thead>
					<tbody>
						@foreach($instruments as $instrument)
							<tr>
								<td>{{ $instrument->name }}</td>
								<td style="text-align: center;">{{ $instrument->sertificate_number }}</td>
								<td style="text-align: center;">{{ $instrument->next_verification_date }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		@endif
		<div class="conditions_controls">
			<span>Условия контроля:</span>
			<br>
			<span>УФ-облучённость контролируемой поверхности объекта контроля 3000 мкВт/см2;</span>
			<br>
			<span>температура окружающей среды: </span>{{ $conclusion->temperature }} °С
		</div>
		<div class="image-object-control">
			<div>Эскиз объекта контроля:</div>
			<img src="{{ asset('types_data/'.$conclusion->component()->type()->id.'/mk.jpg') }}" alt="">
		</div>
		<div class="result-control">
			<div class="result-control-title">I - участок контроля</div>
			<table border="1" class="mk-control">
				<tr>
					<th>Участки контроля (резьба, сварной шов и т.д.)</th>
					<th>Участки с дефектами, их координатами.</th>
					<th>Обнаруженные дефекты, их размеры.</th>
					<th>Оценка качества</th>
				</tr>
				<tr>
					<td>Резьбовые и гаечные соединения, основной металл</td>
					<td>{{ $conclusion->area_deffects }}</td>
					<td>{{ $conclusion->deffects_size }}</td>
					<td>{{ $conclusion->mk_result }}</td>
				</tr>
			</table>
			<br>
			<div class="result">
				<span><b>Заключение:</b></span> {{ $conclusion->mk_result }}
			</div>
		</div>
		<div class="chief">
			<span class="key"><b>Начальник ЛНК:</b></span>
			<span class="value">{{ $director->value }}</span>
		</div>
		<div class="executor" style="height: 130px;">
			<div class="datas">
				<span><b>Исполнитель:</b></span>

				<span class="value">{!! $conclusion->inspector()->name.' '.$conclusion->inspector()->level.'<br>'.$conclusion->inspector()->document !!}</span>
				<div class="data-podpis" style="position: relative; left: 250px; top: -100px;">
					@if($ecp->value == 'on')
						<img src="{{ asset('print.png') }}" alt="" class="ecp_image">
					@endif
				</div>
			</div>
			<div class="podpis" style="position: relative; left: 300px; top: -115px;">
				{{--<img src="{{ asset('print.png') }}" alt="" style="width: 220px;">--}}
			</div>
		</div>

	</div>
	<!--@if($loop->index > 0)
		<div class="breaker"></div>
	@endif-->
@endforeach

<script>
	window.print();
</script>
</body>
</html>