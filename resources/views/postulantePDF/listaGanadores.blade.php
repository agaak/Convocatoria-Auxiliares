<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$titulo_conv}}</title>
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
            text-align: left;
            top: 0;
            border-bottom: 0.4px solid #242D47;
        }
        #footer {
        bottom: 0;
        border-top: 0.1pt solid #242D47;
        font-size: 13px;
        }
        .page-number:before {
        content: "Pagina " counter(page);
        }
        table {
            width: 100%;
        }
        table,th,td{border: 1px solid black;border-collapse: collapse;}
        th {padding: 5px; text-align:left; background-color: #242D47; color: white;}
        td{padding: 5px;}
        tr:nth-child(even) {background-color: #F3F3F3;}
        tr:hover {background-color: #f8f8f8;}
        .table-requests1 { padding-top: 20px; width: 720px; font-size: 15px;}
        .row_name{width: 26%}
        .row_nro{width: 5%}
        .row_ci{width: 15%;}
        .row_nota{width: 15%}
        .row_ap{width: 30%}
        .row_item{width: 9%}
        .page_break { page-break-before: auto; }
    </style>
</head>
<body>
<h3 style="text-align: center">  {{$titulo_conv}}</h3>
<h3 style="text-align: center">Lista de ganadores</h3>
    @foreach ($listaAux as $auxiliatura)
        <div class="table-requests1">
            <h3>{{ $auxiliatura->nombre_aux}}</h3>
                <table >
                    <thead style="text-align: center">
                    <tr>
                        <th style="text-align: center" class="row_nro">#</th>
                        <th style="text-align: center" class="row_ci">CI</th>
                        <th style="text-align: center" class="row_name">Apellidos</th>
                        <th style="text-align: center" class="row_name">Nombre</th>
                        <th style="text-align: center" class="row_con">Nota</th>
                        <th style="text-align: center" class="row_fin"># items</th>
                    </tr>
                    </thead>
                    <tbody style="text-align: center">
                        @php $num = 1  @endphp
                        @if($listaPost->has($auxiliatura->id))
                          @foreach ($listaPost[$auxiliatura->id] as $postulante)
                          @if ($postulante->item!==null)
                            <tr>
                            <td style="font-weight: normal">{{ $num++ }}</td>
                            <td style="font-weight: normal">{{ $postulante->ci}}</td>
                            <td style="font-weight: normal">{{ $postulante->apellido}} </td>
                            <td style="font-weight: normal">{{ $postulante->nombre}}</td>
                            <td style="font-weight: normal">{{ $postulante->calificacion }}</td>
                                @if ($postulante->item==0)
                                    <td style="font-weight: normal">No quiso</td>
                                    @else
                                    <td style="font-weight: normal">{{ $postulante->item }}</td>
                                @endif
                            </tr>
                            @endif
                          @endforeach
                        @endif
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