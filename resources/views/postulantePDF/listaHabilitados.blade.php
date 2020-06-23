<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>lista de habilitados</title>
    <style>
        #header,
        #footer {
            position: fixed;
            left: 0;
            right: 0;
            color: #242D47;
            font-size: 13px;
        }
        #header {
            text-align: center;
            top: 0;
            border-bottom: 0.4px solid #242D47;
        }
        #footer {
        bottom: 0;
        border-top: 0.1pt solid #242D47;
        font-size: 14px;
        }
        .page-number:before {
        content: "Pagina " counter(page);
        }
        table {
            width: 100%;
        }
        th {
            padding: 5px;
            text-align:left;
           background-color: #242D47;
            color: white;
        }
        tr:nth-child(even) {background-color: #BEBBFF;}
        tr:hover {background-color: #f8f8f8;}
        .table-requests1 {
            padding-top: 20px;
            width: 100%;
            font-size: 15px;
            margin-left: 0ch;
            margin-right: 0ch;
        }
        .page_break { page-break-before: auto; }
        
    </style>
</head>
<body>
    <h2 style="text-align: center"> Lista de habilitados</h2>
    
        @foreach ($listaAux as $aux)
         
        <div class="table-requests1">
            <h3>{{ $aux->nombre_aux}}</h3>
            
            <table >
                <thead>
                <tr>
                <th>Nombre</th>
                <th>Habilitado</th>
                <th>Observaciones</th>
                </tr>
                </thead>
                <tbody>
                    
                    @foreach ($listPostulantes as $postulante)
                    
                        @if ($postulante->nombre_aux==$aux->nombre_aux)
                        <tr>
                        <td>{{ $postulante->nombre }} {{ $postulante->apellido }}</td>
                            @if ($postulante->habilitado===null)
                                <td >-</td>
                            @else
                            @if ($postulante->habilitado)
                                <td >Si</td>
                            @else
                                <td >No</td>
                            @endif
                            @endif
                            <td>{{ $postulante->observacion}}</td>
                        </tr>
                        @endif
                            
                    @endforeach
                
                </tbody>
            </table>
        </div>
        <div id="footer">
            <div class="page-number"></div>
        </div>
        <div class="page_break"></div>
        @endforeach
</body>
</html>