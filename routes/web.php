<?php

Auth::routes();

Route::get('/register', 'RegisterController@create')->name('register.create');
Route::post('/register', 'RegisterController@store')->name('register.store');

Route::get('/', 'MainController@index')->name('main.index')->middleware('auth');
// Просроченные заключения на главной
Route::get('main/getConclusions', 'MainController@getConclusions')->name('main.getConclusions')->middleware('auth');

// проверка пользователя на существование
Route::post('/ajax/check_exist_user', 'Admin\UserController@checkExistUser')->name('users.ajax.check_exist_user');
// базы
Route::resource('units', 'Admin\UnitController')->middleware(['auth']);
// компании
Route::resource('companies', 'Admin\CompanyController')->middleware(['auth']);
Route::post('/companies/get_work_locations', 'Admin\CompanyController@get_work_locations')->name('companies.get_work_locations')->middleware(['auth']);
Route::post('/companies/get_facilities', 'Admin\CompanyController@get_facilities')->name('companies.get_facilities')->middleware(['auth']);
// меняем значения мест проведения работ и установок
Route::post('/ajax/companies/setLocation', 'Admin\CompanyController@setLocation')->name('companies.setLocation')->middleware(['auth']);
Route::post('/ajax/companies/setFacility', 'Admin\CompanyController@setFacility')->name('companies.setFacility')->middleware(['auth']);

//удаление места, установки
Route::get('/companies/workLocation/{id}', 'Admin\CompanyController@workLocationDelete')->name('workLocation.delete')->middleware(['auth']);
Route::get('/companies/facilityDelete/{id}', 'Admin\CompanyController@facilityDelete')->name('facilityDelete.delete')->middleware(['auth']);

// пользователи
Route::resource('users', 'Admin\UserController')->middleware(['auth']);
Route::post('/users/get_work_locations', 'Admin\UserController@get_work_locations')->name('users.get_work_locations')->middleware(['auth']);
Route::post('/users/blocking_user', 'Admin\UserController@blocking_user')->name('users.blocking_user')->middleware(['auth']);

// инструменты
Route::resource('instruments', 'Admin\InstrumentController')->middleware(['auth']);
// инспектора
Route::resource('inspectors', 'Admin\InspectorController')->middleware(['auth']);
//Route::post('/inspectors/uploadSignInspector', 'Admin\InspectorController@uploadSignInspector')->name('inspectors.uploadSignInspector')->middleware(['auth']);
//транспорт
Route::resource('transports', 'Admin\TransportController')->middleware(['auth']);
Route::resource('drivers', 'Admin\DriverController')->middleware(['auth']);

/* Путевые листы */
Route::get('waybills', 'Admin\WaybillController@index')->name('waybills.index')->middleware(['auth']);
Route::resource('waybills_legkovoy', 'Admin\WaybillLegkovoyController')->middleware(['auth']);
Route::resource('waybills_cargo', 'Admin\WaybillCargoController')->middleware(['auth']);
//Подгрузка данных водителя
Route::post('/ajax/waybills_legkovoy/get_data_on_driver_id', 'Admin\WaybillLegkovoyController@get_data_on_driver_id')->name('ajax.waybills_legkovoy.get_data_on_driver_id')->middleware('auth');
//Подгрузка данных ТС
Route::post('/ajax/waybills_legkovoy/get_data_on_transport_id', 'Admin\WaybillLegkovoyController@get_data_on_transport_id')->name('ajax.waybills_legkovoy.get_data_on_transport_id')->middleware('auth');
//Подгрузка данных водителя
Route::post('/ajax/waybills_cargo/get_data_on_driver_id', 'Admin\WaybillCargoController@get_data_on_driver_id')->name('ajax.waybills_cargo.get_data_on_driver_id')->middleware('auth');
//Подгрузка данных ТС
Route::post('/ajax/waybills_cargo/get_data_on_transport_id', 'Admin\WaybillCargoController@get_data_on_transport_id')->name('ajax.waybills_cargo.get_data_on_transport_id')->middleware('auth');
// Печатная форма путевого листа для легкового ТС
Route::get('/print_waybill/{id}/legkovoy', 'Admin\PrintWaybillsController@legkovoy')->name('print_waybills.legkovoy')->middleware(['auth']);
// Печатная форма путевого листа для грузового ТС
Route::get('/print_waybill/{id}/cargo', 'Admin\PrintWaybillsController@cargo')->name('print_waybills.cargo')->middleware(['auth']);

// типы
Route::resource('types', 'Admin\TypeController')->middleware(['auth']);
Route::post('/types/deleteImgType', 'Admin\TypeController@deleteImgType')->name('types.deleteImgType')->middleware(['auth']);

// компоненты
Route::resource('components', 'Admin\ComponentController')->middleware(['auth']);
Route::post('/components/check_tape_number_exists', 'Admin\ComponentController@check_tape_number_exists')->name('components.check_tape_number_exists')->middleware(['auth']);
Route::post('/components/histories', 'Admin\ComponentController@histories')->name('components.histories')->middleware(['auth']);
// заключения
Route::resource('conclusions', 'Admin\ConclusionController')->middleware(['auth']);
Route::get('conclusions/create/{tape_number}', 'Admin\ConclusionController@create')->name('conclusions.create.tape_number')->middleware(['auth']);
// поиск заключений. Применение фильтров
Route::post('/conclusions/accept_filters', 'Admin\ConclusionController@accept_filters')->name('conclusions.accept_filters')->middleware('auth');
// поиск заключений. Сброс фильтров
Route::post('/conclusions/reset_filters', 'Admin\ConclusionController@reset_filters')->name('conclusions.reset_filters')->middleware('auth');
// Показать все заключения
Route::post('/conclusions/show_all', 'Admin\ConclusionController@show_all')->name('conclusions.show_all')->middleware('auth');
// создание архива
Route::post('conclusions/zip', 'Admin\ConclusionController@zipArchiveFile')->name('conclusions.zip')->middleware(['auth']);
Route::post('conclusions/zipNotSign', 'Admin\ConclusionController@zipArchiveNotSignFile')->name('conclusions.zipNotSign')->middleware(['auth']);

// параметры
Route::resource('configs', 'Admin\ConfigController')->middleware(['auth']);
// смена значения ЭЦП (при печати заключений)
Route::post('/configs/stamp_change', 'Admin\ConfigController@stamp_change')->name('configs.stamp_change')->middleware(['auth']);
Route::post('/configs/signDirector_change', 'Admin\ConfigController@signDirector_change')->name('configs.signDirector_change')->middleware(['auth']);
Route::post('/configs/signInspector_change', 'Admin\ConfigController@signInspector_change')->name('configs.signInspector_change')->middleware(['auth']);
Route::post('/configs/ecpPrint_change', 'Admin\ConfigController@ecpPrint_change')->name('configs.ecpPrint_change')->middleware(['auth']);
Route::post('/configs/uploadSignDiretor', 'Admin\ConfigController@uploadSignDiretor')->name('configs.uploadSignDiretor')->middleware(['auth']);
Route::post('/configs/uploadStamp', 'Admin\ConfigController@uploadStamp')->name('configs.uploadStamp')->middleware(['auth']);
Route::post('/configs/uploadEcpPrint', 'Admin\ConfigController@uploadEcpPrint')->name('configs.uploadEcpPrint')->middleware(['auth']);

// заключения. Подгрузка данных по номеру ленты
Route::post('/ajax/conclusions/get_data_on_type_number', 'Admin\ConclusionController@get_data_on_type_number')->name('ajax.conclusions.get_data_on_type_number')->middleware('auth');
// компоненты. Подгрузка информации при выборе типа
Route::post('/ajax/components/get_data_on_type', 'Admin\ComponentController@get_type')->name('ajax.components.get_type')->middleware('auth');

// поиск компонентов. Применение фильтров
Route::post('/components/accept_filters', 'Admin\ComponentController@accept_filters')->name('components.accept_filters')->middleware('auth');
// поиск компонентов. Сброс фильтров
Route::post('/components/reset_filters', 'Admin\ComponentController@reset_filters')->name('components.reset_filters')->middleware('auth');
// Показать все компонеты
Route::post('/components/show_all', 'Admin\ComponentController@show_all')->name('components.show_all')->middleware('auth');

// поиск компонетов. Подгрузка списка дат
Route::post('/components/get_info_for_filters', 'Admin\ComponentController@get_info_for_filters')->name('components.get_info_for_filters')->middleware('auth');

// поиск заключений. Подгрузка списка дат
Route::post('/conclusions/get_info_for_filters', 'Admin\ConclusionController@get_info_for_filters')->name('conclusions.get_info_for_filters')->middleware('auth');
// печать лент
Route::get('/conclusions/all/print_lengths', 'Admin\ConclusionController@print_lengths')->name('conclusions.print_lengths')->middleware(['auth']);
// печать ленты
Route::get('/conclusions/{conclusion_id}/print_length', 'Admin\ConclusionController@print_length')->name('conclusions.print_length')->middleware(['auth']);
// получение последнего заключения по номеру ленты
Route::post('/conclusions/get_last_conclusion_on_tape_number', 'Admin\ConclusionController@get_last_conclusion_on_tape_number')->name('conclusions.get_last_conclusion_on_tape_number')->middleware(['auth']);
Route::post('/conclusions/get_conclusion_on_tape_number_and_date', 'Admin\ConclusionController@get_conclusion_on_tape_number_and_date')->name('conclusions.get_conclusion_on_tape_number_and_date')->middleware(['auth']);

// история заключения
Route::post('/conclusions/histories', 'Admin\ConclusionController@histories')->name('conclusions.histories')->middleware(['auth']);
//записать в бд подписанный файл
Route::post('/conclusions/signToDB', 'Admin\ConclusionController@signToDB')->name('conclusions.signToDB')->middleware(['auth']);
// графики
Route::post('/main/chartCreate', 'MainController@chartCreate')->name('main.chartCreate')->middleware('auth');
Route::post('/main/chartCreateAct', 'MainController@chartCreateAct')->name('main.chartCreateAct')->middleware('auth');

// заявки
Route::resource('orders', 'OrderController')->middleware(['auth']);
// заявки. Прикрепление архива
Route::post('orders/{id}/archive', 'OrderController@archive')->name('admin.orders.archive')->middleware(['auth']);
// сохранение заключений в заявку
Route::post('/conclusion_orders/save', 'Admin\ConclusionController@save_orders')->name('conclusions.save_orders')->middleware(['auth']);
// список заключений в заявке
Route::get('/orders/{order_id}/list_conclusions', 'OrderController@list_conclusions')->name('orders.list_conclusions')->middleware(['auth']);
// обновление статуса и комментария заявки
Route::post('/ajax/orders/update_info', 'OrderController@update_info')->name('orders.update_info')->middleware(['auth']);
// страницы
Route::get('/admin/pages', 'Admin\PageController@index')->name('admin.pages')->middleware(['auth']);
Route::get('/admin/pages/{id}/edit', 'Admin\PageController@edit')->name('admin.pages.edit')->middleware(['auth']);
Route::put('/admin/pages/{id}/update', 'Admin\PageController@update')->name('admin.pages.update')->middleware(['auth']);
// инструкции
Route::get('/admin/instructions', 'Admin\InstructionController@index')->name('admin.instructions')->middleware(['auth']);
Route::get('/admin/instructions/create', 'Admin\InstructionController@create')->name('admin.instructions.create')->middleware(['auth']);
Route::post('/admin/instructions/store', 'Admin\InstructionController@store')->name('admin.instructions.store')->middleware(['auth']);
Route::get('/admin/instructions/{id}/edit', 'Admin\InstructionController@edit')->name('admin.instructions.edit')->middleware(['auth']);
Route::put('/admin/instructions/{id}/update', 'Admin\InstructionController@update')->name('admin.instructions.update')->middleware(['auth']);
Route::delete('/admin/instructions/{id}/destroy', 'Admin\InstructionController@destroy')->name('admin.instructions.destroy')->middleware(['auth']);

// акты
Route::get('/acts', 'Admin\ActController@index')->name('acts.index')->middleware(['auth']);
Route::post('/acts/accept_filters', 'Admin\ActController@accept_filters')->name('acts.accept_filters')->middleware(['auth']);
Route::get('/acts/{act_id}/show', 'Admin\ActController@show_act')->name('acts.show')->middleware(['auth']);
Route::get('/act/{id}/delete', 'Admin\ActController@deleteAct')->name('act.deleteAct')->middleware(['auth']);
Route::post('/acts/signChange', 'Admin\ActController@signChange')->name('act.signChange')->middleware('auth');
Route::post('/acts/stampChange', 'Admin\ActController@stampChange')->name('act.stampChange')->middleware('auth');

// инвентаризация
Route::post('/acts/get_facilities', 'Admin\ActController@get_facilities')->name('acts.get_facilities')->middleware(['auth']);
Route::post('/acts/get_work_locations', 'Admin\ActController@get_work_locations')->name('acts.get_work_locations')->middleware(['auth']);
Route::post('/acts/get_dates', 'Admin\ActController@get_dates')->name('acts.get_dates')->middleware(['auth']);
Route::get('/admin/inventarization', 'Admin\InventarizationController@index')->name('admin.inventarization');
Route::post('/admin/inventarization/accept_filters', 'Admin\InventarizationController@accept_filters')->name('admin.inventarization.accept_filters');
Route::post('/admin/inventarization/reset_filters', 'Admin\InventarizationController@reset_filters')->name('admin.inventarization.reset_filters');
Route::get('/admin/inventarization/export_xlsx', 'Admin\InventarizationController@export_xlsx')->name('admin.inventarization.export_xlsx');
// оповещения
Route::get('/alarms', 'AlarmController@index')->name('alarms.index')->middleware(['auth']);
// меняет все на прочитанные
Route::get('/alarms/changeReading', 'AlarmController@changeReading')->name('alarms.changeReading')->middleware(['auth']);
// подгрузка оповещения
Route::post('/alarms/show', 'AlarmController@show')->name('alarms.show')->middleware(['auth']);
Route::get('/mail/alarmInstrument', 'MailSendTestController@send')->name('mail.alarmInstrument');
Route::get('/mail/alarmConclusionInspectors', 'MailSendTestControllerConclusion@send')->name('mail.alarmConclusionInspectors');

// новости
Route::resource('news', 'Admin\NewsController')->middleware(['auth']);

//pdf
Route::get('invoices/download', 'InvoiceController@download');
Route::get('/report/{id}/pdf', 'Admin\ReportpdfController@report_pdf')->name('reports.pdf')->middleware(['auth']);
Route::get('/report/{id}/download_pdf', 'Admin\ReportpdfController@download_pdf')->name('reports.download_pdf')->middleware(['auth']);

/*
 * Отчёты
 */
// мк
Route::get('/report/{id}/mk', 'Admin\ReportController@mk')->name('reports.mk')->middleware(['auth']);
// узт
Route::get('/report/{id}/uzt', 'Admin\ReportController@uzt')->name('reports.uzt')->middleware(['auth']);
// узк
Route::get('/report/{id}/uzk', 'Admin\ReportController@uzk')->name('reports.uzk')->middleware(['auth']);
// вик
Route::get('/report/{id}/vik', 'Admin\ReportController@vik')->name('reports.vik')->middleware(['auth']);
// ги
Route::get('/report/{id}/gi', 'Admin\ReportController@gi')->name('reports.gi')->middleware(['auth']);
Route::get('/report/{id}/preventer', 'Admin\ReportController@preventer')->name('reports.preventer')->middleware(['auth']);
Route::get('/report/{id}/calibration', 'Admin\ReportController@calibration')->name('reports.calibration')->middleware(['auth']);
Route::get('/report/{id}/bgrp', 'Admin\ReportController@bgrp')->name('reports.bgrp')->middleware(['auth']);
// пасспорт
Route::get('/report/{id}/passport', 'Admin\ReportController@passport')->name('reports.passport')->middleware(['auth']);
// все формы
Route::get('/report/{id}/passport_uzt_vik_mk_gi', 'Admin\ReportController@passport_uzt_vik_mk_gi')->name('reports.passport_uzt_vik_mk_gi')->middleware(['auth']);
// пдф
Route::get('/report/{id}/passport_uzt_vik_mk_gi_pdf', 'Admin\ReportController@passport_uzt_vik_mk_gi_pdf')->name('reports.passport_uzt_vik_mk_gi_pdf')->middleware(['auth']);
// ecp
Route::get('/report/{id}/passport_uzt_vik_mk_gi_pdf_ecp', 'Admin\ReportController@passport_uzt_vik_mk_gi_pdf_ecp')->name('reports.passport_uzt_vik_mk_gi_pdf_ecp')->middleware(['auth']);

/*
 * Общие отчёты
 */
// мк
Route::get('/general_report/mk', 'Admin\ReportController@general_mk')->name('reports.general.mk')->middleware(['auth']);
// узт
Route::get('/general_report/uzt', 'Admin\ReportController@general_uzt')->name('reports.general.uzt')->middleware(['auth']);
// вик
Route::get('/general_report/vik', 'Admin\ReportController@general_vik')->name('reports.general.vik')->middleware(['auth']);
// ги
Route::get('/general_report/gi', 'Admin\ReportController@general_gi')->name('reports.general.gi')->middleware(['auth']);
// пасспорт
Route::get('/general_report/passport', 'Admin\ReportController@general_passport')->name('reports.general.passport')->middleware(['auth']);
// отчёт в excel
Route::get('/general_report/excel', 'Admin\ReportController@general_excel')->name('reports.general.excel')->middleware(['auth']);
// общий отчёт
Route::get('/general_report/all', 'Admin\ReportController@general_all')->name('reports.general.all')->middleware(['auth']);


// просмотр страницы
Route::get('/pages/{id}/show', 'PageController@show')->name('pages.show')->middleware(['auth']);


/*
 * CRON обработка
 */
// запуск проверки оповещений
Route::get('/cron/alarm_processing', 'CronController@alarm_processing')->name('cron.alarm_processing');
// проверка срока действия документов у инспекторов
Route::get('/cron/check_document_validity_to_inspectors', 'CronController@check_document_validity_to_inspectors')->name('cron.check_document_validity_to_inspectors');
// проверка поверки интрументов (если до поверки < месяца - создаёт оповещение)
Route::get('/cron/check_instrument_date_verify_on_month', 'CronController@check_instrument_date_verify_on_month')->name('cron.check_instrument_date_verify_on_month');


use App\Http\Controllers\PDFController;
Route::get('pdf/generate/{id}', 'PDFController@generatePDFmk')->name('pdf.generate')->middleware(['auth']);


// qr
Route::resource('qrs', 'Admin\QrConclusionsController')->middleware(['auth']);
// Подгрузка данных по номеру ленты
Route::post('/ajax/qrs/get_data_on_type_number', 'Admin\QrConclusionsController@get_data_on_type_number')->name('ajax.qrs.get_data_on_type_number')->middleware('auth');
Route::post('/ajax/qrs/get_type_number', 'Admin\QrConclusionsController@get_type_number')->name('ajax.qrs.get_type_number')->middleware('auth');

Route::post('qrs/editQr', 'Admin\QrConclusionsController@editQr')->name('qrs.editQr')->middleware('auth');
Route::post('qrs/updateQr', 'Admin\QrConclusionsController@updateQr')->name('qrs.updateQr')->middleware('auth');
Route::post('qrs/checkComponentId', 'Admin\QrConclusionsController@checkComponentId')->name('qrs.checkComponentId')->middleware('auth');
Route::post('qrs/activeChange', 'Admin\QrConclusionsController@activeChange')->name('qrs.activeChange')->middleware('auth');
