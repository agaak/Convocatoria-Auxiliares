@extends('convocatory.layoutConvocatory')

@section('content-convocatory')
    <!-- Contenido real de la página -->
    <div class="overflow-auto content">
        <h5 style="margin: 25px" class="font-weight-bold">Calificacion de Conocimientos</h5>
      <!-- Button trigger modal -->
      <button type="button" style="margin-left: 15px" class="btn add-item" data-toggle="modal" data-target="#exampleModalCenter">
        <a data-toggle="modal" data-target="#exampleModalCenter">
          <img src="{{ asset('img/addBLUE.png')}}" width="35" height="35">
        </a> Añadir Tematica
      </button>

        <!-- Table -->
    <div class="table-requests">
        <table class="table table-bordered" style="text-align: center">
          <thead class="thead-dark">
            <tr>
              <th style="vertical-align: middle; font-weight: normal;" scope="col" rowspan="2">#</th>
              <th style="vertical-align: middle; font-weight: normal;" scope="col" rowspan="2">Tematica</th>
              <th style="font-weight: normal" scope="col" colspan="6">Codigo de Auxiliatura</th>
              <th style="vertical-align: middle; font-weight: normal;" scope="col" rowspan="2">Opciones</th>
            </tr>
            <tr>
              <th style="font-weight: normal" scope="col">LCO-ADM</th>
              <th style="font-weight: normal" scope="col">LDS-ADM</th>
              <th style="font-weight: normal" scope="col">LDS-AUX</th>
              <th style="font-weight: normal" scope="col">LM-AUX</th>
              <th style="font-weight: normal" scope="col">LM-ADM</th>
              <th style="font-weight: normal" scope="col">LM-AUX</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="table-light">1</td>
              <td class="table-light">ADM LINUX</td>
              <td class="table-light">0</td>
              <td class="table-light">0</td>
              <td class="table-light">0</td>
              <td class="table-light">0</td>
              <td class="table-light">0</td>
              <td class="table-light">0</td>
              <td class="table-light"><a class="options" data-toggle="modal" data-target="#exampleModalCenter">
                  <img src="{{ asset('img/pen.png')}}" width="30" height="30">
                </a>
                <a class="options">
                  <img src="{{ asset('img/trash.png')}}" width="30" height="30">
                </a></td>
            </tr>
          </tbody>
        </table>
        </div>
      <!-- Modal -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Tematica</h5>
          <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('request') }}">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="nombre">Nueva Tematica</label>
              <input name="nombre" type="text" class="form-control" id="nombre" aria-describedby="emailHelp" placeholder="Linux Avanzado" required>
              <div class="form-row " style="margin-top: 20px">
                <div class="form-group col-6">
                  <div class="row">
                  <label for="nombre colFormLabelSm" class="col-sm-8 col-form-label">Valor por defecto:</label>
                  <div class="col-sm-4">
                  <input name="item" type="text" class="form-control form-control-sm" id="item" placeholder="30" required>
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
      </div></div></div>
    <div class="my-5 py-5 text-center">
        <a href="{{ route('knowledgeRating') }}" class="btn btn-info" tabindex="-1" role="button" aria-disabled="true">Finalizar</a>
    </div>
    </div>
@endsection