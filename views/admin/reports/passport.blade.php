<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>ПАСПОРТ</title>
	<link rel="stylesheet" href="{{ asset('css/print.css') }}">
	<style>
		h4 {
			margin-bottom: 5px;
			font-weight: bold;
		}
	</style>
</head>
<body>
	<div class="passport bodrer-data">
		<div style="text-align: right; padding: 5px;">
			<img src="{{ asset('companies_data/'.$company->id.'/logo.jpg') }}" alt="" style="height: 70px; width: 150px; border-radius: 5px;">
		</div>
	<div class="title centered" style="text-transform: uppercase">
		{{ $company->name }}<br>
		{{ $component->facility()->number }} {{ $component->facility()->gos_number }} {{ $component->facility()->area }}<br><br>
		ТЕХНИЧЕСКИЙ ПАСПОРТ(ФОРМУЛЯР)<br>
		{{ $type->name }}<br>
		{{ $type->description }}<br>
		<img class="eskiz-vik" src="{{ asset('types_data/'.$type->id.'/vik.jpg') }}" alt="">
	</div>
	<div style="font-size: 20px; bottom:0;">
		<div class="footer_title footer_title_main centered">Изготовитель:</div>
		<div class="footer_title centered">{{ $type->manufacturer }}</div>
		<!--<div class="footer_title centered" style="margin-top: 10px; color: gray; padding: 5px;">{{ $typeNumber }}</div>-->
	</div>
	</div>
	<div class="breaker"></div>
	<div class="passport-info bodrer-data">
	<div class="title centered" style="text-transform: uppercase; font-size: 18px;">
		<b>ТЕХНИЧЕСКИЙ ПАСПОРТ(формуляр)<br>
		{{ $type->name }}<br>
		{{ $type->description }}</b><br>
	</div>
		<div class="table-data">
			<h4>1.0 Общие сведения</h4>
			<table border="1">
				<tr>
					<th style="width: 50%; text-align: left;">1. Наименование компании поставщика</th>
					<td>{{ $type->manufacturer }}</td>
				</tr>
				<tr>
					<th style="text-align: left;">2. Наименование компании владельца</th>
					<td>{{ $company->name }}</td>
				</tr>
				<tr>
					<th style="text-align: left;">3. Наименование изделия</th>
					<td>{{ $type->name }}</td>
				</tr>
				<tr>
					<th style="text-align: left;">4. Тип/модель изделия</th>
					<td>{{ $type->description }}</td>
				</tr>
				<tr>
					<th style="text-align: left;">5. Серийный номер изделия</th>
					<td>{{ $component->serial_number }}</td>
				</tr>
				<tr>
				<th style="text-align: left;">6. Номер бандажной ленты (рег. №)</th>
					<td>{{ $typeNumber }}</td>
				</tr>
				<tr>
					<th style="text-align: left;">7. Срок службы</th>
					<td>{{ $component->type()->life_time }}</td>
				</tr>
				<tr>
					<th style="text-align: left;">8. Дата ввода в эксплуатацию</th>
					<td>{{ date('d.m.Y', strtotime($component->date_start_expluatation)) }} г.</td>

				</tr>
			</table>
			<div style="margin-bottom: -8%;">
				<h4>2.0 Назначение изделия</h4>
					<span style="margin-bottom: 0px;">Данное изделие рекомендовано для проведения следующих операции обработки нефтяных и газовых скважин:</span>
					<ul>
						<li>Цементирование;</li>
						<li>Гидроразрыв пласта;</li>
						<li>Кислотная обработка;</li>
						<li>Для линий высокого давления при прокачке смесей, абразивов, буровых растворов, химических растворов и других схожих жидкостей;</li>
						<li>Испытания скважин.</li>
					</ul>
			</div>
		</div>
		<div class="table-data">
			<h4>3.0 Значения основных параметров и характеристик (свойств) изделия</h4>
			<table border="1">
				<tr>
					<th style="width: 50%; text-align: left;">1. Рабочее давление (максимальное)</th>
					<td>{{ $component->type()->pressure }} {{ $component->type()->measure }}</td>
					<!--<td>@if($component->type()->measure === 'Psi')-->
					<!--	{{ round((float)($component->type()->pressure)/145.038, 1, PHP_ROUND_HALF_UP) }} МПа-->
					<!--	@elseif($component->type()->measure === 'МПа')-->
					<!--	{{ (int)((float)($component->type()->pressure)*145.038) }} Psi-->
					<!--	@endif-->
					<!--</td>-->
				</tr>
				<tr>
					<th style="text-align: left;">2. Материал изделия</th>
					<td colspan="2">Легированная сталь/РТИ</td>
				</tr>
				<tr>
					<th style="text-align: left;">3. Температурный режим работы</th>
					<td colspan="2">От {{ $conclusion->component()->type()->temperature_mode }} °С До {{ $conclusion->component()->type()->temperature_mode1 }} °С</td>
				</tr>
				<tr>
					<th style="text-align: left;">4. Условия работы в коррозийных средах</th>
					<td colspan="2">Коррозионно-стойкая в среде H₂S</td>
				</tr>
			</table>
			<div>
				<h4>4.0 Сведения о приемке</h4>
				<p style="margin-top: 0px;">Изделие испытано после изготовления на герметичность рабочим давлением {{ $component->type()->pressure }} {{ $component->type()->measure }}
						<!--@if($component->type()->measure === 'Psi')-->
						<!--({{ round((float)($component->type()->pressure)/145.038, 1, PHP_ROUND_HALF_UP) }} МПа)-->
						<!--@elseif($component->type()->measure === 'МПа')-->
						<!--({{ (int)((float)($component->type()->pressure)*145.038) }} Psi)-->
						<!--@endif<br> -->
					и прочность пробным давлением {{ $crimping }} {{ $component->type()->measure }}
						<!--@if($component->type()->measure === 'Psi')-->
						<!--{{ (float)($component->type()->pressure) * 1.5 }} Psi-->
						<!--({{ round((float)($component->type()->pressure)/145.038*1.5, 1, PHP_ROUND_HALF_UP) }} МПа)-->
						<!--@elseif($component->type()->measure === 'МПа')-->
						<!--{{ round((float)($component->type()->pressure)*1.5, 1, PHP_ROUND_HALF_UP) }} МПа-->
						<!--({{ (int)((float)($component->type()->pressure)*145.038*1.5) }} Psi)-->
						<!--@endif-->.
						<br>
					Заключение: испытание выдержало.
				</p>
			</div>
			<div>
				<h4>5.0 Гарантия изготовителя</h4>
				<p style="margin-top: 0px;">Гарантия изготовителя не распространяется на предусмотренные к износу при эксплуатации части.<br>
					В случае возникновения поломки, на которую распространяется гарантия, владельцу изделия необходимо обратиться в команию {{ $company->name }} или к её официальному представителю.
				</p>
			</div>
		</div>
		<!--<div style="font-size: 20px; bottom:0;">
			<div class="footer_title centered" style="color: gray; padding: 5px;">{{ $typeNumber }}</div>
		</div>-->
	</div>
	<div class="breaker"></div>
	<div class="passport-info bodrer-data">
	<div class="title centered" style="text-transform: uppercase;">
		журнал проведения контроля<br>
	</div>
	<div class="table-data" >
		<table border="1" style="text-align: center;">
			<tr>
				<th>Дата проведения контроля</th>
				<th>Места проведения контроля</th>
				<!--<th>Перечень работ, проведённых при ремонте и техническом обслуживании (ВИК | УЗК | МК | ГИ)</th>-->
				<th>Результат / заключение</th>
				<th>Наименовение организации, проводившей контроль Ф.И.О. инспектора</th>
				<!--<th>Подпись</th>-->
				<th>Примечание</th>
			</tr>
			@foreach($conclusions as $conclusion_data)
				<tr>
					<td>{{ date('d.m.Y', strtotime($conclusion_data->date)) }} г.</td>
					<td>
						@php($result_conclusion = 'Годен')
						<p style="text-align: center;">Проведен неразрушающий контроль методами<br>
						{{-- ВИК --}}
						@if($conclusion_data->vik_result === "Состояние поверхности объекта контроля соответствует требованиям 3997-00.001 МУ «Методические указания по определению критериев вывода из эксплуатации нефтепромыслового оборудования»; Недопустимых дефектов не обнаружено")
							ВИК - Годен,
						@elseif(!empty($conclusion_data->vik_result))
							ВИК - Не годен,
							@php($result_conclusion = 'Не годен')
						@endif
						{{-- УЗК --}}
						@if($conclusion_data->uzt_result === 'Обнаруженные толщины не менее допустимых значений. Годен')
							УЗК - Годен,
						@elseif(!empty($conclusion_data->uzt_result))
							УЗК - Не годен,
							@php($result_conclusion = 'Не годен')
						@endif
						{{-- МК --}}
						@if($conclusion_data->mk_result === 'Годен')
							МК - Годен
						@elseif(!empty($conclusion_data->mk_result))
							МК - Не годен
							@php($result_conclusion = 'Не годен')
						@endif
						<br>(Соединительные элементы. Наружная и внутренняя поверхность в доступных местах.).
						{{-- ГИ --}}
						@if($conclusion_data->gi_result === 'Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность')
							Проведено гидравлическое испытание - Годен,
						@elseif(!empty($conclusion_data->gi_result))
							Проведено гидравлическое испытание - Не годен,
							@php($result_conclusion = 'Не годен')
						@endif
					</p>
					</td>
					<td>{{ $result_conclusion }}</td>
					<td>{!! $header->value !!} тел.8(34643)-4-27-90<br> {{ $conclusion_data->inspector()->name }}</td>
					<!--<td>{{ $conclusion_data->inspector()->name }} <img src="{{ asset('') }}" alt="" style="width: 90px; position: relative; top: -10px;" class="pechat"></td>-->
					<td></td>
				</tr>
			@endforeach
		</table>
	</div>
	</div>
	<div id="border" style="font-size: 20px;">
	   @if($ecp->value == 'on' || Auth::user()->role == 'Пользователь')
		<div style="position: relative; text-align: center; margin-bottom: 0px;">
			<img src="{{ asset('config_data/ecpPrint.png') }}" alt="" style="width: 330px;">
		</div>
		@endif
			<div class="footer_title centered" style="color: gray; padding: 5px;">{{ $typeNumber }}</div>
	</div>

	<!--@if($signInspector->value == 'on')
	<div class="podpis" style="position: relative; left: 420px; top: -100px;">
		<img src="{{ asset('inspectors_data/'.$inspector->id.'/signInspector.png') }}" alt="" style="width: 100px;">
	</div>
	@endif
	@if($signDirector->value == 'on')
	<div class="podpis" style="position: relative; left: 300px; top: -110px;">
		<img src="{{ asset('config_data/signDirector.png') }}" alt="" style="width: 100px;">
	</div>
	@endif -->
	@if($stamp->value == 'on' || Auth::user()->role == 'Пользователь')
	<div class="data-podpis" style="position: relative; left: 250px; top: 50px;">
		<img src="{{ asset('config_data/stamp.png') }}" alt="" class="ecp_image">
	</div>
	@endif

	<script>
		window.print();
	</script>
</body>
</html>