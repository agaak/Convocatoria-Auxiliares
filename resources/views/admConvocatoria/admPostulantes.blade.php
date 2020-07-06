@extends('admConvocatoria.layaoutAdmConvocatoria')

@section('content-adm-convocatoria')
<div class="overflow-auto content" style="width: 100vw; height: 77vh;">

    <h3 class="text-uppercase">Postulantes</h3>
    {{-- Triger modal --}}
    <div class="row mr-1 ml-1">
        <button type="button" class="btn btn-dark my-3 col-xs-2" data-toggle="modal" 
        data-target="#storePostulanteModal">Registrar postulante</button>
        <div class="col"></div>
        @if ($prePostulante->pre_posts_habilitado)
            <a href="{{ route('habilitarPostulante', $prePostulante->id) }}" id="pre-posts-habilitar" type="button" class="btn btn-secondary my-3 col-xs-2">Deshabilitar Postulanciones</a> 
        @else
            <a href="{{ route('habilitarPostulante', $prePostulante->id) }}" id="pre-posts-habilitar" type="button" class="btn btn-success my-3 col-xs-2">Habilitar Postulanciones</a>  
        @endif
    </div>
    
    <!-- Table -->
    <div class="table-requests1" >
        <table id="postulantesConv" class="table table-striped table-bordered" style="width:100%" style="text-align:left">
        <thead class="thead-dark">
            <tr> 
            <th style="font-weight: normal" scope="col">Item</th>
            {{-- <th style="font-weight: normal" scope="col">#</th> --}}
            <th style="font-weight: normal" scope="col">CI</th>
            <th style="font-weight: normal" scope="col">Apellido</th>
            <th style="font-weight: normal" scope="col">Nombre</th>
            <th style="font-weight: normal" scope="col" class="text-center">Fecha de recepcion de documentos</th>
            {{-- th style="font-weight: normal" scope="col">Apellidos</th> --}}
            </tr>
        </thead>
        <tbody style="background-color: white">
            {{-- @php $num = 1  @endphp --}}
            @foreach($listPostulantes as $item)
                <tr>
                <th style="font-weight: normal">{{$item->nombre_aux}}</th>
                {{-- <th style="font-weight: normal">{{ $num++ }}</th> --}}
                <th style="font-weight: normal">{{ $item->ci }}</th>
                <th style="font-weight: normal">{{ $item->apellido }}</th>
                <th style="font-weight: normal">{{ $item->nombre }}</th>
                <th style="font-weight: normal" class="text-center">{{ $item->created_at }}</th>
                {{-- <th style="font-weight: normal">{{ $item->apellido }}</th> --}}
                </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    <br>

    <div class="modal fade" id="storePostulanteModal" tabindex="-1" role="dialog" aria-labelledby="postModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="postModalTitle">Registro Postulante</h5>
                <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <form method="POST" action="{{ route('admPostulanteCreate') }}" id="form-create-postulante">
                    {{ csrf_field() }}
                    
                    <input type="hidden" name="id-conv-postulante" id="id-conv-postulante" value="">
                    <div class="form-group row pr-0 mb-3">
                        <div class="col-auto">
                        <label for="adm-post-rotulo"  class="col-form-label col-form-label">Rotulo:</label>
                        </div>
                        <div class="col-4 px-0">
                            <input type="text" name="adm-post-rotulo" placeholder="Ingrese su rotulo" class="form-control form-control" id="adm-post-rotulo" required>
                        </div> <div class="col-auto">
                            <button type="button" class="btn btn-primary" onclick="comprobarRotulo({{ $listaRotulos }}, {{ $listaAux }})">Comprobar Postulante</button>
                        </div>
                        {!! $errors->first('adm-post-rotulo', '<div class="error" id="err"> <strong class="message-error text-danger col-sm-12">:message</strong></div>') !!}
                    </div>
                    {!! $errors->first('ci', '<div class="error" id="err"> <strong class="message-error text-danger col-sm-12">:message</strong></div>') !!}
                    <div class="d-none text-left col-sm-12 mt-0" id="rotulo-no-existe">
                        <strong class="text-primary">El rotulo ingresado existe</strong>
                    </div>
                    <div class="d-none text-left col-sm-12 mt-0" id="rotulo-existe">
                        <strong class="text-danger">El rotulo ingresado no existe</strong>
                    </div>

                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="adm-cono-nombre" class="col-sm-5 col-form-label pr-0">N° Hojas:</label>
                                <div class="col-sm-7 pl-0">
                                    <input class="form-control" type="text" disabled id="post-hojas" name="hojas" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="adm-cono-nombre" class="col-sm-5 col-form-label mx-0 pr-0">Código SIS:</label>
                                <div class="col-sm-7 mx-0 pl-0">
                                    <input class="form-control mx-0" type="text" disabled id="post-cod" pattern="[0-9]+" name="cod-sis" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="d-block">Auxiliatura:<br>
                            <select name="auxiliaturas[]" class="select2" readonly id="auxiliaturas" multiple="multiple" required>
                            </select>
                        </label>
                    </div>
                    <div class="form-group row">
                        <label for="adm-cono-nombre" class="col-sm-3 col-form-label">Nombres:</label>
                        <div class="col-sm-9">
                        <input type="text" name="postulante-nombre" disabled id="post-nom" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="adm-cono-nombre" class="col-sm-3 col-form-label">Apellidos:</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" disabled id="post-ape" name="postulante-apellidos" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="adm-cono-nombre" class="col-sm-3 col-form-label">Dirección:</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" disabled id="post-dir" name="postulante-direccion" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="adm-cono-correo"  class="col-sm-3 col-form-label">Correo:</label>
                        <div class="input-group col-sm-9">
                            <input type="email" class="form-control mt-0" id="post-cor" name="correo-direccion" disabled aria-label="Recipient's username" 
                                aria-describedby="basic-addon2" required>
                            <div class="input-group-append">
                              <span class="input-group-text" id="basic-addon2">@</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="adm-cono-nombre" class="col-sm-4 col-form-label">Teléfono:</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" disabled id="post-tel" name="telefono" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="adm-cono-nombre" class="col-sm-3 col-form-label">Carnet:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" disabled id="post-ci" name="ci" pattern="[0-9]{4,10}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @if($errors->any())
                            <script>
                                window.onload = () => {
                                    $('#storePostulanteModal').modal('show');
                                }
                            </script>
            @endif
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-info" form="form-create-postulante" id="bttn-post" disabled>Guardar</button>
            </div>
        </div>
    </div>
</div>{{-- 
<button type="button" class="btn btn-secondary">
    <a href="/convocatoria/adm-postulantes/habilitadosPDF" style="color: #FFFF;">PDF</a>
</button> --}}
</div>

<script src="{{ asset('js/jquery-3.5.1.slim.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#postulantesConv').DataTable( {
            "pageLength":70,
            responsive: true,
            "columnDefs": [
            /* { "orderable": false}, */
            { "visible": false, "targets": 0 }
            ],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
            },"bLengthChange": false,
            orderFixed: [[ 0, 'asc' ],[ 2, 'asc' ],[ 3, 'asc' ]],
            rowGroup: {
                dataSrc: 0,startRender: function (rows, group) {
                return group + ' (' + rows.count() + ' postulantes)';
        }
            },
            
        } );
    } );
</script>
@endsection

    
    
