@extends('verConvocatoria.layoutVerConvocatoria')

@section('content-resultados')
    <div class="overflow-auto content">
        <h1>NOTAS FINALES</h1>

        @component('components.calificaciones.tablaNotasFinales',
        ['listaPost'=>$listaPost, 'listaAux'=>$listaAux, 'titulo_conv'=>$titulo_conv])
        @endcomponent
    </div>
@endsection