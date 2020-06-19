<div class="table-requests {{session()->get('ver')? 'my-5': ''}}">
    <table class="table table-bordered" style="text-align: center" >
      <thead class="thead-dark">
        <tr>
          <th style="font-weight: normal" scope="col">Items</th>
          <th style="font-weight: normal" scope="col">Cantidad</th>
          <th style="font-weight: normal" scope="col">Hrs. Academicas/Mes</th>
          <th style="font-weight: normal" scope="col">Nombre de la Auxiliatura</th>
          <th style="font-weight: normal" scope="col">Codigo de Auxiliatura</th>
          @if (!session()->get('ver'))  
            <th style="font-weight: normal" scope="col">Opciones</th>
          @endif
        </tr>
      </thead>
      <tbody style="background-color: white">
        @php $num = 1 @endphp
        @foreach($requests as $reques)
          <tr> 
            <td>{{ $num++ }}</td>
            <td>{{ $reques->cant_aux }} Aux.</td>
            <td>{{ $reques->horas_mes }} hrs/mes</td>
            <td>{{ $reques->nombre_aux }}</td>
            <td>{{ $reques->cod_aux }}</td>
            @if (!session()->get('ver'))
              <td>
                <a class="options" data-toggle="modal" data-target="#requestEditModal" data-cantidad="{{ $reques->cant_aux }}" 
                data-horas_mes="{{ $reques->horas_mes }}" data-id="{{ $reques->id }}"data-id_auxiliatura="{{ $reques->id_auxiliatura }}" 
                data-nombre="{{ $reques->nombre_aux }}" data-cod_aux="{{ $reques->cod_aux }}" data-dismiss="modal">
                  <img src="{{ asset('img/pen.png') }}" width="25" height="25">
                </a>
                <form class="d-inline" action="{{ route('delete', $reques->id) }}" method="POST">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}
                  <button type="submit" class="btn btn-link">
                    <img src="{{ asset('img/trash.png') }}" width="30" height="30">
                  </button>    
                </form>
              </td>
            @endif
          </tr>
        @endforeach
      </tbody>
    </table>
    
    {{ $slot }}
  </div>
  