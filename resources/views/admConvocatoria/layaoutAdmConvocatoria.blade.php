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
                <li class="navbar-item {{ activeMenuConten('convocatoria/adm-conocimientos') }}">
                    <a class="link-list" href="{{ route('admConocimientos') }}">Comision de evaluación de conocimientos</a>
                </li>
                <li class="navbar-item {{ activeMenuConten('convocatoria/adm-meritos') }}">
                    <a class="link-list" href="{{ route('admMeritos') }}">Comision de evaluacion de méritos</a>
                </li>
                <li class="navbar-item {{ activeMenuConten('convocatoria/adm-postulantes') }}">
                    <a class="link-list" href="{{ route('admPostulantes') }}">Postulantes</a>
                </li>
                <li class="navbar-item {{ activeMenuConten('convocatoria/adm-avisos') }}">
                    <a class="link-list" href="{{ route('admAvisos') }}">Avisos</a>
                </li>
                {{-- <li class="navbar-item {{ activeMenuConten('convocatoria/adm-resultados') }}">
                    <a class="link-list" href="{{ route('admResultados') }}">Resultados</a>
                </li>
                <li class="navbar-item {{ activeMenuConten('convocatoria/adm-asignacion') }}">
                    <a class="link-list" href="{{ route('admAsignacion') }}">Asignacion de Items</a>
                </li> --}}
            </ul>
        </nav>

        @yield('content-adm-convocatoria')

    </div>
@endsection