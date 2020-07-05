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
        table,th,td{
            border: 1px solid black;
            border-collapse: collapse;
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
        td{
            padding: 5px;
        }
        tr:nth-child(even) {background-color: #F3F3F3;}
        tr:hover {background-color: #f8f8f8;}
        .table-requests1 {
            padding-top: 20px;
            width: 720px;
            font-size: 15px;
            margin-left: 0;
            margin-right: 0;
        }
        .row_ci{width: 15%}
        .row_name{width: 30%}
        .row_ap{width: 30%}
        .row_mer{width: 15%}
        .page_break { page-break-before: auto; }
        .aprob{background-color: aquamarine;}
        body {
            width: 720px;
        }
    </style>
</head>
<body>
<h3 style="text-align: center">  {{$titulo_conv}}</h3>
<h3 style="text-align: center">Notas de meritos</h3>
<div class="table-requests1">
    <table>
        <thead>
            <tr>
            <th class="row_ci">CI</th>    
            <th class="row_name">Apellido</th>
            <th class="row_name">Nombre</th>
            <th class="row_con">Nota final meritos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listaPost as $item)
            <tr>
                <td style="font-weight: normal">{{ $item->ci}}</td>
                <td style="font-weight: normal">{{ $item->apellido }} </td>
                <td style="font-weight: normal">{{ $item->nombre }}</td>
                <td style="font-weight: normal">{{ $item->nota }} </td>
            </tr>
                    
            @endforeach
        </tbody>
        </table>
        <div id="footer">
            <div class="page-number"></div>
        </div>
            
</body>
</html>