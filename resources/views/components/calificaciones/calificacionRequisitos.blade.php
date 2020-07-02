
<form method="POST" action="{{ route('calificarRequisito.update') }}"
                id="calificar-requisitos" >
                {{ csrf_field() }}
                {{ method_field('PUT') }}
        <input type="hidden" id="id-evaluador" value="{{$idPostulante}}" name="id-postulante">
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
                      <div class="form-group mt-2">
                        <div class="form-group row">
                        <label for="exampleFormControlTextarea1" class="col-1">{{chr($alphas++).')'  }}</label>
                        <div class="col-9">
                          <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                             style="min-width: 80%" disabled float="right">{{$requisito->descripcion}} 
                          </textarea></div>
                        @php $esEva = false; @endphp
                        @if (auth()->check())
                          @if (auth()->user()->hasRoles(['evaluador']))
                            @php $esEva = true; @endphp
                          @endif
                        @endif
                          <div class="col-2">
                            <div class="btn-group">
                              @php 
                                $esValido = $mapVerifications[$auxiliatura->id][$requisito->id]['esValido'];
                              @endphp
                              @if($esEva)
                              <label class="btn {{ is_null($esValido)?'btn-secondary':($esValido?'btn-success':'btn-secondary') }}" id="options{{ $auxiliatura->id.$requisito->id }}1"
                                type="button" onclick="validarRequisito( {{ $auxiliatura->id }}, {{ $requisito->id }});"
                                name="options{{ $auxiliatura->id.$requisito->id }}">
                                Si
                              </label>
                              <label class="btn {{ is_null($esValido)?'btn-secondary':($esValido?'btn-secondary':'btn-danger') }}"" id="options{{ $auxiliatura->id.$requisito->id }}2"
                                type="button" onclick="desValidarRequisito( {{ $auxiliatura->id }}, {{ $requisito->id }});"
                                name="options{{ $auxiliatura->id.$requisito->id }}">
                                No
                              </label>
                              @endif
                            </div></div>
                         
                        
                        <h5 id="obsLabel{{ $auxiliatura->id.$requisito->id }}" name="obsLabel{{ $auxiliatura->id.$requisito->id }}" 
                          style="{{ is_null($esValido)?'display:none':($esValido?'display:none':'')}}"> 
                          Observacion
                        </h5> 
                        @if ($esEva)
                        <textarea id="obsText{{ $auxiliatura->id.$requisito->id }}" name="obsText{{ $auxiliatura->id.$requisito->id }}" 
                          style="{{ is_null($esValido)?'display:none':($esValido?'display:none':'')}};min-width: 80%" rows="2"
                          class="mx-2 mt-1">{{ $mapVerifications[$auxiliatura->id][$requisito->id]['observacion'] }}</textarea>
                        @else
                        <textarea id="obsText{{ $auxiliatura->id.$requisito->id }}" name="obsText{{ $auxiliatura->id.$requisito->id }}" 
                          style="{{ is_null($esValido)?'display:none':($esValido?'display:none':'')}};min-width: 80%" rows="2"
                          class="mx-2 mt-1" readonly>{{ $mapVerifications[$auxiliatura->id][$requisito->id]['observacion'] }}</textarea>
                        @endif
                      </div>
                      </div>
                  @endforeach
            </div>
            @php $initContent = false @endphp
          @endforeach
        </div>
</form>