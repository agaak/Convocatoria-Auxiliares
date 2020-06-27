
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('css/styles.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    {{-- Datatables --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/b-1.6.2/b-html5-1.6.2/rg-1.1.2/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.1.2/css/rowGroup.bootstrap4.min.css">
    
</head>
<body>
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
                          <th style="font-weight: normal">{{ $item->nota_final_conoc }}</th>
                          <th style="font-weight: normal">{{ $item->nota_final_merito}}</th>
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
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/es.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    @foreach ($listaAux as $auxiliatura)
    <script>
      $(document).ready(function() {
          $('#notas{{ $auxiliatura->id}}').DataTable({
            "pageLength":50,
          "language": {
              "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
          },"bLengthChange": false,responsive: true,
          order: [[1, 'asc']], 
          });
      
      });
      
  </script>
    @endforeach 

    
</body>
</html>
