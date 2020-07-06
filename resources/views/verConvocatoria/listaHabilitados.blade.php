@extends('verConvocatoria.layoutVerConvocatoria')

@section('content-resultados')
    <div class="overflow-auto content">
        <h3> Lista de Habilitados</h3>

        @component('components.resultados.listaHabilitados', 
            ['listPostulantes' => $listPostulantes])
        @endcomponent

    </div>
@endsection