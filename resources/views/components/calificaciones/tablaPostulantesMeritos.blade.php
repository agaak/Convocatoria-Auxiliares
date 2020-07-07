<div class="table-requests">
    <table id="tablaMeritos" class="table table-striped table-bordered" style="text-align: center" >
      <thead class="thead-dark">
        <tr>
          <th style="font-weight: normal" scope="col">#</th>
          <th style="font-weight: normal" scope="col">CI</th>
          <th style="font-weight: normal" scope="col">Apellidos</th>
          <th style="font-weight: normal" scope="col">Nombres</th>
          <th style="font-weight: normal" scope="col">Nota Final</th>
          @if (auth()->check())
            @if (auth()->user()->hasRoles(['evaluador']))
              @if (!session()->get('ver'))
                    @if (!$publicado)
                      <th style="font-weight: normal" scope="col">Calificar</th>
                    @endif
              @endif
            @else
              <th style="font-weight: normal" scope="col">Ver detalles</th>
            @endif
          @else 
            <th style="font-weight: normal" scope="col">Ver detalles</th>
          @endif    
        </tr>
      </thead>
      <tbody style="background-color: white">
        @php $indice=1 @endphp
        @foreach($postulantes as $postulante)
        <tr> 
        @php $idEst=$postulante->id @endphp
            <td>{{ $indice++ }}</td>
            <td>{{ $postulante->ci }}</td>
            <td>{{$postulante->apellido}}</td>
            <td>{{ $postulante->nombre }}</td>
            @if($postulante->nota > 0)  <td>{{$postulante->nota}}</td> @else <td>-</td> @endif
            @if (auth()->check())
              @if (auth()->user()->hasRoles(['evaluador']))
                @if (!session()->get('ver'))
                  @if (!$publicado)
                  <td><a class="options" href="{{ route('evaluarM.calificarMeritos', $idEst) }}"><img
                      src="{{ asset('img/pen.png') }}" width="25" height="25">
                    </a></td>
                  @endif
                @endif
              @else
                @if(auth()->user()->hasRoles(['administrador']))
                <td><a class="options" href="{{ route('notasResMeritoEst', $idEst) }}">Ver</a></td>
                @else  
                <td><a class="options" href="{{ route('notasMeritoEst', $idEst) }}">Ver</a></td>
                @endif
              @endif
            @else
            <td><a class="options" href="{{ route('notasMeritoEst', $idEst) }}">Ver</a></td>
            @endif 
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
{{-- <script src="{{ asset('js/jquery-3.5.1.slim.min.js') }}"></script> --}}
<script>
    // $(document).ready(function() {
    //     $('#tablaMeritos').DataTable({
    //     "pageLength":70,"bPaginate": false,
    //     "language": {
    //         "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    //     },"bLengthChange": false,responsive: true,
    //     order: [0, 'asc'],  "bInfo" : false
    //     });
    
    // });
    
</script>