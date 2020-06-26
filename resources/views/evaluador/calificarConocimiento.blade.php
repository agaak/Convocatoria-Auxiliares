@extends('evaluador.layoutEvaluador')

@section('content-evaluador')
    
    <div class="overflow-auto content">

        
        <h3>Calificacion de 
            @foreach ($auxsTemsEval as $item)
                @if ($item->id == $id_tem)
                    {{ $item->nombre }}
                @endif    
            @endforeach
        </h3>
        @if ($tipoConv === 1)
            @component('components.calificaciones.tablaPostulantesConocByTem',
                ['postulantes'=>$postulantes])
            @endcomponent 
        @else
            @component('components.calificaciones.tablaPostulantesConocByAux',
                ['postulantes'=>$postulantes])
            @endcomponent 
        @endif
        
    
    </div>
    
@endsection