<!doctype html>
<html lang="ru">
<head>
	<meta charset="utf8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Пакет документов</title>
	<link rel="stylesheet" href="{{ asset('css/print.css') }}">
	<style>
	 /* body { font-family: 'Times New Roman', Times, serif; }*/
	  body { font-family: times; line-height: 1.2;}
	  p, span, div, h1, h2, h3 {
			font-weight: normal!important;
		}
		.header-data{position:static;}
		h4 {
			margin-bottom: 5px;
			font-weight: bold;
		}
	</style>
</head>
<body>
	@if($conclusion->passport == 1)
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
	<!--<div style="font-size: 20px; bottom:0; text-align: center;">-->
	<!--	<div>Изготовитель:</div>-->
	<!--	<div>{{ $type->manufacturer }}</div>-->
	<!--</div>-->
		 <div class="colontitul centered">
			<div>Изготовитель:</div>
			<div>{{ $type->manufacturer }}</div>
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
				<h4 style="margin-bottom: 0px;">2.0 Назначение изделия</h4>
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
			<h4 style="margin-bottom: 0px;">3.0 Значения основных параметров и характеристик (свойств) изделия</h4>
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
				<h4 style="margin-bottom: 0px;">4.0 Сведения о приемке</h4>
				<p style="margin-top: 0px;">Изделие испытано после изготовления на герметичность рабочим давлением {{ $component->type()->pressure }} {{ $component->type()->measure }}
						<!--@if($component->type()->measure === 'Psi')-->
						<!--({{ round((float)($component->type()->pressure)/145.038, 1, PHP_ROUND_HALF_UP) }} МПа)-->
						<!--@elseif($component->type()->measure === 'МПа')-->
						<!--({{ (int)((float)($component->type()->pressure)*145.038) }} Psi)-->
						<!--@endif <br>-->
					и прочность пробным давлением {{ $crimping }} {{ $component->type()->measure }}.
						<!--@if($component->type()->measure === 'Psi')-->
						<!--{{ (float)($component->type()->pressure) * 1.5 }} Psi-->
						<!--({{ round((float)($component->type()->pressure)/145.038*1.5, 1, PHP_ROUND_HALF_UP) }} МПа)-->
						<!--@elseif($component->type()->measure === 'МПа')-->
						<!--{{ round((float)($component->type()->pressure)*1.5, 1, PHP_ROUND_HALF_UP) }} МПа-->
						<!--({{ (int)((float)($component->type()->pressure)*145.038*1.5) }} Psi)-->
						<!--@endif-->
						<br>
					Заключение: испытание выдержало.
				</p>
			</div>
			<div>
				<h4 style="margin-bottom: 0px;">5.0 Гарантия изготовителя</h4>
				<p style="margin-top: 0px;">Гарантия изготовителя не распространяется на предусмотренные к износу при эксплуатации части.<br>
					В случае возникновения поломки, на которую распространяется гарантия, владельцу изделия необходимо обратиться в команию {{ $type->manufacturer }} или к её официальному представителю.
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
	<div class="table-data">
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
					@php($conclusion_data->date = implode('.', array_reverse(explode('-', $conclusion_data->date))))
					<td>{{ $conclusion_data->date }} г.</td>
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
					<td>ООО &#171АльянсЭксперт&#187 <br>Лаборатория неразрушающего контроля<br> тел.8(34643)-4-27-90<br> {{ $conclusion_data->inspector()->name }}</td>
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
			<div class="footer_title centered" style="color: gray;">{{ $typeNumber }}</div>
	</div>
	<div class="breaker"></div>
@endif
<!--pasport end-->

@if(!empty($conclusion->uzt_result) && $conclusion->check_uzt == 1)
<!--uzt start-->	
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
	<div class="name-object"><span>Наименование объекта контроля:</span><br><b>{{ $type->name }} {{ $type->description }}</b></div>
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
		@if(!empty($instruments_uzt) && count($instruments_uzt) > 0)
			<div class="measure_instruments">
			<span>Применяемые средства измерений:</span><br>
			@foreach($instruments_uzt as $instrument)
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

	<div class="chief">
		<span class="key"><b>Начальник ЛНК:</b></span>
		<span class="value">{{ $director->value }}</span>
	</div>
		<div class="executor">
			<div class="datas mb-1">
				<span><b>Исполнитель:</b></span><br>
				<span>специалист {{ $inspector->level }} уровня по {{ $inspector->control_method }}</span><br>
				<span>Удостоверение № {{ $inspector->num_document }}</span>
				<span class="value" style="float: right;">{{ $inspector->name }}</span>
					@if($signInspector->value == 'on' || Auth::user()->role == 'Пользователь')
					<div class="podpis-dir">
						<img src="{{ asset('config_data/signDirector.png') }}" alt="">
					</div>
					@endif
					@if($signDirector->value == 'on' || Auth::user()->role == 'Пользователь')
					<div class="podpis-inspector">
						<img src="{{ asset('inspectors_data/'.$inspector->id.'/signInspector.png') }}" alt="">
					</div>
					@endif
					<br>
					@if($stamp->value == 'on' || Auth::user()->role == 'Пользователь')
					<div class="data-podpis">
						<img src="{{ asset('config_data/stamp.png') }}" alt="" class="ecp_image">
					</div>
					@endif
			</div>
		</div>
</div>
@endif
<!--uzt end-->

@if(!empty($conclusion->uzk_result) && $conclusion->check_uzk == 1)
<div class="break_before"></div>
<!--uzk start-->	
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
	<div class="name-object"><span>Наименование объекта контроля:</span><br><b>{{ $type->name }} {{ $type->description }}</b></div>
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
		@if(!empty($instruments_uzk) && count($instruments_uzk) > 0)
			<div class="measure_instruments">
			@foreach($instruments_uzk as $instrumentUzk)
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
					@if($signInspector->value == 'on' || Auth::user()->role == 'Пользователь')
					<div class="podpis-dir">
						<img src="{{ asset('config_data/signDirector.png') }}" alt="">
					</div>
					@endif
					@if($signDirector->value == 'on' || Auth::user()->role == 'Пользователь')
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
</div>
@endif
<!--uzk end-->

@if(!empty($conclusion->vik_result) && $conclusion->check_vik == 1)
<div class="break_before"></div>
<!--vik start-->

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
				<h4>Заключение № ВИК {{ $conclusion->id }}</h4>
				<p>по визуальному и измерительному контролю (дефектоскопия)</p>
			</div>
		</div>
		<div class="date">От:
			<span>
			@php($conclusion->date = implode('.', array_reverse(explode('-', $conclusion->date))))
				{{ $conclusion->date }}
		</span>
		</div>
		<div class="name-object"><span>Наименование объекта контроля:</span><br><b>{{ $type->name }} {{ $type->description }}</b></div>
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
		<!--<div class="part_num"><b>Партийный номер:</b><br> {{ $type->partial_number }}</div>-->
		<div class="city"><span>Место проведения контроля: </span><b>{{ $company->name }} {{ $component->work_location()->name }} {{ $component->facility()->number }} {{ $component->facility()->gos_number }} {{ $component->facility()->area }}</b></div>
		<div class="gost"><span>Контроль проводился согласно </span>{{ $gost_vik->value }}</div>
			<br>
		@if(!empty($instruments_vik) && count($instruments_vik) > 0)
			<div class="measure_instruments">
			<span>Применяемые средства измерений:</span><br>
			@foreach($instruments_vik as $instrument)
			@if($instrument->yes_instrument == 1)
				@php($instrument->next_verification_date = implode('.', array_reverse(explode('-', $instrument->next_verification_date))))
				<span>{{ $instrument->name }} № {{ $instrument->sertificate_number }} {{ $instrument->model }} s/n {{ $instrument->serial_number }} дата калибровки до {{ $instrument->next_verification_date }}г.;</span><br>
			@endif
			@endforeach
			</div>
		@endif
		<div class="conditions_controls">
			<span>Условия контроля:</span>
			<br>
			<span>температура окружающей среды: </span>{{ $conclusion->temperature }} °С
			<br>
			<span>освещённость: общая 600 лк; контролируемой поверхности - 2500 лк</span>
			<br>
			<span>Визуальному и измерительному контролю подверглись: места доступные для осмотра.</span>
		</div>
		<!--<div class="image-object-control">
			<div>Эскиз объекта контроля:</div>
			<br>
			<img src="{{ asset('types_data/'.$type->id.'/vik.jpg') }}" alt="">
			<br>
			<br>
		</div>-->
		<div class="result-control">
			<span><b>Заключение:</b></span>
			@if($conclusion->vik_result === "Состояние поверхности объекта контроля соответствует требованиям 3997-00.001 МУ «Методические указания по определению критериев вывода из эксплуатации нефтепромыслового оборудования»; Недопустимых дефектов не обнаружено")
				<b>Годен.</b> {{ $conclusion->vik_result }}
			@else
				<b>Не годен.</b> {{ $conclusion->vik_result }}
			@endif
		</div>
		<div class="chief">
			<span class="key"><b>Начальник ЛНК:</b></span>
			<span class="value">{{ $director->value }}</span>
		</div>
		
			<div class="datas mb-1">
				<span><b>Исполнитель:</b></span><br>
				<span>специалист {{ $inspector->level }} уровня по {{ $inspector->control_method }}</span><br>
				<span>Удостоверение № {{ $inspector->num_document }}</span>
				<span class="value" style="float: right;">{{ $inspector->name }}</span>
					@if($signInspector->value == 'on' || Auth::user()->role == 'Пользователь')
					<div class="podpis-dir">
						<img src="{{ asset('config_data/signDirector.png') }}" alt="">
					</div>
					@endif
					@if($signDirector->value == 'on' || Auth::user()->role == 'Пользователь')
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
	</div>

@endif
<!--vik end-->

@if(!empty($conclusion->mk_result) && $conclusion->check_mk == 1)
<div class="break_before"></div>
<!--mk start-->
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
			{{ $conclusion->date }}
		</span>
	</div>
	<div class="name-object"><span>Наименование объекта контроля:</span><br><b>{{ $type->name }} {{ $type->description }}</b></div>
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
		@if(!empty($instruments_mk) && count($instruments_mk) > 0)
			<div class="measure_instruments">
				<span>Применяемые средства измерений:</span><br>
				@foreach($instruments_mk as $instrument)
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
		<img src="{{ asset('types_data/'.$type->id.'/mk.jpg') }}" alt="" style="width: 120px; height: 120px;">
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
					@if($signInspector->value == 'on' || Auth::user()->role == 'Пользователь')
					<div class="podpis-dir">
						<img src="{{ asset('config_data/signDirector.png') }}" alt="">
					</div>
					@endif
					@if($signDirector->value == 'on' || Auth::user()->role == 'Пользователь')
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
</div>

@endif
<!--mk end-->


@if(!empty($conclusion->gi_result) && $conclusion->check_gi == 1)
<div class="break_before"></div>
<!--gi start-->

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
		<div class="name-object"><span>Наименование объекта контроля:</span><br><b>{{ $type->name }} {{ $type->description }}</b></div>
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
	<div class="gost"><span>Контроль проводился согласно </span>{{ $gost_gi->value }}</div>
	<div class="conditions_controls">
		<span>Условия контроля: температура окружающей среды: </span>{{ $conclusion->temperature }} °С; <span>температура воды + 10 °С</span>
	</div>
		<br>
		@if(!empty($instruments_gi) && count($instruments_gi) > 0)
			<div class="measure_instruments">
			<span>Применяемые средства измерений:</span><br>
			@foreach($instruments_gi as $instrument)
			@if($instrument->yes_instrument == 1)
				@php($instrument->next_verification_date = implode('.', array_reverse(explode('-', $instrument->next_verification_date))))
				<span>{{ $instrument->name }} № {{ $instrument->sertificate_number }} {{ $instrument->model }} s/n {{ $instrument->serial_number }} дата калибровки до {{ $instrument->next_verification_date }}г.;</span><br>
			@endif
			@endforeach
			</div>
		@endif
		<div class="gi">
			<span><b>Результаты испытания</b></span>
			<br>
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
					@endif
					@if(!empty($type->act_3) || !empty($type->period_3))
					<tr>
						<td>3 этап - P<sub>3</sub>= {{ $type->crimping_3 }} {{ $component->type()->measure }}, время выдержки {{ $type->period_3 }} минут</td>
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
		<!--<div class="gost"><span>Нормативная документация </span>{{ $gost_gi->value }}</div>-->
		<div class="result-control">
			@if($conclusion->gi_result === 'Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность' && file_exists(public_path('types_data/'.$type->id.'/diagram_crimping.jpg')))
				<div><b>Приложение: </b><span>диаграмма гидравлического испытания № {{ $conclusion->id }}</span></div><br>
			@else
				<div><b>Приложение: </b><span>испытания проводились без диаграммы.</span></div><br>
			@endif
			<div><b>Заключение:</b></div>
			<div class="result">
				@if($conclusion->gi_result === 'Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность')
					Объект ({{ $type->name }}, {{ $type->description }}) испытание давлением {{ $component->type()->pressure }} {{ $component->type()->measure }} <b>выдержал</b>
				@else
				Объект ({{ $type->name }}, {{ $type->description }}) испытание давлением {{ $component->type()->pressure }} {{ $component->type()->measure }} <b>не выдержал</b>
				@endif
			</div>
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
					@if($signInspector->value == 'on' || Auth::user()->role == 'Пользователь')
					<div class="podpis-dir">
						<img src="{{ asset('config_data/signDirector.png') }}" alt="">
					</div>
					@endif
					@if($signDirector->value == 'on' || Auth::user()->role == 'Пользователь')
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
	</div>
@if($conclusion->gi_result === 'Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность' && file_exists(public_path('types_data/'.$type->id.'/diagram_crimping.jpg')))
	<div class="breaker"></div>
	<div class="image-object-control">
		<div>Приложение № {{ $conclusion->id }} диаграмма гидравлического испытания</div>
		<img src="{{ asset('types_data/'.$type->id.'/diagram_crimping.jpg') }}" style="width:500px;height:auto;">
	</div>
@endif
<!--gi end-->
	@endif

<!-- preventer start -->
@if($conclusion->gi_result == "Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность" && !empty($conclusion->diameter_plashki))
	<div class="break_before"></div>
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
			<div style="font-size: 22px;"><b>
				АКТ № {{ $conclusion->id }}<br>
				Гидравлических испытаний противовыбросового оборудования</b>
			</div>
		</div>
		<div class="date">От:
			<span>
			@php($conclusion->date = implode('.', array_reverse(explode('-', $conclusion->date))))
				{{ $conclusion->date }}
		</span>
		</div>
		<div class="name-object">
			<span>Мы, нижеподписавшиеся:</span><br>
			<span>Представитель ООО «АльянсЭксперт»:</span> <span style="float: right;"> ______________ / {{ $inspector->name }}</span><br>
		</div>
	<div class="city">
		<span>Ответственный за оборудование</span><br>
		{{ $company->name }} <span style="float: right;">______________ / _____________________________ </span>
	</div>
	<br>
	<div>Составили настоящий акт в том, что на территории заказчика, а именно:<br>
		{{ $company->name }} {{ $component->work_location()->name }} {{ $component->facility()->number }} {{ $component->facility()->gos_number }} {{ $component->facility()->area }}
		,были проведены гидравлические испытания противовыбросового оборудования.
	</div>
	<br>
	@if(!empty($instruments_gi) && count($instruments_gi) > 0)
		<div class="measure_instruments">
			@foreach($instruments_gi as $instrument)
				@if($instrument->yes_instrument == 1)
					@php($instrument->next_verification_date = implode('.', array_reverse(explode('-', $instrument->next_verification_date))))
					<span>{{ $instrument->name }} № {{ $instrument->sertificate_number }} {{ $instrument->model }} s/n {{ $instrument->serial_number }} дата калибровки до {{ $instrument->next_verification_date }};</span><br>
				@endif
			@endforeach
		</div>
	@endif
	<br>
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
				@endif
				@if(!empty($type->act_3) || !empty($type->period_3))
				<tr>
					<td>3 этап - P<sub>3</sub>= {{ $type->crimping_3 }} {{ $component->type()->measure }}, время выдержки {{ $type->period_3 }} минут</td>
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
	<div class="conditions_controls">
		<span>Условия контроля: температура окружающей среды: </span>{{ $conclusion->temperature }} °С; <span>температура воды + 10 °С</span>
	</div>
	<br>
	<div>Корпус превентора: {{ $type->name }}</div>
	<div>Производства: {{ $type->manufacturer }} S/N: {{ $component->serial_number }}</div>
	<div>опрессован на давление {{ $component->type()->pressure }} {{ $component->type()->measure }}</div>
		<!--<div class="gost"><span>Нормативная документация </span>{{ $gost_gi->value }}</div>-->
		<div class="result-control">
			<div class="result">
				Результат испытаний:
				@if($conclusion->gi_result === 'Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность')
					герметично. Диаграмма №: {{ $conclusion->id }}/1
				@else
					не герметично. Диаграмма №: {{ $conclusion->id }}/1
				@endif
			</div>
		</div>
		<br>
	<div>Секция с глухими плашками превентора: {{ $type->name }}</div>
	<div>Производства: {{ $type->manufacturer }} S/N: {{ $component->serial_number }}</div>
	<div>опрессован на давление {{ $component->type()->pressure }} {{ $component->type()->measure }}</div>
		<!--<div class="gost"><span>Нормативная документация </span>{{ $gost_gi->value }}</div>-->
		<div class="result-control">
			<div class="result">
				Результат испытаний:
				@if($conclusion->gi_result === 'Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность')
					герметично. Диаграмма №: {{ $conclusion->id }}/2
				@else
					не герметично. Диаграмма №: {{ $conclusion->id }}/2
				@endif
			</div>
		</div>
		<br>
	<div>Секция с тубными плашками Ø {{ $conclusion->diameter_plashki }} мм. {{ $type->name }}</div>
	<div>Производства: {{ $type->manufacturer }} S/N: {{ $component->serial_number }}</div>
	<div>опрессован на давление {{ $component->type()->pressure }} {{ $component->type()->measure }}</div>
		<!--<div class="gost"><span>Нормативная документация </span>{{ $gost_gi->value }}</div>-->
		<div class="result-control">
			<div class="result">
				Результат испытаний:
				@if($conclusion->gi_result === 'Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность')
					герметично. Диаграмма №: {{ $conclusion->id }}/3
				@else
					не герметично. Диаграмма №: {{ $conclusion->id }}/3
				@endif
			</div>
		</div>
		<div class="executor">
			<div class="datas mb-1">
				<span><b>Исполнитель:</b></span><br>
				<span>специалист {{ $inspector->level }} уровня по {{ $inspector->control_method }}</span><br>
				<span>Удостоверение № {{ $inspector->num_document }}</span>
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
	</div>
	</div>

	@if(file_exists(public_path('conclusions_data/'.$conclusion->id.'/diagramma_crimping_1.jpg')))
	<div class="breaker"></div>
	<div class="image-object-control">
		<div>Диаграмма № {{ $conclusion->id }}/1</div>
		<img src="{{ asset('conclusions_data/'.$conclusion->id.'/diagramma_crimping_1.jpg') }}" alt="" style="height: 100%; width: 100%;">
	</div>
	@endif
	@if(file_exists(public_path('conclusions_data/'.$conclusion->id.'/diagramma_crimping_2.jpg')))
	<div class="breaker"></div>
	<div class="image-object-control">
		<div>Диаграмма № {{ $conclusion->id }}/2</div>
		<img src="{{ asset('conclusions_data/'.$conclusion->id.'/diagramma_crimping_2.jpg') }}" alt="" style="height: 100%; width: 100%;">
	</div>
	@endif
	@if(file_exists(public_path('conclusions_data/'.$conclusion->id.'/diagramma_crimping_3.jpg')))
	<div class="breaker"></div>
	<div class="image-object-control">
		<div>Диаграмма № {{ $conclusion->id }}/3</div>
		<img src="{{ asset('conclusions_data/'.$conclusion->id.'/diagramma_crimping_3.jpg') }}" alt="" style="height: 100%; width: 100%;">
	</div>
	@endif

@endif
<!-- preventer end -->

<!-- тарировка start -->
@if($conclusion->gi_result == "Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность" && !empty($conclusion->calibration_pressure))
	<div class="break_before"></div>
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
		Клапан предохранительный настроен на удержание давления: {{ $conclusion->calibration_pressure }} МПа} 
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
		составило {{ $fixPressure }} МПа, что не превышает 5% от давления настройки и соответствует требованиям {{ $gost_requirement->value }}
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
	@if(!empty($instruments_gi) && count($instruments_gi) > 0)
	<div class="measure_instruments">
		Испытательное оборудование:<br>
		@foreach($instruments_gi as $instrument)
			@if($instrument->yes_instrument == 1)
				@php($instrument->next_verification_date = implode('.', array_reverse(explode('-', $instrument->next_verification_date))))
				<span>{{ $instrument->name }} № {{ $instrument->sertificate_number }} {{ $instrument->model }} s/n {{ $instrument->serial_number }} дата калибровки до {{ $instrument->next_verification_date }}г.;</span><br>
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
	</div>
	@if(file_exists(public_path('conclusions_data/'.$conclusion->id.'/diagramma_calibration.jpg')))
	<div class="breaker"></div>
	<div class="image-object-control">
		<div>Диаграмма № {{ $conclusion->id }}</div>
		<img src="{{ asset('conclusions_data/'.$conclusion->id.'/diagramma_calibration.jpg') }}" alt="" style="height: 100%; width: 100%;">
	</div>
	@endif
@endif
<!-- тарировка end -->

<!-- бгрп start -->
@if($conclusion->gi_result == "Узел (объект) признается выдержавшим гидравлическое испытание на прочность и герметичность" && !empty($conclusion->coefficient))
	<div class="break_before"></div>
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
		Гидравические испытания проводитились следующим оборудованием:<br>
		@if(!empty($instruments) && count($instruments) > 0)
			<div class="measure_instruments">
				@foreach($instruments as $instrument)
					@if($instrument->yes_instrument == 1)
						<span>{{ $instrument->name }} № {{ $instrument->sertificate_number }} дата калибровки до {{ $instrument->next_verification_date }};</span><br>
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
@endif
<!-- бгрп end -->

	<script>
		window.print();
	</script>
</body>
</html>