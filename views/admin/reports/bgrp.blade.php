<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title></title>
	<link rel="stylesheet" href="{{ asset('css/print.css') }}">
</head>
<body>
	<div class="conclusion">
		<div>
			<div style="font-size: 10px;">
				{!! $header->value !!}
			</div>
			<div style="display: flex;justify-content: center;align-items: center;margin-top: -30px;">
				<img style="width: 150px; height: 150px;" src="{{ asset('alyansLogo.png') }}" alt="">
			</div>
		</div>
		<br>
		<div class="title">
			<div class="header-data">ООО &#171АльянсЭксперт&#187 <br>Лаборатория неразрушающего контроля</div>
			<div>
				<h4>Акт гидравлического испытания № {{ $conclusion->id }}</h4>
			</div>
		</div>
		<div class="date">От:
			<span>
			@php($conclusion->date = implode('.', array_reverse(explode('-', $conclusion->date))))
				{{ $conclusion->date }}
			</span>
		</div>
		<div class="name-object"><span>Наименование объекта, подвергавшегося гидравлическому испытанию:</span><br>
			{{ $type->name }} {{ $type->description }}
		</div>
		<div class="data-object">
			<span>S/N </span>{{ $component->serial_number }}
			<span>Manf. </span>{{ $type->manufacturer }}
		</div>
	<div class="city">
		<span>Место проведения контроля: </span><br>
		{{ $company->name }}, {{ $component->work_location()->name }} {{ $component->facility()->number }} {{ $component->facility()->gos_number }} {{ $component->facility()->area }}.
	</div>
	<div>
		Специалистами ООО «АльянсЭксперт» проведено гидравлическое испытание объекта:<br>
		Гидравические испытания проводились следующим оборудованием:<br>
		@if(!empty($instruments) && count($instruments) > 0)
			<div class="measure_instruments">
				@foreach($instruments as $instrument)
					@if($instrument->yes_instrument == 1)
						@php($instrument->next_verification_date = implode('.', array_reverse(explode('-', $instrument->next_verification_date))))
						<span>{{ $instrument->name }} № {{ $instrument->sertificate_number }} дата калибровки до {{ $instrument->next_verification_date }}г;</span><br>
					@endif
				@endforeach
			</div>
		@endif
	</div>
		<div class="gi">
			<span>Этапы испытания:</span>
			@if($conclusion->gi_result === 'Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность')
				<table border="0">
					@if(!empty($type->act_1) || !empty($type->period_1))
					<tr>
						<td>1 этап - P<sub>1</sub>= {{ $type->crimping_1 }} {{ $component->type()->measure }}, время выдержки {{ $type->period_1 }} минут</td>
					</tr>
					@endif
					@if(!empty($type->act_2) || !empty($type->period_2))
						<tr>
							<td>2 этап - P<sub>2</sub>= {{ $type->crimping_2 }} {{ $component->type()->measure }}, время выдержки {{ $type->period_2 }} минут</td>
						</tr>
					@elseif(!empty($crimping_2))
						<tr>
							<td>2 этап - P<sub>2</sub>= {{ $crimping_2 }} {{ $component->type()->measure }}, время выдержки {{ $type->period_1 }} минут</td>
						</tr>
					@endif
					@if(!empty($type->act_2) || !empty($type->period_2))
					<tr>
						<td>3 этап - P<sub>3</sub>= {{ $crimping_3 }} {{ $component->type()->measure }}, время выдержки {{ $type->period_2 }} минут</td>
					</tr>
					@endif
					@if(!empty($type->act_4) || !empty($type->period_4))
					<tr>
						<td>4 этап - P<sub>4</sub>= {{ $type->crimping_4 }} {{ $component->type()->measure }}, время выдержки {{ $type->period_4 }} минут</td>
					</tr>
					@endif
					@if(!empty($type->act_5) || !empty($type->period_5))
					<tr>
						<td>5 этап - P<sub>5</sub>= {{ $type->crimping_5 }} {{ $component->type()->measure }}, время выдержки {{ $type->period_5 }} минут</td>
					</tr>
					@endif
					@if(!empty($type->act_6) || !empty($type->period_6))
					<tr>
						<td>6 этап - P<sub>6</sub>= {{ $type->crimping_6 }} {{ $component->type()->measure }}, время выдержки {{ $type->period_6 }} минут</td>
					</tr>
					@endif
				</table>
			@else
			<table border="0">
					@if(!empty($type->act_1) || !empty($type->period_1))
					<tr>
						<td>1 этап - P<sub>1</sub>= 0 {{ $component->type()->measure }}, время выдержки 0 минут</td>
					</tr>
					@endif
					@if(!empty($type->act_2) || !empty($type->period_2))
					<tr>
						<td>2 этап - P<sub>2</sub>= 0 {{ $component->type()->measure }}, время выдержки 0 минут</td>
					</tr>
					@endif
					@if(!empty($type->act_3) || !empty($type->period_3))
					<tr>
						<td>3 этап - P<sub>3</sub>= 0 {{ $component->type()->measure }}, время выдержки 0 минут</td>
					</tr>
					@endif
					@if(!empty($type->act_4) || !empty($type->period_4))
					<tr>
						<td>4 этап - P<sub>4</sub>= 0 {{ $component->type()->measure }}, время выдержки 0 минут</td>
					</tr>
					@endif
					@if(!empty($type->act_5) || !empty($type->period_5))
					<tr>
						<td>5 этап - P<sub>5</sub>= 0 {{ $component->type()->measure }}, время выдержки 0 минут</td>
					</tr>
					@endif
					@if(!empty($type->act_6) || !empty($type->period_6))
					<tr>
						<td>6 этап - P<sub>6</sub>= 0 {{ $component->type()->measure }}, время выдержки 0 минут</td>
					</tr>
					@endif
				</table>
			@endif
		</div>
		<div>При выдержке под  давлением падения давления по манометру не наблюдалось.</div>
		<div class="conditions_controls">
			<span>Условия контроля: температура окружающей среды: </span>{{ $conclusion->temperature }} °С; <span>температура воды + 10 °С</span>
		</div>
		<div>
			После выдержки под  давлением и снижения давления до нуля выполнялся осмотр 
			каждой сборочной единицы (объекта) линии манифольда. При осмотре признаков остаточных 
			деформаций, трещин, разрывов, течей, отпотеваний основного металла, пропусков в разъёмных 
			соединениях обнаружено не было.																														            
		</div>
		<div class="result-control">
			@if($conclusion->gi_result === 'Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность' && file_exists(public_path('conclusions_data/'.$conclusion->id.'/diagramma_bgrp.jpg')))
				<div>
					<b>Приложение: </b>
					<span>диаграмма гидравлического испытания № {{ $conclusion->id }}</span>
				</div>
			@endif
			<div><b>Заключение:</b></div>
			<div class="result">
				<!--Объект, входящий в состав блока ГРП высокого давления, испытание давлением-->
				@if($conclusion->gi_result === 'Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность')
					@if(!empty($crimping_3))
						Объект {{ $type->name }} {{ $type->description }} испытание пробным давлением Р = {{ $crimping_3 }} {{ $component->type()->measure }} выдержал.
					@elseif(!empty($crimping_2))
						Объект {{ $type->name }} {{ $type->description }} испытание пробным давлением Р = {{ $crimping_2 }} {{ $component->type()->measure }} выдержал.
					@else
						Объект {{ $type->name }} {{ $type->description }} испытание пробным давлением Р = {{ $component->type()->pressure }} {{ $component->type()->measure }} выдержал.
					@endif
				@else
					@if(!empty($crimping_3))
						Объект {{ $type->name }} {{ $type->description }} испытание пробным давлением Р = {{ $crimping_3 }} {{ $component->type()->measure }} не выдержал.
					@elseif(!empty($crimping_2))
						Объект {{ $type->name }} {{ $type->description }} испытание пробным давлением Р = {{ $crimping_2 }} {{ $component->type()->measure }} не выдержал.
					@else
						Объект {{ $type->name }} {{ $type->description }} испытание пробным давлением Р = {{ $component->type()->pressure }} {{ $component->type()->measure }} не выдержал.
					@endif
				@endif
			</div>
		</div>
		<div class="executor">
			<div class="datas mb-1">
				<span>Испытание провели специалисты:</span>
				<span class="value">{{ $inspector->name }}</span>
					@if($signInspector->value == 'on' || Auth::user()->role == 'Пользователь')
					<div class="podpis-inspector">
						<img src="{{ asset('inspectors_data/'.$inspector->id.'/signInspector.png') }}" alt="">
					</div>
					@endif
					@if($stamp->value == 'on' || Auth::user()->role == 'Пользователь')
					<div class="data-podpis" style="top: 5px;">
						<img src="{{ asset('config_data/stamp.png') }}" alt="" class="ecp_image">
					</div>
					@endif
			</div>
		</div>
		<div id="border" style="font-size: 20px;">
		   @if(($ecp->value == 'on' || Auth::user()->role == 'Пользователь') && file_exists(public_path('config_data/ecpPrint.png')))
			<div style="position: relative; text-align: center; margin-bottom: 0px; overflow: auto;">
				<img src="{{ asset('config_data/ecpPrint.png') }}" alt="" style="width: 330px;">
			</div>
			@endif
		</div>
	</div>
	@if($conclusion->gi_result === 'Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность' && file_exists(public_path('conclusions_data/'.$conclusion->id.'/diagramma_bgrp.jpg')))
	<div class="breaker"></div>
	<div class="image-object-control">
		<div>
			Диаграмма гидравлического испытания № {{ $conclusion->id }}
			к акту гидравлического испытания № {{ $conclusion->id }}
			от:
			@php($conclusion->date = implode('.', array_reverse(explode('-', $conclusion->date))))
				{{ $conclusion->date }}
		</div>
		<img src="{{ asset('conclusions_data/'.$conclusion->id.'/diagramma_bgrp.jpg') }}" alt="" style="width:500px;height:auto;">
	</div>
	@endif
</div>
	<script>
		window.print();
	</script>
</body>
</html>