@extends('convocatory.layoutConvocatory')

@section('content-convocatory')
    <!-- Contenido real de la página -->
    <div class="overflow-auto content">
        <h3>Fechas Importantes</h3>
        <div class="my-5">
            <a class="text-decoration-none" type="button" data-toggle="modal" data-target="#importantDatesModal">
                <img src="{{ asset('img/calendarAdd.png')}}" width="40" height="40">
            <span class="mx-2">Añadir Evento</span>
            </a>            
        </div>

        <div class="modal fade" id="importantDatesModal" tabindex="-1" role="dialog" aria-labelledby="importanDatesTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importanDatesTitle">Añadir nuevo evento</h5>
                        <button type="button" class="modal-icon" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('importantDates') }}" id="important-dates">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="title-event">Titulo de evento</label>
                                <input type="text" class="form-control" name="titulo-evento" id="title-event" required>
                            </div>
                            <div class="form-group">
                                <label for="place-event">Lugar de evento</label>
                                <input type="text" class="form-control" name="lugar-evento" id="place-event" required>
                            </div>
                            <div class="form-row">
                                <div class="col-sm-6 text-center">
                                    <label for="place-event-date-ini">Fecha inicio</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control" name="fecha-ini-evento" id="place-event-date-ini" autocomplete="off" required>
                                        <span class="input-group-addon">
                                            <img class="center-y-icon" src="{{ asset('img/calendar.png')}}" width="34" height="34" alt="icon-calendar">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-center">
                                    <label for="place-event-date-end">Fecha fin</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control" name="fecha-fin-evento" id="place-event-date-end" autocomplete="off" required>
                                        <span class="input-group-addon">
                                            <img class="center-y-icon" src="{{ asset('img/calendar.png')}}" width="34" height="34" alt="icon-calendar">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input type="submit" class="btn btn-info" value="Guardar" form="important-dates">
                    </div>
                </div>
            </div>
        </div>

        <table class="table my-5">
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
                <tr>
                    <td>Fecha inicio de la convocatoria "XYZ gestión 2020"</td>
                    <td>Faculta de ciencias y tecnología</td>
                    <td class="text-center">02/02/2020</td>
                    <td class="text-center">05/05/2020</td>
                    <td class="text-center">
                        <a>
                            <img src="{{ asset('img/pen.png')}}" width="30" height="30">
                        </a>
                        <a>
                            <img src="{{ asset('img/trash.png')}}" width="30" height="30">
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection