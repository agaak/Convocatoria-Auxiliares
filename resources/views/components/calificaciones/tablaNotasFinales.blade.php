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
                <table id= "notas{{ $auxiliatura->id}}" class="table table-bordered">
                  <thead class="thead-dark text-left">
                    <tr>
                      <th class="font-weight-normal" scope="col">CI</th>
                      <th class="font-weight-normal" scope="col">Nombre completo</th>
                      <th class="font-weight-normal" scope="col">Nota conocimientos</th>
                      <th class="font-weight-normal" scope="col">Nota meritos</th>
                      <th class="font-weight-normal" scope="col">Nota final</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if($listaPost->has($auxiliatura->id))
                      @foreach ($listaPost[$auxiliatura->id] as $item)
                        <tr>
                          <th style="font-weight: normal">{{ $item->ci }}</th>
                          <th style="font-weight: normal">{{ $item->apellido }} {{ $item->nombre }}</th>
                          @if ($item->nota_final_conoc===null)
                            <th style="font-weight: normal">-</th>
                          @else
                            <th style="font-weight: normal">{{ $item->nota_final_conoc }}</th>
                          @endif
                          @if ($item->nota_final_merito===null)
                            <th style="font-weight: normal">-</th>
                          @else
                            <th style="font-weight: normal">{{ $item->nota_final_merito }}</th>
                          @endif
                          <th style="font-weight: normal">-</th>
                          </tr>
                      @endforeach
                    @endif
                  </tbody>   
                </table>
              </div>
          </div>
          {{ $initContent = false  }}
          @endforeach
      </div>
  </div>
    <script src="{{ asset('js/jquery-3.5.1.slim.min.js') }}"></script>
    @foreach ($listaAux as $auxiliatura)
    <script>
      $(document).ready(function() {
          $('#notas{{ $auxiliatura->id}}').DataTable({
            "rowCallback": function( row, data, index ) {
                var notafinal = /* parseFloat */(data[4]),
                    $node = this.api().row(row).nodes().to$();
                    
                if (notafinal == '-'/*  50.0 */ ) {
                  $node.addClass('aprobado')
                }
            }  ,
            "pageLength":50,
          "language": {
              "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
          },"bLengthChange": false,responsive: true,
          order: [[1, 'asc']], 
          
          });
      
      });
      
  </script>
    @endforeach 