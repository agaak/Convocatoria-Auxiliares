<div class="table-requests1 mx-4">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" id="myTab" role="tablist">
      @php $initTabs = true @endphp
      @foreach ($listaAux as $auxiliatura)
        <li class="nav-item">
          <a class="nav-link{{ $initTabs ? " active" : '' }}" id={{ $auxiliatura->id }} data-toggle="tab" 
              href="#{{ "body".$auxiliatura->id }}" role="tab" aria-controls="home" aria-selected={{ $initTabs }}>
            {{ $auxiliatura->nombre_aux }}
          </a>
        </li>
       {{ $initTabs = false  }}
      @endforeach
  </ul>
  @php $initContent = true; @endphp
  <div class="tab-content" id="myTabContent">
      @foreach ($listaAux as $auxiliatura)
        <div class="tab-pane fade{{ $initContent ? " show active" : '' }}" id={{ "body".$auxiliatura->id}} 
          role="tabpanel" aria-labelledby={{ $auxiliatura->id}}>
          <div class="table-requests1">
              <table id= "notas{{ $auxiliatura->id}}" class="table table-striped table-bordered"
                  style="width: 100%">
                  <thead class="thead-dark text-center">
                      <tr>
                          <th style="vertical-align: middle;" scope="col" rowspan="2">#</th>
                          <th style="vertical-align: middle;" class="font-weight-normal" scope="col" rowspan="2">CI</th>
                          <th style="vertical-align: middle;" class="font-weight-normal" scope="col" rowspan="2">Apellidos</th>
                          <th style="vertical-align: middle;" class="font-weight-normal" scope="col" rowspan="2">Nombres</th>
                          @foreach ($tematicas[$auxiliatura->id] as $tematica)
                            <th class="font-weight-normal" scope="col" colspan="{{ count($tematica->areas) }}">{{ $tematica->nombre }}</th>
                          @endforeach
                          <th style="vertical-align: middle;" class="font-weight-normal" scope="col" rowspan="2">Nota final</th>
                      </tr>
                      <tr>
                        @foreach ($tematicas[$auxiliatura->id] as $tematica)
                          @foreach ($tematica['areas'] as $area)
                            <th class="font-weight-normal" scope="col">{{ $area->area }}/{{ $area->porcentaje }}</th>
                          @endforeach
                        @endforeach
                      </tr>
                  </thead>
                  <tbody>
                    @if($listaPost->has($auxiliatura->id))
                      @php $num = 1  @endphp
                      @foreach ($listaPost[$auxiliatura->id] as $item)
                        <tr>    
                              <th style="font-weight: normal">{{ $num++ }}</th>
                              <th style="font-weight: normal">{{ $item->ci }}</th>
                              <th style="font-weight: normal">{{ $item->apellido }}</th>
                              <th style="font-weight: normal">{{ $item->nombre }}</th>
                              @foreach ($tematicas[$auxiliatura->id] as $tematica)
                                  @foreach ($tematica['areas'] as $area)
                                    <td class="text-center" scope="col">
                                      @foreach ($item->notas_tems[$tematica->id] as $tems)
                                        @if($tems->id_area == $area->id_area)
                                          {{ $tems->calificacion != null ?$tems->calificacion:'-' }}
                                        @endif
                                      @endforeach
                                    </td>
                                  @endforeach
                              @endforeach
                              <td class="text-center">{{ $item->nota_final_conoc }}</td>
                        </tr>
                      @endforeach
                    @endif
                  </tbody>
              </table>
          </div>
        </div>
        @php $initContent = false @endphp
      @endforeach
  </div>
</div>
<script src="{{ asset('js/jquery-3.5.1.slim.min.js') }}"></script>
@foreach ($listaAux as $auxiliatura)
  <script>
    $(document).ready(function() {
        $('#notas{{ $auxiliatura->id}}').DataTable({
        "rowCallback": function( row, data, index ) {
                var notafinal = (data[4 + {{count($tematicas[$auxiliatura->id])}}]),
                    $node = this.api().row(row).nodes().to$();
                    
                if (notafinal >= 50.5  ) {
                  $node.addClass('aprobado')
                }
            },
          "pageLength":50,
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },"bLengthChange": false,responsive: true,
        order: [[2, 'asc']],"bPaginate": false
        });
      
    });
</script>
@endforeach 