@extends('admResultados.layaoutAdmResultados')

@section('content-adm-resultados')

  <div class="overflow-auto content">

    <h3>Lista de Habilitados</h3>
      
    
    @component('components.resultados.listaHabilitados', 
        ['listPostulantes' => $listPostulantes])
    @endcomponent

    <div class="text-center">
      <form class="d-inline" action="{{ route('admHabilitados.publicar') }}"
            method="POST">
            {{ csrf_field() }}
            @if($publicado)
              <button type="submit" class="btn btn-info" disabled>Publicar</button> 
            @else
              @if($entregado)
                  <button type="submit" class="btn btn-info">Publicar</button> 
              @else
                  <button type="submit" class="btn btn-info" disabled>Publicar</button> 
              @endif
            @endif 
      </form>
    </div>
    @if ($publicado)
      <div class="text-right">
        <button type="button" class="btn btn-secondary">
          <a href="/convocatoria/adm-postulantes/habilitadosPDF" style="color: #FFFF;">PDF</a>
        </button>
      </div>
    @endif
  </div>
@endsection