@extends('evaluador.layoutEvaluador')

@section('content-evaluador')
    
    <div class="overflow-auto content">

        <div class="contenido-mis-convocatorias">
        <h2>
            Calificacion de meritos
        </h2>
        <h3>
            Calificacion
        </h3>
        @component('components.calificaciones.tablaPostulantesMeritos',['postulantes'=>$postulantes])
        @endcomponent
        </div>
    </div>
    
@endsection