@extends('convocatory.layoutConvocatory')

@section('content-convocatory')
    
    <!-- Contenido real de la página -->
    <div class="overflow-auto content">
        <h1>Requisitos</h1>
                
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
              <h5 class="modal-title" id="exampleModalLongTitle">Añadir nuevo requisito</h5>
              <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Inciso A:</label>
                      <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Ingrese el requisito" rows="3"></textarea>
                      <small id="emailHelp" class="form-text text-muted">Los requisitos son creados atravez de indices alfabeticos.</small>
                    </div>
                  </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-info">Guardar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection