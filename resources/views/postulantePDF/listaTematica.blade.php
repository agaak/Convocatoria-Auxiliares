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
        .table-requests1 { padding-top: 20px; width: 100%; font-size: 15px; margin-left: 0ch; margin-right: 0ch;}
        .row_name{width: 65%}
        .row_ic{width: 15%;}
        .row_con{width: 20%}
        .page_break { page-break-before: auto; }
        .aprob{background-color: aquamarine;}
    </style>
</head>
<body>
<h3 style="text-align: center">  {{$titulo_conv}} </h3>
<h3 style="text-align: left">{{$nom_tem_db }}</h3>
<div class="table-request1">
    <table>
        <thead>
            <tr>
                <th class="row.ic">CI</th>
                <th class="row.name">Estudiante</th>
                <th class="row.con">Nota</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($postulantes as $item)
                <tr>
                    <td style="font-weight: normal">{{ $item->ci }}</td>
                    <td style="font-weight: normal">{{ $item->apellido }} {{ $item->nombre }}</td>
                    <td style="font-weight: normal">{{ $item->calificacion}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>