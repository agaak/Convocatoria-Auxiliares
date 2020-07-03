<div class="table-requests1" >
    <table class="table table-striped table-bordered" style="width:100%" style="text-align:left">
    <thead class="thead-dark">
        <tr> 
        <th style="font-weight: normal" scope="col">N°</th>
        <th style="font-weight: normal" scope="col">CI</th>
        <th style="font-weight: normal" scope="col">Apellidos</th>
        <th style="font-weight: normal" scope="col">Nombres</th>
        <th style="font-weight: normal" scope="col">Auxiliatura</th>
        <th style="font-weight: normal" scope="col">Habilitado</th>
        <th style="font-weight: normal" scope="col">Observacion</th>
        @if (auth()->check())
            @if (auth()->user()->hasRoles(['evaluador']))
                <th style="font-weight: normal" scope="col">Calificar</th>    
            @else
                <th style="font-weight: normal" scope="col">Ver Detalles</th> 
            @endif
        @else
            <th style="font-weight: normal" scope="col">Ver Detalles</th>
        @endif
        </tr>
    </thead>
    <tbody style="background-color: white">
        @php $num=1; @endphp
        @foreach($listPostulantes as $item)
        @php $tam = count($item->nombre_aux); $cont = 0; @endphp
            <tr>
            <td scope="col" style="vertical-align: middle;" rowspan="{{ $tam }}">{{ $num++ }}</td>
            <td scope="col" style="vertical-align: middle;" rowspan="{{ $tam }}">{{ $item->ci }}</td>
            <td scope="col" style="vertical-align: middle;" rowspan="{{ $tam }}">{{ $item->apellido }}</td>
            <td scope="col" style="vertical-align: middle;" rowspan="{{ $tam }}">{{ $item->nombre }}</td>
            @foreach ($item->nombre_aux as $auxs_post)
                @if($cont++ == 0)
                    <td >{{$auxs_post->nombre_aux}}</td>
                    @if ($auxs_post->habilitado === null)
                        <td class="text-center">-</td>
                    @else
                        @if ($auxs_post->habilitado)
                        <td class="text-center">Si</td>
                        @else
                        <td class="text-center">No</td>
                        @endif
                    @endif
                    <td >{{ $auxs_post->observacion }}</td>  
                @endif 
            @endforeach
            @if (auth()->check())
                @if (auth()->user()->hasRoles(['evaluador']))
                    <td class="table-light text-center" scope="col" rowspan="{{$tam}}" style="vertical-align: middle;">
                        <a class="options" href="{{ route('calificarRequisito.index', $item->id) }}">
                        <img src="{{ asset('img/pen.png') }}" width="20" height="25"></a>
                    </td>  
                @else
                    <td class="table-light text-center" scope="col" rowspan="{{$tam}}" style="vertical-align: middle;">
                        <a class="options" href="{{ route('admHabilitadosPost', $item->id) }}">Ver</a>
                    </td>
                @endif
            @else 
                <td class="table-light text-center" scope="col" rowspan="{{$tam}}" style="vertical-align: middle;">
                    <a class="options" href="{{ route('admHabilitadosPost', $item->id) }}">Ver</a>
                </td>
            @endif
            </tr>
            @php $cont = 0; @endphp
            @foreach ($item->nombre_aux as $auxs_post)
                @if($cont++ > 0)
                <tr>
                <td >{{$auxs_post->nombre_aux}}</td>
                @if ($auxs_post->habilitado === null)
                        <td class="text-center">-</td>
                        
                    @else
                    @if ($auxs_post->habilitado)
                    <td class="text-center">Si</td>
                    @else
                    <td class="text-center">No</td>
                    @endif
                    
                @endif 
                <td >{{ $auxs_post->observacion }}</td> 
                </tr>   
                @endif
            @endforeach
        @endforeach
    </tbody>
    </table>
</div>