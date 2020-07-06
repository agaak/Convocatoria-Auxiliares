@extends('admResultados.layaoutAdmResultados')

@section('content-adm-resultados')

  <div class="overflow-auto content">

    <h3>Detalles de calificaión de Requisitos</h3>
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