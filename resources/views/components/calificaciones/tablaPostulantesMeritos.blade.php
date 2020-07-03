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
              <th style="font-weight: normal" scope="col">Calificar</th>
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
            <td>
            @if (auth()->check())
              @if (auth()->user()->hasRoles(['evaluador']))
                <a class="options" href="{{ route('evaluarM.calificarMeritos', $idEst) }}"><img
                  src="{{ asset('img/pen.png') }}" width="25" height="25">
                </a>
              @else
                @if(auth()->user()->hasRoles(['administrador']))
                <a class="options" href="{{ route('notasResMeritoEst', $idEst) }}">Ver</a>
                @else  
                  <a class="options" href="{{ route('notasMeritoEst', $idEst) }}">Ver</a>
                @endif
              @endif
            @else
              <a class="options" href="{{ route('notasMeritoEst', $idEst) }}">Ver</a>
            @endif 
            </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>