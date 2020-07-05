@extends('evaluador.layoutEvaluador')

@section('content-evaluador')
    
    <div class="overflow-auto content">
        <h3> Calificacion de requisitos</h3>

    <!-- Table -->
    @component('components.resultados.listaHabilitados', 
        ['listPostulantes' => $listPostulantes])
    @endcomponent
    <div class="text-center">
        {!! $errors->first('id-evaluador', '<strong class="message-error text-danger">:message</strong>') !!}<br>
        <form class="d-inline" action="{{ route('entregarHabilitados') }}"
            method="POST" id="evaluador-meritos-delete">
            {{ csrf_field() }}
            <input type="hidden"  name="id-evaluador">
            @if($entregado || $publicado)
                <button type="submit" class="btn btn-info" disabled>Entregar Todo</button> 
            @else
                <button type="submit" class="btn btn-info">Entregar Todo</button> 
            @endif   
        </form>
    </div>
    @if ($entregado||$publicado)
    <div class="text-right">
      <button type="button" class="btn btn-secondary">
        <a href="/convocatoria/adm-postulantes/habilitadosPDF" style="color: #FFFF;">PDF</a>
      </button>
    </div>
  @endif
    </div>
@endsection
