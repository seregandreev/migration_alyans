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
			<h4>Заключение № УЗК {{ $conclusion->id }}</h4>
			<p>по результатам ультразвукового контроля</p>
		</div>
	</div>
		<div class="date">От:
			<span>
			@php($conclusion->date = implode('.', array_reverse(explode('-', $conclusion->date))))
				{{ $conclusion->date }}
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
	<!--<div class="part_num"><b>Партийный номер:</b> {{ $type->partial_number }}</div>-->
	<div class="city"><span>Место проведения контроля: </span><b>{{ $company->name }} {{ $component->work_location()->name }} {{ $component->facility()->number }} {{ $component->facility()->gos_number }} {{ $component->facility()->area }}</b></div>
	<div class="gost"><span>Контроль производился в соответствии с </span>{{ $gost_uzk->value }}</div>
	<span>Применяемые средства измерений:</span><br>
		@if(!empty($instrumentsUzk) && count($instrumentsUzk) > 0)
			<div class="measure_instruments">
			@foreach($instrumentsUzk as $instrumentUzk)
			@if($instrumentUzk->yes_instrument == 1)
				@php($instrumentUzk->next_verification_date = implode('.', array_reverse(explode('-', $instrumentUzk->next_verification_date))))
				<span>{{ $instrumentUzk->name }} № {{ $instrumentUzk->sertificate_number }} {{ $instrumentUzk->model }} s/n {{ $instrumentUzk->serial_number }} дата калибровки до {{ $instrumentUzk->next_verification_date }}г.;</span><br>
			@endif
			@endforeach
			</div>
		@endif
	<div class="conditions_controls">
		<span>Условия контроля: температура окружающей среды: </span>{{ $conclusion->temperature }} °С
	</div>
	@if(file_exists(public_path('types_data/'.$type->id.'/uk.jpg')))
	<div class="image-object-control">
		<div>Эскиз объекта контроля:</div>
		<img src="{{ asset('types_data/'.$type->id.'/uk.jpg') }}" alt="" style="width: 350px;">
	</div>
	@endif
	<div class="result-control">
		<div><b>Результат проверки:</b></div>
		<div class="result">
			@if($conclusion->uzk_result === 'Годен')
				В результате ультразвукового контроля дефектов, препятствующих дальнейшей эксплуатации изделия <b>не обнаружено</b>
			@else
				В результате ультразвукового контроля дефектов, препятствующих дальнейшей эксплуатации изделия <b>обнаружено</b>
			@endif
		</div>
	</div>

	<div class="chief" style="margin-bottom: 1%;">
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
	<div id="border" style="font-size: 20px;">
	   @if($ecp->value == 'on' || Auth::user()->role == 'Пользователь')
		<div style="position: relative; text-align: center; margin-bottom: 0px; overflow: auto;">
			<img src="{{ asset('config_data/ecpPrint.png') }}" alt="" style="width: 330px;">
		</div>
		@endif
	</div>
</div>
	<script>
		window.print();
	</script>
</body>
</html>