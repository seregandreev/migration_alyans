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
			<h4>Заключение № УЗТ(УЗД) {{ $conclusion->id }}</h4>
			<p>по результатам ультразвуковой толщинометрии (дефектоскопия)</p>
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
	<div class="gost"><span>Контроль проводился согласно </span>{{ $gost_uzt->value }}</div>
	<br>
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
		<span>Номинальная частота контроля: 5 МГц;</span>
		<br>
		<span>Условия контроля: температура окружающей среды: </span>{{ $conclusion->temperature }} °С
	</div>
	<div class="image-object-control">
		<div>Эскиз объекта контроля:</div>
		<img src="{{ asset('types_data/'.$type->id.'/uzt.jpg') }}" alt="" style="width: 350px;">
		<p>С1-С10 - сечения (места проведения УЗТ)</p>
		<p>Результаты измерений (мм)</p>
	</div>
	<div class="result-control">
		<table border="1" class="uzt-control">
			<tr>
				<td rowspan="2">Сечение</td>
				@php($cnt_concl_measure = 0)
					@while($cnt_concl_measure < 1)
						@if(!empty($conclusion->measure_1) && $conclusion->measure_1 != "-") @php($cnt_concl_measure += 1) @endif
						@if(!empty($conclusion->measure_2) && $conclusion->measure_2 != "-") @php($cnt_concl_measure += 1) @endif
						@if(!empty($conclusion->measure_3) && $conclusion->measure_3 != "-") @php($cnt_concl_measure += 1) @endif
						@if(!empty($conclusion->measure_4) && $conclusion->measure_4 != "-") @php($cnt_concl_measure += 1) @endif
						@if(!empty($conclusion->measure_5) && $conclusion->measure_5 != "-") @php($cnt_concl_measure += 1) @endif
						@if(!empty($conclusion->measure_6) && $conclusion->measure_6 != "-") @php($cnt_concl_measure += 1) @endif
						@if(!empty($conclusion->measure_7) && $conclusion->measure_7 != "-") @php($cnt_concl_measure += 1) @endif
						@if(!empty($conclusion->measure_8) && $conclusion->measure_8 != "-") @php($cnt_concl_measure += 1) @endif
						@if(!empty($conclusion->measure_9) && $conclusion->measure_9 != "-") @php($cnt_concl_measure += 1) @endif
						@if(!empty($conclusion->measure_10) && $conclusion->measure_10 != "-") @php($cnt_concl_measure += 1) @endif
						@break
					@endwhile
				<th colspan="{{ $cnt_concl_measure }}">Измеренная толщина, мм</th>
				@php($cnt_type_measure = 0)
					@while($cnt_type_measure < 1)
						@if(!empty($type->measure_1) && $type->measure_1 != "-" && !empty($conclusion->measure_1) && $conclusion->measure_1 != "-") @php($cnt_type_measure += 1) @endif
						@if(!empty($type->measure_2) && $type->measure_2 != "-" && !empty($conclusion->measure_2) && $conclusion->measure_2 != "-") @php($cnt_type_measure += 1) @endif
						@if(!empty($type->measure_3) && $type->measure_3 != "-" && !empty($conclusion->measure_3) && $conclusion->measure_3 != "-") @php($cnt_type_measure += 1) @endif
						@if(!empty($type->measure_4) && $type->measure_4 != "-" && !empty($conclusion->measure_4) && $conclusion->measure_4 != "-") @php($cnt_type_measure += 1) @endif
						@if(!empty($type->measure_5) && $type->measure_5 != "-" && !empty($conclusion->measure_5) && $conclusion->measure_5 != "-") @php($cnt_type_measure += 1) @endif
						@if(!empty($type->measure_6) && $type->measure_6 != "-" && !empty($conclusion->measure_6) && $conclusion->measure_6 != "-") @php($cnt_type_measure += 1) @endif
						@if(!empty($type->measure_7) && $type->measure_7 != "-" && !empty($conclusion->measure_7) && $conclusion->measure_7 != "-") @php($cnt_type_measure += 1) @endif
						@if(!empty($type->measure_8) && $type->measure_8 != "-" && !empty($conclusion->measure_8) && $conclusion->measure_8 != "-") @php($cnt_type_measure += 1) @endif
						@if(!empty($type->measure_9) && $type->measure_9 != "-" && !empty($conclusion->measure_9) && $conclusion->measure_9 != "-") @php($cnt_type_measure += 1) @endif
						@if(!empty($type->measure_10) && $type->measure_10 != "-" && !empty($conclusion->measure_10) && $conclusion->measure_10 != "-") @php($cnt_type_measure += 1) @endif
						@break
					@endwhile
				<th colspan="{{ $cnt_type_measure }}">Предельно-допустимая толщина, мм</th>
			</tr>
			<tr>
			@if(!empty($conclusion->measure_1) && $conclusion->measure_1 != "-")<td>С1</td>@else<td style="display: none">С1</td>@endif
			@if(!empty($conclusion->measure_2) && $conclusion->measure_2 != "-")<td>С2</td>@else<td style="display: none">С2</td>@endif
			@if(!empty($conclusion->measure_3) && $conclusion->measure_3 != "-")<td>С3</td>@else<td style="display: none">С3</td>@endif
			@if(!empty($conclusion->measure_4) && $conclusion->measure_4 != "-")<td>С4</td>@else<td style="display: none">С4</td>@endif
			@if(!empty($conclusion->measure_5) && $conclusion->measure_5 != "-")<td>С5</td>@else<td style="display: none">С5</td>@endif
			@if(!empty($conclusion->measure_6) && $conclusion->measure_6 != "-")<td>С6</td>@else<td style="display: none">С6</td>@endif
			@if(!empty($conclusion->measure_7) && $conclusion->measure_7 != "-")<td>С7</td>@else<td style="display: none">С7</td>@endif
			@if(!empty($conclusion->measure_8) && $conclusion->measure_8 != "-")<td>С8</td>@else<td style="display: none">С8</td>@endif
			@if(!empty($conclusion->measure_9) && $conclusion->measure_9 != "-")<td>С9</td>@else<td style="display: none">С9</td>@endif
			@if(!empty($conclusion->measure_10) && $conclusion->measure_10 != "-")<td>С10</td>@else<td style="display: none">С10</td>@endif
			@if(!empty($type->measure_1) && $type->measure_1 != "-" && !empty($conclusion->measure_1) && $conclusion->measure_1 != "-")<td>С1</td>@else<td style="display: none">С1</td>@endif
			@if(!empty($type->measure_2) && $type->measure_2 != "-" && !empty($conclusion->measure_2) && $conclusion->measure_2 != "-")<td>С2</td>@else<td style="display: none">С2</td>@endif
			@if(!empty($type->measure_3) && $type->measure_3 != "-" && !empty($conclusion->measure_3) && $conclusion->measure_3 != "-")<td>С3</td>@else<td style="display: none">С3</td>@endif
			@if(!empty($type->measure_4) && $type->measure_4 != "-" && !empty($conclusion->measure_4) && $conclusion->measure_4 != "-")<td>С4</td>@else<td style="display: none">С4</td>@endif
			@if(!empty($type->measure_5) && $type->measure_5 != "-" && !empty($conclusion->measure_5) && $conclusion->measure_5 != "-")<td>С5</td>@else<td style="display: none">С5</td>@endif
			@if(!empty($type->measure_6) && $type->measure_6 != "-" && !empty($conclusion->measure_6) && $conclusion->measure_6 != "-")<td>С6</td>@else<td style="display: none">С6</td>@endif
			@if(!empty($type->measure_7) && $type->measure_7 != "-" && !empty($conclusion->measure_7) && $conclusion->measure_7 != "-")<td>С7</td>@else<td style="display: none">С7</td>@endif
			@if(!empty($type->measure_8) && $type->measure_8 != "-" && !empty($conclusion->measure_8) && $conclusion->measure_8 != "-")<td>С8</td>@else<td style="display: none">С8</td>@endif
			@if(!empty($type->measure_9) && $type->measure_9 != "-" && !empty($conclusion->measure_9) && $conclusion->measure_9 != "-")<td>С9</td>@else<td style="display: none">С9</td>@endif
			@if(!empty($type->measure_10) && $type->measure_10 != "-" && !empty($conclusion->measure_10) && $conclusion->measure_10 != "-")<td>С10</td>@else<td style="display: none">С10</td>@endif
			</tr>
			<tr>
				<td>Минимальная толщина</td>
				@if(!empty($conclusion->measure_1) && $conclusion->measure_1 != "-")<td>{{ $conclusion->measure_1 }}</td>@else<td style="display: none">{{ $conclusion->measure_1 }}</td>@endif
				@if(!empty($conclusion->measure_2) && $conclusion->measure_2 != "-")<td>{{ $conclusion->measure_2 }}</td>@else<td style="display: none">{{ $conclusion->measure_2 }}</td>@endif
				@if(!empty($conclusion->measure_3) && $conclusion->measure_3 != "-")<td>{{ $conclusion->measure_3 }}</td>@else<td style="display: none">{{ $conclusion->measure_3 }}</td>@endif
				@if(!empty($conclusion->measure_4) && $conclusion->measure_4 != "-")<td>{{ $conclusion->measure_4 }}</td>@else<td style="display: none">{{ $conclusion->measure_4 }}</td>@endif
				@if(!empty($conclusion->measure_5) && $conclusion->measure_5 != "-")<td>{{ $conclusion->measure_5 }}</td>@else<td style="display: none">{{ $conclusion->measure_5 }}</td>@endif
				@if(!empty($conclusion->measure_6) && $conclusion->measure_6 != "-")<td>{{ $conclusion->measure_6 }}</td>@else<td style="display: none">{{ $conclusion->measure_6 }}</td>@endif
				@if(!empty($conclusion->measure_7) && $conclusion->measure_7 != "-")<td>{{ $conclusion->measure_7 }}</td>@else<td style="display: none">{{ $conclusion->measure_7 }}</td>@endif
				@if(!empty($conclusion->measure_8) && $conclusion->measure_8 != "-")<td>{{ $conclusion->measure_8 }}</td>@else<td style="display: none">{{ $conclusion->measure_8 }}</td>@endif
				@if(!empty($conclusion->measure_9) && $conclusion->measure_9 != "-")<td>{{ $conclusion->measure_9 }}</td>@else<td style="display: none">{{ $conclusion->measure_9 }}</td>@endif
				@if(!empty($conclusion->measure_10) && $conclusion->measure_10 != "-")<td>{{ $conclusion->measure_10 }}</td>@else<td style="display: none">{{ $conclusion->measure_10 }}</td>@endif
				@if(!empty($type->measure_1) && $type->measure_1 != "-" && !empty($conclusion->measure_1) && $conclusion->measure_1 != "-")<td>{{ $type->measure_1 }}</td>@else<td style="display: none">{{ $type->measure_1 }}</td>@endif
				@if(!empty($type->measure_2) && $type->measure_2 != "-" && !empty($conclusion->measure_2) && $conclusion->measure_2 != "-")<td>{{ $type->measure_2 }}</td>@else<td style="display: none">{{ $type->measure_2 }}</td>@endif
				@if(!empty($type->measure_3) && $type->measure_3 != "-" && !empty($conclusion->measure_3) && $conclusion->measure_3 != "-")<td>{{ $type->measure_3 }}</td>@else<td style="display: none">{{ $type->measure_3 }}</td>@endif
				@if(!empty($type->measure_4) && $type->measure_4 != "-" && !empty($conclusion->measure_4) && $conclusion->measure_4 != "-")<td>{{ $type->measure_4 }}</td>@else<td style="display: none">{{ $type->measure_4 }}</td>@endif
				@if(!empty($type->measure_5) && $type->measure_5 != "-" && !empty($conclusion->measure_5) && $conclusion->measure_5 != "-")<td>{{ $type->measure_5 }}</td>@else<td style="display: none">{{ $type->measure_5 }}</td>@endif
				@if(!empty($type->measure_6) && $type->measure_6 != "-" && !empty($conclusion->measure_6) && $conclusion->measure_6 != "-")<td>{{ $type->measure_6 }}</td>@else<td style="display: none">{{ $type->measure_6 }}</td>@endif
				@if(!empty($type->measure_7) && $type->measure_7 != "-" && !empty($conclusion->measure_7) && $conclusion->measure_7 != "-")<td>{{ $type->measure_7 }}</td>@else<td style="display: none">{{ $type->measure_7 }}</td>@endif
				@if(!empty($type->measure_8) && $type->measure_8 != "-" && !empty($conclusion->measure_8) && $conclusion->measure_8 != "-")<td>{{ $type->measure_8 }}</td>@else<td style="display: none">{{ $type->measure_8 }}</td>@endif
				@if(!empty($type->measure_9) && $type->measure_9 != "-" && !empty($conclusion->measure_9) && $conclusion->measure_9 != "-")<td>{{ $type->measure_9 }}</td>@else<td style="display: none">{{ $type->measure_9 }}</td>@endif
				@if(!empty($type->measure_10) && $type->measure_10 != "-" && !empty($conclusion->measure_10) && $conclusion->measure_10 != "-")<td>{{ $type->measure_10 }}</td>@else<td style="display: none">{{ $type->measure_10 }}</td>@endif
			</tr>
		</table>
		<br>
		<div class="result">
			<span><b>Вывод:</b> {{ $conclusion->uzt_result }}</span>
			<br>
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