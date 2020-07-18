@extends('layout')

@section('content')
    <!-- Divición del contenido de la página -->
    <div class="content-div">
        <!-- Barra de navegación secundario -->
        <nav class="navbar-personal">
            @php
                function activeMenuConten($url) {
                    return request()->is($url)? 'navbar-lateral-active': '';
                }
            @endphp
            <h2 class="title-navbar">{{ $conv->titulo }}</h2>
            @if (auth()->user()->hasRoles(['administrador']))
            <ul class="container-list-ver m-2">
                <li class="navbar-item-ver">
                    <a href="{{ route('admConocimientos') }}" class="link-list navbar-lateral-active">
                        <img src="{{ asset('img/navigation.svg') }}" width="15" height="15" class="mb-1">Registros
                    </a>
                </li>
                <li class="navbar-item-ver mb-2"><a href="{{ route('admHabilitados') }}" class="link-list">Resultados</a></li>
            </ul>
            <ul class="container-list">
                <li class="navbar-item {{ activeMenuConten('convocatoria/adm-conocimientos') }}">
                    <a class="link-list" href="{{ route('admConocimientos') }}">Comision de evaluación de conocimientos</a>
                </li>
                <li class="navbar-item {{ activeMenuConten('convocatoria/adm-meritos') }}">
                    <a class="link-list" href="{{ route('admMeritos') }}">Comision de evaluacion de méritos</a>
                </li>
                <li class="navbar-item {{ activeMenuConten('convocatoria/adm-avisos') }}">
                    <a class="link-list" href="{{ route('admAvisos') }}">Avisos</a>
                </li>
            </ul>
            @endif
            @if (auth()->user()->hasRoles(['secretaria']))
            <ul class="container-list">
                <li class="navbar-item {{ activeMenuConten('convocatoria/adm-postulantes') }}">
                    <a class="link-list" href="{{ route('admPostulantes') }}">Postulantes</a>
                </li>
            </ul>
            @endif 
        </nav>

        @yield('content-adm-convocatoria')

    </div>
@endsection