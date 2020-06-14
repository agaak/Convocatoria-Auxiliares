<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Correo</title>
</head>
<body>
    <h2 class="mx-2 my-2">"Usted fue designado como Evaluador"</h2>
    <p class="mx-2"><strong>{{$datos['nombres']}}</strong> fue designado como evaluador de la {{$datos['titulo']}} </p><br>

    <p style="text-align: center">Su usuario es: <strong>{{$datos['usuario']}} </strong></p>
    <p style="text-align: center">Su contraseña es: <strong>{{$datos['ci']}} </strong></p> <br>

    @foreach ($datos['rol'] as $item)
    <div class="card border-dark mb-3">
        <div class="card-body">
        <p>Tendra el Rol de Evaluador de <strong>{{ $item ['nombre'] }}</strong></p>
        @if ($item ['id'] == 2)
            <p><strong>Las auxiliaturas que se le asigno es:</strong></p>
            @foreach ($datos['auxiliaturas'] as $aux)
                <p>- {{ $aux ['nombre'] }}</p> 
            @endforeach
            <p><strong>Las Tematicas que se le asigno es:</strong></p>
            @foreach ($datos['tematicas'] as $tem)
                <p>- {{ $tem ['nombre'] }}</p>
            @endforeach
        @endif
        </div>
    </div>
    @endforeach
</body>
</html>