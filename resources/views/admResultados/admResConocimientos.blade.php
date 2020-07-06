@extends('admResultados.layaoutAdmResultados')

@section('content-adm-resultados')

  <div class="overflow-auto content">

    <h3>Calificación de Conocimientos</h3>
      
    @component('components.resultados.notasByTematica', 
      ['tematicas' => $tematicas, 'tipoConv' => $tipoConv])
    @endcomponent

</div>
@endsection