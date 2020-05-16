@extends('convocatory.layoutConvocatory')

@section('content-convocatory')
    <!-- Contenido real de la página -->
    <div class="overflow-auto content">
        <h3 style="margin: 20px">Requerimientos</h3><br>

        <!-- Button trigger modal -->
  
        
 
      
<button type="button" style="margin-left: 65px" class="btn add-item" data-toggle="modal" data-target="#exampleModalCenter">
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
  <div class="col-md-10" style="margin-left: 50px">
        <table class="table table-striped">
            <thead class="thead-dark">
              <tr>
                <th style="font-weight: normal" scope="col">Items</th>
                <th style="font-weight: normal" scope="col">Cantidad</th>
                <th style="font-weight: normal" scope="col">Hrs. Academicas</th>
                <th style="font-weight: normal" scope="col">Nombre de la Auxiliatura</th>
                <th style="font-weight: normal" scope="col">Codigo de Auxiliatura</th>
                <th style="font-weight: normal" scope="col">Opciones</th>
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
                  <a class="options" >
                <img src="{{ asset('img/trash.png')}}" width="30" height="30">
                  </a></td>
              </tr>
            </tbody>
          </table>
  </div>
    </div>
@endsection