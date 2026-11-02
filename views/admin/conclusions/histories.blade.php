<div class="modal fade" id="histories" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">История заключения</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th style="width: 100px;">Дата</th>
                        <th>Тип</th>
                        <th>Описание</th>
                        <th>Установка</th>
                        <th>Инспектор</th>
                        <th>Результат</th>
                        @if(Auth::user()->role == 'Администратор' || Auth::user()->role == 'Работник лаборатории')
                            <th>Действия</th>
                            <th>Последний изменивший</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="makesign" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
	<meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Форма подписи</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				<div class="mainContent">
					<div id="left-col">
						<div id="info" style="display:none">
							<div id="info_msg" style="text-align:center;">
								<img id="info_img" src="ex2/ex2_files/application_information.png" alt="">
								<span id="ExtensionEnabledTxt">Расширение загружено</span>
								<img src="ex2/ex2_files/green_dot.png" width="10" height="10" alt="Расширение не загружено" id="ExtensionEnabledImg">
								<br>
								<span id="PlugInEnabledTxt">Плагин загружен</span>
								<img src="ex2/ex2_files/green_dot.png" width="10" height="10" alt="Плагин не загружен" id="PluginEnabledImg">
								<br>
								<span id="CspEnabledTxt">Криптопровайдер загружен</span>
								<img src="ex2/ex2_files/green_dot.png" width="10" height="10" alt="КриптоПро CSP не загружен" id="CspEnabledImg">
								<br>
								<span id="PlugInVersionTxt" lang="ru">Версия плагина: 2.0.14459</span>
								<span id="CSPVersionTxt" lang="ru">Версия криптопровайдера: 5.0.12330</span>
								<br>
								<span id="CSPNameTxt" lang="ru">Криптопровайдер: Crypto-Pro GOST R 34.10-2012 Cryptographic Service Provider</span>
							</div>
							<div id="boxdiv" style="display:none">
								<span id="errorarea">
									У вас отсутствуют личные сертификаты. Вы можете 
									<a href="https://cryptopro.ru/sites/default/files/products/cades/demopage/cades_bes_file.html#" onclick="Common_RetrieveCertificate();" style="color:#0837ff"> получить</a> 
									сертификат от тестового УЦ, предварительно установив 
									<a href="https://testca.cryptopro.ru/certsrv/certnew.cer?ReqID=CACert&amp;Renewal=1&amp;Enc=bin" style="color:#0837ff">корневой сертификат тестового УЦ</a> 
									в доверенные.
								</span>
							</div>
						</div>
						
						<p id="info_msg" name="CertificateTitle">Выберите сертификат:</p>
						<div id="item_border" name="CertListBoxToHide" style="box-shadow: 0px 0px 0px;">
							<select size="3" name="CertListBox" id="CertListBox" style="width:100%;resize:none;border:0;">
							</select>             
						</div>

						<p id="info_msg" name="DataToSign" style="display: none;">Загрузить файл:</p>
						<div id="item_border" name="DataToSignItemBorder" style="display: block;">
							<input id="openFileButton" type="file" name="openFileButton" onchange="openFile(event)" style="width: 100%; box-shadow: 0px 0px 0px;">
							<script>
								var openFile = function (event) {
									fileContent = undefined;
									var input = event.target;
									var reader = new FileReader();
									reader.readAsDataURL(input.files[0]);
									reader.onload = function () {
										var header = ";base64,";
										var fileData = reader.result;
										fileContent = fileData.substr(fileData.indexOf(header) + header.length);
									};
								};
							</script>
						</div>
						<p></p>
						<div>
							<input id="conclusion_id" value="" type="hidden" />
							<input id="SignBtn" type="button" value="Подписать файл" name="SignData" onclick="
											if ('' == openFileButton.value)
												{ alert('Файл не выбран.'); return; }
											else
												if ('' == fileContent || undefined == fileContent)
												{ alert('Выбран пустой файл'); return; }
											else
												Common_SignCadesBES_File('CertListBox')" style="display: block; box-shadow: 0px 0px 0px;">
						</div>

						<!--<div id="cert_info" style="display:none">
							<h2>Информация о сертификате</h2>
								<p class="info_field" id="subject">Владелец: <b><b></b></b></p>
								<p class="info_field" id="issuer">Издатель: <b><b></b></b></p>
								<p class="info_field" id="from">Выдан: <b><b></b></b></p>
								<p class="info_field" id="till">Действителен до: <b><b></b></b></p>
								<p class="info_field" id="provname">Криптопровайдер: <b><b></b></b></p>
								<p class="info_field" id="privateKeyLink">Ссылка на закрытый ключ: <b><b></b></b></p>
								<p class="info_field" id="algorithm">Алгоритм ключа: <b><b></b></b></p>
								<p class="info_field" id="status">Статус: <b> <b></b></b></p>
								<p class="info_field" id="location">Установлен в хранилище: <b></b></p>
						</div>-->
						
						

						<p id="info_msg" name="SignatureTitle" style="display: none;"></p>
						<div id="item_border" name="SignatureTitleItemBorder" style="display: none; box-shadow: 0px 0px 0px;">
							<textarea id="SignatureTxtBox" style="font-size:9pt;height:600px;width:100%;resize:none;border:0;"></textarea>
							
							
							
							
							<script language="javascript">
							
							/* function make_pdf(){
								var hashBASE64 = document.getElementById("SignatureTxtBox").innerHTML;
								var pdf_link = document.getElementById('pdf_link');
								pdf_link.href = 'data:application/pdf;base64,' + hashBASE64; 
							} */
						
							
							
								var txtDataToSign = "Hello World";
								document.getElementById("SignatureTxtBox").innerHTML = "";
								var canPromise = !!window.Promise;
								if (isEdge()) {
									ShowEdgeNotSupported();
								} else {
									if (canPromise) {
										cadesplugin.then(function () {
											Common_CheckForPlugIn();
										},
											function (error) {
												if (window.cadesplugin_extension_loaded) {
													document.getElementById('PluginEnabledImg').setAttribute("src", "Img/red_dot.png");
													document.getElementById('PlugInEnabledTxt').innerHTML = error;
												}
											}
										);
									} else {
										window.addEventListener("message", function (event) {
											if (event.data == "cadesplugin_loaded") {
												CheckForPlugIn_NPAPI();
											} else if (event.data == "cadesplugin_load_error") {
												if (window.cadesplugin_extension_loaded) {
													document.getElementById('PluginEnabledImg').setAttribute("src", "Img/red_dot.png");
													document.getElementById('PlugInEnabledTxt').innerHTML = "Плагин не загружен";
												}
											}
										},
											false);
										window.postMessage("cadesplugin_echo_request", "*");
									}
								}
							</script>
						</div>
						
						
						<p></p>
						<p id="info_msg" name="TimeTitle"></p>
						
						<a id="pdf_link" download href="" style="display:none" title='Download pdf document'>Скачать Подписанный PDF</a><br />
					</div>
<script language="javascript" src="{{ asset('ex2/ex2_files/highlight.js') }}"></script>
				</div>
            </div>
        </div>
    </div>
</div>