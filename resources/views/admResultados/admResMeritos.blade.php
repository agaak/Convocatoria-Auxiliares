@extends('admResultados.layaoutAdmResultados')

@section('content-adm-resultados')

  <div class="overflow-auto content" style="width: 100vw; height: 77vh;">

    <h3>Calificacion de Meritos</h3>
    @component('components.calificaciones.tablaPostulantesMeritos',['postulantes'=>$postulantes])
    @endcomponent
  </div>
</div>
@endsection