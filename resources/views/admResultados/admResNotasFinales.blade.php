@extends('admResultados.layaoutAdmResultados')

@section('content-adm-resultados')

  <div class="overflow-auto content" style="width: 100vw; height: 77vh;">

    <h3>Lista de Habilitados</h3>
    @component('components.calificaciones.tablaNotasFinales',
    ['listaPost'=>$listaPost, 'listaAux'=>$listaAux, 'titulo_conv'=>$titulo_conv])
    @endcomponent

</div>
@endsection