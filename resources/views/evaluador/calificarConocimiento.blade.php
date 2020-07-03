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
        
        <div class="text-center">
            {!! $errors->first('id-evaluador', '<strong class="message-error text-danger">:message</strong>') !!}<br>
            <form class="d-inline" action="{{ route('entregarConocimientos',['id' => $id_tem, 'tem' => $nom ]) }}"
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