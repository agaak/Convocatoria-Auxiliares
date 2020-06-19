@extends('convocatory.layoutConvocatory')

@section('content-convocatory')

<div class="overflow-auto content">

  <h3 class="text-uppercase text-left">seccion Requerimientos</h3>

  <!-- Button trigger modal -->
  @if (!session()->get('ver'))
    <div class="my-3" style="margin-left: 3ch">
      <a class="text-decoration-none" type="button" data-toggle="modal" data-target="#requestModal">
        <img src="{{ asset('img/addBLUE.png') }}" width="30" height="30">
        <span class="mx-1">Añadir requerimiento</span>
      </a>
    </div> 
  @endif 

  <!-- Modal -->
  <div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="requestTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="requestTitle">Requerimiento</h5>
          <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('create') }}" id="request">
            {{ csrf_field() }}
            <div class="form-group">
              @if($auxs->isEmpty())
              <label for="nombre">No hay auxiliaturas para añadir</label>
              @else
              <label for="nombre">Nombre de Auxiliatura</label>
              <select class="form-control" id="id-aux" name="id-aux">
                @foreach($auxs as $aux) 
                  <option value="{{$aux->nombre_aux}}|{{$aux->id}}">{{ $aux->nombre_aux }}</option>
                @endforeach
              </select>
              <div class="form-row " style="margin-top: 20px">
                <div class="form-group col-6">
                  <div class="row">
                    <label for="codigo_pro colFormLabelSm" class="col-sm-4 col-form-label">Cantidad</label>
                    <div class="col-sm-8">
                      <input name="cantidad" type="number" class="form-control form-control-sm" id="cantidad"
                        placeholder="3" min="1" max="20" required>
                    </div>
                  </div>
                </div>
                <div class="form-group col-6">
                  <div class="row">
                    <label for="marca colFormLabelSm" class="col-sm-8 col-form-label">Hrs.Academicas/mes</label>
                    <div class="col-sm-4">
                      <input name="horas" type="number" class="form-control form-control-sm" id="horas"
                        placeholder="80" min="1" max="100" required>
                    </div>
                  </div>
                </div>
              </div>
              @endif
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <input class="btn btn-info" type="submit" value="Guardar">
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
  <!-- Visualizar Tabla Meritos-->
  @component('components.convocatoria.tablaRequerimientos', ['requests' => $requests])
  @endcomponent
<!-- Edit Modal-->
  <div class="modal fade" id="requestEditModal" tabindex="-1" role="dialog" aria-labelledby="requestTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="requestTitle">Editar Requerimiento</h5>
          <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('update') }}" role="form" autocomplete="off">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <input type="hidden" id="id-request" name="id-request">
            <div class="form-group">
              <label for="nombre">Nombre de Auxiliatura</label>
              <select class="form-control" id="id-aux-request" name="id-aux-request">
                @foreach($auxs as $aux) 
                  <option value="{{$aux->id}}">{{ $aux->nombre_aux }}</option>
                @endforeach
              </select>
              <div class="form-row " style="margin-top: 20px">
                <div class="form-group col-6">
                  <div class="row">
                    <label for="codigo_pro colFormLabelSm" class="col-sm-4 col-form-label">Cantidad</label>
                    <div class="col-sm-8">
                      <input name="cantidad-request" type="number" class="form-control form-control-sm" id="cantidad-request"
                        placeholder="3" min="1" max="20" required>
                    </div>
                  </div>
                </div>
                <div class="form-group col-6">
                  <div class="row">
                    <label for="marca colFormLabelSm" class="col-sm-8 col-form-label">Hrs.Academicas/mes</label>
                    <div class="col-sm-4">
                      <input name="horas_mes-request" type="number" class="form-control form-control-sm" id="horas_mes-request"
                        placeholder="80" min="1" max="100" required>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <input class="btn btn-info" type="submit" value="Guardar">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>

@endsection