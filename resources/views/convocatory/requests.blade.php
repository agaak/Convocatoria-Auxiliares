@extends('convocatory.layoutConvocatory')

@section('content-convocatory')

<div class="overflow-auto content">

  <h3 class="text-uppercase text-center">Requerimientos</h3>

  <!-- Button trigger modal -->
  <div class="my-3" style="margin-left: 3ch">
    <a class="text-decoration-none" type="button" data-toggle="modal" data-target="#requestModal">
      <img src="{{ asset('img/addBLUE.png') }}" width="30" height="30">
      <span class="mx-1">Añadir requerimiento</span>
    </a>
  </div>

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
          <form method="POST" action="{{ route('requestValid') }}" id="request">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="nombre">Nombre de Auxiliatura</label>
              <input name="nombre" type="text" class="form-control" id="nombre" aria-describedby="emailHelp" autofocus
                placeholder="Ingresa el nombre de la auxiliatura" required>
              <div class="form-row " style="margin-top: 20px">
                <div class="form-group col-6">
                  <div class="row">
                    <label for="nombre colFormLabelSm" class="col-sm-4 col-form-label">Item</label>
                    <div class="col-sm-8">
                      <input name="item" type="number" class="form-control form-control-sm" id="item" placeholder="1"
                        min="1" max="50" required>
                    </div>
                  </div>
                </div>
                <div class="form-group col-6">
                  <div class="row">
                    <label for="codigo_pro colFormLabelSm" class="col-sm-4 col-form-label">Cantidad</label>
                    <div class="col-sm-8">
                      <input name="codigo_pro" type="number" class="form-control form-control-sm" id="cantidad"
                        placeholder="3" min="1" max="20" required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-6">
                  <div class="row">
                    <label for="marca colFormLabelSm" class="col-sm-8 col-form-label">Hrs.Academicas/mes</label>
                    <div class="col-sm-4">
                      <input name="marca" type="number" class="form-control form-control-sm" id="hr-aca"
                        placeholder="80" min="1" max="100" required>
                    </div>
                  </div>
                </div>
                <div class="form-group col-6">
                  <div class="row">
                    <label for="precio colFormLabelSm" class="col-sm-6 col-form-label">Codigo Aux.</label>
                    <div class="col-sm-6">
                      <input name="precio" type="text" class="form-control form-control-sm" id="cod-aux"
                        placeholder="LCO-ADM" style="text-transform:uppercase;" required>
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
  <!-- Table -->
  <div class="table-requests">
    <table class="table table-bordered" style="text-align: center">
      <thead class="thead-dark">
        <tr>
          <th style="font-weight: normal" scope="col">Items</th>
          <th style="font-weight: normal" scope="col">Cantidad</th>
          <th style="font-weight: normal" scope="col">Hrs. Academicas/Mes</th>
          <th style="font-weight: normal" scope="col">Nombre de la Auxiliatura</th>
          <th style="font-weight: normal" scope="col">Codigo de Auxiliatura</th>
          <th style="font-weight: normal" scope="col">Opciones</th>
        </tr>
      </thead>
      <tbody style="background-color: white">
        @foreach($requests as $reques)
        <tr>
          <td>{{ $reques->item }}</td>
          <td>{{ $reques->cantidad }} Aux.</td>
          <td>{{ $reques->horas_mes }} hrs/mes</td>
          <td>{{ $reques->nombre }}</td>
          <td>{{ $reques->cod_aux }}</td>
          <td><a class="options" data-toggle="modal" data-target="#requestEditModal" data-item="{{ $reques->item }}"
              data-cantidad="{{ $reques->cantidad }}" data-horas_mes="{{ $reques->horas_mes }}" data-id="{{ $reques->id }}"
              data-nombre="{{ $reques->nombre }}" data-cod_aux="{{ $reques->cod_aux }}" data-dismiss="modal"><img
                src="{{ asset('img/pen.png') }}" width="25" height="25"></a>
                  
                  <form class="d-inline" action="{{ route('requestDelete', $reques->id) }}" method="POST">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}
                  
                  <button type="submit" >
                      <img src="{{ asset('img/trash.png') }}" width="30" height="30">
                     
              </form></td>
        </tr>@endforeach
      </tbody>
    </table>
  </div>
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
          <form method="POST" action="{{ route('requestUpdate') }}" role="form" autocomplete="off">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <input type="hidden" id="id-request" name="id-request">
            <div class="form-group">
              <label for="nombre">Nombre de Auxiliatura</label>
              <input name="nombre-request" type="text" class="form-control" id="nombre-request" aria-describedby="emailHelp" autofocus
              value="{{ old('nombre') }}" required>
              <div class="form-row " style="margin-top: 20px">
                <div class="form-group col-6">
                  <div class="row">
                    <label for="nombre colFormLabelSm" class="col-sm-4 col-form-label">Item</label>
                    <div class="col-sm-8">
                      <input name="item-request" type="number" class="form-control form-control-sm" id="item-request"
                        min="1" max="50" required>
                    </div>
                  </div>
                </div>
                <div class="form-group col-6">
                  <div class="row">
                    <label for="codigo_pro colFormLabelSm" class="col-sm-4 col-form-label">Cantidad</label>
                    <div class="col-sm-8">
                      <input name="cantidad-request" type="number" class="form-control form-control-sm" id="cantidad-request"
                        min="1" max="20" required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-6">
                  <div class="row">
                    <label for="marca colFormLabelSm" class="col-sm-8 col-form-label">Hrs.Academicas/mes</label>
                    <div class="col-sm-4">
                      <input name="horas_mes-request" type="number" class="form-control form-control-sm" id="horas_mes-request"
                        min="1" max="100" required>
                    </div>
                  </div>
                </div>
                <div class="form-group col-6">
                  <div class="row">
                    <label for="precio colFormLabelSm" class="col-sm-6 col-form-label">Codigo Aux.</label>
                    <div class="col-sm-6">
                      <input name="cod_aux-request" type="text" class="form-control form-control-sm" id="cod_aux-request"
                        style="text-transform:uppercase;" required>
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

        

  <div class="my-5 py-5 text-center">
    <a href="{{ route('requirement') }}" class="btn btn-info" tabindex="-1" role="button"
      aria-disabled="true">Siguiente</a>
  </div>
</div>

@endsection