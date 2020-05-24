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
    $('#id-important-events').val(listDates['id_important_events']);
    $('#title-event').val(listDates['title_event']);
    $('#place-event').val(listDates['place_event']);
    $('#place-event-date-ini').val(listDates['date_ini']);
    $('#place-event-date-end').val(listDates['date_fin']);
    $('#time-event-ini').val(listDates['time_ini']);
    $('#time-event-end').val(listDates['time_fin']);
}

$(document).ready(function(){
    $("#deleteDates").click(function(){        
        $("#important-dates-delete").submit(); // Submit the form
    });
});