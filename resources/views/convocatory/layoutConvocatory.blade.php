@extends('layout')

@section('content')
    <!-- Divición del contenido de la página -->
    <div class="content-div">
        <!-- Barra de navegación secundario -->
        <nav class="navbar navbar-expand-lg navbar-light navbar-margin">
            <ul class="navbar-nav flex-column navbar-content">
                <h2 class="txt-uppercase">nueva convocatoria</h2>
                <li class="nav-item">
                    <a class="nav-link text-uppercase text-dark" href="{{ route('titleDescription') }}">título y descripción</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase text-dark" href="{{ route('request') }}">requerimientos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase text-dark" href="{{ route('requirement') }}">requisitos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase text-dark" href="{{ route('importantDates') }}">fechas importantes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase text-dark" href="{{ route('meritRating') }}">calificación de meritos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase text-dark" href="{{ route('knowledgeRating') }}">calificación de conocimientos</a>
                </li>
            </ul>
        </nav>
        
        @yield('content-convocatory')
                
    </div>
@endsection