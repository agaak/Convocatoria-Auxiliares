<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title></title>
    <style>

        .text-center {
            text-align: center;
        }
        .font-weight-bold {
            font-weight: bold;
            border-bottom: 1px solid black;
        }
        .font-weight-normal {
            font-weight: inherit;
        }
        body {
            width: 720px;
        }

        h1 {
            margin-top: 0;
        }

        h3 {
            margin-top: .5rem;
            margin-bottom: .5rem;
        }

    </style>
</head>
<body>
    <h1 class="text-center"><span class="font-weight-bold">ROTULO DEL POSTULANTE</span></h1>

    <h3 class="font-weight-normal"><span class="font-weight-bold">COD. ROTULO:</span> {{ $postulante->rotulo }}</h3>
    <h3 class="font-weight-normal"><span class="font-weight-bold">NOMBRE COMPLETO:</span> {{ $postulante->nombre }} {{ $postulante->apellido }}</h3>
    <h3 class="font-weight-normal"><span class="font-weight-bold">CORREO ELECTRONICO:</span> {{ $postulante->correo }}</h3>
    <h3 class="font-weight-normal"><span class="font-weight-bold">DIRECCION:</span> {{ $postulante->direccion }}</h3>
    <h3 class="font-weight-normal"><span class="font-weight-bold">COD. SIS:</span> {{ $postulante->cod_sis }}</h3>
    <h3 class="font-weight-normal"><span class="font-weight-bold">TELEFONO:</span> {{ $postulante->telefono }}</h3>
    <h3 class="font-weight-normal"><span class="font-weight-bold">CI:</span> {{ $postulante->ci }}</h3>

    <br>

    <h3><span class="font-weight-bold">AUXILIATURAS POSTULADAS:</span></h3>
    <ul>
        @foreach ($auxiliaturas as $item)
            <li><h3 class="font-weight-normal">{{ $item->nombre_aux }}</h3></li>
        @endforeach
    </ul>
</body>
</html>