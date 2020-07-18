@extends('admResultados.layaoutAdmResultados')

@section('content-adm-resultados')

  <div class="overflow-auto content">

    <h3>Notas Finales</h3>
    @component('components.calificaciones.tablaNotasFinales',
    ['listaPost'=>$listaPost, 'listaAux'=>$listaAux, 'titulo_conv'=>$titulo_conv,
         'porcentaje_conoc'=>$porcentaje_conoc, 'porcentaje_merit'=>$porcentaje_merit])
    @endcomponent

</div>
@endsection