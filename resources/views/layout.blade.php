<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convocatoria de Auxiliares</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker3.standalone.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Barra de navegación principal -->
    <div class="container-body">
        <header class="container-navbar">
            
            <div class="logo-title">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('img/logo.png')}}" width="55" height="90">
                </a>
                <h1 class="logo-title-body text-uppercase">
                    sistema de convocatorias <br>
                    universidad mayor de san simon
                </h1>
            </div>

            <div class="time-navbar">
                <div class="container-time">
                    <time class="text-white date-time"> {{ date('d-m-Y') }} <br> {{ date('H:i:s') }} </time>
                </div>
                <nav class="navbar navbar-expand-lg navbar-dark container-bar">
                    @php
                        function activeMenu($url) {
                            $direction = '';
                            if (request()->is($url)) {
                                $direction = 'activate';
                            } elseif (request()->is($url.'/*')) {
                                $direction = 'activate';
                            }
                            return $direction;
                        }
                    @endphp
                    <a class="navbar-brand" href="#"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse navbar-collapse-color" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link {{ activeMenu('convocatoria') }}" href="{{ route('convocatory') }}">Convocatorias</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ activeMenu('resultados') }}" href="{{ route('results') }}">Resultados</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ activeMenu('admision') }}" href="{{ route('proceduresDocs') }}">Tramites y documentos</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        
        </header>
        
    
        @yield('content')
    
        <!-- Footer -->
        <footer class="footer-personal">
            <div class="text-center py-3">© 2020 Copyright:
                <a href="" class="text-uppercase text-white">agaak code</a>
            </div>
        
        </footer>
    </div>
        
    <script src="{{ asset('js/jquery-3.5.1.slim.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.es.min.js') }}"></script>
    <script src="{{ asset('js/jquery.timepicker.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>

</html>