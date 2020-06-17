@extends('evaluador.layoutEvaluador')

@section('content-evaluador')
    <div class="m-4">
        <h3 class="mb-4 text-center">Lista de Mis Convocatorias</h3>
        @foreach ($convs as $conv)
            <div class="card-personal">
                <a class="card-personal-title" href="{{ route('helper.redirect', $conv->id) }}">{{ $conv->titulo }}</a>
                <p class="card-personal-body">{{ $conv->descripcion_convocatoria }}</p>
            </div>
        @endforeach
    </div>
    
@endsection