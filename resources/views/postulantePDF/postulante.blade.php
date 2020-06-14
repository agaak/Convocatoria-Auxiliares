<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title></title>
    <style>
        
        .container {
            margin: 0 auto;
        }
        .my-5 {
            margin-top: 2rem;
        }

        .text-center {
            text-align: center;
        }
        .font-weight-bold {
            font-weight: bold;
        }

    </style>
</head>
<body>
    <div class=" container my-5 text-center">
        <h1 class="font-weight-bold">{{ $postulante->nombre }} {{ $postulante->apellido }}</h1>
        <h2 class="font-weight-bold">{{ $postulante->direccion }}</h2>
        <h2 class="font-weight-bold">{{ $postulante->telefono }}</h2>
        <h2 class="font-weight-bold">{{ $postulante->correo }}</h2>
        <h2 class="font-weight-bold">{{ $postulante->ci }}</h2>
        <br>
        @foreach ($auxiliaturas as $item)
            <span class="font-weight-bold" style="font-size: 25px">{{$item->cod_aux}}</span>
        @endforeach
        <br>
        <br>
        @foreach ($auxiliaturas as $item)
            <h2 class="font-weight-bold">{{ $item->nombre_aux }}</h2>
        @endforeach
    </div>
</body>
</html>