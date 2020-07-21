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
            <ul class="container-list-ver m-2">
                <li class="navbar-item-ver"><a href="{{ route('admConocimientos') }}" class="link-list">Gestionar Registros</a></li>
                <li class="navbar-item-ver mb-2">
                    <a href="{{ route('admHabilitados') }}" class="link-list navbar-lateral-active">
                        Gestionar Resultados <img src="{{ asset('img/navigation.svg') }}" width="15" height="15" class="mb-1 ml-2">
                    </a>
                </li>
            </ul>
            <ul class="container-list">
                <li class="navbar-item {{ activeMenuConten('convocatoria/adm-habilitados*') }}">
                    <a class="link-list" href="{{ route('admHabilitados') }}">Lista Habilitados</a>
                </li>
                <li class="navbar-item {{ request()->is('convocatoria/adm-notas-merito*')? 'navbar-lateral-active':
                (request()->is('convocatoria/adm-res-meritos')? 'navbar-lateral-active': '') }}">
                    <a class="link-list" href="{{ route('admResMeritos') }}">Notas de Merito</a>
                </li>
                <li class="navbar-item {{ activeMenuConten('convocatoria/adm-res-conocimientos') }}">
                    <a class="link-list" href="{{ route('admResConocimientos') }}">Notas de Conocimientos</a>
                </li>
                {{-- <li class="navbar-item {{ activeMenuConten('convocatoria/adm-res-nota-final') }}">
                    <a class="link-list" href="{{ route('admResNotaFinal') }}">Notas Finales</a>
                </li> --}}
                <li class="navbar-item {{ activeMenuConten('convocatoria/adm-asignaciones') }}">
                    <a class="link-list" href="{{ route('admResAsignaciones') }}">Asignacion de Auxiliaturas</a>
                </li>
            </ul>
        </nav>

        @yield('content-adm-resultados')

    </div>
@endsection