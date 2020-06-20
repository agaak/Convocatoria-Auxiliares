@extends('evaluador.layoutEvaluador')

@section('content-evaluador')
    
    <div class="overflow-auto content">


        <h2> Calificacion de conocimientos</h2>
        
        <h3>Calificacion 
            @foreach ($auxsTemsEval as $item)
                @if ($item->id == $id_tem)
                    {{ $item->nombre }}
                @endif    
            @endforeach
        </h3>

        @component('components.calificaciones.tablaPostulantesConoc',
            ['postulantes'=>$postulantes])
        @endcomponent
    
    </div>
    
@endsection