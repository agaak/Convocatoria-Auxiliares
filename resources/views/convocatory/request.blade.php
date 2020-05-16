@extends('convocatory.layoutConvocatory')

@section('content-convocatory')
    <!-- Contenido real de la página -->
    <div class="overflow-auto content">
        <h3>Requerimientos</h3><br>

        <!-- Button trigger modal -->
        
<button type="button" class="btn btn-light add-item" data-toggle="modal" data-target="#exampleModalCenter">
<a class="add-item" data-toggle="modal" data-target="#exampleModalCenter">
                <img src="{{ asset('img/addBLUE.png')}}" width="35" height="35">
            </a> Añadir requerimiento
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Requerimiento</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </div>
  </div>
        <table class="table table-striped">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Items</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Hrs. Academicas</th>
                <th scope="col">Nombre de la Auxiliatura</th>
                <th scope="col">Codigo de Auxiliatura</th>
                <th scope="col">Opciones</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>7 Aux.</td>
                <td>80 hrs/mes</td>
                <td>Administrador de laboratorio de Computo</td>
                <td>LCO-ADM</td>
                <td><a class="options" data-toggle="modal" data-target="#exampleModalCenter">
                <img src="{{ asset('img/pen.png')}}" width="30" height="30">
                  </a>
                  <a class="options" data-toggle="modal" data-target="#exampleModalCenter">
                <img src="{{ asset('img/trash.png')}}" width="30" height="30">
                  </a></td>
              </tr>
            </tbody>
          </table>
    </div>
@endsection