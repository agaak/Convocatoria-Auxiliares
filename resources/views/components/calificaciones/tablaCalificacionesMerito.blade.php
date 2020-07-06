<div class="table-requests">
    <table class="table table-striped table-bordered">
          <thead class="thead-dark">
              <tr>
                  <th class="font-weight-normal" scope="col">Descripcion de Meritos</th>
                  <th class="font-weight-normal text-center" scope="col">Porcentaje</th>
                  <th class="font-weight-normal text-center" scope="col">Nota</th>
                  @if (auth()->check())
                    @if (auth()->user()->hasRoles(['evaluador']))
                        <th class="font-weight-normal text-center" scope="col">Calificar</th>
                    @endif
                  @endif
              </tr>
          </thead>
          <tbody class="bg-white">

          @foreach($listaMeritos as $item)
                <tr class="{{ $item[0] === null? 'table-secondary': 'table-light' }}">
                    <td class="{{ $item[0] === null? 'font-weight-bold ': 'text-lowercase' }}"
                        style="padding-left: {{ espacios($item[1]) }}px;">{{ $item[1] }}</td>
                    <td class="text-center">{{ $item[2] }}</td>
                    @if (!session()->get('ver'))
                        <th class="text-center">
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
                        </th>
                        @if (auth()->check())
                            @if (auth()->user()->hasRoles(['evaluador']))
                            <td class="text-center">
                            @foreach($lista as $item2)
                                @if( ($item2->id) == $item[3] )
                                    <button data-toggle="modal" class="btn btn-link" onclick="mostrarModalMeritos({{ json_encode($item2) }},{{ json_encode($item)}})" data-target="#modalCalificar">
                                            <img src="{{ asset('img/pen.png') }}" width="25" height="25">
                                    </button>
                                @endif
                            @endforeach
                            </td>
                            @endif
                        @endif
                        
                        
                    @else
                    <td class="text-center">
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
                    @endif

                </tr>
            @endforeach
          </tbody>
    </table>
</div>
@if (auth()->check())
    @if (!auth()->user()->hasRoles(['evaluador']))
    <div class="form-group text-right mr-5">
       <h6><strong>Nota Final {{$m_total}}</strong></h6>
    </div>
    @endif
@else
<div class="form-group text-right mr-5">
    <h6><strong>Nota Final {{$m_total}}</strong></h6>
 </div>
@endif