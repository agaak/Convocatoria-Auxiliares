@extends('convocatory.layoutConvocatory')

@section('content-convocatory')
    <!-- Contenido real de la página -->
    <div class="overflow-auto content">
        <h3>Calificación de Méritos</h1>
        {{-- Descripcion del contenido y adjunto un icono para edita esta descripcion en un modal --}}
        <div class="container">
            <div class="row my-5">
                <p class="paragraph-merit col-sm my-auto">
                    <span class="font-weight-bold">La calificacion de méritos</span> se basará en los documentos presentados 
                    por el postulante y se realizará sobre la base de <span class="font-weight-bold">100</span>
                    puntos que representa el <span class="font-weight-bold">10%</span> del puntaje final.
                </p>
                <a class="col-auto my-auto mx-auto" type="button" data-toggle="modal" data-target="#porcentageModal">
                    <img src="{{ asset('img/pen.png')}}" width="30" height="30">
                </a>
            </div>
        </div>
        {{-- Modal de la descripcion del contenido para cambiar dato nota y porcentaje --}}
        <div class="modal fade" id="porcentageModal" tabindex="-1" role="dialog" aria-labelledby="porcentageMeritModal"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="porcentageMeritModal">Porcentaje de evaluación</h5>
                        <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('meritRatingValid') }}" id="points-merit-form">
                            {{ csrf_field() }}
                            <p>
                                <span class="font-weight-bold">La calificación de méritos</span> se basará en los documentos presentados por el postulante:
                            </p>
                            <div class="form-row my-4 bg-light">
                                <span class="my-auto">Se calificará sobre la base de:</span>
                                <input type="number" class="form-control col-sm-2 mx-2" name="puntos-calificacion" placeholder="100" min="0" max="100" required>
                                <span class="my-auto">puntos</span>
                            </div>
                            <div class="form-row my-4 bg-light">
                                <span class="my-auto">Que representa el:</span>
                                <input type="number" class="form-control col-sm-2 mx-2" name="porcentaje-merito" id="porcent-merit" placeholder="%" min="0" max="100" required>
                                <span class="my-auto">% de la nota final</span>
                            </div>
                        </form>
                        
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input type="submit" class="btn btn-info" value="Guardar" form="points-merit-form">
                    </div>
                </div>
            </div>
        </div>
        {{-- Botones para añadir merito y submerito que ademas abren el modal respectivo --}}
        <div class="row my-4">
            <div class="col-lg-3 my-1">
                <a class="text-decoration-none" type="button" data-toggle="modal" data-target="#meritModal">
                    <img src="{{ asset('img/addBLUE.png')}}" width="35" height="35"> Añadir mérito
                </a>
            </div>
    
            <div class="col-lg-3 my-1">
                <a class="text-decoration-none" type="button" data-toggle="modal" data-target="#subMeritModal">
                    <img src="{{ asset('img/addBLUE.png')}}" width="35" height="35"> Añadir submérito
                </a>
            </div>
        </div>
        {{-- Modal del añadir merito --}}
        <div class="modal fade" id="meritModal" tabindex="-1" role="dialog" aria-labelledby="meritModalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="meritModalTitle">Añadir nuevo mérito</h5>
                        <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('meritRatingValid') }}" id="merit-form">
                            {{ csrf_field() }}
                            <div class="form-row my-2">
                                <label class="col-3 my-auto" for="description-merit">Descripción:</label>
                                <textarea class="form-control col-sm" name="descripcion-merito" id="description-merit" rows="3" placeholder="Ingrese la descripción del mérito" required></textarea>
                            </div>
                            <div class="form-row my-2">
                                <label class="col-3 col-form-label" for="porcent-merit">Porcentaje:</label>
                                <input type="number" class="form-control col-sm-3" name="porcentaje-merito" id="porcent-merit" placeholder="%" min="0" max="100" required>
                            </div>
                        </form>
                        
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input type="submit" class="btn btn-info" value="Guardar" form="merit-form">
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal del añadir submerito --}}
        <div class="modal fade" id="subMeritModal" tabindex="-1" role="dialog" aria-labelledby="subMeritModalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="subMeritModalTitle">Añadir nuevo submérito</h5>
                        <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('meritRatingValid') }}" id="sub-merit-form">
                            {{ csrf_field() }}
                            <div class="form-row my-2">
                                <label class="col-3" for="merit-sub-merit">Mértio / submérito</label>
                                <div class="col-sm">
                                    <select class="form-control" id="merit-sub-merit" name="merito-o-submerito">
                                        <option>MÉRITO</option>
                                        <option>sub mérito</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row my-2">
                                <label class="col-3 my-auto" for="description-sub-merit">Descripción:</label>
                                <textarea class="form-control col-sm" name="descripcion-sub-merito" id="description-sub-merit" rows="3" placeholder="Ingrese la descripción del mérito" required></textarea>
                            </div>
                            <div class="form-row my-2">
                                <label class="col-3 col-form-label" for="porcent-sub-merit">Porcentaje:</label>
                                <input type="number" class="form-control col-sm-3" name="porcentaje-sub-merito" id="porcent-sub-merit" placeholder="%" required min="0" max="100">
                            </div>
                        </form>
                        
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input type="submit" class="btn btn-info" value="Guardar" form="sub-merit-form">
                    </div>
                </div>
            </div>
        </div>
        {{-- Tabla de merito y submeritos --}}
        <table class="table my-5">
            <thead class="thead-dark text-center">
                <tr>
                    <th class="font-weight-normal text-uppercase" scope="col">descripcion de meritos</th>
                    <th class="font-weight-normal" scope="col">Porcentaje</th>
                    <th class="font-weight-normal" scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody class="bg-white">

                <tr>
                    <td class="text-uppercase">descripcion del merito y submeritos</td>
                    <td class="text-center">65</td>
                    <td class="text-center">
                        <a type="button" data-toggle="modal" data-target="#meritModal">
                            <img src="{{ asset('img/pen.png')}}" width="30" height="30">
                        </a>
                        <a type="button">
                            <img src="{{ asset('img/trash.png')}}" width="30" height="30">
                        </a>
                    </td>
                </tr>

                <tr>
                    <td class="pl-4">descripcion del merito y submeritos</td>
                    <td class="text-center">65</td>
                    <td class="text-center">
                        <a type="button" data-toggle="modal" data-target="#subMeritModal">
                            <img src="{{ asset('img/pen.png')}}" width="30" height="30">
                        </a>
                        <a type="button">
                            <img src="{{ asset('img/trash.png')}}" width="30" height="30">
                        </a>
                    </td>
                </tr>

            </tbody>
        </table>
        <div class="my-5 text-center">
            <a href="{{ route('knowledgeRating') }}" type="button" class="btn btn-info my-5">Siguiente</a>
        </div>
    </div>
@endsection