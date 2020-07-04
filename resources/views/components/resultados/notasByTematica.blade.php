<div class="container">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        @php $initTabs = true @endphp
        @foreach ($tematicas as $tematica)
            <li class="nav-item">
              <a class="nav-link{{ $initTabs ? " active" : '' }}" id={{ $tematica->id }} data-toggle="tab" 
                href="#{{ "body".$tematica->id }}" role="tab" aria-controls="home" aria-selected={{ $initTabs }}>
                @if (count($tematica->postulantes)==0)
                  {{ $tipoConv==1? $tematica->nombre : $tematica->cod_aux.'-'.$tematica->nombre}}
                @else
                <strong>{{ $tipoConv==1? $tematica->nombre : $tematica->cod_aux.'-'.$tematica->nombre}}</strong>
                @endif
              </a>
            </li>
            {{ $initTabs = false  }}
        @endforeach
    </ul>
      @php $initContent = true; @endphp
      <div class="tab-content" id="myTabContent">
        @foreach ($tematicas as $tematica)
          <div class="tab-pane fade{{ $initContent ? " show active" : '' }}" id={{ "body".$tematica->id}} 
            role="tabpanel" aria-labelledby={{ $tematica->id}}>
              <div class="table-requests1">
                <table id= "notas{{ $tematica->id}}" class="table table-striped table-bordered">
                  <thead class="thead-dark text-left">
                    <tr>
                      <th class="font-weight-normal" scope="col">Item</th>
                      <th class="font-weight-normal" scope="col">CI</th>
                      <th class="font-weight-normal" scope="col">Apellidos</th>
                      <th class="font-weight-normal" scope="col">Nombres</th>
                      <th class="font-weight-normal" scope="col">Nota</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $num=1; @endphp
                    
                    @foreach ($tematica->postulantes as $item)
                        <tr>
                          <td>{{ $num++ }}</td>
                          <td>{{ $item[0]->ci }}</td>
                          <td>{{ $item[0]->apellido }}</td>
                          <td>{{ $item[0]->nombre }}</td>
                          @if($item[0]->calificacion === null)
                            <td>-</td>
                          @else
                            <td>{{ $item[0]->calificacion }}</td>
                          @endif
                        </tr>
                    @endforeach
                  </tbody>   
                </table>
              </div>
            @if (auth()->check())
                @if (auth()->user()->hasRoles(['administrador']))
                    <div class="text-center">
                        <form class="d-inline" action="{{ route('admNotasTematica.publicar',['id' => $tematica->id_aux, 'tem' => $tematica->nombre ]) }}"
                            method="POST">
                            {{ csrf_field() }}
                            @if($tematica->publicado)
                                <button type="submit" class="btn btn-info" disabled>Publicar</button> 
                            @else
                                @if($tematica->entregado)
                                    <button type="submit" class="btn btn-info">Publicar</button> 
                                @else
                                    <button type="submit" class="btn btn-info" disabled>Publicar</button> 
                                @endif
                            @endif 
                        </form>
                    </div>
                @endif
            @endif
          </div>
          {{ $initContent = false  }}
          @endforeach
      </div>
  </div>