<!doctype html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title></title>
	<link rel="stylesheet" href="{{ asset('css/print.css') }}">
	<style>
	  body { font-family: Times New Roman, sans-serif; font-size: 12px;}
	 /* p, span, div {*/
		/*	font-weight: normal!important;*/
		/*}*/
	</style>
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
			<h4>Заключение № МК {{ $conclusion->id }}</h4>
			<p>по результатам магнитопорошкового контрля (дефектоскопия)</p>
		</div>
	</div>
	<div class="date">От:
		<span>
			@php($conclusion->date = implode('.', array_reverse(explode('-', $conclusion->date))))
			<b>{{ $conclusion->date }}</b>
		</span>
	</div>
	<div class="name-object"><span>Наименование объекта контроля:</span><br>{{ $type->name }} {{ $type->description }}</div>
	<div class="data-object">
			@if(strlen($component->serial_number) > 20)
				<div class="serial_number">
					<span>S/N </span>
					<div class="data-sn-tn-manf-outsize">{{ $component->serial_number }}</div>
				</div>
				<div class="tape_number">
					<span>Рег.№ </span>
					<div class="data-sn-tn-manf-outsize">{{ $typeNumber }}</div>
				</div>
				<div class="manufacturer">
					<span>Manf. </span>
					<div class="data-sn-tn-manf-outsize">{{ $type->manufacturer }}</div>
				</div>
			@else
				<div class="serial_number">
					<span>S/N </span>
					<div class="data-sn-tn-manf">{{ $component->serial_number }}</div>
				</div>
				<div class="tape_number">
					<span>Рег.№ </span>
					<div class="data-sn-tn-manf">{{ $typeNumber }}</div>
				</div>
				<div class="manufacturer">
					<span>Manf. </span>
					<div class="data-sn-tn-manf">{{ $type->manufacturer }}</div>
				</div>
			@endif
	</div>
	<div class="city"><span>Место проведения контроля: </span><b>{{ $company->name }} {{ $component->work_location()->name }} {{ $component->facility()->number }} {{ $component->facility()->gos_number }} {{ $component->facility()->area }}</b></div>
	<div class="gost"><span>Контроль проводился согласно </span>{{ $gost_mk->value }}</div>
		@if(!empty($instruments) && count($instruments) > 0)
			<div class="measure_instruments">
				<span>Применяемые средства измерений:</span><br>
				@foreach($instruments as $instrument)
				@if($instrument->yes_instrument == 1)
					@php($instrument->next_verification_date = implode('.', array_reverse(explode('-', $instrument->next_verification_date))))
					<span>{{ $instrument->name }} № {{ $instrument->sertificate_number }} {{ $instrument->model }} s/n {{ $instrument->serial_number }} дата калибровки до {{ $instrument->next_verification_date }}г.;</span><br>
				@endif
				@endforeach
			</div>
		@endif
	<div class="conditions_controls">
		<!--<span>носитель на масленной основе Carrier 2.</span><br>-->
		<span>Способ контроля: способ приложенного поля (СПП).</span><br>
		<span>Схема нагмагничевания: продольное (полюсное) при помощи солиноида (электромагнита).</span><br>
		<span>Намагничевающий ток: переменный.</span><br>
		<span>Напряженность магнитного поля: не менее 70 А/см.</span><br>
		<span>Условия контроля:</span><br>
		<span>температура окружающей среды: {{ $conclusion->temperature}} °С</span>
		<br>
		<span>УФ-облучённость контролируемой поверхности объекта контроля 3000 мкВт/см2;</span>
		<!--<span>температурный режим: </span><span>{{ $conclusion->component()->type()->temperature_mode}} °С - {{ $conclusion->component()->type()->temperature_mode1}} °С</span>-->
	</div>
	<div class="image-object-control">
		<div>Эскиз объекта контроля:<br></div>
		<img src="{{ asset('types_data/'.$type->id.'/mk.jpg') }}" alt="" style="width: 350px;">
	</div>
	<div class="result-control">
		<div class="result-control-title">I - участок контроля</div>
		<table border="1" class="mk-control">
			<tr>
				<th>Проконтролированные элементы</th>
				<th>Координаты дефектов (со схемой расположения)</th>
				<th>Обнаруженные дефекты и их размеры.</th>
				<th>Оценка качества</th>
			</tr>
			<tr>
				<td>Соединительные элементы (покрытие отсутствует)</td>
				<td>{{ $conclusion->area_deffects }}</td>
				<td>{{ $conclusion->deffects_size }}</td>
				<td>{{ $conclusion->mk_result }}</td>
			</tr>
		</table>
	</div>
	<div class="result-control">
		<span><b>Заключение:</b></span> {{ $conclusion->mk_result }}
		<br>
	</div>
	<div class="chief">
		<span class="key"><b>Начальник ЛНК:</b></span>
		<span class="value">{{ $director->value }}</span>
	</div>
	<div class="executor">
		<div class="datas mb-1">
			<span><b>Исполнитель:</b></span><br>
			<span>специалист {{ $inspector->level }} уровня по {{ $inspector->control_method }}</span><br>
			<span>Удостоверение № {{ $inspector->num_document }}</span>
			<span class="value">{{ $inspector->name }}</span>
				@if($signDirector->value == 'on' || Auth::user()->role == 'Пользователь')
				<div class="podpis-dir">
					<img src="{{ asset('config_data/signDirector.png') }}" alt="">
				</div>
				@endif
				@if($signInspector->value == 'on' || Auth::user()->role == 'Пользователь')
				<div class="podpis-inspector">
					<img src="{{ asset('inspectors_data/'.$inspector->id.'/signInspector.png') }}" alt="">
				</div>
				@endif
				@if($stamp->value == 'on' || Auth::user()->role == 'Пользователь')
				<div class="data-podpis">
					<img src="{{ asset('config_data/stamp.png') }}" alt="" class="ecp_image">
				</div>
				@endif
		</div>
	</div>
	@if($ecp->value == 'on' || Auth::user()->role == 'Пользователь')
	<div id="border" style="font-size: 20px;">
		<div style="position: relative; text-align: center; margin-bottom: 0px; overflow: auto;">
			<img src="{{ asset('config_data/ecpPrint.png') }}" alt="" style="width: 330px;">
		</div>
	</div>
	@endif
</div>
<script>
	window.print();
</script>
</body>
</html>