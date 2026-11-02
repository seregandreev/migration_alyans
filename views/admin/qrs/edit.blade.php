<!-- Модальное окно -->
<div class="modal fade" id="qrEditModel" tabindex="-1" aria-labelledby="qrEditModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="qrEditModalLabel">Редактирование записи</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <form action="{{ route('qrs.updateQr') }}" method="POST">
        <div class="modal-body">
            @csrf
            <div class="row">
                <div class="col-12 mb-2 tape-number-edit was-validated">
                    <label for="tape_number_edit" class="form-label">Номер ленты</label>
                    <input class="form-control" type="text" name="tape_number_edit" id="tape_number_edit" required>
                    <div id="search_tape_number_edit-result"></div>
                    <div class="invalid-feedback">Заполниете номер ленты </div>
                </div>
                <div class="col-12 mb-2 alert alert-danger yes-qr-in-db-edit" role="alert">
                  <i class="bi bi-exclamation-triangle"></i>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="col-12 mb-2">
                    <label for="company_id_edit" class="form-label">Компания</label>
                    <select class="form-control" name="company_id_edit" id="company_id_edit" disabled>
                    </select>
                </div>
                <div class="col-12 mb-2">
                    <label for="work_location_id_edit" class="form-label">Место проведения работ</label>
                    <select class="form-control" name="work_location_id_edit" id="work_location_id_edit" disabled>
                    </select>
                </div>
                <div class="col-12 mb-2">
                    <label for="facility_id_edit" class="form-label">Установка</label>
                    <select class="form-control" name="facility_id_edit" id="facility_id_edit" disabled>
                    </select>
                </div>
                <input type="hidden" name="component_id_edit">
                <input type="hidden" name="qr_id_edit">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        </div>
      </form>
    </div>
  </div>
</div>