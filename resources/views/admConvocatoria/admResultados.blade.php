@extends('admConvocatoria.layaoutAdmConvocatoria')

@section('content-adm-convocatoria')

  <div class="overflow-auto content" style="width: 100vw; height: 77vh;">

    <h3>Resultados</h3>

      @component('components.calificaciones.tablaNotasFinales',
      ['listaPost'=>$listaPost, 'listaAux'=>$listaAux])
      @endcomponent
      
  </div>
</div>
@endsection