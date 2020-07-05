@extends('evaluador.layoutEvaluador')

@section('content-evaluador')
    
    <div class="contenido-mis-convocatorias overflow-auto">
        @foreach ($convs as $conv)
            @if ($conv->id == session()->get('convocatoria'))
                <p class="text-center"><span class="text-uppercase font-weight-bold border-bottom border-dark">{{ $conv->titulo }}</span></p>
            @endif
        @endforeach
        <h3>
            Calificacion de meritos
        </h3>
        @component('components.calificaciones.tablaPostulantesMeritos',['postulantes'=>$postulantes])
        @endcomponent

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
        @if ($publicado || $entregado)
        <div class="text-right">
          <button type="button" class="btn btn-secondary">
            <a href="/convocatoria/adm-postulantes/notasMeritoPDF" style="color: #FFFF;">PDF</a>
          </button>
        </div>
      @endif
    </div>
    
@endsection