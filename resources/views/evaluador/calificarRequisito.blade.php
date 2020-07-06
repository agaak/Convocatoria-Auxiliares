@extends('evaluador.layoutEvaluador')

@section('content-evaluador')

    <div class="contenido-mis-convocatorias overflow-auto" id="editEvalRequisitos" style="width: 100vw; height: 90vh;">
      @foreach ($convs as $conv)
        @if ($conv->id == session()->get('convocatoria'))
          <p class="text-center"><span class="text-uppercase font-weight-bold border-bottom border-dark">{{ $conv->titulo }}</span></p>
        @endif
      @endforeach
        <h3>Calificación de Requisitos</h3>

        <h6> {{ $postulante->nombre.' '.$postulante->apellido }} </h6>
      
      <div class="table-requests">
        @component('components.calificaciones.calificacionRequisitos', 
          ['auxiliaturas' => $auxiliaturas,'idPostulante' => $idPostulante,'mapVerifications'=> $mapVerifications,
            'requisitos'=>$requisitos])
        @endcomponent
      </div>
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