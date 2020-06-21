@extends('layout')

@section('content')
    <!-- Divición del contenido de la página -->
    <div class="content-div">
        <div class="bg-dark pl-2 pr-2 mis-convocatorias">
            <div class="text-white">
                <h3 class="eva-title">Evaluador {{ auth()->user()->name }}</h3>
                <a class="menu-link menu-icono" href="{{ request()->is('evaluador')? '#': route('evaluador.index') }}">Mis convocatorias</a>
                <ul class="menu">
                    @foreach ($convs as $conv)
                        <li class="menu-item ml-3"><a class="menu-link" href="{{ route('helper.redirect', $conv->id) }}">{{ $conv->titulo }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="convocatoria-actual">
                @if (request()->is('evaluador/calificar*'))
                    <h3 class="eva-title"><a class="text-white text-decoration-none" href="{{ route('calificar.index') }}">Convocatoria actual</a></h3>
                    <ul class="menu">
                    @foreach ($roles as $rol)
                        @if ($rol->nombre == 'Meritos')
                            <li class="menu-item"><a class="menu-link" href="#">Requisito</a></li>
                            <li class="menu-item"><a class="menu-link" href="{{ route('calificarMerito.index') }}">Merito</a></li>
                        @endif
                        @if ($rol->nombre == 'Conocimientos')
                            <li class="menu-item">
                                <a class="menu-link menu-icono btn-2" href="#">{{ $tipoConv === 1? 'Temáticas': 'Auxiliaturas' }}</a>
                                <ul class="menu menu-2 {{ request()->is('evaluador/calificar')? 'd-none': 
                                request()->is('evaluador/calificar/merito')? 'd-none': ''}}">
                                    @foreach ($auxsTemsEval as $item)
                                        @if ($tipoConv === 1) 
                                            <li class="menu-item ml-3">
                                                <a class="menu-link" href="{{ route('calificarConoc.index',['id' => $item->id, 'tem' => 'todos']) }}">
                                                    {{ $item->nombre }}
                                                </a>
                                            </li>
                                        @else 
                                            <li class="menu-item ml-3">
                                                <a class="menu-link menu-icono btn-3" href="#">{{ $item->nombre }}</a>
                                                <ul class="menu menu-3">
                                                    <li class="menu-item ml-3">
                                                        <a class="menu-link" href="{{ route('calificarConoc.index',['id' => $item->id, 'tem' => 'oral']) }}">
                                                            Examen Oral
                                                        </a>
                                                    </li>
                                                    <li class="menu-item ml-3">
                                                        <a class="menu-link" href="{{ route('calificarConoc.index',['id' => $item->id, 'tem' => 'escrito']) }}">
                                                            Examen Escrito
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                            
                        @endif
                        
                    @endforeach
                    
                    
                @endif
            </div>
        </div>
        @yield('content-evaluador')
    </div>
@endsection