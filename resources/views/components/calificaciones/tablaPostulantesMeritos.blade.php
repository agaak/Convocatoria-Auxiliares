<div class="table-requests">
    <table class="table table-striped table-bordered" style="text-align: center" >
      <thead class="thead-dark">
        <tr>
          <th style="font-weight: normal" scope="col">#</th>
          <th style="font-weight: normal" scope="col">CI</th>
          <th style="font-weight: normal" scope="col">Apellidos</th>
          <th style="font-weight: normal" scope="col">Nombres</th>
          <th style="font-weight: normal" scope="col">Nota Final</th>
          @if (auth()->check())
            @if (auth()->user()->hasRoles(['evaluador']))
            @if (!$publicado)
              <th style="font-weight: normal" scope="col">Calificar</th>
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
              @if (!$publicado)
              <td><a class="options" href="{{ route('evaluarM.calificarMeritos', $idEst) }}"><img
                  src="{{ asset('img/pen.png') }}" width="25" height="25">
                </a></td>
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