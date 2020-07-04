@extends('evaluador.layoutEvaluador')

@section('content-evaluador')
    
    <div class="overflow-auto content">

        <div class="contenido-mis-convocatorias">
        <h3>
            Calificacion de meritos
        </h3>
        @component('components.calificaciones.tablaPostulantesMeritos',['postulantes'=>$postulantes])
        @endcomponent
        </div>

        <div class="text-center">
            {!! $errors->first('id-evaluador', '<strong class="message-error text-danger">:message</strong>') !!}<br>
            <form class="d-inline" action="{{ route('entregarMeritos') }}"
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
        @if ($publicado || true)
        <div class="text-right">
          <button type="button" class="btn btn-secondary">
            <a href="/convocatoria/adm-postulantes/notasMeritoPDF" style="color: #FFFF;">PDF</a>
          </button>
        </div>
      @endif
    </div>
    
@endsection