@extends('layout')

@section('content')
    <!-- Divición del contenido de la página -->
    <div class="content-div">
        <div class="bg-dark pl-2 pr-2">
            <div class="mis-convocatorias text-white">
                <h3 class="eva-title">Evaluador</h3>
                @if (request()->is('evaluador'))
                    <a class="menu-link menu-icono" href="#">Mis convocatorias</a>
                @else
                    <a class="menu-link menu-icono" href="{{ route('evaluador.index') }}">Mis convocatorias</a>
                @endif
                <ul class="menu">
                    @foreach ($convs as $conv)
                        <li class="menu-item ml-3"><a class="menu-link" href="{{ route('evaluar.index', $conv->id) }}">{{ $conv->titulo }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="convocatoria-actual">
                @if (request()->is('evaluador/*'))
                    <h3 class="eva-title">Convocatoria actual</h3>
                    <a class="menu-link menu-icono" href="#">Calificar</a>
                    <ul class="menu d-none">
                        <li class="menu-item ml-3"><a class="menu-link" href="#">Requisito</a></li>
                        <li class="menu-item ml-3"><a class="menu-link" href="{{ route('evaluarM.index', $id) }}">Merito</a></li>
                    </ul>
                @endif
            </div>
        </div>
        @yield('content-evaluador')
    </div>
@endsection