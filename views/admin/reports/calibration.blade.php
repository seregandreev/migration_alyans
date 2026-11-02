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
				<h4>Акт тарировки предохранительного клапана № {{ $conclusion->id }}</h4>
			</div>
		</div>
		<div class="date">От:
			<span>
			@php($conclusion->date = implode('.', array_reverse(explode('-', $conclusion->date))))
				{{ $conclusion->date }}
		</span>
		</div>
		<div class="city">
			<span>Настоящий акт составлен о том, что Базе </span>
			{{ $company->name }} {{ $component->work_location()->name }} {{ $component->facility()->number }} {{ $component->facility()->gos_number }} {{ $component->facility()->area }}<br>
			была произведена настройка и проверка работоспособности оборудования, а именно:<br>
			<b>Клапан предохранительный</b> {{ $type->description }} произведенного фирмой {{ $type->manufacturer }}<br>
			с заводским номером: {{ $component->serial_number }} и инвентарным номером: {{ $typeNumber }}<br>
			Принадлежащий организации: {{ $company->name }}
		</div>
	<div><br>
		<b style="margin-left: 10px;">1. Настройка клапана предохранительного</b><br>
		Настройка клапана предохранительного произведена с учетом его рабочих характеристик, 
		с учетом характеристик оборудования, в составе которого работает клапан предохранительный, 
		в соответствии с {{ $gost_container->value }} Сосуды, работающие под давлением. 
		Клапаны предохранительные. Требования безопасности;
		{{ $gost_armature->value }} Арматура трубопроводная. Методы контроля и испытаний.<br>
		Клапан предохранительный настроен на удержание давления: {{ $conclusion->calibration_pressure }}  МПа 
		(давление настройки) и срабатывание при превышении этого давления. 
	</div>
	<div>
		{{-- давление не превышающее 5% --}}
		<b style="margin-left: 10px;">2. Проверка работоспособности клапана предохранительного</b><br>
		Клапан предохранительный испытан на герметичность затвора путем выдержки под давлением 
		настройки: {{ $conclusion->calibration_pressure }} МПа в течение {{ $type->period_1 }} минут. 
		При выдержке под давлением падения давления по манометру не наблюдалось.<br>
		Клапан предохранительный испытан на срабатывание 8 циклами "открыто-закрыто" в результате
		чего установлено: максимальное зафиксированное давление начала открытия (P<sub>н.о.</sub>) клапана 
		составило  <!--  {{ $fixPressure }} -->{{ $conclusion->calibration_pressure }} МПа, что не превышает 5% от давления настройки и соответствует требованиям {{ $gost_requirement->value }}
	</div>
	<div>
		<b>Диаграмма проведения проверки работоспособности предохранительного клапана № {{ $conclusion->id }}</b>
	</div>
	<div class="conditions_controls">
		<b style="margin-left: 10px;">3. Условия настройки и контроля</b><br>
		<span>Температура окружающей среды: </span><br>
		<span>Испытательная среда: Вода. {{ $conclusion->temperature }} °С;</span><br>
		<span>температура воды + 10 °С.</span>
	</div>
	@if(!empty($instruments) && count($instruments) > 0)
	<div class="measure_instruments">
		Испытательное оборудование:<br>
		@foreach($instruments as $instrument)
			@if($instrument->yes_instrument == 1)
				<span>{{ $instrument->name }} № {{ $instrument->sertificate_number }} дата калибровки {{ $instrument->next_verification_date }};</span><br>
			@endif
		@endforeach
	</div>
	@endif
		<div class="executor">
			<div class="datas mb-1">
				<span>Тарировку произвели специалисты<br>ООО «АльянсЭксперт»</span>
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
	@if(file_exists(public_path('conclusions_data/'.$conclusion->id.'/diagramma_calibration.jpg')))
	<div class="breaker"></div>
	<div class="image-object-control">
		<div>Диаграмма № {{ $conclusion->id }}</div>
		<img src="{{ asset('conclusions_data/'.$conclusion->id.'/diagramma_calibration.jpg') }}" alt="" style="height: 100%; width: 100%;">
	</div>
	@endif
	<script>
		window.print();
	</script>
</body>
</html>