@extends('convocatory.layoutConvocatory')

@section('content-convocatory')

<div class="overflow-auto content">

    <h3 class="text-uppercase text-center">Fechas Importantes</h3>

    <!-- Button trigger modal -->
    <div class="my-3" style="margin-left: 3ch">
        <a class="text-decoration-none" type="button" data-toggle="modal" data-target="#importantDatesModalCreate">
            <img src="{{ asset('img/calendarAdd.png') }}" width="30" height="30">
            <span class="mx-1">Añadir Evento</span>
        </a>
    </div>
    {{-- Actulizar base de datos --}}
    <div class="modal fade" id="importantDatesModalUpdate" tabindex="-1" role="dialog" aria-labelledby="importanDatesTitleUpdate"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importanDatesTitleUpdate">Actualizar evento</h5>
                    <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('importantDateSave') }}"
                        id="important-dates-update">

                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <input type="hidden" id="id-important-events" name="id-datos">
                        <div class="form-group">
                            <label for="title-event">Titulo de evento</label>
                            <input type="text" class="form-control" name="titulo-evento" id="title-event"
                                placeholder="Ingrese el titulo del evento"
                                value="{{ old('titulo-evento') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="place-event">Lugar de evento</label>
                            <input type="text" class="form-control" name="lugar-evento" id="place-event"
                                placeholder="Ingrese el lugar del evento"
                                value="{{ old('lugar-evento') }}" required>
                        </div>
                        <div class="form-row">
                            <div class="col-sm-6 text-center">
                                <label for="place-event-date-ini">Fecha inicio</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" name="fecha-ini-evento"
                                        id="place-event-date-ini" autocomplete="off" placeholder="Mes/Día/Año"
                                        value="{{ old('fecha-ini-evento') }}" required>
                                    <span class="input-group-addon">
                                        <img class="center-y-icon"
                                            src="{{ asset('img/calendar.png') }}" width="34"
                                            height="34" alt="icon-calendar">
                                    </span>
                                </div>
                                {{ $errors->first('fecha-ini-evento') }}
                                <label for="time-event-ini" class="d-block my-2">Hora inicio</label>
                                <div class="input-group">
                                    <input type="text" class="form-control timepicker text-center" name="tiempo-inicio"
                                        id="time-event-ini" autocomplete="off" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]" required>
                                    <label for="time-event-ini" class="my-auto"><img class="my-auto"
                                            src="{{ asset('img/clock.png') }}" width="30"
                                            height="30"></label>
                                </div>
                                @if($errors->has('fecha-ini-evento'))
                                    <script>
                                        window.onload = function () {
                                            $('#importantDatesModalUpdate').modal('show');
                                        }
                                    </script>
                                @endif
                            </div>
                            <div class="col-sm-6 text-center">
                                <label for="place-event-date-end">Fecha fin</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" name="fecha-fin-evento"
                                        id="place-event-date-end" autocomplete="off" placeholder="Mes/Día/Año"
                                        value="{{ old('fecha-fin-evento') }}" required>
                                    <span class="input-group-addon">
                                        <img class="center-y-icon"
                                            src="{{ asset('img/calendar.png') }}" width="34"
                                            height="34" alt="icon-calendar">
                                    </span>
                                </div>
                                <label for="time-event-end" class="d-block my-2">Hora final</label>
                                <div class="input-group">
                                    <input type="text" class="form-control timepicker text-center" name="tiempo-final"
                                        id="time-event-end" autocomplete="off" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]" required readonly>
                                    <label class="my-auto" for="time-event-end"><img
                                            src="{{ asset('img/clock.png') }}" width="30"
                                            height="30"></label>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <input type="submit" class="btn btn-info" value="Guardar" form="important-dates-update">
                </div>
            </div>
        </div>
    </div>

    {{-- Crear Base de datos --}}

    <div class="modal fade" id="importantDatesModalCreate" tabindex="-1" role="dialog" aria-labelledby="importanDatesTitleCreate"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importanDatesTitleCreate">Añadir nuevo evento</h5>
                    <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('importantDatesValid') }}"
                        id="important-dates-create">

                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="title-event">Titulo de evento</label>
                            <input type="text" class="form-control" name="titulo-evento" id="title-event"
                                placeholder="Ingrese el titulo del evento"
                                value="{{ old('titulo-evento') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="place-event">Lugar de evento</label>
                            <input type="text" class="form-control" name="lugar-evento" id="place-event"
                                placeholder="Ingrese el lugar del evento"
                                value="{{ old('lugar-evento') }}" required>
                        </div>
                        <div class="form-row">
                            <div class="col-sm-6 text-center">
                                <label for="place-event-date-ini">Fecha inicio</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" name="fecha-ini-evento"
                                        id="place-event-date-ini" autocomplete="off" placeholder="Mes/Día/Año"
                                        value="{{ old('fecha-ini-evento') }}" required readonly>
                                    <span class="input-group-addon">
                                        <img class="center-y-icon"
                                            src="{{ asset('img/calendar.png') }}" width="34"
                                            height="34" alt="icon-calendar">
                                    </span>
                                </div>
                                {{ $errors->first('fecha-ini-evento') }}
                                <label for="time-event-ini" class="d-block my-2">Hora inicio</label>
                                <div class="input-group">
                                    <input type="text" class="form-control timepicker text-center" name="tiempo-inicio"
                                        id="time-event-ini" autocomplete="off" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]" required>
                                    <label for="time-event-ini" class="my-auto"><img class="my-auto"
                                            src="{{ asset('img/clock.png') }}" width="30"
                                            height="30"></label>
                                </div>
                                @if($errors->has('fecha-ini-evento'))
                                    <script>
                                        window.onload = function () {
                                            $('#importanDatesTitleCreate').modal('show');
                                        }
                                    </script>
                                @endif
                            </div>
                            <div class="col-sm-6 text-center">
                                <label for="place-event-date-end">Fecha fin</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" name="fecha-fin-evento"
                                        id="place-event-date-end" autocomplete="off" placeholder="Mes/Día/Año"
                                        value="{{ old('fecha-fin-evento') }}" required readonly>
                                    <span class="input-group-addon">
                                        <img class="center-y-icon"
                                            src="{{ asset('img/calendar.png') }}" width="34"
                                            height="34" alt="icon-calendar">
                                    </span>
                                </div>
                                <label for="time-event-end" class="d-block my-2">Hora final</label>
                                <div class="input-group">
                                    <input type="text" class="form-control timepicker text-center" name="tiempo-final"
                                        id="time-event-end" autocomplete="off" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]" required>
                                    <label class="my-auto" for="time-event-end"><img
                                            src="{{ asset('img/clock.png') }}" width="30"
                                            height="30"></label>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <input type="submit" class="btn btn-info" value="Guardar" form="important-dates-create">
                </div>
            </div>
        </div>
    </div>

    <div class="table-requests">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <thead class="thead-dark text-center">
                    <tr>
                        <th class="font-weight-normal" scope="col">Evento</th>
                        <th class="font-weight-normal" scope="col">Lugar</th>
                        <th class="font-weight-normal" scope="col">Fecha Inicial</th>
                        <th class="font-weight-normal" scope="col">Fecha Fin</th>
                        <th class="font-weight-normal" scope="col">Opciones</th>
                    </tr>
                </thead>
            <tbody class="bg-white">
                @foreach ($importantDatesList as $item)
                <tr>
                    <td>{{ $item->titulo_evento }}</td>
                    <td>{{ $item->lugar_evento }}</td>
                    <td class="text-center">{{ $item->fecha_inicio }} <br> {{ $item->hora_inicio }} </td>
                    <td class="text-center">{{ $item->fecha_final }} <br> {{ $item->hora_final }} </td>
                    <td class="text-center">
                        <a type="button" onclick="editDatesList({{ $item }})" data-toggle="modal" data-target="#importantDatesModalUpdate">
                            <img src="{{ asset('img/pen.png') }}" width="30" height="30">
                        </a>
                        
                        <form class="d-inline" action="{{ route('importantDatesDelete') }}" method="POST" id="important-dates-delete">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <input type="hidden" name="id-eliminar" value="{{ $item->id_eventos_impotantes }}">
                            <a type="button" id="deleteDates">
                                <img src="{{ asset('img/trash.png') }}" width="30" height="30">
                            </a>    
                        </form>
                        
                    </td>
                </tr> 
                @endforeach
            </tbody>
        </table>
    </div>
    
</div>
@endsection