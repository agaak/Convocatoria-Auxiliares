@extends('convocatory.layoutConvocatory')

@section('content-convocatory')
    
    <!-- Contenido real de la página -->
    <div class="overflow-auto content">
        <h5 style="margin: 20px" class="font-weight-bold">REQUISITOS</h5>
        <br>
        <div style="margin-left: 50px">
            <button type="button" class="btn add-item" data-toggle="modal" data-target="#exampleModalCenter">
                <a class="add-item" data-toggle="modal" data-target="#exampleModalCenter">
                    <img src="{{ asset('img/addBLUE.png')}}" width="35" height="35">
                </a> Añadir requerimiento
            </button>
            <div class="table-requests">
                <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th style="font-weight: normal" scope="col">#</th>
                        <th style="font-weight: normal" scope="col">Descripcion</th>
                        <th style="font-weight: normal" scope="col">Opciones</th>
                      </tr>
                    </thead>
                    <tbody style="background-color: white">
                      <tr>
                        <th scope="row">A</th>
                        <td>Ser estudiante regular y con rendimiento de las carreras de Licenciatura en Ingeniería
                          Informática o Licenciatura en Ingeniería de Sistemas y/o afín, que cursa regularmente en la
                          universidad. Para administrador de Laboratorio de Mantenimiento de Hardware podrán
                          presentarse además estudiantes de Ing. Electrónica. Estudiante regular es aquel que está
                          inscrito en la gestión académica vigente y cumple los requisitos exigidos para seguir una
                          carrera universitaria y el rendimiento académico, haber aprobado más de la mitad de las
                          materias curriculares que corresponde al semestre anterior, certificado por el
                          departamento de Registros e Inscripciones.</td>
                        <td style="text-align: center">
                            <a class="options" data-toggle="modal" data-target="#exampleModalCenter">
                                <img src="{{ asset('img/pen.png')}}" width="25" height="25">
                            </a>
                            <a class="options" data-toggle="modal" data-target="#exampleModalCenter">
                                <img src="{{ asset('img/trash.png')}}" width="25" height="25">
                            </a>
                        </td>
                      </tr>
                    </tbody>
                </table>
                <form>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nota(*)</label>
                      <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Ingrese la nota respectiva" rows="3"></textarea>
                    </div>
                </form>
                <div style="text-align: center">
                    <button type="button" class="btn btn-info">Siguiente</button>
                </div>
            </div>
        </div>
        
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