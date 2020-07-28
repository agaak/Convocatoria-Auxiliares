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
                  <thead class="thead-dark text-center">
                    <tr>
                      <th class="font-weight-normal" scope="col">#</th>
                      <th class="font-weight-normal" scope="col">CI</th>
                      <th class="font-weight-normal" scope="col">Apellido</th>
                      <th class="font-weight-normal" scope="col">Nombre</th>
                      <th class="font-weight-normal" scope="col">Conocimiento/{{$porcentaje_conoc}}</th>
                      <th class="font-weight-normal" scope="col">Meritos/{{$porcentaje_merit}}</th>
                      <th class="font-weight-normal" scope="col">Nota final</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $num = 1  @endphp
                      @foreach ($listaPost as $item)
                        @if($item->aux_conoc->has($auxiliatura->id))
                        <tr>
                          <td class="text-center">{{ $num++ }}</td>
                          <td class="text-center">{{ $item->ci }}</td>
                          <td>{{ $item->apellido }} </td>
                          <td>{{ $item->nombre }}</td>
                          @if ($item->aux_conoc[$auxiliatura->id][0]->nota_fin_conoc===null)
                            <td class="text-center">-</td>
                          @else
                            <td class="text-center">{{ $item->aux_conoc[$auxiliatura->id][0]->nota_fin_conoc }}</td>
                          @endif
                          @if ($item->nota_fin_merit===null)
                            <td class="text-center">-</td>
                          @else
                            <td class="text-center">{{ $item->nota_fin_merit }}</td>
                          @endif
                          @if ($item->aux_conoc[$auxiliatura->id][0]->nota_fin===null)
                            <td class="text-center">-</td>
                          @else
                            <th class="text-center" >{{ $item->aux_conoc[$auxiliatura->id][0]->nota_fin }}</th>
                          @endif
                          </tr>
                        @endif
                      @endforeach
                  </tbody>   
                </table>
              </div>
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
                var notafinal = (data[6]),
                    $node = this.api().row(row).nodes().to$();
                    
                if (notafinal >= 50.5  ) {
                  $node.addClass('aprobado')
                }
            }  ,
            "pageLength":70,"bPaginate": false,
          "language": {
              "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
          },"bLengthChange": false,responsive: true,
          order: [[0, 'asc']],  "bInfo" : false,
          dom: 'frtipB',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        title: 'Notas finales {{ $auxiliatura->nombre_aux}}',
                        orientation: 'portrait',
                        pageSize: 'LETTER',
                        customize: function ( doc ) {
                        doc.defaultStyle.alignment = 'left';
                        doc.styles.tableHeader.alignment = 'left';
                        doc.defaultStyle.fontSize = '11';
                        doc.content[1].table.widths = ['5%','10%','25%','20%','15%','15%','10%']
                        }
                        
                    }
                ]
          });
      
      });
      
  </script>
    @endforeach 