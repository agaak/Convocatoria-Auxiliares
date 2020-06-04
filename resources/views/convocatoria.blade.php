@extends('layout')

@section('content')

<div class="overflow-auto content">
    <h3 class="text-uppercase text-left">Convocatorias</h3>

    <div class="container">
        {{-- Boton para crear una nueva convocatoria --}}
        <div class="row my-3">
            <a type="button" data-toggle="modal" data-target="#convocatoriaModal">
                <img src="{{ asset('img/addBLUE.png') }}" width="30" height="30">
                <span class="mx-1">Crear Convocatoria</span>
            </a>
        </div>
    </div>

    {{-- Moadal pra crear nueva convocatoria --}}
    {{-- conv = convocatoria --}}
    <div class="modal fade" id="convocatoriaModal" tabindex="-1" role="dialog" aria-labelledby="convModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="convModalTitle">Crear Nueva Convocatoria</h5>
                    <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('convocatoria.store') }}" id="conv-form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="conv-titulo">Título</label>
                            <textarea class="form-control" name="conv-titulo" id="conv-titulo" rows="2"
                                placeholder="Ingrese el título de la convocatoria" required minlength="30"
                                maxlength="150">{{ old('conv-titulo') }}</textarea>
                            {!! $errors->first('conv-titulo', '<strong
                                class="message-error text-danger">:message</strong>')
                            !!}
                        </div>
                        <div class="form-group">
                            <label for="conv-descripcion">Descripción</label>
                            <textarea class="form-control" name="conv-descripcion" id="conv-descripcion" rows="3"
                                placeholder="Ingrese el título de la convocatoria" required
                                minlength="10">{{ old('conv-descripcion') }}</textarea>
                            {!! $errors->first('conv-descripcion', '<strong class="text-danger">:message</strong>') !!}
                        </div>
                        <div class="form-row mb-3">
                            <div class="col-sm-6 text-center">
                                <label for="conv-fecha-ini">Fecha Inicio</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" name="conv-fecha-ini" id="conv-fecha-ini"
                                        placeholder="Mes/Día/Año" value="{{ old('conv-fecha-ini') }}"
                                        readonly>
                                    <span class="input-group-addon">
                                        <img class="center-y-icon"
                                            src="{{ asset('img/calendar.png') }}" width="34"
                                            height="34" alt="icon-calendar">
                                    </span>
                                </div>
                                {!! $errors->first('conv-fecha-ini', '<strong
                                    class="message-error text-danger">:message</strong>') !!}
                            </div>
                            <div class="col-sm-6 text-center">
                                <label for="conv-fecha-fin">Fecha Final</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" name="conv-fecha-fin" id="conv-fecha-fin"
                                        placeholder="Mes/Día/Año" value="{{ old('conv-fecha-fin') }}"
                                        readonly>
                                    <span class="input-group-addon">
                                        <img class="center-y-icon"
                                            src="{{ asset('img/calendar.png') }}" width="34"
                                            height="34" alt="icon-calendar">
                                    </span>
                                </div>
                                {!! $errors->first('conv-fecha-fin', '<strong
                                    class="message-error text-danger">:message</strong>') !!}
                            </div>
                        </div>
                        <div class="form-row text-center">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="conv-tipo">Tipo</label>
                                    <select class="form-control" id="conv-tipo" name="conv-tipo">
                                        @foreach($tipos as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('conv-tipo') == $item->id? 'selected': '' }}>
                                                {{ $item->nombret_tipo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="conv-gestion">Gestion</label>
                                    <select name="conv-gestion" id="conv-gestion" class="form-control">
                                        <option value="op-1"
                                            {{ old('conv-gestion') === 'op-1'? 'selected': '' }}>
                                            {{ $anioActual }}</option>
                                        <option value="op-2"
                                            {{ old('conv-gestion') === 'op-2'? 'selected': '' }}>
                                            {{ $anioActual+1 }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @if($errors->any())
                            <script>
                                window.onload = () => {
                                    $('#convocatoriaModal').modal('show');
                                }
                            </script>
                        @endif
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info" form="conv-form">Gurardar</button>
                </div>
            </div>
        </div>
    </div>

    @if($convos->isEmpty())
        <h1>No hay convocatorias registradas</h1>
    @else
        @if(count($convos)<4)
            <div class="container text-center my-3">
                <div class="row mx-auto my-auto">
                    @foreach($convos as $convo)
                        <div class="col-sm-4">
                            <div class="card text-center" style="height: 300px">
                                <div class="card-header"
                                    style="font-size:16px; background: #0A091B; color: white; height: 65px;">
                                    {{ $convo->titulo }}
                                </div>
                                <div class="card-body overflow-auto" data-spy="scroll" style="height: 100px">
                                    <p class="card-text">{{ $convo->descripcion_convocatoria }}</p>
                                </div>
                                <div class="card-footer text-muted">
                                    <form class="d-inline"
                                        action="{{ route('convocatoria.destroy', $convo->id) }}"
                                        method="POST">
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-link btn-sm">
                                            <img src="{{ asset('img/trash2.png') }}" width="37"
                                                height="29">
                                        </button>
                                    </form>
                                    @if($convo->creado)
                                        @if($convo->publicado)
                                            <a href="{{ route('admConvocatoria',$convo->id ) }}"
                                                style="background-color:#2F2D4A; color:white;"
                                                class="btn btn-primary btn-sm">{{ csrf_field() }}Administrar</a>
                                            <a href="#" style="color:white;" class="btn btn-info btn-sm">Visualizar</a>
                                </div>
                                <div class="card-footer text-muted" style="height: 50px;font-size:14px;">Esta convocatoria esta en curso.</div>
                            @else
                                <a href="{{ route('admConvocatoria',$convo->id ) }}"
                                    style="background-color:#2F2D4A; color:white;"
                                    class="btn btn-primary btn-sm">{{ csrf_field() }}Administrar</a>
                                <a href="{{ route('convocatoria.show',$convo->id ) }}"
                                    style="color:white;" class="btn btn-success btn-sm">{{ csrf_field() }}Publicar</a>
                            </div>
                            <div class="card-footer text-muted" style="height: 50px;font-size:14px;">Esta convocatoria esta lista para publicarse.</div>
                    @endif
                @else
                    <a href="{{ route('convocatoria.edit',$convo->id ) }}"
                        style="color:white;" class="btn btn-secondary btn-sm">{{ csrf_field() }}Editar</a>
                    <a href="#" style="background-color:#2F2D4A; color:white;" class="btn btn-primary btn-sm"
                        type="button" disabled>Administrarr</a>
                    <a href="{{ Storage::url($convo -> ruta_pdf) }}" class="btn-descargar" target="_blank">
                        <i class="fas fa-download"></i></a>
                </div>
                <div class="card-footer text-muted" style="height: 50px;font-size:14px;">Esta convocatoria se encuentra incompleta.</div>
        @endif
</div>
</div>
@endforeach
</div>
</div>
@else
<div class="container text-center my-3">
    <div class="row mx-auto my-auto">
        <div id="recipeCarousel" class="carousel slide w-100" data-ride="carousel">
            <div class="carousel-inner w-100" role="listbox">
                <div style="visibility: hidden"> {{ $num = 0 }}</div>
                @foreach($convos as $convo)
                    @if($num++ == 0)
                        <div class="carousel-item active">
                        @else
                            <div class="carousel-item">
                    @endif
                    <div class="col-md-4">
                        <div class="card text-center" style="height: 350px">
                            <div class="card-header"
                                style="font-size:16px; background: #0A091B; color: white; height: 65px;">
                                {{ $convo->titulo }}
                            </div>
                            <div class="card-body overflow-auto" data-spy="scroll" style="height: 100px">
                                <p class="card-text">{{ $convo->descripcion_convocatoria }}</p>
                            </div>
                            <div class="card-footer text-muted">
                                <form class="d-inline"
                                    action="{{ route('convocatoria.destroy', $convo->id) }}"
                                    method="POST">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-link btn-sm">
                                        <img src="{{ asset('img/trash2.png') }}" width="37"
                                            height="29">
                                    </button>
                                </form>
                                @if($convo->creado)
                                    @if($convo->publicado)
                                        <a href="{{ route('admConvocatoria',$convo->id ) }}"
                                            style="background-color:#2F2D4A; color:white;"
                                            class="btn btn-primary btn-sm">{{ csrf_field() }}Administrar</a>
                                        <a href="#" style="color:white;" class="btn btn-info btn-sm">Visualizar</a>
                            </div>
                            <div class="card-footer text-muted" style="height: 50px;font-size:14px;">Esta convocatoria esta en curso.</div>
                        @else
                            <a href="{{ route('admConvocatoria',$convo->id ) }}"
                                style="background-color:#2F2D4A; color:white;"
                                class="btn btn-primary btn-sm">{{ csrf_field() }}Administrar</a>
                            <a href="{{ route('convocatoria.show',$convo->id ) }}"
                                style="color:white;" class="btn btn-success btn-sm">{{ csrf_field() }}Publicar</a>
                        </div>
                        <div class="card-footer text-muted" style="height: 50px;font-size:14px;">Esta convocatoria esta lista para publicarse.</div>
                @endif
            @else
                <a href="{{ route('convocatoria.edit',$convo->id ) }}" style="color:white;"
                    class="btn btn-secondary btn-sm">{{ csrf_field() }}Editar</a>
                <a href="#" style="background-color:#2F2D4A; color:white;" class="btn btn-primary btn-sm" type="button"
                    disabled>Administrarr</a>
            </div>
            <div class="card-footer text-muted" style="height: 50px; font-size:14px;">Esta convocatoria se encuentra incompleta.</div>
            @endif
        </div>
    </div>
</div>
@endforeach
</div>
<a class="carousel-control-prev w-auto" href="#recipeCarousel" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle" aria-hidden="true"
        style="height: 40px; width: 40px;"></span>
    <span class="sr-only">Previous</span>
</a>
<a class="carousel-control-next w-auto" href="#recipeCarousel" role="button" data-slide="next">
    <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle" aria-hidden="true"
        style="height: 40px; width: 40px;"></span>
    <span class="sr-only">Next</span>
</a>
</div>
</div>
</div>

</div>
@endif
@endif
</div>
@endsection