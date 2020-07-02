@extends('layout')

@section('content')
    <div class="overflow-auto content">
        <h3 class="text-uppercase text-left">Avisos</h3>
        @foreach($listAvisos as $aviso)
            <div class="list-cards">
                <div class="card">
                    <div class="card-header">{{ $aviso->titulo }}</div>
                    <div class="card-body"><p>{{ $aviso->descripcion }}</p></div>
                    <div class="card-footer text-muted p-1">publicado: {{ $aviso->updated_at }}</div>
                    <div class="btn-home">
                        <a href="" class="btn btn-info">Ir a convocatoria</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection