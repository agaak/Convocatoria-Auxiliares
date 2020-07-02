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

    </div>
    
@endsection