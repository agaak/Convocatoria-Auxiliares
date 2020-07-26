<div class="table-requests" >
    <table class="table table-striped table-bordered" style="width:100%" style="text-align:left">
    <thead class="thead-dark text-center">
        <tr> 
        <th style="font-weight: normal" scope="col">#</th>
        <th style="font-weight: normal" scope="col">CI</th>
        <th style="font-weight: normal" scope="col">Apellidos</th>
        <th style="font-weight: normal" scope="col">Nombres</th>
        <th style="font-weight: normal" scope="col">Auxiliatura</th>
        <th style="font-weight: normal" scope="col">Habilitado</th>
        <th style="font-weight: normal" scope="col">Observacion</th>
        @if (auth()->check())
            @if (auth()->user()->hasRoles(['evaluador']))
                @if (!session()->get('ver'))
                @if (!$publicado)
                    <th style="font-weight: normal" scope="col">Calificar</th> 
                @endif @endif
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
                    @if (!session()->get('ver'))
                        @if (!$publicado)
                            @if ($item->calificando_requisito)
                                <td class="table-light text-center" scope="col" rowspan="{{$tam}}" style="vertical-align: middle;">
                                    <a class="options" id="{{'btn-calificar'.$item->id}}" onclick="calificarRequisito({{$item->id}})" href="{{ route('calificarRequisito.index', $item->id) }}">
                                    <img src="{{ asset('img/pen.png') }}" width="25" height="25"></a>
                                </td>    
                            @else
                                <td class="table-light text-center" scope="col" rowspan="{{$tam}}" style="vertical-align: middle;">
                                    <a class="options" href="{{ route('calificarRequisito.index', $item->id) }}">
                                    <img src="{{ asset('img/pen.png') }}" width="25" height="25"></a>
                                </td> 
                            @endif
                        @endif 
                    @endif
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