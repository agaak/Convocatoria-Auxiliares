@extends('admResultados.layaoutAdmResultados')

@section('content-adm-resultados')

  <div class="overflow-auto content" style="width: 100vw; height: 77vh;">

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
              <button type="submit" class="btn btn-info">Publicar</button> 
            @endif 
      </form>
    </div>

  </div>
@endsection