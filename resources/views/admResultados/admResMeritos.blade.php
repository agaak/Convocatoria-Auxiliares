@extends('admResultados.layaoutAdmResultados')

@section('content-adm-resultados')

  <div class="overflow-auto content" style="width: 100vw; height: 77vh;">

    <h3>Calificacion de Meritos</h3>
    @component('components.calificaciones.tablaPostulantesMeritos',['postulantes'=>$postulantes])
    @endcomponent

    <div class="text-center">
      <form class="d-inline" action="{{ route('admMeritos.publicar') }}"
            method="POST">
            {{ csrf_field() }}
            @if($publicado)
              <button type="submit" class="btn btn-info" disabled>Publicado</button> 
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
        <a href="/convocatoria/adm-postulantes/notasMeritoPDF" style="color: #FFFF;">PDF</a>
      </button>
    </div>
  @endif
  </div>
@endsection