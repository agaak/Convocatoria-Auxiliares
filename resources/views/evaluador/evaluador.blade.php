@extends('evaluador.layoutEvaluador')

@section('content-evaluador')
    <div class="m-4 contenido-mis-convocatorias">
        <h3 class="mb-4">Mis Convocatorias</h3>
        @foreach ($convs as $conv)
        @if($conv->publicado)
            <div class="card-personal">
                <a class="card-personal-title border" href="{{ route('helper.redirect', $conv->id) }}">{{ $conv->titulo }}</a>
                <p class="card-personal-body">{{ $conv->descripcion_convocatoria }}</p>
                <div class="text-right mb-2 mr-3">
                    <a href="{{ route('helper.redirect.ver', $conv->id) }}" class="btn btn-info btn-sm text-white text">Ver convocatoria</a>
                </div>
            </div>
            @endif
        @endforeach
    </div>
@endsection