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

    </div>
@endsection
