@extends('evaluador.layoutEvaluador')

@section('content-evaluador')
    <div class="overflow-auto content" id="editEvalRequisitos">
        <h2> Calificacion de Requisitos</h2>
        <h3> {{ $postulante->nombre.' '.$postulante->apellido }} </h3>
      <form method="POST" action="{{ route('calificarRequisito.update') }}"
                id="calificar-requisitos" >
                {{ csrf_field() }}
                {{ method_field('PUT') }}
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          @php $initTabs = true @endphp
          @foreach ($auxiliaturas as $auxiliatura)
            <li class="nav-item">
              <a class="nav-link{{ $initTabs ? " active" : '' }}" id={{ $auxiliatura->id }} data-toggle="tab" href="#{{ "body".$auxiliatura->id }}" role="tab" aria-controls="home" aria-selected={{ $initTabs }}>
                {{ $auxiliatura->nombre_aux }}
              </a>
            </li>
           {{ $initTabs = false  }}
          @endforeach
        </ul>
        @php 
          $initContent = true;
         @endphp
        <div>
          <input type="hidden" style="min-width: 80%" name="mapverification" id="mapverification" value="{{ json_encode($mapVerifications) }}" >
          </div>
        <div class="tab-content" id="myTabContent">
          @foreach ($auxiliaturas as $auxiliatura)
            @php $alphas = 65; @endphp
            <div class="tab-pane fade{{ $initContent ? " show active" : '' }}" id={{ "body".$auxiliatura->id }} role="tabpanel" aria-labelledby={{ $auxiliatura->id }}>
                  @foreach ($requisitos as $requisito)
                      <div class="form-group">
                        <label for="exampleFormControlTextarea1">{{chr($alphas++).')'  }}</label>
                          <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                             style="min-width: 80%" disabled float="right">
                             {{ $requisito->descripcion }} 
                          </textarea>
                        <div class="btn-group">
                          @php 
                            $esValido = $mapVerifications[$auxiliatura->id][$requisito->id]['esValido'];
                          @endphp
                          <label class="btn {{ is_null($esValido)?'btn-secondary':($esValido?'btn-success':'btn-secondary') }}" id="options{{ $auxiliatura->id.$requisito->id }}1"
                            type="button" onclick="validarRequisito( {{ $auxiliatura->id }}, {{ $requisito->id }});"
                            name="options{{ $auxiliatura->id.$requisito->id }}">
                            Si
                          </label>
                          <label class="btn {{ is_null($esValido)?'btn-secondary':($esValido?'btn-secondary':'btn-danger') }}"" id="options{{ $auxiliatura->id.$requisito->id }}2"
                            type="button" onclick="desValidarRequisito( {{ $auxiliatura->id }}, {{ $requisito->id }});"
                            name="options{{ $auxiliatura->id.$requisito->id }}"  >
                            No
                          </label>
                        </div>
                        <h5 id="obsLabel{{ $auxiliatura->id.$requisito->id }}" name="obsLabel{{ $auxiliatura->id.$requisito->id }}" 
                          style="{{ is_null($esValido)?'display:none':($esValido?'display:none':'')}}"> 
                          Observacion
                        </h5>
                        <textarea id="obsText{{ $auxiliatura->id.$requisito->id }}" name="obsText{{ $auxiliatura->id.$requisito->id }}" 
                          style="{{ is_null($esValido)?'display:none':($esValido?'display:none':'')}};min-width: 80%" rows="2" >
                          {{ $mapVerifications[$auxiliatura->id][$requisito->id]['observacion'] }}
                        </textarea>
                      </div>
                  @endforeach
            </div>
            @php $initContent = false @endphp
          @endforeach
        </div>
      </form>
      <div>
        @if (session('errorCalificarReq')) 
        <label class="message-error text-center text-danger col-sm-12" id="errorRequisito">
          {{ session('errorCalificarReq') }}
        </strong>    
        @endif
      </div>
      <div style= "float: right;">
        <button id="bttn-cancel-requisitos" name="bttn-cancel-requisitos" type="submit" class="btn btn-secondary" value="Cancelar" onclick="window.location ='{{ route("calificarRequisitosPost.index") }}'">
          Cancelar
        </button>
        <button id="bttn-save-requisitos" type="submit" class="btn btn-info" value="Guardar" form="calificar-requisitos">
          Guardar
        </button>
      </div>
    </div>
    
@endsection