<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convocatoria de Auxiliares</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('css/styles.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Barra de navegación principal -->
    <div class="container-header">
        <header class="navbar-container">
            <a href="{{ route('home') }}">
                <img src="{{ asset('img/logo.png')}}" width="133" height="133">
            </a>
            <div class="navbar-div">
                <div class="login-container">
                    <a href="" class="login text-white">Iniciar sesión</a>
                </div>
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="#"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav navbar-navbar">
                            <li class="nav-item">
                                <a class="nav-link text-uppercase font-weight-bold text-dark" href="{{ route('convocatory') }}">convocatorias</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-uppercase font-weight-bold text-dark" href="{{ route('results') }}">resultados</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-uppercase font-weight-bold text-dark" href="{{ route('admission') }}">admisión</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
    
        </header>
    
        @yield('content')
    
        <!-- Footer -->
        <footer class="bg-secondary">
            <div class="text-center py-3">© 2020 Copyright:
                <a href="" class="text-uppercase text-white">agaak code</a>
            </div>
        
        </footer>
    </div>
    
        
    <script src="{{ asset('js/jquery-3.5.1.slim.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>

</html>