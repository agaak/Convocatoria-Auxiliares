@extends('evaluador.layoutEvaluador')

@section('content-evaluador')
    <div class="overflow-auto content" id="editEvalRequisitos" style="width: 100vw; height: 90vh;">
        <h3>Calificacion de Requisitos</h3>

        <h6> {{ $postulante->nombre.' '.$postulante->apellido }} </h6>

      @component('components.calificaciones.calificacionRequisitos', 
        ['auxiliaturas' => $auxiliaturas,'idPostulante' => $idPostulante,'mapVerifications'=> $mapVerifications,
          'requisitos'=>$requisitos])
      @endcomponent

      <div>
        @if (session('errorCalificarReq')) 
        <label class="message-error text-center text-danger col-sm-12" id="errorRequisito">
          {{ session('errorCalificarReq') }}
        </strong>    
        @endif
      </div>
      <div style= "float: right;">
        <button id="bttn-cancel-requisitos" name="bttn-cancel-requisitos" type="submit" class="btn btn-secondary" value="Cancelar" onclick="window.location ='{{ route('calificarRequisitosPost.index') }}'">
          Cancelar
        </button>
        <button id="bttn-save-requisitos" type="submit" class="btn btn-info" value="Guardar" form="calificar-requisitos">
          Guardar
        </button>
      </div>
    </div>
    
@endsection