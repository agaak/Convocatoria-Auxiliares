<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convocatoria de Auxiliares</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker3.standalone.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/b-1.6.2/b-html5-1.6.2/rg-1.1.2/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.1.2/css/rowGroup.bootstrap4.min.css">
    
</head>

<body>
    <!-- Barra de navegación principal -->
    <div class="container-body">
        <header class="container-navbar">
            
            <div class="logo-title">
                <a href="{{ route('convocatoria.index') }}">
                    <img src="{{ asset('img/logo.png')}}" width="55" height="90">
                </a>
                <h1 class="logo-title-body text-uppercase">
                    sistema de convocatorias <br>
                    universidad mayor de san simon
                </h1>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
            <div class="time-navbar">
                <div class="container-time">
                    <time class="text-white date-time">
                        <div class="btn-group dropleft">
                            <button type="button" class="btn btn-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @guest
                                <img src="{{ asset('img/guest.svg') }}" width="30" height="30" class="svg-color">
                                @else
                                <img src="{{ asset('img/user.png') }}" width="30" height="30">
                                @endguest
                            </button>
                            <div class="dropdown-menu color-fondo px-1">
                                @guest
                                <a class="dropdown-item nav-link my-1 login {{ activeMenu('login') }}" href="{{ route('login') }}">Iniciar sesión</a>
                                {{-- <a class="dropdown-item nav-link my-1 login {{ activeMenu('register') }}" href="{{ route('register') }}">Registrar</a> --}}
                                @else
                                <a class="dropdown-item nav-link login" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a>
                                @endguest
                            </div>
                          </div>
                    </time>
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

                    @if (auth()->check())
                        @if (!auth()->user()->hasRoles(['evaluador']))
                            <a class="navbar-brand" href="#"></a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse navbar-collapse-color" id="navbarNav">
                                <ul class="navbar-nav">
                                    <li class="nav-item">
                                        <a class="nav-link {{ activeMenu('convocatoria') }}" href="{{ route('convocatoria.index') }}">Convocatorias</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ activeMenu('resultados') }}" href="{{ route('results') }}">Resultados</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ activeMenu('admision') }}" href="{{ route('proceduresDocs') }}">Tramites y documentos</a>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    @else
                        <a class="navbar-brand" href="#"></a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse navbar-collapse-color" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link {{ activeMenu('convocatoria') }}" href="{{ route('convocatoria.index') }}">Convocatorias</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ activeMenu('resultados') }}" href="{{ route('results') }}">Resultados</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ activeMenu('admision') }}" href="{{ route('proceduresDocs') }}">Tramites y documentos</a>
                                </li>
                            </ul>
                        </div>
                    @endif
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
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.es.min.js') }}"></script>
    <script src="{{ asset('js/jquery.timepicker.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <script src="{{ asset('js/es.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>

    <!-- Datatables -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/rowgroup/1.1.2/js/dataTables.rowGroup.min.js"></script>
    
    <script>
    $(document).ready(function() {
        $('#table_id').DataTable({
          "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
          },"bLengthChange": false
          
        });
      });
    </script>

    <script>
        $(document).ready(function() {
        $('#example').DataTable( {
            
            "columnDefs": [
            { "visible": false, "targets": 0 }
            ],
            "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
          },"bLengthChange": false,
            //order: [[0, 'asc']], 
            orderFixed: [ 0, 'asc' ],
            rowGroup: {
                dataSrc: 0
            }
        } );
    } );
    </script>
</body>

</html>