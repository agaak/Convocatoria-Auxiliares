@extends('verConvocatoria.layoutVerConvocatoria')

@section('content-resultados')
    <div class="overflow-auto content">
        <h3>Notas de Conocimiento por Temática</h3>
    @component('components.resultados.notasByTematica', 
      ['tematicas' => $tematicas, 'tipoConv' => $tipoConv])
    @endcomponent
    </div>
@endsection