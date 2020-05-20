@extends('convocatory.layoutConvocatory')

@section('content-convocatory')
    <!-- Contenido real de la página -->
    <div class="overflow-auto content">

        <h3>Nueva Convocatoria</h3>
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
                    <input type="text" class="form-control" name="fecha-ini" id="date-ini" autocomplete="off" placeholder="Mes/Día/Año" value="{{ old('fecha-ini') }}" required>
                    <span class="input-group-addon">
                        <img class="center-y-icon" src="{{ asset('img/calendarAdd.png')}}" width="34" height="34" alt="icon-calendar">
                    </span>
                    {{ $errors->first('fecha-ini') }}
                </div>
                <label class="col-auto col-form-label text-uppercase" for="date-end">fecha fin</label>
                <div class="col-xl input-group date">
                    <input type="text" class="form-control" name="fecha-fin" id="date-end" autocomplete="off" placeholder="Mes/Día/Año" value="{{ old('fecha-fin') }}" required>
                    <span class="input-group-addon">
                        <img class="center-y-icon" src="{{ asset('img/calendarAdd.png')}}" width="34" height="34" alt="icon-calendar">
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