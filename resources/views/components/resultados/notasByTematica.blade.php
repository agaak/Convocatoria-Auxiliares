<div class="table-requests">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        @php $initTabs = true  @endphp
        @php $initTabs = session()->has('id_tem')? session()->get('id_tem').'-'.session()->get('id_area') : 
              $tematicas[0]['id'].'-'.$tematicas[0]['areas'][0]['id_area']; @endphp
        @foreach ($tematicas as $tematica)
          @foreach($tematica['areas'] as $area)
            <li class="nav-item">
              <a class="nav-link{{ $initTabs==$tematica->id.'-'.$area->id_area ? " active" : '' }}" 
              id="{{ $tematica->id.'-'.$area->id_area }}" data-toggle="tab" href="#{{ "body".$tematica->id.'-'.$area->id_area  }}" 
              role="tab" aria-controls="home" aria-selected={{ $initTabs }}>
                @if (count($area->postulantes)==0)
                  {{ $tematica->nombre.'-'.$area->area}}
                @else
                <strong>{{ $tematica->nombre.'-'.$area->area}}</strong>
                @endif
              </a>
            </li>
          @endforeach
        @endforeach
    </ul>
    @php $initContent = session()->has('id_tem')? session()->get('id_tem').'-'.session()->get('id_area') : 
      $tematicas[0]['id'].'-'.$tematicas[0]['areas'][0]['id_area']; @endphp
      <div class="tab-content" id="myTabContent">
        @foreach ($tematicas as $tematica)
          @foreach($tematica['areas'] as $area)
          <div class="tab-pane fade{{ $initContent==$tematica->id.'-'.$area->id_area ? " show active" : '' }}" id={{ "body".$tematica->id.'-'.$area->id_area}} 
            role="tabpanel" aria-labelledby={{ $tematica->id.'-'.$area->id_area}}>
              <div class="table-requests1">
                <table id= "notas{{ $tematica->id.'-'.$area->id_area}}" class="table table-striped table-bordered">
                  <thead class="thead-dark text-center">
                    <tr>
                      <th class="font-weight-normal" scope="col">#</th>
                      <th class="font-weight-normal" scope="col">CI</th>
                      <th class="font-weight-normal" scope="col">Apellidos</th>
                      <th class="font-weight-normal" scope="col">Nombres</th>
                      <th class="font-weight-normal" scope="col">Nota</th>
                    </tr>
                  </thead>
                  <tbody class="text-center">
                    @php $num=1; @endphp
                    
                    @foreach ($area->postulantes as $item)
                        <tr>
                          <td>{{ $num++ }}</td>
                          <td>{{ $item[0]->ci }}</td>
                          <td>{{ $item[0]->apellido }}</td>
                          <td>{{ $item[0]->nombre }}</td>
                          @if($item[0]->calificacion === null)
                            <td></td>
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
                        <form class="d-inline" action="{{ route('admNotasTematica.publicar',['id_tem' => $tematica->id, 'id_area' => $area->id_area ]) }}"
                            method="POST">
                            {{ csrf_field() }}
                            @if($area->publicado)
                                <button type="submit" class="btn btn-info" disabled>Publicar</button>
                                
                                <div class="text-right">
                                  <button type="button" class="btn btn-secondary">
                                    <a href="/evaluador/calificar/conocimiento/{{ $tematica->id }}/{{ $area->id_area }}/pdf" style="color: #FFFF;">PDF</a>
                                  </button>
                                </div>
                            @else
                                @if($area->entregado)
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
          @endforeach
          @endforeach
      </div>
      
  </div>
  <script src="{{ asset('js/jquery-3.5.1.slim.min.js') }}"></script>
  @foreach ($tematicas as $tematica)
  @foreach ($tematica['areas'] as $area)
    <script>
      $(document).ready(function() {
          $('#notas{{ $tematica->id.'-'.$area->id_area}}').DataTable({
      
            "pageLength":50,retrieve: true,
          "language": {
              "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
          },"bLengthChange": false,responsive: true,
          order: [[2, 'asc']],"bPaginate": false
          });
      
      });
      
  </script>
  @endforeach 
  @endforeach 