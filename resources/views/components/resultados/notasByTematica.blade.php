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
                  @if (!session()->get('ver'))  
                    <div class="text-center">
                        <form class="d-inline" action="{{ route('admNotasTematica.publicar',['id' => $tematica->id_aux, 'tem' => $tematica->nombre ]) }}"
                            method="POST">
                            {{ csrf_field() }}
                            @if($tematica->publicado)
                                <button type="submit" class="btn btn-info" disabled>Publicar</button>
                                
                                <div class="text-right">
                                  <button type="button" class="btn btn-secondary">
                                    <a href="/evaluador/calificar/conocimiento/{{$tipoConv ==1? $tematica->id: $tematica->id_aux}}/{{$tematica->nombre}}/pdf" style="color: #FFFF;">PDF</a>
                                  </button>
                                </div>
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
            @endif
          </div>
          {{ $initContent = false  }}
          {{-- @if ($tematica->publicado)
            <div class="text-right">
                <a href="{{ route('PDFconocimientos',['id' => $tematica->id_aux, 'tem' => $tematica->nombre ]) }}" class="btn btn-success btn-sm text-white">Ver</a>
                <a href="/convocatoria/adm-postulantes/habilitadosPDF" style="color: #FFFF;">PDF</a>
              
            </div>
          @endif --}}
          @endforeach
      </div>
      
  </div>
  <script src="{{ asset('js/jquery-3.5.1.slim.min.js') }}"></script>
  @foreach ($tematicas as $tematica)
    <script>
      $(document).ready(function() {
          $('#notas{{ $tematica->id}}').DataTable({
      
            "pageLength":50,
          "language": {
              "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
          },"bLengthChange": false,responsive: true,
          order: [[2, 'asc']],"bPaginate": false
          });
      
      });
      
  </script>
  @endforeach 