<!DOCTYPE html>
<html lang="es">
<head>
    <title>Error</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css')}}">
</head>
<body>
    <div class="error-500">
        <div class="astronauta">
            <h1 class="text-error">Error en la página</h1>
        </div>
        <p>A causa del error, si usted tenia una sesión activa entonces se cerrará.</p>
        <h2>Causas:</h2>
        <p>* Si usted es un evaluador, no tiene convocatorias asignadas.</p>
        <a href="{{ route('convocatoria.index') }}">Ir a la página pricipal</a><br><br>
        <a href="{{ route('login') }}">Ir a iniciar de sesión</a>

    </div>
</body>
</html>