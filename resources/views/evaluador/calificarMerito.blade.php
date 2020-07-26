@extends('evaluador.layoutEvaluador')

@section('content-evaluador')
    
    <div class="contenido-mis-convocatorias overflow-auto">
        @foreach ($convs as $conv)
            @if ($conv->id == session()->get('convocatoria'))
                <p class="text-center"><span class="text-uppercase font-weight-bold border-bottom border-dark">{{ $conv->titulo }}</span></p>
            @endif
        @endforeach
        <h3>
            Calificación de Méritos
        </h3>
        @component('components.calificaciones.tablaPostulantesMeritos',
                ['postulantes'=>$postulantes, 'publicado'=> $publicado])
        @endcomponent

        @if (session('revisando')) 
        <div class="text-center">
            <strong class="message-error text-danger"> {{ session('revisando') }}</strong>
        </div>
        @endif

        <div class="text-center">
            {!! $errors->first('id-evaluador', '<strong class="message-error text-danger">:message</strong>') !!}<br>
            <form class="d-inline" action="{{ route('entregarMeritos') }}"
                method="POST" id="evaluador-meritos-delete">
                {{ csrf_field() }}
                <input type="hidden"  name="id-evaluador">
                @if(count($postulantes)>0)
                @if($entregado || $publicado)
                    <button type="submit" class="btn btn-info" disabled>Entregado</button> 
                @else
                    <button type="submit" id="btn-entregarMeritos" class="btn btn-info">Entregar Todo</button> 
                @endif
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