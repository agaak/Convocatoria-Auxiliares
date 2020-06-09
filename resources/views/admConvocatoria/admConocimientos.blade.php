@extends('admConvocatoria.layaoutAdmConvocatoria')

@section('content-adm-convocatoria')
<div class="overflow-auto content">

    <h3 class="text-uppercase text-center">Comision de evaluacion de conocimientos</h3>
    <!-- Trigger modal -->
    <button class="pl-4 pr-4 btn btn-dark mt-3" type="button" data-toggle="modal" data-target="#admConoModal">Registrar Evaluador</button>

    <!-- Table -->
    <div class="table-requests1 vertical-align: middle; mt-3">
        <table class="table table-bordered" style="text-align:center">
        <thead class="thead-dark" style="text-align: center">
        <tr>
                @if ($tipoConvocatoria==2)
                <th style="font-weight: normal" scope="col" >Auxiliatura</th>
                @else
                <th style="font-weight: normal" scope="col">Tematica</th>
                @endif 
            <th style="font-weight: normal" scope="col">Carnet</th>
            <th style="font-weight: normal" scope="col">Nombres</th>
            <th style="font-weight: normal" scope="col">Apellidos</th>
            <th style="font-weight: normal" scope="col">Correo</th>
            <th style="font-weight: normal" scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody style="background-color: white">
        @foreach ($evaluadores as $evaluador)
        @php $num = 1; $tam = 0; @endphp
            <tr>
            @foreach($lista_tem_aux as $tem_aux)
                @php $tam = $tem_aux->id_eva == $evaluador->id_eva_conv? $tam + 1 : $tam; @endphp
                @if($num == 1 && $tem_aux->id_eva == $evaluador->id_eva_conv)
                @php  $num++ @endphp
                <td scope="col" style="text-align: left">{{$tem_aux->nombre}}</td>
                @endif 
            @endforeach
            <td scope="col" style="vertical-align: middle;" rowspan="{{$tam}}" >{{$evaluador->ci}}</td>
            <td scope="col" style="vertical-align: middle;" rowspan="{{$tam}}">{{$evaluador->nombre}}</td>
            <td scope="col" style="vertical-align: middle;" rowspan="{{$tam}}">{{$evaluador->apellido}}</td>
            <td scope="col" style="vertical-align: middle;" rowspan="{{$tam}}">{{$evaluador->correo}}</td>
                <td class="table-light" scope="col" rowspan="{{$tam}}" style="vertical-align: middle;">
                    <a class="options" data-toggle="modal" data-target="#editEvalConociminetos" 
                    onclick="editEvalConociminetos({{ json_encode($evaluador) }}, {{ json_encode($lista_tem_aux) }}, {{ json_encode($listaMultiselect) }})"
                    data-dismiss="modal"><img src="{{ asset('img/pen.png') }}" width="20" height="25"></a>
                    <form class="d-inline" action="{{ route('admConocimientosDelete', $evaluador->id) }}" method="POST">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                      <button type="submit" class="btn btn-link">
                        <img src="{{ asset('img/trash.png') }}" width="20" height="25">
                      </button>
                    </form>
                  </td>  
            </tr>
            @foreach ($lista_tem_aux as $tem_aux)
                @if($tem_aux->id_eva==$evaluador->id_eva_conv)
                    @if($num++ > 2)
                        <tr><td scope="col" style="text-align: left">{{$tem_aux->nombre}}</td></tr>
                   @endif
                @endif
            @endforeach        
        @endforeach
        </tbody>
        </table>
    </div>

    <!-- Edit Modal-->
    <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="requestTitle"
    aria-hidden="true">
    </div>


    

</div>
{{-- Modal para crear nuevo evaluador de conocimientos --}}
<div class="modal fade" id="admConoModal" tabindex="-1" role="dialog" aria-labelledby="admConoModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="admConoModalTitle">Registrar Evaluador de Conocimientos</h5>
                    <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admConoStore') }}" id="from-adm-conocimientos">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="adm-cono-tipo">Auxiliatura:</label>
                            <select id="adm-cono-tipo" name="adm-cono-tipo[]" class="select2" multiple="multiple" autofocus required>
                                @foreach ($listaMultiselect as $item)
                                    <option value="{{ $item->id_unico }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('adm-cono-tipo', '<strong class="message-error text-danger id="err"">:message</strong>') !!}
                        </div>
                        <div class="form-group row mb-1">
                            <label for="adm-cono-ci"  class="col-sm-1 col-form-label">CI:</label>
                            <div class="col-sm-5">
                                <input type="number" name="adm-cono-ci" placeholder="Ingrese su carnet" class="form-control" id="adm-cono-ci" required>
                            </div> <div class="col-sm-6">
                                <button type="button" class="btn btn-primary" onclick="comprobar({{ $listaEva }})">Comprobar Existencia</button>
                            </div>
                            {!! $errors->first('adm-cono-ci', '<div class="error" id="err"> <strong class="message-error text-danger col-sm-12">:message</strong></div>') !!}
                        </div>
                        <div class="d-none text-left col-sm-12 mt-0" id="ci-no-existe">
                            <strong class="text-primary">El CI ingresado ya exite</strong>
                        </div>
                        <div class="d-none text-left col-sm-12 mt-0" id="ci-existe">
                            <strong class="text-success">El CI ingresado aun no existe</strong>
                        </div>
                        <div class="form-group row mt-4">
                            <label for="adm-cono-nombre" class="col-sm-3 col-form-label">Nombre:</label>
                            <div class="col-sm-9">
                            <input type="text" name="adm-cono-nombre" value="{{ old('adm-cono-nombre') }}" minlength="3" disabled id="adm-nom" class="form-control" required>
                            </div>
                            {!! $errors->first('adm-cono-nombre', '<strong class="message-error text-danger col-sm-12">:message</strong>') !!}
                        </div>
                        <div class="form-group row">
                            <label for="adm-ape" class="col-sm-3 col-form-label">Apellidos:</label>
                            <div class="col-sm-9">
                            <input type="text" name="adm-cono-apellidos" value="{{ old('adm-cono-apellidos') }}" minlength="3" disabled id="adm-ape" class="form-control" required>
                            </div>
                            {!! $errors->first('adm-cono-apellidos', '<strong class="message-error text-center text-danger col-sm-12">:message</strong>') !!}
                        </div>
                        <div class="form-group row">
                        <label for="adm-cono-correo"  class="col-sm-3 col-form-label">Correo:</label>
                        <div class="input-group col-sm-9">
                            <input type="email" class="form-control mt-0" name="adm-cono-correo" disabled id="adm-correo" aria-label="Recipient's username" 
                                aria-describedby="basic-addon2" value="{{ old('adm-cono-correo') }}" required>
                            <div class="input-group-append">
                              <span class="input-group-text" id="basic-addon2">@</span>
                            </div>
                        </div>
                        {!! $errors->first('adm-cono-correo', '<strong class="message-error text-danger text-right col-sm-10 mt-0 mb-1">:message</strong>') !!}
                        </div>
                        <div class="form-group row">
                        <label for="adm-cono-correo2"  class="col-sm-3 col-form-label">Correo Alt(*)</label>
                        <div class="input-group col-sm-9">
                            <input type="email" class="form-control" name="adm-cono-correo2" disabled id="adm-correo2" aria-label="Recipient's username" 
                                aria-describedby="basic-addon2">
                            <div class="input-group-append">
                              <span class="input-group-text" id="basic-addon2">@</span>
                            </div>
                        </div>
                        {!! $errors->first('adm-cono-correo2', '<strong class="message-error text-danger text-center col-sm-12">:message</strong>') !!}
                        </div>
                        @if ($errors->any())
                            <script>
                                window.onload = () => {
                                    document.getElementById("adm-nom").disabled = false;
                                    $('#admConoModal').modal('show');
                                    document.getElementById("adm-nom").disabled = false;
                                    document.getElementById("adm-ape").disabled = false;
                                    document.getElementById("adm-correo").disabled = false;
                                    document.getElementById("adm-correo2").disabled = false;
                                    document.getElementById("button-guardar").disabled = false;
                                }
                            </script>
                        @endif
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" form="from-adm-conocimientos" class="btn btn-info" id="button-guardar" disabled>Guardar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal para editar evaluador de conocimientos --}}
<div class="modal fade" id="editEvalConociminetos" tabindex="-1" role="dialog" aria-labelledby="admConoModalTitle"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="admConoModalTitle">Editar Evaluador de Conocimientos</h5>
            <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('admConoUpdate') }}" id="from-adm-conocimientos-edit">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <input type="hidden" id="id-evaluador" value="{{ old('id-evaluador') }}" name="id-evaluador">
                <input type="hidden" id="id_eva_conv" value="{{ old('id_eva_conv') }}" name="id_eva_conv">
                <div class="form-group">
                    <label for="adm-cono-tipo">Auxiliatura:</label>
                    <select name="adm-cono-tipo2[]" class="select2" id="select-cono" multiple="multiple" required>
                        @foreach ($listaMultiselect as $item)
                        <option value="{{ $item->id_unico }}">{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                {!! $errors->first('adm-cono-tipo', '<strong class="message-error text-danger id="err"">:message</strong>') !!}
                </div>
                <div class="form-group row">
                        <label for="adm-cono-ci-edit" class="col-sm-3 col-form-label">Carnet:</label>
                        <div class="col-sm-9">
                        <input type="number" name="adm-cono-ci-edit" value="{{ old('adm-cono-ci-edit') }}" readonly class="form-control" id="adm-cono-ci-edit" required>
                        </div>
                    {!! $errors->first('adm-cono-ci', '<p class="message-error text-danger id="err"">:message</p>') !!}
                </div>
                <div class="d-none text-center col-sm-6" id="ci-no-existe">
                    <p class="text-success">El CI ingresado ya exite</p>
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
                    <input type="text" name="adm-cono-apellidos-edit" value="{{ old('adm-cono-apellidos-edit') }}" id="adm-cono-apellidos-edit" minlength="3" class="form-control" required>
                    </div>
                    {!! $errors->first('adm-cono-apellidos-edit', '<strong class="message-error text-danger id="err"">:message</strong>') !!}
                </div>
                <div class="form-group row">
                    <label for="adm-cono-correo-edit"  class="col-sm-3 col-form-label">Correo:</label>
                    <div class="input-group col-sm-9">
                        <input type="email" class="form-control" name="adm-cono-correo-edit" value="{{ old('adm-cono-correo-edit') }}" id="adm-cono-correo-edit" aria-label="Recipient's username" 
                            aria-describedby="basic-addon2" required>
                        <div class="input-group-append">
                          <span class="input-group-text" id="basic-addon2">@</span>
                        </div>
                    </div>
                    {!! $errors->first('adm-cono-correo-edit', '<strong class="message-error text-danger text-right col-sm-10 mt-0 mb-1">:message</strong>') !!}
                </div>
                <div class="form-group row">
                    <label for="adm-cono-correo2-edit"  class="col-sm-3 col-form-label">Correo Alt(*)</label>
                    <div class="input-group mb-1 col-sm-9">
                        <input type="email" class="form-control" name="adm-cono-correo2-edit" value="{{ old('adm-cono-correo2-edit') }}" id="adm-cono-correo2-edit" aria-label="Recipient's username" 
                            aria-describedby="basic-addon2">
                        <div class="input-group-append">
                          <span class="input-group-text" id="basic-addon2">@</span>
                        </div>
                    </div>
                    {!! $errors->first('adm-cono-correo2-edit', '<strong class="message-error text-danger text-right col-sm-10 mt-0 mb-1">:message</strong>') !!}
                </div>
                @if ($errors->any())
                    <script>
                        window.onload = () => {
                            $('#editEvalConociminetos').modal('show');
                        }
                    </script>
                @endif
            </form>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" form="from-adm-conocimientos-edit" class="btn btn-info" id="button-guardar2">Guardar</button>
        </div>
    </div>
</div>
</div>

    
@endsection