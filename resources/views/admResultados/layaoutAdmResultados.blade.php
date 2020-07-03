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
            <h2 class="text-uppercase title-navbar">titulo convocatoria</h2>
            <ul class="container-list">
                <li class="navbar-item {{ activeMenuConten('convocatoria/adm-habilitados') }}">
                    <a class="link-list" href="{{ route('admHabilitados') }}">Lista Habilitados</a>
                </li>
                <li class="navbar-item {{ activeMenuConten('convocatoria/adm-res-meritos') }}">
                    <a class="link-list" href="{{ route('admResMeritos') }}">Notas de Merito</a>
                </li>
                <li class="navbar-item {{ activeMenuConten('convocatoria/adm-res-conocimientos') }}">
                    <a class="link-list" href="{{ route('admResConocimientos') }}">Notas de Conocimientos</a>
                </li>
                <li class="navbar-item {{ activeMenuConten('convocatoria/adm-asignaciones') }}">
                    <a class="link-list" href="{{ route('admResAsignaciones') }}">Asignacion de Items</a>
                </li>
            </ul>
        </nav>

        @yield('content-adm-resultados')

    </div>
@endsection