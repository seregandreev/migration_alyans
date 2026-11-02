@extends('layouts.template')
@section('title', 'Транспорт')

@section('header')
    <h4>Список транспорта</h4>
@endsection

@section('content')

    <div class="row">
        <div class="col-3">
            <a href="{{ route('transports.create') }}" class="btn btn-primary">Добавить</a>
        </div>
        <div class="col-3">
            <button class="btn btn-primary" onclick="sortAuto()">Сортировать по авто</button>
        </div>
        <div class="col-3">
            <button class="btn btn-primary" onclick="sortMileage()">Сортировать по пробегу</button>
        </div>
    </div>
    <hr>

    <div class="scroller">
        <table class="table table-bordered" style="font-size: 13px;" id="viewTable">
            <thead>
            @if(count($transports) > 0)
                <tr>
                    <th>Наименование</th>
                    <th>VIN номер</th>
                    <th>Гос. номер</th>
                    <th>Пробег</th>
                    <th>Тех. осмотр</th>
                    <th>Страховка</th>
                    <th>Номер СТС</th>
                    <th>Номер ПТС</th>
                    <th>Дата тех. обслуживания</th>
                    <th>Дата тех. осмотра</th>
                    <th>Дата страховки</th>
                    <th>Действия</th>
                </tr>
            @endif
            </thead>
            <tbody>
            @if(count($transports) < 1)
                <div class="alert alert-danger" role="alert">
                    Не добавлено ещё ни одного транспорта
                </div>
            @else
                @foreach($transports as $transport)
                    <tr>
                        <td>{{ $transport->name }}</td>
                        <td>{{ $transport->vin_num }}</td>
                        <td>{{ $transport->gos_num }}</td>
                        <td>{{ $transport->mileage }}</td>
                        <td style="text-align: center;">
                            @if(file_exists(public_path('transports_data/'.$transport->id.'/scan_inspection.pdf')))
                                <a href="{{ asset('transports_data/'.$transport->id.'/scan_inspection.pdf') }}" data-fancybox="gallery" target="_blank">Просмотреть скан</a>
                                <!--<img src="{{ asset('transports_data/'.$transport->id.'/scan_inspectiont.pdf') }}" alt="" style="height: 50px;">-->
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if(file_exists(public_path('transports_data/'.$transport->id.'/scan_insurance.pdf')))
                                <a href="{{ asset('transports_data/'.$transport->id.'/scan_insurance.pdf') }}" data-fancybox="gallery" target="_blank">Просмотреть скан</a>
                                <!--<img src="{{ asset('transports_data/'.$transport->id.'/scan_insurance.pdf') }}" alt="" style="height: 50px;">-->
                                
                            @endif
                        </td>
                        <td>{{ $transport->num_sts }}</td>
                        <td>{{ $transport->num_pts }}</td>
                        <td>{{ $transport->get_formed_date_service($transport->date_service) }}</td>
                        <td>{{ $transport->get_formed_date_inspection($transport->date_inspection) }}</td>
                        <td>{{ $transport->get_formed_date_insurance($transport->date_insurance) }}</td>
                        <td>
                            <a href="{{ route('transports.edit', ['id' => $transport->id]) }}" class="btn btn-success">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" onclick="if(confirm('Подтвердите удаление транспорта: {{ $transport->name }}')){$('#item_{{ $transport->id }}_delete').submit();}" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <form action="{{ route('transports.destroy', ['id' => $transport->id]) }}" id="item_{{ $transport->id }}_delete" method="POST">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script>
            $(document).ready(function() {
            $('.datatable').DataTable({
                //'paging': false
            });
        });
function sortAuto() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("viewTable");
  switching = true;
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.getElementsByTagName("TR");
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[0];
      y = rows[i + 1].getElementsByTagName("TD")[0];
      //check if the two rows should switch place:
      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        //if so, mark as a switch and break the loop:
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}

function sortMileage() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("viewTable");
  switching = true;
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.getElementsByTagName("TR");
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[3];
      y = rows[i + 1].getElementsByTagName("TD")[3];
      //check if the two rows should switch place:
      if (Number(x.innerHTML) > Number(y.innerHTML)) {
        //if so, mark as a switch and break the loop:
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}
</script>
@endsection


@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js">
@endsection