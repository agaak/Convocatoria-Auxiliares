@extends('convocatory.layoutConvocatory')

@section('content-convocatory')

<div class="overflow-auto content">

    <h3 class="text-uppercase text-center">Nueva Convocatoria</h3>
    <form class="form-title-description" method="POST" action="{{ route('titleDescriptionValid') }}">

        {{ csrf_field() }}
        {{method_field('PUT')}}
        
        <div class="form-group my-5">
            <label class="text-uppercase" for="convocatory-title">titulo</label>
            <textarea style="resize: none;" class="form-control" name="titulo-conv" id="convocatory-title" rows="2" autofocus
                placeholder="Ingrese el título de la CONVOCATORIA" required>{{ old('titulo-conv') === null? $convo[0]->titulo_conv: old('titulo-conv') }}</textarea>
            {{ $errors->first('titulo-conv') }}
        </div>
        <div class="form-row my-5">
            <label class="col-auto col-form-label text-uppercase" for="department-conv">departamento</label>
            <div class="col-xl">
                <select class="form-control" id="department-conv" name="departamento-ant">
                    @foreach ($departamets as $item)
                        <option value="{{ $item->id }}">{{ old('departamento-ant') === null? $item->departament_conv: old('departamento-ant') }}</option>
                    @endforeach
                </select>
            </div>
            <label class="col-auto col-form-label text-uppercase" for="date-ini">fecha inicio</label>
            <div class="col-xl input-group date">
                <input type="text" class="form-control" name="fecha-ini" id="date-ini" autocomplete="off"
                    value="{{ old('fecha-ini') === null? $convo[0]->fecha_ini: old('fecha-ini') }}" placeholder="Mes/Día/Año" required readonly>
                <span class="input-group-addon">
                    <img class="center-y-icon" src="{{ asset('img/calendar.png') }}" width="34"
                        height="34" alt="icon-calendar">
                </span>
                {{ $errors->first('fecha-ini') }}
            </div>
            <label class="col-auto col-form-label text-uppercase" for="date-end">fecha fin</label>
            <div class="col-xl input-group date">
                <input type="text" class="form-control" name="fecha-fin" id="date-end" autocomplete="off"
                value="{{ old('fecha-ini') === null? $convo[0]->fecha_fin: old('fecha-ini') }}" placeholder="Mes/Día/Año" required readonly>
                <span class="input-group-addon">
                    <img class="center-y-icon" src="{{ asset('img/calendar.png') }}" width="34"
                        height="34" alt="icon-calendar">
                </span>
            </div>
        </div>
        <div class="form-group my-5">
            <label class="text-uppercase" for="description-conv">descripcion</label>
            <textarea style="resize: none;" class="form-control" name="descripcion-conv" id="description-conv" rows="4"
                required
                placeholder="Ingrese la descripción de la CONVOCATORIA">{{ old('descripcion-conv') === null? $convo[0]->descripcion_conv: old('descripcion-conv') }}</textarea>
            {{ $errors->first('descripcion-conv') }}
        </div>
        <div class="text-center">
            <input class="btn btn-info text-uppercase form-title-description" type="submit" value="siguiente">
        </div>
    </form>
</div>
@endsection