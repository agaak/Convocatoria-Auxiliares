@extends('evaluador.layoutEvaluador')

@section('content-evaluador')
    
    <div class="contenido-mis-convocatorias overflow-auto">
        @foreach ($convs as $conv)
            @if ($conv->id == session()->get('convocatoria'))
                <p class="text-center mt-2"><span class="text-uppercase font-weight-bold border-bottom border-dark">{{ $conv->titulo }}</span></p>
            @endif
        @endforeach
        
        <h4 class="mx-4">Calificación de 
            @foreach ($auxsTemsEval as $item)
                @if ($item->id == $id_tem)
                    {{ $item->nombre }} -
                    @foreach ($item['areas'] as $area)
                        @if ($area->id_area == $nom)
                            {{ $area->area }}
                        @endif
                    @endforeach
                @endif    
            @endforeach
        </h4>
        @if($publicado_habilitados)
            @component('components.calificaciones.tablaPostulantesConocByTem',
                ['postulantes'=>$postulantes,'publicado'=>$publicado, 'entregado'=>$entregado])
            @endcomponent
            <div class="text-center">
                {!! $errors->first('id-evaluador', '<strong class="message-error text-danger">:message</strong>') !!}<br>
                <form class="d-inline" action="{{ route('entregarConocimientos',['id' => $id_tem, 'tem' => $nom ]) }}"
                    method="POST" id="evaluador-meritos-delete">
                    {{ csrf_field() }}
                    <input type="hidden"  name="id-evaluador">
                    @if($entregado || $publicado)
                        <button type="submit" class="btn btn-info" disabled>Entregado</button> 
                        <div class="text-right">
                            <button type="button" class="btn btn-secondary">
                            <a href="/evaluador/calificar/conocimiento/{{$id_tem}}/{{$nom}}/pdf" style="color: #FFFF;">PDF</a>
                            </button>
                        </div>
                    @else
                        <button type="submit" class="btn btn-info d-none" id="btn-entregar">Entregar Todo</button> 
                    @endif   
                </form>
            </div>
        @else
            <h5 class="text-center mt-5"><strong>Aun no hay postulantes habilitados</strong></h5>
        @endif
    
    </div>
    
@endsection