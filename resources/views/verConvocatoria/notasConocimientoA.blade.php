@extends('verConvocatoria.layoutVerConvocatoria')

@section('content-resultados')
    <div class="overflow-auto content">
        <h1>NOTAS CONOCIMIENTO AUXILIATURA</h1>
        @component('components.resultados.notasByAuxiliatura', 
          ['listaAux' => $listaAux,'listaPost'=>$listaPost])
        @endcomponent
    </div>
@endsection