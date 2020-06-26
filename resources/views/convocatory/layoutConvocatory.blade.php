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
            <h2 class="text-uppercase title-navbar">nueva convocatoria</h2>
            @if (session()->get('ver'))
                <ul class="container-list-ver m-2">
                    <li class="navbar-item-ver"><a href="" class="link-list {{ activeMenuConten('convocatoria/*') }}">Ver Detalles</a></li>
                    <li class="navbar-item-ver mb-2"><a href="{{ route('listHabilitados') }}" class="link-list">Ver Resultados</a></li>
                </ul>
            @endif
            <ul class="container-list">
                <li class="navbar-item {{ activeMenuConten('convocatoria/requerimientos') }}">
                    <a class="link-list" href="{{ route('requests') }}">Requerimientos</a>
                </li>
                <li class="navbar-item {{ activeMenuConten('convocatoria/requisitos') }}">
                    <a class="link-list" href="{{ route('requirement') }}">Requisitos</a>
                </li>
                <li class="navbar-item {{ activeMenuConten('convocatoria/documentos') }}">
                    <a class="link-list" href="{{ route('documentos') }}">Documentos</a>
                </li>
                <li class="navbar-item {{ activeMenuConten('convocatoria/fechas-importantes') }}">
                    <a class="link-list" href="{{ route('importantDates') }}">Eventos importantes</a>
                </li>
                <li class="navbar-item {{ activeMenuConten('convocatoria/calificacion-meritos') }}">
                    <a class="link-list" href="{{ route('calificacion-meritos.index') }}">Calificación de Meritos</a>
                </li>
                <li class="navbar-item {{ activeMenuConten('convocatoria/calificacion-conocimientos') }}">
                    <a class="link-list" href="{{ route('knowledgeRating') }}">Calificación de Conocimientos</a>
                </li>
            </ul>
        </nav>
 
        @yield('content-convocatory')

    </div>
@endsection