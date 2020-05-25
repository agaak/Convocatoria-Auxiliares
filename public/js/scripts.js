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

$('#requestEditModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var mid = button.data('id')
    var mnombre = button.data('nombre')
    var mitem = button.data('item')
    var mcantidad = button.data('cantidad')
    var mhoras_mes = button.data('horas_mes')
    var mcod_aux = button.data('cod_aux')
    var modal = $(this)
    modal.find('.modal-body #id-request').val(mid);
    modal.find('.modal-body #nombre-request').val(mnombre);
    modal.find('.modal-body #item-request').val(mitem);
    modal.find('.modal-body #cantidad-request').val(mcantidad);
    modal.find('.modal-body #horas_mes-request').val(mhoras_mes);
    modal.find('.modal-body #cod_aux-request').val(mcod_aux);
    })

$(document).ready(function(){
    $("#deleteDates").click(function(){        
        $("#important-dates-delete").submit(); // Submit the form
    });
});


function editMeritModal(lista) {
    $('#description-merit-edit').val(lista[1].split(' ')[1]);
    $('#porcent-merit-edit').val(lista[2]);
    $('#id-merit-input').val(lista[3]);
}

$('#requirementsEditModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var mid = button.data('id')
    var minc = button.data('inc')
    var mdescripcion = button.data('descripcion')
    var modal = $(this)
    modal.find('.modal-body #id-requirement').val(mid);
    modal.find('.modal-body #inc-requirement').val(minc);
    modal.find('.modal-body #descripcion-requirement').val(mdescripcion);
    })
