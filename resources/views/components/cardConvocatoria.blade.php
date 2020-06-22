<div class="col-md-4 mb-3 mt-3">
    <div class="card text-center" style="height: 375px">
        <div class="card-header"
            style="font-size:16px; background: #0A091B; color: white; height: 65px;">
            {{ $convo->titulo }}
        </div>
        <div class="card-body overflow-auto" data-spy="scroll" style="height: 100px">
            <p class="card-text">{{ $convo->descripcion_convocatoria }}</p>
        </div>
        <div class="card-footer text-muted">
            @if (auth()->check())
                @if (auth()->user()->hasRoles(['administrador']))
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
                                class="btn btn-sm">{{ csrf_field() }}Administrar</a>
                            <a href="{{ route('helper.redirect.ver', $convo->id) }}" class="btn btn-success btn-sm text-white">Ver</a> 
                        @endif
                        @if (auth()->user()->hasRoles(['evaluador']))
                        <a href="{{ route('helper.redirect', $convo->id) }}" style="background-color:#2F2D4A; color:white;"
                            class="btn btn-sm">{{ csrf_field() }}Evaluar</a>
                        @endif
                    @else
                        <a href="{{ route('helper.redirect.ver', $convo->id) }}" class="btn btn-success btn-sm text-white">Ver</a> 
                        <a type="button" onclick="listaAux({{ $auxs }}, {{ $convo->id }})" class="btn btn-success btn-sm text-white" data-toggle="modal" data-target="#postulanteModal">
                            Postular ahora </a>
                    @endif                      
                    <a href="{{ route('convocatoria.download',$convo->id ) }}" style="color:white;"
                    class="btn btn-info btn-sm">Descargar</a>
                    </div>
                    <div class="card-footer text-muted" style="height: 50px;font-size:14px;">Esta
                    convocatoria esta en curso.</div>
                @else
                    <a href="{{ route('adminConvocatoria',$convo->id ) }}"
                    style="background-color:#2F2D4A; color:white;"
                    class="btn btn-sm">{{ csrf_field() }}Administrar</a>
                    <a href="{{ route('convocatoria.show',$convo->id ) }}"
                    style="background-color:#61DE4D;color:rgb(255, 255, 255);"
                    class="btn btn-sm">{{ csrf_field() }}Publicar</a>
                    <a href="{{ route('helper.redirect.ver', $convo->id) }}" class="btn btn-success btn-sm text-white">Ver</a>
                    </div>
                    <div class="card-footer text-muted" style="height: 50px;font-size:14px;">Esta
                    convocatoria esta lista para publicarse.</div>
                @endif
            @else
                <a href="{{ route('convocatoria.edit',$convo->id ) }}"
                style="background-color:#2F2D4A; color:white;"
                class="btn btn-sm">{{ csrf_field() }}Editar</a>
                <button style="background-color:#9C9C9C; color:white;" class="btn btn-sm"
                type="button" disabled>Publicar</button>
                </div>
                <div class="card-footer text-muted" style="height: 50px; font-size:14px;">Esta convocatoria se
                encuentra incompleta.</div>
            @endif
    </div>
    {{ $slot }}
</div>