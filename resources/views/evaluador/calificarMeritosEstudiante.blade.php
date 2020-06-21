@extends('evaluador.layoutEvaluador')

@section('content-evaluador')
    @php
        function espacios($cadena) {
            $contar = 0;
            for ($i=0; $i < strlen($cadena) ; $i++) {
                $contar +=10; if ($cadena[$i]==')' ) { break; }
            }
            return $contar-8;
        }

        function convertir($arreglo) {
            return json_encode($arreglo);
        }
    @endphp
    <div class="overflow-auto content">
        <h2>
            Calificacion de meritos del estudiante:
        </h2>
        <h3>
            {{ $estudiante[0]->nombre }} {{ $estudiante[0]->apellido }}
        </h3>
        @component('components.calificaciones.tablaCalificacionesMerito',['lista'=>$lista, 'listaMeritos'=>$listaMeritos])
        @endcomponent

        <form action="#" methos="POSt">
              
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="hidden" name="idNotaFinalMerito" id="idNotaFinalMerito" value="{{$idNotaFinalMerito[0]->id}}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label class="">Nota Final</label>
                    <input type="text" class="form-control" id="nota"  value="{{$notaFinalMerito[0]->m_total}}" readonly>
                </div>
            </div>
            
            <div class="modal-footer">
                <a class="btn btn-secondary" href="{{ route('calificarMerito.index') }}">Cancelar</a>
                <button   button type="submit" class="btn btn-info" form="merit-form">Guardar</button>
            </div>
        </form>
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
                            <input type="radio" id="puntos" name="customRadioInline1" class="custom-control-input">
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