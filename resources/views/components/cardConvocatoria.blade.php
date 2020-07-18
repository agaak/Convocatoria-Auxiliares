<div class="col-md-4 mb-3 mt-3">
    <div class="card text-center" style="height: 375px">
        <div class="card-header"
            style="font-size:16px; background: #0A091B; color: white; height: 65px;">
            {{ $convo->titulo }}
        </div>
        @php
            $meses = ["Enero", "Febrero", "Marzo", "Abril" ,"Mayo" ,"Junio" ,"Julio" ,"Agosto" ,"Septiembre" ,"Octubre" ,"Noviembre" ,"Diciembre"];
        @endphp
        <div class="card-body overflow-auto" data-spy="scroll" style="height: 100px">
            <p class="card-text">{{ $convo->descripcion_convocatoria }}</p>
        </div>
        <div class="card-footer p-0">
            <p class="m-0 text-muted font-weight-bold bg-light">
                Finaliza el:
                {{ date('j', strtotime($convo->fecha_final)) }} de
                {{ $meses[substr($convo->fecha_final, 5, -3) - 1] }} del
                {{ date('Y', strtotime($convo->fecha_final)) }}
            </p>
        </div>
        <div class="card-footer text-muted">
            @if (auth()->check())
                @if (auth()->user()->hasRoles(['administrador']))
                @if (!($convo->finalizado))
                    <form class="d-inline"
                        action="{{ route('convocatoria.destroy', $convo->id) }}"
                        method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-link btn-sm">
                            <img src="{{ asset('img/trash2.png') }}"
                                width="36" height="29">
                        </button>
                    </form>
                    @endif
                @endif
                @if (auth()->user()->hasRoles(['secretaria']) && !$convo->creado)
                    <form class="d-inline"
                        action="{{ route('convocatoria.destroy', $convo->id) }}"
                        method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-link btn-sm">
                            <img src="{{ asset('img/trash2.png') }}"
                                width="36" height="29">
                        </button>
                    </form>
                @endif
            @endif
            @if($convo->creado)
                @if($convo->publicado)
                    @if (auth()->check())
                        @if (auth()->user()->hasRoles(['administrador']))
                            <a href="{{ route('adminConvocatoria',$convo->id ) }}"
                                style="background-color:#2F2D4A; color:white;"
                                class="btn btn-sm">{{ csrf_field() }}{{ $convo->finalizado? 'Ver Administracion' : 'Administrar'}}</a>
                            <a href="{{ route('helper.redirect.ver', $convo->id) }}" class="btn btn-primary btn-sm text-white">Ver</a> 
                        @endif
                        @if (auth()->user()->hasRoles(['secretaria']))
                            @if (!($convo->finalizado))
                            <a href="{{ route('adminConvocatoria',$convo->id ) }}"
                                style="background-color:#2F2D4A; color:white;"
                                class="btn btn-sm">{{ csrf_field() }}Administrar</a>
                            @endif
                            <a href="{{ route('helper.redirect.ver', $convo->id) }}" class="btn btn-primary btn-sm text-white">Ver</a>                                    
                        @endif
                        @if (auth()->user()->hasRoles(['evaluador']))
                            @if (!($convo->finalizado))
                                <a href="{{ route('helper.redirect', $convo->id) }}" style="background-color:#2F2D4A; color:white;"
                                class="btn btn-sm">{{ csrf_field() }}Evaluar</a>
                            @endif
                            <a href="{{ route('helper.redirect.ver', $convo->id) }}" class="btn btn-primary btn-sm text-white">Ver</a>
                        @endif
                    @else
                        <a href="{{ route('helper.redirect.ver', $convo->id) }}" class="btn btn-primary btn-sm text-white">Ver</a>
                        @if ($convo->pre_posts_habilitado && !($convo->finalizado))
                            <a type="button" onclick="listaAux({{ $auxs }}, {{ $convo->id }})" class="btn btn-success btn-sm text-white" data-toggle="modal" data-target="#postulanteModal">
                                Postular ahora
                            </a>
                        @endif
                    @endif                      
                    <a href="{{ route('convocatoria.download',$convo->id ) }}" style="color:white;"
                    class="btn btn-info btn-sm">Descargar</a>
                    </div>
                    <div class="card-footer text-muted" style="height: 50px;font-size:14px;">Esta
                    convocatoria {{ $convo->finalizado? 'finalizo' : 'esta en curso'}}.</div>
                @else
                    @if (auth()->user()->hasRoles(['secretaria']))
                        <a href="{{ route('adminConvocatoria',$convo->id ) }}"
                            style="background-color:#2F2D4A; color:white;"
                            class="btn btn-sm">{{ csrf_field() }}Administrar</a>
                    @else
                        <a href="{{ route('adminConvocatoria',$convo->id ) }}"
                        style="background-color:#2F2D4A; color:white;"
                        class="btn btn-sm">{{ csrf_field() }}Administrar</a>
                        <a href="{{ route('convocatoria.show',$convo->id ) }}"
                        style="background-color:#61DE4D;color:rgb(255, 255, 255);"
                        class="btn btn-sm">{{ csrf_field() }}Publicar</a>
                    @endif
                    <a href="{{ route('helper.redirect.ver', $convo->id) }}" class="btn btn-primary btn-sm text-white">Ver</a>
                    </div>
                    <div class="card-footer text-muted" style="height: 50px;font-size:14px;">Esta
                    convocatoria esta lista para publicarse.</div>
                @endif
            @else
                @if (auth()->user()->hasRoles(['administrador']))
                    <a href="{{ route('convocatoria.edit',$convo->id ) }}"
                    style="background-color:#2F2D4A; color:white;"
                    class="btn btn-sm">{{ csrf_field() }}Editar</a>
                    <button style="background-color:#9C9C9C; color:white;" class="btn btn-sm"
                    type="button" disabled>Publicar</button>
                @endif
                    </div>
                    
                    <div class="card-footer text-muted" style="height: 50px; font-size:14px;">Esta convocatoria se
                    encuentra incompleta.</div>
               
            @endif
            
        </div>
    {{ $slot }}
</div>