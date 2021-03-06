@extends('admConvocatoria.layaoutAdmConvocatoria')

@section('content-adm-convocatoria')
<div class="overflow-auto content">
    <h3>Comisión de Evaluacion de Meritos</h3>

    <!-- Trigger modal -->
    @if ($conv->recepcionar)
        <button type="button" class="btn btn-dark my-3" data-toggle="modal"
        data-target="#modalCrearEvaluadorMerit" >Registrar nuevo evaluador</button>
    @endif
 
    <!-- Table -->
    <div class="table-requests1">
        <table id= "evalMerito" class="table table-striped table-bordered" style="text-align:left">
        <thead class="thead-dark">
            <tr>
            <th style="font-weight: normal" scope="col">#</th>
            <th style="font-weight: normal" scope="col">CI</th>
            <th style="font-weight: normal" scope="col">Nombres</th>
            <th style="font-weight: normal" scope="col">Apellidos</th>
            <th style="font-weight: normal" scope="col">Email</th>
            <th style="font-weight: normal" class="text-center" scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody style="background-color: white">
            @php $num = 1  @endphp
            @foreach($listEvaluadorMerit as $item)
                <tr>
                <td style="font-weight: normal">{{ $num++ }}</td>
                <th style="font-weight: normal">{{ $item->ci }}</th>
                <th style="font-weight: normal">{{ $item->nombre }}</th>
                <th style="font-weight: normal">{{ $item->apellido }}</th>
                <th style="font-weight: normal">{{ $item->correo }}</th>
                <th class="text-center">
                    <button type="submit" class="btn btn-link" onclick="editEvaluadorMeritos({{ json_encode($item) }})" 
                    data-toggle="modal" data-target="#modalUpdateEvaluadorMerit">
                    <img src="{{ asset('img/pen.png') }}" width="26" height="26">
                    </button> 
                    <form class="d-inline"
                        action="{{ route('admMeritosDelete', $item->id) }}"
                        method="POST" id="evaluador-meritos-delete">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-link">
                            <img src="{{ asset('img/trash.png') }}" width="26" height="26">
                        </button>    
                    </form>
                    @if ($conv->publicado)
                    <form class="d-inline" action="{{ route('admConocimientosEmail', $item->id) }}" method="POST">
                        {{ csrf_field() }}
                        <button type="submit" onclick="enviarCorreo()" class="btn btn-link">
                            <img src="{{ asset('img/email.png') }}" width="30" height="32">
                        </button>
                    </form>
                    @endif
                </th>
                </tr>
            @endforeach
        </tbody>
        </table>
    </div>

    <!-- Edit Modal-->
    <div class="modal fade" id="requestEditModal" tabindex="-1" role="dialog" aria-labelledby="requestTitle"
    aria-hidden="true">
    </div>

    {{--modal crear evaluador de meritos--}}
    <div class="modal fade" id="modalCrearEvaluadorMerit" tabindex="-1" role="dialog"
        aria-labelledby="evaluadorMeritTitleCreate" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="evaluadorMeritTitleCreate">Registrar evaluador de meritos</h5>
                    <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admMeritosCreate') }}"
                        id="form-create-evaluador-merito">
                        {{ csrf_field() }}
                        <div class="form-group row mb-1">
                            <label for="adm-cono-ci"  class="col-sm-1 col-form-label">CI:</label>
                            <div class="col-sm-5">
                                <input type="number" name="adm-cono-ci" placeholder="Ingrese su carnet" class="form-control" id="adm-cono-ci" required>
                            </div> <div class="col-sm-6">
                                <button type="button" class="btn btn-primary" onclick="comprobar({{ $listEvaluadores }})">Comprobar Existencia</button>
                            </div>
                            {!! $errors->first('adm-cono-ci', '<div class="error" id="err"> <strong class="message-error text-danger col-sm-12">:message</strong></div>') !!}
                        </div>
                        <div class="d-none text-left col-sm-12 mt-0" id="ci-no-existe">
                            <strong class="text-primary">El CI ingresado ya existe</strong>
                        </div>
                        <div class="d-none text-left col-sm-12 mt-0" id="ci-existe">
                            <strong class="text-success">El CI ingresado aun no existe</strong>
                        </div>
                        <div class="form-group row mt-4">
                            <label for="adm-cono-nombre" class="col-sm-3 col-form-label">Nombre:</label>
                            <div class="col-sm-9">
                            <input type="text" name="adm-cono-nombre" minlength="3" disabled id="adm-nom" class="form-control" required>
                            </div>
                            {!! $errors->first('adm-cono-nombre', '<strong class="message-error text-danger col-sm-12">:message</strong>') !!}
                        </div>
                        <div class="form-group row">
                            <label for="adm-ape" class="col-sm-3 col-form-label">Apellidos:</label>
                            <div class="col-sm-9">
                            <input type="text" name="adm-cono-apellidos" minlength="3" disabled id="adm-ape" class="form-control" required>
                            </div>
                            {!! $errors->first('adm-cono-apellidos', '<strong class="message-error text-center text-danger col-sm-12">:message</strong>') !!}
                        </div>
                        <div class="form-group row">
                        <label for="adm-cono-correo"  class="col-sm-3 col-form-label">Correo:</label>
                        <div class="input-group col-sm-9">
                            <input type="email" class="form-control mt-0" name="adm-cono-correo" disabled id="adm-correo" aria-label="Recipient's username" 
                                aria-describedby="basic-addon2" required>
                            <div class="input-group-append">
                              <span class="input-group-text" id="basic-addon2">@</span>
                            </div>
                        </div>
                        {!! $errors->first('adm-cono-correo', '<strong class="message-error text-danger text-right col-sm-10 mt-0 mb-1">:message</strong>') !!}
                        </div>
                        <div class="form-group row">
                        <label for="adm-cono-correo2"  class="col-sm-3 col-form-label">Correo Alt</label>
                        <div class="input-group col-sm-9">
                            <input type="email" class="form-control" name="adm-cono-correo2" disabled id="adm-correo2" aria-label="Recipient's username" 
                                aria-describedby="basic-addon2">
                            <div class="input-group-append">
                              <span class="input-group-text" id="basic-addon2">@</span>
                            </div>
                        </div>
                        <label for="adm-cono-correo2"  class="col-sm-3 col-form-label mt-0">(Opcional)</label>
                        {!! $errors->first('adm-cono-correo2', '<strong class="message-error text-danger text-center col-sm-12">:message</strong>') !!}
                        </div>
                        @if ($errors->any())
                            <script>
                                window.onload = () => {
                                    $('#modalCrearEvaluadorMerit').modal('show');
                                    document.getElementById("button-guardar").disabled = false;
                                }
                            </script>
                        @endif
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" form="form-create-evaluador-merito" class="btn btn-info" id="button-guardar" disabled>Guardar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Actualizar evaluador de meritos --}} 
    <div class="modal fade" id="modalUpdateEvaluadorMerit" tabindex="-1" role="dialog"
        aria-labelledby="importanDatesTitleUpdate" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importanDatesTitleUpdate">Editar evaluador de méritos</h5>
                    <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admMeritosUpdate') }}"
                        id="form-update-evaluador-merito">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="hidden" id="id-evaluador" value="{{ old('id-evaluador') }}" name="id-evaluador">

                        <div class="form-group row">
                            <label for="adm-cono-ci-edit" class="col-sm-3 col-form-label">Carnet:</label>
                            <div class="col-sm-9">
                            <input type="number" name="adm-cono-ci-edit"  value="{{ old('adm-cono-ci-edit') }}" readonly class="form-control" id="adm-cono-ci-edit" required>
                            </div>
                        {!! $errors->first('adm-cono-ci', '<p class="message-error text-danger id="err"">:message</p>') !!}
                    </div>
                    <div class="d-none text-center col-sm-6" id="ci-no-existe">
                        <p class="text-success">El CI ingresado ya existe</p>
                    </div>
                    <div class="d-none text-center col-sm-6" id="ci-existe">
                        <p class="text-primary">El CI ingresado aun no existe</p>
                    </div>
                    <div class="form-group row">
                        <label for="adm-cono-nombre-edit" class="col-sm-3 col-form-label">Nombres:</label>
                        <div class="col-sm-9">
                        <input type="text" name="adm-cono-nombre-edit" value="{{ old('adm-cono-nombre-edit') }}" id="adm-cono-nombre-edit" minlength="3" class="form-control" required>
                        </div>
                        {!! $errors->first('adm-cono-nombre-edit', '<strong class="message-error text-danger id="err"">:message</strong>') !!}
                    </div>
                    <div class="form-group row">
                        <label for="adm-cono-apellidos-edit"  class="col-sm-3 col-form-label">Apellidos:</label>
                        <div class="col-sm-9">
                        <input type="text" name="adm-cono-apellidos-edit"  value="{{ old('adm-cono-apellidos-edit') }}" id="adm-cono-apellidos-edit" minlength="3" class="form-control" required>
                        </div>
                        {!! $errors->first('adm-cono-apellidos-edit', '<strong class="message-error text-danger id="err"">:message</strong>') !!}
                    </div>
                    <div class="form-group row">
                        <label for="adm-cono-correo-edit"  class="col-sm-3 col-form-label">Correo:</label>
                        <div class="input-group col-sm-9">
                            <input type="email" class="form-control" name="adm-cono-correo-edit"  value="{{ old('adm-cono-correo-edit') }}" id="adm-cono-correo-edit" aria-label="Recipient's username" 
                                aria-describedby="basic-addon2" required>
                            <div class="input-group-append">
                              <span class="input-group-text" id="basic-addon2">@</span>
                            </div>
                        </div>
                        {!! $errors->first('adm-cono-correo-edit', '<strong class="message-error text-danger text-right col-sm-10 mt-0 mb-1">:message</strong>') !!}
                    </div>
                   <div class="form-group row">
                        <label for="adm-cono-correo2-edit"  class="col-sm-3 col-form-label mb-0">Correo</label>
                        <div class="input-group mb-1 col-sm-9 mb-0">
                            <input type="email" class="form-control" name="adm-cono-correo2-edit"  value="{{ old('adm-cono-correo2-edit') }}" id="adm-cono-correo2-edit" aria-label="Recipient's username" 
                                aria-describedby="basic-addon2">
                            <div class="input-group-append">
                              <span class="input-group-text" id="basic-addon2">@</span>
                            </div>
                        </div>
                        <label for="adm-cono-correo2"  class="col-sm-3 col-form-label mt-0">(Opcional)</label>
                    </div>
                        @if($errors->any())
                            <script>
                                window.onload = () => {
                                    $('#modalUpdateEvaluadorMerit').modal('show');
                                }
                            </script>
                        @endif
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <input type="submit" class="btn btn-info" value="Guardar" form="form-update-evaluador-merito">
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/jquery-3.5.1.slim.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#evalMerito').DataTable({
        "pageLength":70,"bPaginate": false,
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },"bLengthChange": false,responsive: true,
        order: [0, 'asc'],  "bInfo" : false
        });
    });
</script>
@endsection