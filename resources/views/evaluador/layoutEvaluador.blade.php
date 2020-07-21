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
                    @if($conv->publicado)
                        <li class="menu-item ml-3">
                            <a class="menu-link"href="{{ route('helper.redirect', $conv->id) }}">
                                Convocatoria para auxiliares de {{ $conv->id_tipo_convocatoria === 1? 'laboratorio': 'docencia' }} de la gestion {{ $conv->gestion }}
                            </a>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="convocatoria-actual">
                @if (request()->is('evaluador/calificar*') || request()->is('evaluador/merito*'))
                    <h3 class="eva-title"><a class="text-white text-decoration-none" href="#">Convocatoria Actual</a></h3>
                    <ul class="menu">
                    @foreach ($roles as $rol)
                        @if ($rol->nombre == 'Meritos')
                            <li class="menu-item"><a class="menu-link" href="{{ route('calificarRequisitosPost.index') }}">Requisito</a></li>
                            <li class="menu-item"><a class="menu-link" href="{{ route('calificarMerito.index') }}">Merito</a></li>
                        @endif
                        @if ($rol->nombre == 'Conocimientos')
                            <li class="menu-item">
                                <a class="menu-link menu-icono btn-2" href="#">Temáticas</a>
                                <ul class="menu menu-2 {{ request()->is('evaluador/calificar')? 'd-none':
                                (request()->is('evaluador/calificar/merito*')? 'd-none':
                                ((request()->is('evaluador/calificar/requisitos*')? 'd-none': 
                                (request()->is('evaluador/merito*')? 'd-none': ''))))}}">
                                    @foreach ($auxsTemsEval as $item)
                                        <li class="menu-item ml-3">
                                            <a class="menu-link menu-icono btn-3" href="#">{{ $item->nombre }}</a>
                                            <ul class="menu menu-3">
                                                @foreach ($item['areas'] as $area)
                                                    <li class="menu-item ml-3">
                                                        <a class="menu-link" href="{{ route('calificarConoc.index',['id' => $item->id, 'tem' => $area->id_area ]) }}">
                                                            {{  $area->area }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
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