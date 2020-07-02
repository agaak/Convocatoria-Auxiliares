@extends('admResultados.layaoutAdmResultados')

@section('content-adm-resultados')

  <div class="overflow-auto content" style="width: 100vw; height: 77vh;">

    <h3>Detalles de calificaion de requisitos</h3>
    <div style= "float: right;">
      <a href="{{ route('admHabilitados') }}" class="btn btn-info">
          {{ csrf_field() }}Atras</a>
    </div>
    @component('components.calificaciones.calificacionRequisitos', 
            ['auxiliaturas' => $auxiliaturas,'idPostulante' => $idPostulante,'mapVerifications'=> $mapVerifications,
            'requisitos'=>$requisitos])
    @endcomponent

</div>
@endsection