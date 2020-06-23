@extends('evaluador.layoutEvaluador')

@section('content-evaluador')
    <div class="m-4 contenido-mis-convocatorias">
        <h3 class="mb-4 text-center">Lista de Mis Convocatorias</h3>
        @foreach ($convs as $conv)
            <div class="card-personal">
                <a class="card-personal-title" href="{{ route('helper.redirect', $conv->id) }}">{{ $conv->titulo }}</a>
                <p class="card-personal-body">{{ $conv->descripcion_convocatoria }}</p>
                <div class="text-center mb-1">
                    <a href="{{ route('helper.redirect.ver', $conv->id) }}" class="btn btn-success btn-sm text-white">Ver</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection