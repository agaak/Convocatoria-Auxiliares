@extends('admResultados.layaoutAdmResultados')

@section('content-adm-resultados')

  <div class="overflow-auto content" style="width: 100vw; height: 77vh;">

    <h3>Calificacion de Conocimientos</h3>
      
    @component('components.resultados.notasByTematica', 
      ['tematicas' => $tematicas, 'tipoConv' => $tipoConv])
    @endcomponent

</div>
@endsection