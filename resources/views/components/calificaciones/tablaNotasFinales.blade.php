  <div class="table-requests1">
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
                <table id= "notas{{ $auxiliatura->id}}" class="table table-striped table-bordere d">
                  <thead class="thead-dark text-left">
                    <tr>
                      <th class="font-weight-normal" scope="col">CI</th>
                      <th class="font-weight-normal" scope="col">Nombre completo</th>
                      <th class="font-weight-normal" scope="col">Conocimientos</th>
                      <th class="font-weight-normal" scope="col">Meritos</th>
                      <th class="font-weight-normal" scope="col">Nota final</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if($listaPost->has($auxiliatura->id))
                      @foreach ($listaPost[$auxiliatura->id] as $item)
                        <tr>
                          <td style="font-weight: normal">{{ $item->ci }}</td>
                          <td style="font-weight: normal">{{ $item->apellido }} {{ $item->nombre }}</td>
                          @if ($item->nota_final_conoc===null)
                            <td style="font-weight: normal">-</td>
                          @else
                            <td style="font-weight: normal">{{ $item->nota_final_conoc }}</td>
                          @endif
                          @if ($item->nota_final_merito===null)
                            <td style="font-weight: normal">-</td>
                          @else
                            <td style="font-weight: normal">{{ $item->nota_final_merito }}</td>
                          @endif
                          @if ($item->not_fin===null)
                            <th style="font-weight: normal">-</th>
                          @else
                            <th style="font-weight: normal">{{ $item->not_fin }}</th>
                          @endif
                          </tr>
                      @endforeach
                    @endif
                  </tbody>   
                </table>
              </div>
              <button type="button" class="btn btn-secondary">
                <a href="/convocatoria/adm-resultados/notas-finalesPDF" style="color: #FFFF;">PDF</a>
              </button>
          </div>
          {{ $initContent = false  }}
          @endforeach
      </div>
  </div>
    <script src="{{ asset('js/jquery-3.5.1.slim.min.js') }}"></script>
    <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js') }}"></script>


    @foreach ($listaAux as $auxiliatura)
    <script>
      $(document).ready(function() {
          $('#notas{{ $auxiliatura->id}}').DataTable({
            "rowCallback": function( row, data, index ) {
                var notafinal = (data[4]),
                    $node = this.api().row(row).nodes().to$();
                    
                if (notafinal > 50.0  ) {
                  $node.addClass('aprobado')
                }
            }  ,
            "pageLength":70,"bPaginate": false,
          "language": {
              "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
          },"bLengthChange": false,responsive: true,
          order: [[1, 'asc']], 
          /* dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        
                        title: 'Notas finales {{ $auxiliatura->nombre_aux}}',
                        orientation: 'portrait',
                        pageSize: 'LETTER',
                        customize: function ( doc ) {
                        doc.defaultStyle.alignment = 'left';
                        doc.styles.tableHeader.alignment = 'left';
                        doc.defaultStyle.fontSize = '11',
                        doc.content[1].table.widths = ['10%','50%','15%','15%','10%']
                        }
                        
                    }
                ] */
          });
      
      });
      
  </script>
    @endforeach 