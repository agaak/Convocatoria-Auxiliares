@extends('layout')

@section('content')
<div class="overflow-auto content-div">

    {{-- Modal para agregar area --}}

    <div class="modal fade" id="agregarAreas" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nueva Area de Evaluación</h5>
                    <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" accion="{{ route('docencia.save') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="d-block">Nombre:
                                <input type="text" class="form-control" name="nombre-area-lab"
                                placeholder="Ingrese el Nombre de Area" value="{{ old('nombre-area-lab') }}" required>
                            </label>
                            {!! $errors->first('nombre-area-lab', '<strong class="message-error text-danger">:message</strong>') !!}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <input class="btn btn-info" type="submit" value="Guardar">
                        </div>
                    </form>
                    @if ($errors->has('nombre-area-lab'))
                        <script>
                            window.onload = () => {
                                $('#agregarAreas').modal('show');
                            }
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Modal para editar areas --}}

    <div class="modal fade" id="editarAreas" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Area</h5>
                    <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" accion="{{ route('docencia.update') }}">
                        {{ csrf_field() }} {{ method_field('PUT') }}
                        <input type="hidden" id="id-area-lab" name="id-area">
                        <div class="form-group">
                            <label class="d-block">Nombre:
                                <input type="text" class="form-control" id="nombre-area-id" name="nombre-area-edit" value="{{ old('nombre-area-edit') }}" required>
                            </label>
                            {!! $errors->first('nombre-area-edit', '<strong class="message-error text-danger">:message</strong>') !!}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <input class="btn btn-info" id="area-guardar" type="submit" value="Guardar">
                        </div>
                    </form>
                    @if ($errors->has('nombre-area-edit'))
                        <script>
                            window.onload = () => {
                                $('#editarAreas').modal('show');
                            }
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Modal para agregar Tematica --}}

    <div class="modal fade" id="agregarTematicaDoc" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nueva Temática</h5>
                    <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" accion="{{ route('docencia.save') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="d-block">Nombre:
                                <input type="text" class="form-control" name="nombre-tem-doc"
                                placeholder="Ingrese el Nombre de Tematica" value="{{ old('nombre-tem-doc') }}" required>
                            </label>
                            {!! $errors->first('nombre-tem-doc', '<strong class="message-error text-danger">:message</strong>') !!}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <input class="btn btn-info" type="submit" value="Guardar">
                        </div>
                    </form>
                    @if ($errors->has('nombre-tem-doc'))
                        <script>
                            window.onload = () => {
                                $('#agregarTematicaDoc').modal('show');
                            }
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Modal para editar tematica --}}

    <div class="modal fade" id="editarTematicas" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Temática</h5>
                    <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" accion="{{ route('docencia.update') }}">
                        {{ csrf_field() }} {{ method_field('PUT') }}
                        <input type="hidden" id="id-tem-lab" name="id-tematica">
                        <div class="form-group">
                            <label class="d-block">Nombre:
                                <input type="text" class="form-control" id="nombre-tem-id" name="nombre-tem-edit" value="{{ old('nombre-tem-edit') }}" required>
                            </label>
                            {!! $errors->first('nombre-tem-edit', '<strong class="message-error text-danger">:message</strong>') !!}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <input class="btn btn-info" id="tematica-guardar" type="submit" value="Guardar">
                        </div>
                    </form>
                    @if ($errors->has('nombre-tem-edit'))
                        <script>
                            window.onload = () => {
                                $('#editarTematicas').modal('show');
                            }
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Modal para agregar auxiliaturas --}}

    <div class="modal fade" id="agregarAuxiliaturas" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nueva Auxiliatura</h5>
                    <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" accion="{{ route('docencia.save') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="d-block">Nombre:
                                <input type="text" class="form-control" name="nombre-auxs-lab" 
                                placeholder="Ingrese el Nombre de Auxiliatura" value="{{ old('nombre-auxs-lab') }}" required>
                            </label>
                            {!! $errors->first('nombre-auxs-lab', '<strong class="message-error text-danger">:message</strong>') !!}
                        </div>
                        <div class="form-group">
                            <label class="d-block">Código:
                                <input type="text" class="form-control" name="codigo-auxs-lab" placeholder="Ingrese el Código de Auxiliatura" 
                                value="{{ old('codigo-auxs-lab') }}" onkeyup="javascript:this.value=this.value.toUpperCase()" required>
                            </label>
                            {!! $errors->first('codigo-auxs-lab', '<strong class="message-error text-danger">:message</strong>') !!}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <input class="btn btn-info" type="submit" value="Guardar">
                        </div>
                    </form>
                    @if ($errors->has('nombre-auxs-lab') || $errors->has('codigo-auxs-lab'))
                        <script>
                            window.onload = () => {
                                $('#agregarAuxiliaturas').modal('show');
                            }
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    {{-- Modal para editar auxiliaturas --}}

    <div class="modal fade" id="editarAuxiliaturas" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Auxiliatura</h5>
                    <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" accion="{{ route('docencia.update') }}">
                        {{ csrf_field() }} {{ method_field('PUT') }}
                        <input type="hidden" id="id-aux-lab" name="id-auxiliatura">
                        <div class="form-group">
                            <label class="d-block">Nombre:
                                <input type="text" id="nombre-aux-lab" class="form-control"
                                name="nombre-auxs-edit" value="{{ old('nombre-auxs-edit') }}" required>
                            </label>
                            {!! $errors->first('nombre-auxs-edit', '<strong class="message-error text-danger">:message</strong>') !!}
                        </div>
                        <div class="form-group">
                            <label class="d-block">Código:
                                <input type="text" id="codigo-aux-lab" class="form-control" name="codigo-auxs-edit" value="{{ old('codigo-auxs-edit') }}"
                                onkeyup="javascript:this.value=this.value.toUpperCase()" required>
                            </label>
                            {!! $errors->first('codigo-auxs-edit', '<strong class="message-error text-danger">:message</strong>') !!}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <input class="btn btn-info" id="auxiliatura-guardar" type="submit" value="Guardar">
                        </div>
                    </form>
                    @if ($errors->has('nombre-auxs-edit') || $errors->has('codigo-auxs-edit'))
                        <script>
                            window.onload = () => {
                                $('#editarAuxiliaturas').modal('show');
                            }
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Contenido de la vista de la boratorios --}}

    <div class="container">
        
        <h3 class="mb-3 mt-2">Catálogo de Docencia</h3>

        {{-- Seccion para navegar entre auxiliatura, tematica y areas de evaluacion --}}

        <ul class="nav nav-pills mb-3" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ session()->get('dato') === 1 || session()->get('dato') === null? 'active': '' }}" id="pills-auxiliaturas-tab" data-toggle="pill" 
                href="#pills-auxiliaturas" role="tab" aria-controls="pills-auxiliaturas" aria-selected="true">Auxiliaturas</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ session()->get('dato') === 2? 'active': '' }}" id="pills-tematicas-tab" data-toggle="pill" href="#pills-tematicas"
                role="tab" aria-controls="pills-tematicas" aria-selected="false">Temáticas</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ session()->get('dato') === 3? 'active': '' }}" id="pills-areas-tab" data-toggle="pill" href="#pills-areas"
                role="tab" aria-controls="pills-areas" aria-selected="false">Areas de Evaluación</a>
            </li>
        </ul>
        <div class="tab-content">

            {{-- Seccion de las auxiliaturas --}}

            <div class="tab-pane fade {{ session()->get('dato') === 1 || session()->get('dato') === null? 'show active': '' }}" id="pills-auxiliaturas" role="tabpanel" aria-labelledby="pills-auxiliaturas-tab">
                <a class="mb-3" type="button" data-toggle="modal" data-target="#agregarAuxiliaturas">
                    <img src="{{ asset('img/addBLUE.png') }}" width="30" height="30">
                    <span class="mx-1">Añadir Auxiliatura</span>
                </a>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">Nro.</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Código</th>
                        <th scope="col" class="text-center">Opciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @for ($i = 0; $i < count($auxiliaturas); $i++)
                            <tr>
                                <th scope="row" class="{{ $existAux[$i] ? 'text-danger': 'text-success' }}">{{ $i+1 }}</th>
                                <td>{{ $auxiliaturas[$i]->nombre_aux }}</td>
                                <td>{{ $auxiliaturas[$i]->cod_aux }}</td>
                                <td class="text-center">

                                    @if ($auxiliaturas[$i]->habilitado)
                                        <button class="btn btn-link p-1" data-toggle="modal" data-target="#editarAuxiliaturas"
                                        data-dismiss="modal" onclick="cargarAuxLab({{ $auxiliaturas[$i] }})">
                                            <img src="{{ asset('img/pen.png') }}" width="25" height="25">
                                        </button>
                                    @endif
                                    <form class="d-inline" action="{{ route('laboratorio.enable', $auxiliaturas[$i]->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-link p-1">
                                            @if ($auxiliaturas[$i]->habilitado) 
                                                <img src="{{ asset('img/enable.png') }}" width="25" height="25">
                                            @else
                                                <img src="{{ asset('img/disable.png') }}" width="25" height="25">
                                            @endif
                                        </button>    
                                    </form>

                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            {{-- Seccion de las tematicas --}}

            <div class="tab-pane fade {{ session()->get('dato') === 2? 'show active': '' }}" id="pills-tematicas" role="tabpanel" aria-labelledby="pills-tematicas-tab">
                <a class="mb-3" type="button" data-toggle="modal" data-target="#agregarTematicaDoc">
                    <img src="{{ asset('img/addBLUE.png') }}" width="30" height="30">
                    <span class="mx-1">Añadir Tematica</span>
                </a>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">Nro.</th>
                        <th scope="col">Nombre</th>
                        <th scope="col" class="text-center">Opciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @for ($i = 0; $i < count($tematicas); $i++)
                            <tr>
                                <th scope="row" class="{{ $existTem[$i] ? 'text-danger': 'text-success' }}">{{ $i+1 }}</th>
                                <td>{{ $tematicas[$i]->nombre }}</td>
                                <td class="text-center">

                                    @if ($tematicas[$i]->habilitado)
                                        <button class="btn btn-link p-1" data-toggle="modal" data-target="#editarTematicas"
                                        data-dismiss="modal" onclick="cargarAuxTem({{ $tematicas[$i] }})">
                                            <img src="{{ asset('img/pen.png') }}" width="25" height="25">
                                        </button>
                                    @endif
                                    <form class="d-inline" action="{{ route('laboratorio.enable', $tematicas[$i]->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <input type="hidden" name="tematica">
                                        <button type="submit" class="btn btn-link p-1">
                                            @if ($tematicas[$i]->habilitado)
                                                <img src="{{ asset('img/enable.png') }}" width="25" height="25">
                                            @else
                                                <img src="{{ asset('img/disable.png') }}" width="25" height="25">
                                            @endif
                                        </button>    
                                    </form>

                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            {{-- Seccion de las areas de evaluacion --}}

            <div class="tab-pane fade {{ session()->get('dato') === 3? 'show active': '' }}" id="pills-areas" role="tabpanel" aria-labelledby="pills-areas-tab">
                <a class="mb-3" type="button" data-toggle="modal" data-target="#agregarAreas">
                    <img src="{{ asset('img/addBLUE.png') }}" width="30" height="30">
                    <span class="mx-1">Añadir Area</span>
                </a>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">Nro.</th>
                        <th scope="col">Nombre</th>
                        <th scope="col" class="text-center">Opciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @for ($i = 0; $i < count($areas); $i++)
                            <tr>
                                <th scope="row" class="{{ $existArea[$i] ? 'text-danger': 'text-success' }}">{{ $i+1 }}</th>
                                <td>{{ $areas[$i]->nombre }}</td>
                                <td class="text-center">

                                    @if ($areas[$i]->habilitado)
                                        <button class="btn btn-link p-1" data-toggle="modal" data-target="#editarAreas"
                                        data-dismiss="modal" onclick="cargarAuxArea({{ $areas[$i] }})">
                                            <img src="{{ asset('img/pen.png') }}" width="25" height="25">
                                        </button>
                                    @endif
                                    <form class="d-inline" action="{{ route('laboratorio.enable', $areas[$i]->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <input type="hidden" name="area">
                                        <button type="submit" class="btn btn-link p-1">
                                            @if ($areas[$i]->habilitado)
                                                <img src="{{ asset('img/enable.png') }}" width="25" height="25">
                                            @else
                                                <img src="{{ asset('img/disable.png') }}" width="25" height="25">
                                            @endif
                                        </button>    
                                    </form>

                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

        </div>
    </div>


</div>
@endsection