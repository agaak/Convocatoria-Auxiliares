@extends('convocatory.layoutConvocatory')

@section('content-convocatory')
    <!-- Contenido real de la página -->
    <div class="overflow-auto content">

        <h3 class="text-uppercase text-center font-weight-bold">nueva convocatoria</h3>
        <form class="form-title-description" method="POST" action="{{ route('requestValid') }}">
            {{ csrf_field() }}
            <div class="form-group my-5">
                <label class="text-uppercase" for="convocatory-title">titulo</label>
                <textarea class="form-control text-center" name="titulo-conv" id="convocatory-title" rows="3" required placeholder="Ingrese el título de la CONVOCATORIA">{{ old('titulo-conv') }}</textarea>
                {{ $errors->first('titulo-conv') }}
            </div>
            <div class="form-row my-5">
                <label class="col-auto col-form-label text-uppercase" for="department-conv">departamento</label>
                <div class="col-xl">
                    <select class="form-control" id="department-conv" name="departamento-ant">
                        @php
                            function valor($dato) {
                                $direction = '';
                                if ( old('departamento-ant') == $dato ) {
                                    $direction = 'selected';
                                }
                            return $direction;
                            }
                        @endphp
                        <option {{ valor('SISTEMAS') }}>SISTEMAS</option>
                        <option {{ valor('FISICA') }}>FISICA</option>
                        <option {{ valor('MATEMATICAS') }}>MATEMATICAS</option>
                        <option {{ valor('OTRO') }}>OTRO</option>
                        <option {{ valor('OTRO ALGO') }}>OTRO ALGO</option>
                    </select>
                </div>
                <label class="col-auto col-form-label text-uppercase" for="date-ini">fecha inicio</label>
                <div class="col-xl input-group date">
                    <input type="text" class="form-control" name="fecha-ini" id="date-ini" required value=" {{ old('fecha-ini') }} " autocomplete="off">
                    <span class="input-group-addon">
                        <svg class="calendar-svg" width="34px" height="34px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M14 0H2a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V2a2 2 0 00-2-2zM1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857V3.857z" clip-rule="evenodd"/>
                            <path fill-rule="evenodd" d="M6.5 7a1 1 0 100-2 1 1 0 000 2zm3 0a1 1 0 100-2 1 1 0 000 2zm3 0a1 1 0 100-2 1 1 0 000 2zm-9 3a1 1 0 100-2 1 1 0 000 2zm3 0a1 1 0 100-2 1 1 0 000 2zm3 0a1 1 0 100-2 1 1 0 000 2zm3 0a1 1 0 100-2 1 1 0 000 2zm-9 3a1 1 0 100-2 1 1 0 000 2zm3 0a1 1 0 100-2 1 1 0 000 2zm3 0a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                        </svg>
                    </span>
                    {{ $errors->first('fecha-ini') }}
                </div>
                <label class="col-auto col-form-label text-uppercase" for="date-end">fecha fin</label>
                <div class="col-xl input-group date">
                    <input type="text" class="form-control" name="fecha-fin" id="date-end" required value=" {{ old('fecha-fin') }} " autocomplete="off">
                    <span class="input-group-addon">
                        <svg class="calendar-svg" width="34px" height="34px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M14 0H2a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V2a2 2 0 00-2-2zM1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857V3.857z" clip-rule="evenodd"/>
                            <path fill-rule="evenodd" d="M6.5 7a1 1 0 100-2 1 1 0 000 2zm3 0a1 1 0 100-2 1 1 0 000 2zm3 0a1 1 0 100-2 1 1 0 000 2zm-9 3a1 1 0 100-2 1 1 0 000 2zm3 0a1 1 0 100-2 1 1 0 000 2zm3 0a1 1 0 100-2 1 1 0 000 2zm3 0a1 1 0 100-2 1 1 0 000 2zm-9 3a1 1 0 100-2 1 1 0 000 2zm3 0a1 1 0 100-2 1 1 0 000 2zm3 0a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                        </svg>
                    </span>
                </div>
            </div>
            <div class="form-group my-5">
                <label class="text-uppercase" for="description-conv">descripcion</label>
                <textarea class="form-control" name="descripcion-conv" id="description-conv" rows="5" required placeholder="Ingrese la descripción de la CONVOCATORIA">{{ old('descripcion-conv') }}</textarea>
                {{ $errors->first('descripcion-conv') }}
            </div>
            <div class="text-center">
                <input class="btn btn-info text-uppercase form-title-description" type="submit" value="siguiente"></input>
            </div>
        </form>

    </div>
@endsection