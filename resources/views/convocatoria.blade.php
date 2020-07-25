@extends('layout')

@section('content')
<div class="overflow-auto content" style="width: 100vw; height: 77vh;">
    
    <h3 class="text-uppercase text-left">Convocatorias</h3>

    {{-- Boton para crear una nueva convocatoria --}}
    @if (auth()->check())
        @if (auth()->user()->hasRoles(['secretaria']))
            <div class="container">
                <div class="row my-3">
                    <a type="button" data-toggle="modal" data-target="#convocatoriaModal">
                        <img src="{{ asset('img/addBLUE.png') }}" width="30" height="30">
                        <span class="mx-1">Crear Convocatoria</span>
                    </a>
                </div>
            </div>
        @endif
    @endif
    {{-- Postulante --}}
    <div class="modal fade" id="postulanteModal" tabindex="-1" role="dialog" aria-labelledby="postModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="postModalTitle">Registro Pre Postulante</h5>
                    <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('exportPDF') }}" id="form-postulante">
                        {{ csrf_field() }}

                        <input type="hidden" name="id-conv-postulante" id="id-conv-postulante" value="">
                        <div class="form-group">
                            <label class="d-block">Auxiliatura:<br>
                                <select name="auxiliaturas[]" class="select2" id="auxiliaturas" multiple="multiple" required>
                                </select>
                            </label>
                        </div>
                        <div class="form-row mb-3">
                            <label class="col-auto col-form-label" for="post-nom">Nombres:
                            </label>
                            <div class="col-sm">
                                <input class="form-control" type="text" id="post-nom" placeholder="Ingrese sus nombres" name="postulante-nombre"
                                pattern="[a-zA-z ]+" title="Solo se permite carateres alfabeticos y espacios." required>
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <label class="col-auto col-form-label" for="post-ape">Apellidos:</label>
                            <div class="col-sm">
                                <input class="form-control" type="text" id="post-ape" placeholder="Ingrese sus apellidos" name="postulante-apellidos"
                                pattern="[a-zA-z ]+" title="Solo se permite carateres alfabeticos y espacios." required>
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <label class="col-auto col-form-label" for="post-dir">Dirección:</label>
                            <div class="col-sm">
                                <input class="form-control" type="text" id="post-dir" placeholder="Ingrese su dirección" name="postulante-direccion" required>
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <label class="col-auto col-form-label" for="post-cod">Código SIS:</label>
                            <div class="col-sm">
                                <input class="form-control" type="text" id="post-cod" placeholder="Ingrese su SIS" pattern="[0-9]{9}" name="cod-sis"
                                title="Este campo contiene 9 caracteres numéricos obligatorios." required>
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <label class="col-auto col-form-label" for="post-cor">Correo electrónico:</label>
                            <div class="col-sm">
                                <input class="form-control" type="email" id="post-cor" name="correo-direccion" placeholder="ejemplo@algo.com" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="col-sm-6">Teléfono:
                                <input class="form-control" type="text" placeholder="Ingrese su numero teléfonico" id="post-tel" name="telefono"
                                pattern="[0-9]{7,8}" title="Ingrese un numero valido para celular o telefono fijo." required>
                            </label>
                            <label class="col-sm-6">CI:
                                <input class="form-control" type="text" id="post-ci" placeholder="Ingrese su C.I." name="ci" pattern="[0-9]{4,10}"
                                title="Solo se aceptan caracteres numéricos, como mínimo 4 y máximo 10." required>
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-info" form="form-postulante">Descargar rótulo</button>
                </div>
            </div>
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
                                    <label for="conv-gestion">Año</label>
                                    <select name="conv-gestion" id="conv-gestion" class="form-control" required>
                                        <option value="{{ $anioActual-1 }}"
                                            {{ old('conv-gestion') === $anioActual-1 ? 'selected': '' }}>
                                            {{ $anioActual-1 }}</option>
                                        <option value="{{ $anioActual }}"
                                            {{ old('conv-gestion') === $anioActual? 'selected': '' }}>
                                            {{ $anioActual }}</option>
                                        <option value="{{ $anioActual+1 }}"
                                            {{ old('conv-gestion') === $anioActual+1? 'selected': '' }}>
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
                    <button type="submit" class="btn btn-info" form="conv-form">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Carrusel de cards con datos grals. de una convocatoria --}}
    @component('components.carruselConvocatoria', 
        ['convos' => $convos, 'auxs' => $auxs, 'fechaActual' => $fechaActual])
    @endcomponent

    </div>
@endsection