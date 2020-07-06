@extends('admConvocatoria.layaoutAdmConvocatoria')

@section('content-adm-convocatoria')

  <div class="overflow-auto content">

    <h3>Resultados</h3>

      @component('components.calificaciones.tablaNotasFinales',
      ['listaPost'=>$listaPost, 'listaAux'=>$listaAux, 'titulo_conv'=>$titulo_conv])
      @endcomponent
      
  </div>
</div>
@endsection