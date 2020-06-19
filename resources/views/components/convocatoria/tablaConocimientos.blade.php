<div class="table-requests {{session()->get('ver')? 'my-5': ''}}">
    <table class="table table-bordered" style="text-align: center">
      <thead class="thead-dark">
        <tr>
          <th style="vertical-align: middle; font-weight: normal;" scope="col" rowspan="2">#</th>
          <th style="vertical-align: middle; font-weight: normal;" scope="col" rowspan="2">Tematica</th>
          <th style="font-weight: normal" scope="col" colspan="{{ count($requests) }}">Codigo de Auxiliatura</th>
          @if (!session()->get('ver'))
            <th style="vertical-align: middle; font-weight: normal;" scope="col" rowspan="2">Opciones de<br>Tematica </th>
          @endif
        </tr>
        <tr>
          @foreach($requests as $item)
            <th style="font-weight: normal" scope="col">{{ $item->cod_aux }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @php $num = 1  @endphp
        @foreach($tems as $tematic)
          <tr>
            <td class="table-light">{{ $num++ }}</td>
            <td class="table-light">{{ $tematic->nombre }}</td>
            @foreach($porcentajes as $item)
              @if($item->id_tematica == $tematic->id)
                @if($item->porcentaje == 0)
                <td class="table-light">-</td>
                @else
                <td class="table-light">{{ $item->porcentaje }}</td>
                @endif
              @endif
            @endforeach
            @if (!session()->get('ver'))
              <td class="table-light">
                <a class="options" data-toggle="modal" data-target="#tematicaEditModal" data-id="{{ $tematic->id }}"
                data-nombre="{{ $tematic->nombre }}" data-dismiss="modal">
                  <img src="{{ asset('img/pen.png') }}" width="25" height="25">
                </a>

                <form class="d-inline" action="{{ route('knowledgeRatingTematicDelete', $tematic->id) }}" method="POST">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}
                  <button type="submit" class="btn btn-link">
                    <img src="{{ asset('img/trash.png') }}" width="25" height="25">
                  </button>
                </form>
              </td>
            @endif
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  