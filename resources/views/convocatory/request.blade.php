@extends('convocatory.layoutConvocatory')

@section('content-convocatory')

<!-- Contenido real de la página -->
<div class="overflow-auto content">
  <h5 style="margin: 20px" class="font-weight-bold">Requerimientos</h5>

  <!-- Button trigger modal -->
  <button type="button" style="margin-left: 15px" class="btn add-item" data-toggle="modal" data-target="#exampleModalCenter">
    <a data-toggle="modal" data-target="#exampleModalCenter">
      <img src="{{ asset('img/addBLUE.png')}}" width="35" height="35">
    </a> Añadir requerimiento
  </button>

  <!-- Modal -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Requerimiento</h5>
          <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="background-color: #E7E7E7">
          <form method="POST" action="{{ route('request') }}">
            <div class="form-group">
              <label for="nombre">Nombre de Auxiliatura</label>
              <input name="nombre" type="text" class="form-control" id="nombre" aria-describedby="emailHelp" placeholder="Ingresa el nombre de la auxiliatura" required>
              <div class="form-row " style="margin-top: 20px">
                <div class="form-group col-6">
                  <div class="row">
                  <label for="nombre colFormLabelSm" class="col-sm-4 col-form-label">Item</label>
                  <div class="col-sm-8">
                  <input name="item" type="text" class="form-control form-control-sm" id="item" placeholder="1" required>
                  </div>
                  </div>
                </div>
                <div class="form-group col-6">
                <div class="row">
                  <label for="codigo_pro colFormLabelSm"  class="col-sm-4 col-form-label">Cantidad</label>
                  <div class="col-sm-8">
                  <input name="codigo_pro" type="text" class="form-control form-control-sm" id="cantidad" placeholder="3" required>
                  </div>
                </div>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-6">
                <div class="row">
                  <label for="marca colFormLabelSm" class="col-sm-8 col-form-label">Hrs.Academicas/mes</label>
                  <div class="col-sm-4">
                  <input name="marca" type="text" class="form-control form-control-sm" id="hr-aca" placeholder="80" required>
                  </div>
                </div>
              </div>
                <div class="form-group col-6">
                <div class="row">
                  <label for="precio colFormLabelSm" class="col-sm-6 col-form-label">Codigo Aux.</label>
                  <div class="col-sm-6">
                  <input name="precio" type="text" class="form-control form-control-sm" id="cod-aux" placeholder="LCO-ADM" required>
                  </div>
                </div>
                </div>
              </div>
              
              </fieldset>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <input class="btn btn-info" type="submit" value="Guardar"></input>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
    <!-- Table -->
    <div class="table-requests">
    <table class="table" style="text-align: center">
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
        <tr>
          <td>1</td>
          <td>7 Aux.</td>
          <td>80 hrs/mes</td>
          <td>Administrador de laboratorio de Computo</td>
          <td>LCO-ADM</td>
          <td><a class="options" data-toggle="modal" data-target="#exampleModalCenter">
              <img src="{{ asset('img/pen.png')}}" width="30" height="30">
            </a>
            <a class="options">
              <img src="{{ asset('img/trash.png')}}" width="30" height="30">
            </a></td>
        </tr>
      </tbody>
    </table>
    </div>
    

<div class="my-5 py-5 text-center">
  <a href="{{ route('requirement') }}" class="btn btn-info" tabindex="-1" role="button" aria-disabled="true">Siguiente</a>
</div>
</div>

@endsection