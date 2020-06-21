@extends('evaluador.layoutEvaluador')

@section('content-evaluador')
    <div class="overflow-auto content">
        <h2>
            Calificacion de meritos del estudiante:
        </h2>
        <h3>
            {{ $estudiante[0]->nombre }} {{ $estudiante[0]->apellido }}
        </h3>
        @component('components.calificaciones.tablaCalificacionesMerito',['lista'=>$lista])
        @endcomponent
    </div>

    {{-- Modal del añadir merito --}}
    <div class="modal fade" id="modalCalificar" tabindex="-1" role="dialog" aria-labelledby="meritModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="meritModalTitle">Calificar Merito</h5>
                    <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>Merito/submerito: presenta el "X" %</h6>  
                    <p>nota merito submerito</p>
                    <form method="POST" action="{{ route('calificacion-meritos.store') }}" id="merit-form">
                        {{ csrf_field() }}
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="promedio" name="promedio" class="custom-control-input">
                            <label class="custom-control-label" for="promedio">Promedio</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="puntos" name="promedio" class="custom-control-input">
                            <label class="custom-control-label" for="puntos">Puntos</label>
                        </div>

                        

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button   button type="submit" class="btn btn-info" form="merit-form">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection