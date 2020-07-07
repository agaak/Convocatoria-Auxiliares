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

    {{-- Datatables --}}
    <link rel="stylesheet" href="{{ asset('css/datatable.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('css/jquery.datatable.css')}}">
    <link rel="stylesheet" href="{{ asset('css/jquery.datatable.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('css/twitter.css')}}">
    <link rel="stylesheet" href="{{ asset('css/datatable.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/group.datatable.css')}}">
    
    {{-- PDF datatable --}}
    <link rel="stylesheet" href="{{ asset('css/datatable.pdf.css')}}">

</head>

<body id="body-completado" class="d-none" onload="cargaCompleta();">

    <script>
        function cargaCompleta() {
            $('#body-completado').removeClass('d-none');
        }
    </script>
    <!-- Barra de navegación principal -->
    <div class="container-body">
        <header class="container-navbar">
            
            <div class="logo-title">
                <a href="/">
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
                            <span class=""></span>
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
                                <p class="text-user">{{ auth()->user()->roles[0]['name'] }}: {{ auth()->user()->name }}</p>
                                @endguest
                            </div>
                          </div>
                    </time>
                </div>
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
                <nav class="navbar navbar-expand-lg navbar-dark container-bar">
                    <a class="navbar-brand" href="#"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse navbar-collapse-color" id="navbarNav">
                        <ul class="navbar-nav">
                            
                            <li class="nav-item">
                                <div class="dropdown">
                                    <a class="nav-link dropdown-toggle {{ activeMenu('convocatoria') }}" href="#" role="button" id="convocatoriaLinks" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Convocatorias
                                    </a>
                                    <div class="dropdown-menu bg-dark p-1" aria-labelledby="convocatoriaLinks">
                                        <a class="dropdown-item {{ activeMenu('convocatoria') }}" href="{{ route('convocatoria.index') }}">Vigentes</a>
                                        <a class="dropdown-item {{ activeMenu('convocatorias-pasadas') }}" href="{{ route('convsPasadas') }}">Pasadas</a>
                                    </div>
                                </div>
                            </li>
                            @if (auth()->check() && auth()->user()->hasRoles(['administrador']))
                                <li class="nav-item">
                                    <div class="dropdown">
                                        <a class="nav-link dropdown-toggle {{ activeMenu('catalogo') }}" href="#" role="button" id="catalogoLinks" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Catálogo
                                        </a>
                                        <div class="dropdown-menu bg-dark p-1" aria-labelledby="catalogoLinks">
                                            <a class="dropdown-item {{ activeMenu('catalogo/docencia') }}" href="{{ route('docencia.index') }}">Docencia</a>
                                            <a class="dropdown-item {{ activeMenu('catalogo/laboratorio') }}" href="{{ route('laboratorio.index') }}">Laboratorio</a>
                                        </div>
                                    </div>
                                </li>
                            @endif
                            @if (auth()->check() && auth()->user()->hasRoles(['evaluador']))
                                <li class="nav-item">
                                    <a class="nav-link {{ activeMenu('evaluador') }}" href="{{ route('evaluador.index') }}">Evaluar</a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link {{ activeMenu('avisos') }}" href="/avisos">Avisos</a>
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
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.es.min.js') }}"></script>
    <script src="{{ asset('js/jquery.timepicker.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <script src="{{ asset('js/es.js') }}"></script>
    

    <!-- Datatables -->
    <script src="{{ asset('js/jquery.datatable.min.js') }}"></script>
    <script src="{{ asset('js/datatable.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/group.datatable.min.js') }}"></script>
    <script src="{{ asset('js/datable.buttons.min.js') }}"></script>
    <script src="{{ asset('js/pdf.make.min.js') }}"></script>
    <script src="{{ asset('js/pdf.make.js') }}"></script>
    <script src="{{ asset('js/datable.buttons.html5.js') }}"></script>



    <script>
        $(document).ready(function() {
            $('#table_id').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
            },"bLengthChange": false,responsive: true,
            order: [[2, 'asc']], 
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#postulantes').DataTable( {
                "pageLength":50,
                responsive: true,
                /* dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        title: 'Lista de habilitados ',
                        orientation: 'portrait',
                        pageSize: 'LEGAL',
                        customize: function ( doc ) {
                        doc.defaultStyle.fontSize = 10,
                        doc.content[1].table.widths = ['30%','10%','15%','25%','15%']
                        }
                    }
                ], */
                "columnDefs": [
                { "orderable": false},
                { "visible": false, "targets": 0 }
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },"bLengthChange": false,
                orderFixed: [[ 0, 'asc' ],[ 3, 'asc' ],[ 2, 'asc' ]],
                rowGroup: {
                    dataSrc: 0,
                },
                
            } );
        } );
    </script>
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>

</html>