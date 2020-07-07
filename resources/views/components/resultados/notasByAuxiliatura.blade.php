<div class="container">
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
              <table id= "notas{{ $auxiliatura->id}}" class="table table-striped table-bordered">
                  <thead class="thead-dark text-center">
                      <tr>
                          <th class="font-weight-normal" scope="col">CI</th>
                          <th class="font-weight-normal" scope="col">Apellidos</th>
                          <th class="font-weight-normal" scope="col">Nombres</th>
                          @foreach ($auxiliatura->tematicas as $tematica)
                          @if ($tematica->porcentaje != 0)
                          <th class="font-weight-normal" scope="col">{{ $tematica->nombre }}/{{ $tematica->porcentaje }}</th>
                          @endif
                          
                              
                          @endforeach
                        
                          <th class="font-weight-normal" scope="col">Nota final</th>
                      </tr>
                  </thead>
                  <tbody>
                    @if($listaPost->has($auxiliatura->id))
                      @foreach ($listaPost[$auxiliatura->id] as $item)
                      <tr>
                              <th style="font-weight: normal">{{ $item->ci }}</th>
                              <th style="font-weight: normal">{{ $item->apellido }}</th>
                              <th style="font-weight: normal">{{ $item->nombre }}</th>
                                @foreach ($item->notas_tems as $tems)
                                <td class="text-center" scope="col">{{ $tems->calificacion??'-' }}</td>
                                @endforeach
                              <td class="text-center">{{ $item->nota_final_conoc??'-' }}</td>
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
        
          "pageLength":50,
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },"bLengthChange": false,responsive: true,
        order: [[2, 'asc']],"bPaginate": false
        });
      
    });
</script>
@endforeach 