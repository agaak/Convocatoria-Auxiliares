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

        <form action="{{ route('evaluarM.calificarMeritoFinal') }}" method="POSt" id="merit-nota-form">
            {{ csrf_field() }}  
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input form='merit-nota-form' type="hidden" name="idNotaFinalMerito" id="idNotaFinalMerito" value="{{$idNotaFinalMerito[0]->id}}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label class="">Nota Final</label>
                    <input form='merit-nota-form' type="text" class="form-control" id="nota"  name='nota' value="{{$notaFinalMerito[0]->m_total}}" readonly>
                </div>
            </div>
            
            <div class="modal-footer">
                <a class="btn btn-secondary" href="{{ route('calificarMerito.index') }}">Cancelar</a>
                <button type="submit" class="btn btn-info" form='merit-nota-form'>Guardar</button>
            </div>
        </form>
    </div>

    {{-- Modal del calificar merito --}}
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
                    <h6>Merito/submerito: presenta el <span id=porcentajeMerito></span> %</h6>  
                    <p id='descripcion'>nota merito submerito</p>
                    
                    <form method="POST" action="{{ route('evaluarM.calificarMeritoEspecifico') }}" id="merit-form">
                    {{ csrf_field() }}
                        <input type="text" name="idMerito" id="idMerito" hidden readonly>
                        <input type="text" name="procentajeMer" id="procentajeMer" hidden readonly>
                        
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <p>Evaluar por:</p>
                            </div>
                            <div class="form-group col-md-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" required checked>     
                                    <label class="form-check-label" for="inlineRadio2">Promedio</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" required>
                                    <label class="form-check-label" for="inlineRadio1">Puntos</label>
                                </div>                                
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="inputEmail3" class="col-form-label" required>Notas:</label>       
                            </div>
                            
                            <div class="form-group col-md-6">
                                <input type="text" name="notasMeritos" id="notasMeritos" >
                            </div>
                            <div class="form-group col-md-3">
                                <button type="button" class="btn btn-info" onclick="calcular()">Calcular</button>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <label class="col-sm-3 col-form-label" required>Nota:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control-plaintext" id="notaMerito" name="notaMerito" readonly>
                            </div>
                            <label class="col-sm-3 col-form-label">Porcentaje:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control-plaintext" id="porcentaje" name="porcentaje" readonly>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-info" id="guardar" form="merit-form" disabled="true">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection