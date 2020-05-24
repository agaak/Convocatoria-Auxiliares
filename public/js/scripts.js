$('.input-group.date').datepicker({
    format: 'mm/dd/yyyy',
    language: "es",
    orientation: "bottom left",
    todayHighlight: true,
    autoclose: true,
    orientation: "bottom auto"
});

$('.timepicker').timepicker({
    timeFormat: 'HH:mm:ss',
    interval: 10,
    minTime: '00',
    maxTime: '23:59',
    startTime: '00',
    dynamic: true,
    dropdown: true,
    scrollbar: true
});

$('body').mouseleave(function() {
    $('.ui-timepicker-container').css('display', 'none');
});

$('.timepicker').click(function() {
    $('.ui-timepicker-container').css('display', 'block');
});

function editDatesList(listDates) {
    $('#id-important-events').val(listDates['id_eventos_importantes']);
    $('#title-event').val(listDates['titulo_evento']);
    $('#place-event').val(listDates['lugar_evento']);
    $('#place-event-date-ini').val(listDates['fecha_inicio']);
    $('#place-event-date-end').val(listDates['fecha_final']);
    $('#time-event-ini').val(listDates['hora_inicio']);
    $('#time-event-end').val(listDates['hora_final']);
}

$(document).ready(function(){
    $("#deleteDates").click(function(){        
        $("#important-dates-delete").submit(); // Submit the form
    });
});