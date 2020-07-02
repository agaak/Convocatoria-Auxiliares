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
              <button type="submit" class="btn btn-info" disabled>Publicar</button> 
            @else
              <button type="submit" class="btn btn-info">Publicar</button> 
            @endif 
      </form>
    </div>

  </div>
@endsection