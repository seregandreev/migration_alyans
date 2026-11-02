@extends('layouts.template')
@section('title', 'Список инспекторов')

@section('header')
    <h4>Список инспекторов</h4>
@endsection

@section('content')

    <div class="row">
        <div class="col-3">
            <a href="{{ route('inspectors.create') }}" class="btn btn-primary">Добавить</a>
        </div>
        <div class="col-3">
            <button class="btn btn-primary" onclick="sortAlfabet()">Сортировать по алфавиту</button>
        </div>
        <div class="col-3">
            <button class="btn btn-primary" onclick="sortDate()">Сортировать по дате рождения</button>
        </div>
    </div>
    <hr>
    <div class="scroller">
        <table class="table table-bordered" style="font-size: 13px;" id="viewTable">
            <thead>
            @if(count($inspectors) > 0)
                <tr>
                    <th>Ф.И.О.</th>
                    <th>Номер документа</th>
                    <th>Уровень</th>
                    <th>Метод контроля</th>
                    <th>Срок действия</th>
                    <th>Номер телефона</th>
                    <th>Дата рождения</th>
                    <th>Должность</th>
                    <th>Действия</th>
                </tr>
            @endif
            </thead>
            <tbody>
            @if(count($inspectors) < 1)
                <div class="alert alert-danger" role="alert">
                    Не добавлено ещё ни одного инспектора
                </div>
            @else
                @foreach($inspectors as $inspector)
                    <tr>
                        <td>{{ $inspector->name }}</td>
                        <td>{{ $inspector->num_document }}<br>
                        @if(file_exists(public_path('inspectors_data/'.$inspector->id.'/scan_document.pdf')))
                                <a href="{{ asset('inspectors_data/'.$inspector->id.'/scan_document.pdf') }}" data-fancybox="gallery" target="_blank">Просмотреть скан</a>
                                    <!--<img src="{{ asset('inspectors_data/'.$inspector->id.'/scan_document.pdf') }}" alt="" style="height: 50px;">-->
                                
                            @endif
                        </td>
                        <td>{{ $inspector->level }}</td>
                        <td>{{ $inspector->control_method }}</td>
                        <!--<td>{{ $inspector->document_validity }}</td>-->
                        <td>
                            <span style="@if(strtotime($inspector->document_validity) < time()) font-weight: 700; color: #ff0000; @endif">{{ $inspector->get_formed_data_document_validity() }}</span>
                        </td>
                        <td>{{ $inspector->phone }}</td>
                        <td>{{ $inspector->get_formed_data_birth_day($inspector->birth_day) }}</td>
                        <!--<td>{{ $inspector->document }}</td>-->
                        <td>{{ $inspector->position }}</td>
                        <td>
                            <a href="{{ route('inspectors.edit', ['id' => $inspector->id]) }}" class="btn btn-success">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-danger" onclick="if(confirm('Подтвердите удаление инспектора: {{ $inspector->name }}')){$('#item_{{ $inspector->id }}_delete').submit();}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <form action="{{ route('inspectors.destroy', ['id' => $inspector->id]) }}" id="item_{{ $inspector->id }}_delete" method="POST">
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
@endsection