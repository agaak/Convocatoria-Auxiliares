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
            <h2 class="text-uppercase title-navbar">convocatoria actual</h2>
            <ul class="container-list-ver m-2">
                <li class="navbar-item-ver"><a href="{{ route('requests') }}" class="link-list">Ver Detalles</a></li>
                <li class="navbar-item-ver mb-2"><a href="{{ route('listHabilitados') }}" class="link-list {{ activeMenuConten('convocatoria/*') }}">Ver Resultados</a></li>
            </ul>
            <ul class="container-list">
                <li class="navbar-item {{ activeMenuConten('convocatoria/lista-habilitados') }}">
                    <a class="link-list" href="{{ route('listHabilitados') }}">Lista Habilitados</a>
                </li>
                <li class="navbar-item {{ activeMenuConten('convocatoria/notas-merito') }}">
                    <a class="link-list" href="{{ route('notasMerito') }}">Notas de Merito</a>
                </li>
                <li class=" {{ activeMenuConten('convocatoria/notas-conocimiento*') }}">
                    <a class="link-list" href="#">Notas de Conocimiento</a>
                </li>
                <li class="navbar-item ml-3 mt-1 {{ activeMenuConten('convocatoria/notas-conocimiento-tematica') }}">
                    <a class="link-list" href="{{ route('notasTematica') }}">Notas por Temática</a>
                </li>
                <li class="navbar-item ml-3 {{ activeMenuConten('convocatoria/notas-conocimiento-aux') }}">
                    <a class="link-list" href="{{ route('notasAuxiliatura') }}">Notas por Auxiliatura</a>
                </li>
                <li class="navbar-item {{ activeMenuConten('convocatoria/notas-finales') }}">
                    <a class="link-list" href="{{ route('notasFinales') }}">Notas Finales</a>
                </li>
            </ul>
        </nav>
 
        @yield('content-resultados')

    </div>
@endsection