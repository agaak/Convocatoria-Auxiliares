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
            <ul class="container-list">
                <li class="navbar-item {{ activeMenuConten('convocatoria/titulo-descripcion') }}">
                    <a class="link-list" href="{{ route('titleDescription') }}">Título y Descripción</span></a>
                </li>
                <li class="navbar-item {{ activeMenuConten('convocatoria/requerimientos') }}">
                    <a class="link-list" href="{{ route('request') }}">Requerimientos</a>
                </li>
                <li class="navbar-item {{ activeMenuConten('convocatoria/requisitos') }}">
                    <a class="link-list" href="{{ route('requirement') }}">Requisitos</a>
                </li>
                <li class="navbar-item {{ activeMenuConten('convocatoria/fechas-importantes') }}">
                    <a class="link-list" href="{{ route('importantDates') }}">Fechas Importantes</a>
                </li>
                <li class="navbar-item {{ activeMenuConten('convocatoria/calificacion-meritos') }}">
                    <a class="link-list" href="{{ route('meritRating') }}">Calificación de Meritos</a>
                </li>
                <li class="navbar-item {{ activeMenuConten('convocatoria/calificacion-conocimientos') }}">
                    <a class="link-list" href="{{ route('knowledgeRating') }}">Calificación de Conocimientos</a>
                </li>
            </ul>
        </nav>
        
        @yield('content-convocatory')
                
    </div>
@endsection