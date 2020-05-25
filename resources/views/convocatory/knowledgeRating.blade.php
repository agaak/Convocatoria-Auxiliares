@extends('convocatory.layoutConvocatory')

@section('content-convocatory')

<div class="overflow-auto content">

  <h3 class="text-uppercase text-center">Calificacion de Conocimientos</h3>

  <div class="card border-dark mb-3">
    <div class="card-body">
      <p class="card-text">La calificación de conocimientos se realiza sobre la base de <strong> 100 </strong> puntos,
        equivalentes al <strong> 80% </strong>
        de la calificación final.</p>
    </div>
  </div>

  <!-- Button trigger modal -->
  <div class="row my-3" style="margin-left: 3ch">
    <a class="text-decoration-none" type="button" data-toggle="modal" data-target="#tematicaModal">
      <img src="{{ asset('img/addBLUE.png') }}" width="30" height="30">
      <span class="mx-1">Añadir Tematica</span>
    </a>
    <a class="text-decoration-none" style="margin-left: 15px" type="button" data-toggle="modal" data-target="#auxiliaturaModal">
      <img src="{{ asset('img/pen.png') }}" width="30" height="30">
      <span class="mx-1">Editar Auxiliatura</span>
    </a>
  </div>

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
          @foreach($lista2 as $item)
            <th style="font-weight: normal" scope="col">{{ $item->cod_aux }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
      @foreach($lista as $item)
        <tr>
          <td class="table-light">{{ $item->id }}</td>
          <td class="table-light">{{ $item->tematica }}</td>
          @foreach($lista2 as $item2)
          <td class="table-light">0</td>
          @endforeach 
          <td class="table-light"><a class="options" data-toggle="modal" data-target="#exampleModalCenter">
              <img src="{{ asset('img/pen.png') }}" width="30" height="30">
            </a>
            <a class="options">
              <img src="{{ asset('img/trash.png') }}" width="30" height="30">
            </a></td>
        </tr>
      @endforeach 
      </tbody>
    </table>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="tematicaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Tematica</h5>
          <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('requests') }}">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="nombre">Nombre de la Tematica</label>
              <input name="nombre" type="text" class="form-control" id="nombre" aria-describedby="emailHelp"
                placeholder="Linux Avanzado" required>
              <div class="form-row " style="margin-top: 20px">
                <div class="form-group col-6">
                  <div class="row">
                    <label class="col-8 col-form-label" for="porcent-merit">Valor por defecto:</label>
                    <input type="number" class="form-control col-sm-4" name="porcentaje-merito" id="porcent-merit"
                      value="30" min="0" max="100" required>
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
  <!-- Modal Auxiliatura-->
  <div class="modal fade" id="auxiliaturaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Auxiliatura</h5>
          <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('requests') }}">
            {{ csrf_field() }}
            <div class="form-group">
              <div class="form-row">
                <label class="col-auto col-form-label" for="department-conv">Auxiliatura</label>
                <div class="col-xl">
                  <select class="form-control" id="department-conv" name="departamento-ant">
                    @php
                      function valor($dato) {
                      $direction = '';
                      if ( old('departamento-ant') == $dato ) {
                      $direction = 'selected';
                      }
                      return $direction;
                      }
                    @endphp
                    <option {{ valor('LCO-ADM') }}>LCO-ADM</option>
                    <option {{ valor('LDS-ADM') }}>LDS-ADM</option>
                    <option {{ valor('LDS-AUX') }}>LDS-AUX</option>
                    <option {{ valor('LM-ADM') }}>LM-ADM</option>
                    <option {{ valor('LM-AUX') }}>LM-AUX</option>
                  </select>
                </div>
              </div>
              <div class="form-row" style="margin-top: 20px">
                <div class="form-group col-7">
                  <div class="row">
                    <label for="marca colFormLabelSm" class="col-sm-12 col-form-label">Tematica 1:<span
                        style="font-weight: normal; margin-left:10px">Linux Avanzado</span></label>
                  </div>
                </div>
                <div class="form-group col-4">
                  <div class="row">
                    <label class="col-sm-7 col-form-label" for="porcent-merit">Porcentaje:</label>
                    <input type="number" class="form-control form-control-sm col-sm-5" name="porcentaje-merito"
                      id="porcent-merit" placeholder="30%" min="0" max="100" required>
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-7">
                  <div class="row">
                    <label for="marca colFormLabelSm" class="col-sm-12 col-form-label">Tematica 2:<span
                        style="font-weight: normal; margin-left:10px">Programacion Web</span></label>
                  </div>
                </div>
                <div class="form-group col-4">
                  <div class="row">
                    <label class="col-sm-7 col-form-label" for="porcent-merit">Porcentaje:</label>
                    <input type="number" class="form-control form-control-sm col-sm-5" name="porcentaje-merito"
                      id="porcent-merit" placeholder="30%" min="0" max="100" required>
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-7">
                  <div class="row">
                    <label for="marca colFormLabelSm" class="col-sm-12 col-form-label">Tematica 4:<span
                        style="font-weight: normal; margin-left:10px">Base de Datos</span></label>
                  </div>
                </div>
                <div class="form-group col-4">
                  <div class="row">
                    <label class="col-sm-7 col-form-label" for="porcent-merit">Porcentaje:</label>
                    <input type="number" class="form-control form-control-sm col-sm-5" name="porcentaje-merito"
                      id="porcent-merit" placeholder="30%" min="0" max="100" required>
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
  <div class="my-5 py-5 text-center">
    <a href="{{ route('knowledgeRating') }}" class="btn btn-info" tabindex="-1" role="button"
      aria-disabled="true">Finalizar</a>
  </div>
</div>
@endsection