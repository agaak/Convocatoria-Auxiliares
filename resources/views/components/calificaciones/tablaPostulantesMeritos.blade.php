<div class="table-requests">
    <table class="table table-bordered" style="text-align: center" >
      <thead class="thead-dark">
        <tr>
          <th style="font-weight: normal" scope="col">#</th>
          <th style="font-weight: normal" scope="col">Ci</th>
          <th style="font-weight: normal" scope="col">Estudiante</th>
          <th style="font-weight: normal" scope="col">Nota</th>
          <th style="font-weight: normal" scope="col">Editar</th>
        </tr>
      </thead>
      <tbody style="background-color: white">
        @php $indice=1 @endphp
        @foreach($postulantes as $postulante)
        <tr> 
        @php $idEst=$postulante->id @endphp
            <td>{{ $indice++ }}</td>
            <td>{{ $postulante->ci }}</td>
            <td>{{ $postulante->nombre }} {{$postulante->apellido}}</td>
            @if($postulante->nota > 0)  <td>{{$postulante->nota}}</td> @else <td>-</td> @endif
            <td><a class="options" href="{{ route('evaluarM.calificarMeritos', $idEst) }}"><img
                src="{{ asset('img/pen.png') }}" width="25" height="25"></a></td>
        </tr>@endforeach
      </tbody>
    </table>
  </div>