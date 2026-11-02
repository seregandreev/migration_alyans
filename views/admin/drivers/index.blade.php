@extends('layouts.template')
@section('title', 'Список водителей')

@section('header')
    <h4>Список водителей</h4>
@endsection

@section('content')

    <div class="row">
        <div class="col-3">
            <a href="{{ route('drivers.create') }}" class="btn btn-primary">Добавить</a>
        </div>
    </div>
    <hr>
    <div class="scroller">
        <table class="table table-bordered" style="font-size: 13px;" id="viewTable">
            <thead>
            @if(count($drivers) > 0)
                <tr> 
                    <th>Табельный номер</th>
                    <th>Ф.И.О.</th>
                    <th>Номер ВУ</th>
                    <th>Категория</th>
                    <td>Срок действия</td>
                    <td>Телефон</td>
                    <td>Дата рождения</td>
                    <th>Действия</th>
                </tr>
            @endif
            </thead>
            <tbody>
            @if(count($drivers) < 1)
                <div class="alert alert-danger" role="alert">
                    Не добавлено ещё ни одного водителя
                </div>
            @else
                @foreach($drivers as $driver)
                    <tr>
                        <td>{{ $driver->pers_number }}</td>
                        <td>{{ $driver->name }}</td>
                        <td>{{ $driver->num_vu }}<br>
                        @if(file_exists(public_path('drivers_data/'.$driver->id.'/scan_document.pdf')))
                                <a href="{{ asset('drivers_data/'.$driver->id.'/scan_document.pdf') }}" data-fancybox="gallery" target="_blank">Просмотреть скан</a>
                                    <img src="{{ asset('drivers_data/'.$driver->id.'/scan_document.pdf') }}" alt="" style="height: 50px;">
                                
                            @endif
                        </td>
                        <td>{{ $driver->class_vu }}</td>
                        <td>
                            <span style="@if(strtotime($driver->vu_validity) < time()) font-weight: 700; color: #ff0000; @endif">{{ $driver->get_formed_data_document_validity() }}</span>
                        </td>
                        <td>{{ $driver->phone }}</td>
                        <td>{{ $driver->get_formed_data_birth_day($driver->birth_day) }}</td>
                        <!--<td>{{ $driver->document }}</td>
                        <td>{{ $driver->position }}</td>-->
                        <td>
                            <a href="{{ route('drivers.edit', ['id' => $driver->id]) }}" class="btn btn-success">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-danger" onclick="if(confirm('Подтвердите удаление водителя: {{ $driver->name }}')){$('#item_{{ $driver->id }}_delete').submit();}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <form action="{{ route('drivers.destroy', ['id' => $driver->id]) }}" id="item_{{ $driver->id }}_delete" method="POST">
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
<!--
@section('js')

<script>
function sortAlfabet() {
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

function sortDate() {
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
      x = rows[i].cells[6].textContent;
      y = rows[i + 1].cells[6].textContent;
      rowdatesplitX = x.split('.');
      rowdatesplitY = y.split('.');
      rowdatetimestampX = new Date(parseInt(rowdatesplitX[2],10), 0, 0, 0, parseInt(rowdatesplitX[1],10) - 1, parseInt(rowdatesplitX[0],10)).getTime() /1000;
      rowdatetimestampY = new Date(parseInt(rowdatesplitY[2],10), 0, 0, 0, parseInt(rowdatesplitY[1],10) - 1, parseInt(rowdatesplitY[0],10)).getTime() /1000;
      //check if the two rows should switch place:
      if (rowdatetimestampX > rowdatetimestampY) {
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
@endsection-->