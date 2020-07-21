@extends('verConvocatoria.layoutVerConvocatoria')

@section('content-resultados')
    <div class="overflow-auto content">
        <h3>Notas de Conocimiento por Auxiliatura</h3>
        @component('components.resultados.notasByAuxiliatura', 
          ['listaAux' => $listaAux,'tematicas' => $tematicas,'listaPost'=>$listaPost])
        @endcomponent
    </div>
@endsection