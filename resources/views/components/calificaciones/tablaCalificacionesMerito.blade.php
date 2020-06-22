<div class="table-requests">
    <table class="table table-bordered">
          <thead class="thead-dark">
              <tr>
                  <th class="font-weight-normal" scope="col">Descripcion de Meritos</th>
                  <th class="font-weight-normal" scope="col">Porcentaje</th>
                  <th class="font-weight-normal" scope="col">Nota</th>
                  <th class="font-weight-normal" scope="col">Editar</th>
              </tr>
          </thead>
          <tbody class="bg-white">

          @foreach($listaMeritos as $item)
                <tr class="{{ $item[0] === null? 'table-secondary': 'table-light' }}">
                    <td class="{{ $item[0] === null? 'font-weight-bold ': 'text-lowercase' }}"
                        style="padding-left: {{ espacios($item[1]) }}px;">{{ $item[1] }}</td>
                    <td class="text-center">{{ $item[2] }}</td>
                    @if (!session()->get('ver'))
                        <td>
                        @foreach($lista as $item2)
                            @if( ($item2->id) == $item[3] )
                                @if( ($item2->calificacion) == 0 )
                                    -
                                @else
                                    {{$item2->calificacion}}
                                @endif 
                            @else
                            @endif
                        @endforeach
                        </td>
                        <td>
                        @foreach($lista as $item2)
                            @if( ($item2->id) == $item[3] )
                                <button data-toggle="modal" class="btn btn-link" onclick="mostrarModalMeritos({{ json_encode($item2) }},{{ json_encode($item)}})" data-target="#modalCalificar">
                                    <img src="{{ asset('img/pen.png') }}" width="30" height="30">
                                </button>
                            @else
                            @endif
                        @endforeach
                        </td>
                    @endif
                </tr>
            @endforeach
          </tbody>
    </table>
</div>