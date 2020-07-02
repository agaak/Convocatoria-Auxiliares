@php  $number = 1  @endphp
<div class="table-requests1">
  <table id= "table_id" class="table table-striped table-bordered" style="text-align:left">
    <thead class="thead-dark">
      <tr> 
        <th style="font-weight: normal" scope="col">#</th>
        <th style="font-weight: normal" scope="col">Titulo</th>
        <th style="font-weight: normal" scope="col">Descripcion</th>
        <th style="font-weight: normal" scope="col">Fecha</th>
        <th style="font-weight: normal" scope="col">Opciones</th>
      </tr>
    </thead>
    <tbody style="background-color: white">
       @foreach($listAvisos as $aviso)
        <tr>
          <th style="font-weight: normal">{{ $number++ }}</th>
          <th style="font-weight: normal">{{ $aviso->titulo }}</th>
          <th style="font-weight: normal">{{ $aviso->descripcion }}</th>
          <th style="font-weight: normal">{{ $aviso->updated_at }}</th>
          <th>
            <button type="submit" class="btn btn-link" data-toggle="modal" data-target="#modalUpdateAviso"
              onclick="avisoEditModal({{ json_encode($aviso) }})">
              <img src="{{ asset('img/pen.png') }}" width="26" height="26">
            </button> 
            <form class="d-inline" action="{{ route('admAvisos.delete', $aviso->id) }}" method="POST" id="avisoDelete">
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
              <button type="submit" class="btn btn-link">
                <img src="{{ asset('img/trash.png') }}" width="26" height="26">
              </button>    
            </form>
          </th>
        </tr>
      @endforeach
    </tbody>
  </table>
  {{ $slot }}
</div>
