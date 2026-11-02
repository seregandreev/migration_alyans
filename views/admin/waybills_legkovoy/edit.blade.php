@extends('layouts.template')
@section('title', 'Редактирование путевого листа легкового авто')

@section('header')

@endsection

@section('content')

    <div class="row justify-content-center">
         <div class="col-md-10 col-12">
            <div class="card">
                <div class="card-header first"><h3>Редактирование путевого листа легкового автомобиля</h3> <a class="card-header-link" href="{{ route('waybills.index') }}"><i class="fa fa-mail-reply-all" aria-hidden="true"></i>  Вернуться к списку путевых листов</a> </div>
                <div class="card-body">
                    <form action="{{ route('waybills_legkovoy.update', $waybill->id) }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                      <div class="list card-header mb-3 pt-3 pb-3">
                        <div class="row">
                            <div class="col-md-3 col-12">
                                
                                {{-- Серия --}}
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Серия</h4>
                                <input type="text" class="form-control" name="series" value="АЭ" required>
                                <input type="text" name="type_waybill" hidden value="Легковой">
                            </div>
                            <div class="col-md-3 col-12">
                                {{-- номер --}}
                                <h4 class="card-title"><span style="color: #ff0000;">*</span>Номер</h4>
                                <input type="text" class="form-control" name="number" value="{{ $number }}" required>
                            </div>
                            <div class="col-md-3 col-12"> 
                                 {{-- Срок действия --}}
                                  <h4 class="card-title">Срок действия, от</h4>
                                  <input type="date" class="form-control" name="date_from" value="{{ $waybill->date_from }}">
                           </div>
                           <div class="col-md-3 col-12"> 
                                 {{-- Срок действия --}}
                                  <h4 class="card-title">Срок действия, до</h4>
                                  <input type="date" class="form-control" name="date_to" value="{{ $waybill->date_to }}">
                           </div>
                        </div>
                    </div>
                    <div class="list card-header mb-3 pt-3 pb-3">
                        <div class="row"> 
                            <div class="col-md-12 col-12">
                                {{-- Выбор водителя --}}
                                <select name="driver_id" id="driver_id" class="form-control">
                                    <option value="" selected disabled>-- Выберите водителя --</option>
                                    @if(count($drivers) > 0)
                                        @foreach($drivers as $driver)
                                            <option value="{{ $driver->id }}" @if($driver->id == $waybill->driver_id) selected @endif>{{ $driver->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-4 col-12 mt-2"> 
                                 {{-- Табельный номер --}}
                                  <h4 class="card-title">Табельный номер</h4>
                                  <input type="text" class="form-control" name="pers_number" id="pers_number" value="{{ $driver->pers_number }}">
                           </div>
                           <div class="col-md-4 col-12 mt-2"> 
                                 {{-- Удостоверение № --}}
                                  <h4 class="card-title">Удостоверение №</h4>
                                  <input type="text" class="form-control" name="num_vu" id="num_vu" value="{{ $driver->num_vu }}">
                           </div>
                           <div class="col-md-4 col-12 mt-2"> 
                                 {{-- Класс ВУ --}}
                                  <h4 class="card-title">Класс ВУ</h4>
                                  <input type="text" class="form-control" name="class_vu" id="class_vu" value="{{ $driver->class_vu }}">
                           </div>
                        </div>
                    </div>
                    <div class="list card-header mb-3 pt-3 pb-3">
                        <div class="row"> 
                            <div class="col-md-6 col-12">
                                {{-- Выбор автомобиля --}}
                                <h4 class="card-title">&nbsp</h4>
                                <select name="transport_id" id="transport_id" class="form-control">
                                    <option value="" selected disabled>-- Выберите автомобиль --</option>
                                    @if(count($transports) > 0)
                                        @foreach($transports as $transport)
                                            <option value="{{ $transport->id }}" @if($transport->id == $waybill->transport_id) selected @endif>{{ $transport->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3 col-12"> 
                                 {{-- Государственный номерной знак --}}
                                  <h4 class="card-title">Гос. номер</h4>
                                  <input type="text" class="form-control" name="gos_num" id="gos_num" value="{{ $transport->gos_num }}">
                           </div>
                           <div class="col-md-3 col-12"> 
                                 {{-- Номер парковки --}}
                                  <h4 class="card-title">Номер парковки</h4>
                                  <input type="text" class="form-control" name="parking_number" id="parking_number" value="{{ $transport->garage_number }}">
                           </div>
                        </div>
                    </div>
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">
                        <label>
                            Предрейсовый медицинский осмотр
                        </label>
                    </legend>
                <div class="list card-header mb-3 pt-3 pb-3">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            {{-- Выбор мед. работника --}}
                            <h4 class="card-title">ФИО мед. работника</h4>
                            <input name="doctor_name_before" id="doctor_name_before" class="form-control" value="{{ $waybill->doctor_name_before }}">
                        </div>
                        <div class="col-md-3 col-12"> 
                            {{-- Дата --}}
                            <h4 class="card-title">Дата</h4>
                            <input type="date" class="form-control" name="date_medical_check_before" value="{{ $waybill->date_medical_check_before }}">
                        </div>
                        <div class="col-md-3 col-12"> 
                            {{-- Время --}}
                            <h4 class="card-title">Время</h4>
                            <input type="time" class="form-control" name="time_medical_check_before" value="{{ $waybill->time_medical_check_before }}">
                        </div>
                        <div class="col-md-12 col-12">
                            {{-- Выбор заключения мед. работника --}}
                            <h4 class="card-title">Заключение мед. работника</h4>
                            <select name="medical_check_before" id="medical_check_before" class="form-control">
                                <option value="" selected disabled>-- Выберите вариант --</option>
                                <option value="прошел предрейсовый медицинский осмотр, к исполнению трудовых обязанностей допущен" @if($waybill->medical_check_before == "прошел предрейсовый медицинский осмотр, к исполнению трудовых обязанностей допущен") selected @endif>прошел предрейсовый медицинский осмотр, к исполнению трудовых обязанностей допущен</option>
                                <option value="не прошел предрейсовый медицинский осмотр, к исполнению трудовых обязанностей не допущен" @if($waybill->medical_check_before == "не прошел предрейсовый медицинский осмотр, к исполнению трудовых обязанностей не допущен") selected @endif>не прошел предрейсовый медицинский осмотр, к исполнению трудовых обязанностей не допущен</option>
                            </select>
                        </div>
                    </div>
                </div>
                </fieldset>
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">
                        <label>
                            Послерейсовый медицинский осмотр
                        </label>
                    </legend>
                <div class="list card-header mb-3 pt-3 pb-3">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            {{-- Выбор мед. работника --}}
                            <h4 class="card-title">ФИО мед. работника</h4>
                            <input name="doctor_name_after" id="doctor_name_after" class="form-control" value="{{ $waybill->doctor_name_after }}">                      
                        </div>
                        <div class="col-md-3 col-12"> 
                            {{-- Дата --}}
                            <h4 class="card-title">Дата</h4>
                            <input type="date" class="form-control" name="date_medical_check_after" value="{{ $waybill->date_medical_check_after }}">
                        </div>
                        <div class="col-md-3 col-12"> 
                            {{-- Время --}}
                            <h4 class="card-title">Время</h4>
                            <input type="time" class="form-control" name="time_medical_check_after" value="{{ $waybill->time_medical_check_after }}">
                        </div>
                        <div class="col-md-12 col-12">
                            {{-- Выбор заключения мед. работника --}}
                            <h4 class="card-title">Заключение мед. работника</h4>
                            <select name="medical_check_after" id="medical_check_after" class="form-control">
                                <option value="" selected disabled>-- Выберите вариант --</option>
                                <option value="прошел послерейсовый медицинский осмотр" @if($waybill->medical_check_after == "прошел послерейсовый медицинский осмотр") selected @endif>прошел послерейсовый медицинский осмотр</option>
                                <option value="не прошел послерейсовый медицинский осмотр" @if($waybill->medical_check_after == "не прошел послерейсовый медицинский осмотр") selected @endif>не прошел послерейсовый медицинский осмотр</option>
                            </select>
                        </div>
                    </div>
                </div>
                </fieldset>
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">
                        <label>
                            Предрейсовый (предсменный) контроль
                        </label>
                    </legend>
                <div class="list card-header mb-3 pt-3 pb-3">
                        <div class="row"> 
                            <div class="col-md-6 col-12 mt-2">
                                {{-- Механик --}}
                                <h4 class="card-title">Механик, ФИО</h4>
                                <select name="mechanic_id" id="mechanic_id" class="form-control">
                                    <option value="" selected disabled>-- Выберите механика --</option>
                                    @foreach($userMechanics as $mechanic)
                                        <option value="{{ $mechanic->id }}" @if($mechanic->id == $waybill->mechanic_id) selected @endif>{{ $mechanic->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-12"> 
                                {{-- Дата --}}
                                <h4 class="card-title">Дата</h4>
                                <input type="date" class="form-control" name="date_transport_check_before" value="{{ $waybill->date_transport_check_before }}">
                            </div>
                            <div class="col-md-3 col-12"> 
                                {{-- Время --}}
                                <h4 class="card-title">Время</h4>
                                <input type="time" class="form-control" name="time_transport_check_before" value="{{ $waybill->time_transport_check_before }}">
                            </div>
                            <div class="col-md-12 col-12 mt-2">
                                {{-- Выбор заключения контрллера ТС --}}
                                <h4 class="card-title">Заключение механика ТС</h4>
                                <select name="transport_check_before" id="transport_check_before" class="form-control">
                                    <option value="" selected disabled>-- Выберите вариант --</option>
                                    <option value="Выпуск на линию разрешен" @if($waybill->transport_check_before == "Выпуск на линию разрешен") selected @endif>Выпуск на линию разрешен</option>
                                    <option value="Выпуск на линию не разрешен" @if($waybill->transport_check_before == "Выпуск на линию не разрешен") selected @endif>Выпуск на линию не разрешен</option>
                                </select>
                        </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">
                        <label>
                            Движение горючего
                        </label>
                    </legend>
                <div class="list card-header mb-3 pt-3 pb-3">
                        <div class="row"> 
                            <div class="col-md-4 col-12">
                                {{-- Показания одометра, до --}}
                                  <h4 class="card-title">Показания одометра, км. до</h4>
                                  <input type="text" class="form-control" name="transport_meliage_before" id="transport_meliage_before" value="{{ $waybill->transport_meliage_before }}">
                            </div>
                            <div class="col-md-4 col-12">
                                {{-- Показания одометра, после --}}
                                  <h4 class="card-title">Показания одометра, км. после</h4>
                                  <input type="text" class="form-control" name="transport_meliage_after" value="{{ $waybill->transport_meliage_after }}">
                            </div>
                            <div class="col-md-4 col-12">
                                {{-- Марка горючего --}}
                                  <h4 class="card-title">Марка горючего</h4>
                                  <input type="text" class="form-control" name="type_sulder" id="type_sulder" value="{{ $transport->type_sulder }}">
                            </div>
                            <div class="col-md-3 col-12 mt-2">
                                {{-- Выдано --}}
                                  <h4 class="card-title">Выдано, л</h4>
                                  <input type="text" class="form-control" name="sulder_issued" value="{{ $waybill->sulder_issued }}">
                            </div>
                            <div class="col-md-3 col-12 mt-2">
                                {{-- При выезде --}}
                                  <h4 class="card-title">При выезде, л</h4>
                                  <input type="text" class="form-control" name="sulder_departure" value="{{ $waybill->sulder_departure }}">
                            </div>
                            <div class="col-md-3 col-12 mt-2">
                                {{-- При возвращении --}}
                                  <h4 class="card-title">При возвращении, л</h4>
                                  <input type="text" class="form-control" name="sulder_return" value="{{ $waybill->sulder_return }}">
                            </div>
                            <div class="col-md-3 col-12 mt-2">
                                {{-- Расход по норме --}}
                                  <h4 class="card-title">Расход по норме, л</h4>
                                  <input type="text" class="form-control" id='expense_sulder_norm' name="expense_sulder_norm" value="{{ $waybill->expense_sulder_norm }}">
                            </div>
                            <div class="col-md-3 col-12 mt-2">
                                {{-- Расход факт --}}
                                  <h4 class="card-title">Расход факт, л</h4>
                                  <input type="text" class="form-control" id='expense_sulder_fact' name="expense_sulder_fact" value="{{ $waybill->expense_sulder_fact }}">
                            </div>
                            <div class="col-md-2 col-12 mt-2">
                                {{-- Эканомия --}}
                                  <h4 class="card-title">Эканомия, л</h4>
                                  <input type="text" class="form-control" name="economy_sulder" value="{{ $waybill->economy_sulder}}">
                            </div>
                            <div class="col-md-2 col-12 mt-2">
                                {{-- Перерасход --}}
                                  <h4 class="card-title">Перерасход, л</h4>
                                  <input type="text" class="form-control" name="overspending" value="{{ $waybill->overspending }}">
                            </div>
                           {{-- <div class="col-md-2 col-12 mt-2">
                                 Перерасход 
                                  <h4 class="card-title">&nbsp</h4>
                                  <a href="#" name="expenseSulder" onClick="expenseSulder();">Вычислить</a>
                            </div>--}}
                        </div>
                    </div>
                </fieldset>
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">
                        <label>
                            Задание водителю
                        </label>
                    </legend>
                <div class="list card-header mb-3 pt-3 pb-3">
                            <div class="row"> 
                                <div class="col-md-12 col-12">
                                    {{-- В распоряжение --}}
                                      <h4 class="card-title">В распоряжение(наименование организации)</h4>
                                      <input type="text" class="form-control" name="disposition_organization_name" value="ООО &#171АльянсЭксперт&#187 Губкина 35с1, Мегион, Россия">
                                </div>
                                <div class="col-md-12 col-12 mt-2">
                                    {{-- Адрес подачи --}}
                                      <h4 class="card-title">Адрес подачи</h4>
                                      <input type="text" class="form-control" name="address_departure" value="{{ $waybill->address_departure }}">
                                </div>
                                <div class="col-md-3 col-12 mt-2">
                                    {{-- Дата выезда с парковки --}}
                                      <h4 class="card-title">Дата выезда с парковки</h4>
                                      <input type="date" class="form-control" name="date_transport_departure" value="{{ $waybill->date_transport_departure }}">
                                </div>
                                <div class="col-md-3 col-12 mt-2">
                                    {{-- Время выезда с парковки, ч. мин. --}}
                                      <h4 class="card-title">Время выезда с парковки, ч. мин.</h4>
                                      <input type="time" class="form-control" name="time_transport_departure" value="{{ $waybill->time_transport_departure }}">
                                </div>
                                <div class="col-md-3 col-12 mt-2">
                                    {{-- Дата возвращения на парковку --}}
                                      <h4 class="card-title">Дата возвращения на парковку</h4>
                                      <input type="date" class="form-control" name="date_transport_return" value="{{ $waybill->date_transport_return }}">
                                </div>
                                <div class="col-md-3 col-12 mt-2">
                                    {{-- Время возвращения на парковку, ч. мин. --}}
                                      <h4 class="card-title">Время возвращения на парковку, ч. мин.</h4>
                                      <input type="time" class="form-control" name="time_transport_return" value="{{ $waybill->time_transport_return }}">
                                </div>
                                <div class="col-md-12 col-12 mt-2">
                                    {{-- Прочие отметки --}}
                                      <h4 class="card-title">Прочие отметки(Опоздания, ожидания, простои в пути, заезды на парковку)</h4>
                                      <textarea type="text" class="form-control" name="other_marks" value="{{ $waybill->other_marks }}"></textarea>
                                </div>
                                <div class="col-md-6 col-12 mt-2">
                                    {{-- Диспетчер-нарядчик --}}
                                      <h4 class="card-title">Диспетчер-нарядчик</h4>
                                      <select name="dispetcher_id" id="dispetcher_id" class="form-control">
                                        <option value="" selected disabled>-- Выберите диспетчера --</option>
                                        @if(count($userDispetchers) > 0)
                                            @foreach($userDispetchers as $dispetcher)
                                                <option value="{{ $dispetcher->id }}" @if($dispetcher->id == $waybill->dispetcher_id) selected @endif>{{ $dispetcher->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                 <div class="row mt-3"> 
                        <div class="col-md-2 offset-md-10 col-12 mb-5"> 
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                 </div>
            </form>
                </div>
                </div>
            </div>
        </div>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script>

        {{-- Подгрузка данных по водителю --}}
        $('#driver_id').change(function() {
            var current_obj = $(this);
            var driver_id = current_obj.val();
            if(current_obj.val() !== '')
                {
                    var token = $('input[name="_token"]').val();
                    $.post('{{ route('ajax.waybills_legkovoy.get_data_on_driver_id') }}', {'_token': token, 'driver_id': driver_id}, 
                    function(data) {
                            current_obj.css('border', '1px solid green');
                            $('#pers_number').val(data['driver'].pers_number);
                            $('#num_vu').val(data['driver'].num_vu);
                            $('#class_vu').val(data['driver'].class_vu);
                    });
                }
        });

        {{-- Подгрузка данных по ТС --}}
        $('#transport_id').change(function() {
            var current_obj = $(this);
            var transport_id = current_obj.val();
            if(current_obj.val() !== '')
                {
                    var token = $('input[name="_token"]').val();
                    $.post('{{ route('ajax.waybills_legkovoy.get_data_on_transport_id') }}', {'_token': token, 'transport_id': transport_id}, function(data) {
                            current_obj.css('border', '1px solid green');
                            $('#gos_num').val(data['transport'].gos_num);
                            $('#parking_number').val(data['transport'].garage_number);
                            $('#transport_meliage_before').val(data['transport'].mileage);
                            $('#type_sulder').val(data['transport'].type_sulder);
                    });
                }
        });

        {{-- Изменение фактического расхода --}}
        function expenseSulder() {
            var sulderNorm = Number($('#expense_sulder_norm').val());
            //var sulderFact = $('#expense_sulder_fact').val();
            var sulderIssued = Number($('#sulder_issued').val());
            var sulderDeparture = Number($('#sulder_departure').val());
            var sulderReturn = Number($('#sulder_return').val());
            var overspending;
            var economySulder;
            var sulderFact;
            sulderFact = Number((sulderIssued + sulderDeparture) - sulderReturn);
            //$('#expense_sulder_fact').val() = sulderFact;

            if(sulderNorm > sulderFact) {
                economySulder = sulderNorm - sulderFact;
                overspending = null;
            }
            else if (sulderNorm < sulderFact) {
                overspending = sulderFact - sulderNorm;
                economySulder = null;
            }
            //$('#overspending').val() = overspending;
            //$('#economy_sulder').val() = economySulder;
            console.log(sulderNorm, sulderIssued, sulderDeparture);
        }
    </script>
@endsection