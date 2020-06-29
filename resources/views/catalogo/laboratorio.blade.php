@extends('layout')

@section('content')
    <div class="overflow-auto content-div">

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
                        <form method="POST" accion="{{ route('laboratorio.save') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="d-block">Nombre:
                                    <input type="text" class="form-control" name="nombre-auxs-lab" value="{{ old('nombre-auxs-lab') }}" required>
                                </label>
                                {!! $errors->first('nombre-auxs-lab', '<strong class="message-error text-danger">:message</strong>') !!}
                            </div>
                            <div class="form-group">
                                <label class="d-block">Código:
                                    <input type="text" class="form-control" name="codigo-auxs-lab" value="{{ old('codigo-auxs-lab') }}"
                                    onkeyup="javascript:this.value=this.value.toUpperCase()" required>
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
        
        <div class="container">
            <h3 class="text-uppercase text-left mb-3">Laboratorio</h3>
            <ul class="nav nav-pills mb-3" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="pills-auxiliaturas-tab" data-toggle="pill" 
                    href="#pills-auxiliaturas" role="tab" aria-controls="pills-auxiliaturas" aria-selected="true">Auxiliaturas</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-tematicas-tab" data-toggle="pill" href="#pills-tematicas"
                    role="tab" aria-controls="pills-tematicas" aria-selected="false">Temáticas</a>
                </li>
            </ul>
            <div class="tab-content">

                {{-- Seccion de las auxiliaturas --}}

                <div class="tab-pane fade show active" id="pills-auxiliaturas" role="tabpanel" aria-labelledby="pills-auxiliaturas-tab">
                    <a class="mb-3" type="button" data-toggle="modal" data-target="#agregarAuxiliaturas">
                        <img src="{{ asset('img/addBLUE.png') }}" width="30" height="30">
                        <span class="mx-1">Añadir Auxiliatura</span>
                    </a>
                    <div class="text-center">
                        {!! $errors->first('existe', '<strong class="message-error text-danger">:message</strong>') !!}
                    </div>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">Nro.</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Código</th>
                            <th scope="col" class="text-center">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < count($auxiliaturas); $i++)
                                <tr>
                                    <th scope="row">{{ $i+1 }}</th>
                                    <td>{{ $auxiliaturas[$i]->nombre_aux }}</td>
                                    <td>{{ $auxiliaturas[$i]->cod_aux }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-link p-1" data-toggle="modal" data-target="#editarAuxiliaturas" data-dismiss="modal"
                                        onclick="">
                                            <img src="{{ asset('img/pen.png') }}" width="25" height="25">
                                        </button> 
                                        <form class="d-inline" action="{{ route('laboratorio.delete', $auxiliaturas[$i]->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <input type="hidden" name="exite" value="">
                                            <button type="submit" class="btn btn-link p-1">
                                                <img src="{{ asset('img/trash.png') }}" width="25" height="25">
                                            </button>    
                                        </form>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>

            <div class="tab-pane fade" id="pills-tematicas" role="tabpanel" aria-labelledby="pills-tematicas-tab">tematicas</div>

            </div>
        </div>


    </div>
@endsection