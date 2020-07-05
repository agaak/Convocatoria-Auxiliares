<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$titulo_conv}}</title>
    <style>
        #header, #footer {
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
        table,th,td{border: 1px solid black;border-collapse: collapse;}
        tr:nth-child(even) {background-color: #F3F3F3;}
        tr:hover {background-color: #f8f8f8;}
        td{padding: 5px;}
        .table-requests1 {
            padding-top: 20px;
            width: 720px;
            font-size: 15px;
            margin-left: 0;
            margin-right: 0;
        }
        .row_nom{width: 25%}
        .row_ap{width: 25%}
        .row_hab{width: 10%;}
        .row_obs{width: 40%}
        .page_break { page-break-before: auto; }
        body {
            width: 720px;
        }
    </style>
</head>
<body>
<h3 style="text-align: center">  {{$titulo_conv}}</h3>
<h3 style="text-align: center">Lista de habilitados</h3>
    
        @foreach ($listaAux as $aux)
         
        <div class="table-requests1">
            <h3>{{ $aux->nombre_aux}}</h3>
            
            <table >
                <thead>
                <tr>
                <th class="row_ap">Apellido</th>
                <th class="row_nom">Nombre</th>
                <th class="row_hab">Habilitado</th>
                <th class="row_obs">Observaciones</th>
                </tr>
                </thead>
                <tbody>
                    
                    @foreach ($listPostulantes as $postulante)
                    
                        @if ($postulante->nombre_aux==$aux->nombre_aux)
                        <tr>
                        <td>{{ $postulante->apellido }}</td>
                        <td>{{ $postulante->nombre }} </td>
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