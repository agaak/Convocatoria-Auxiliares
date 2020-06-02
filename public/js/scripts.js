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
    var mcantidad = button.data('cantidad')
    var mhoras_mes = button.data('horas_mes')
    var mnombre = button.data('nombre')
    var mid_aux = button.data('id_auxiliatura')
    var modal = $(this)
    var sel = document.getElementById("id-aux-request");
    sel.remove(sel.selectedIndex);
    var opt = document.createElement("option");
    opt.value = mid_aux;
    opt.text = mnombre;
    sel.add(opt, null);
    $("#id-aux-request").val(mid_aux);
    modal.find('.modal-body #id-request').val(mid);
    modal.find('.modal-body #cantidad-request').val(mcantidad);
    modal.find('.modal-body #horas_mes-request').val(mhoras_mes);
    
})

    
$('#tematicaEditModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var mid = button.data('id')
        var modal = $(this)
        modal.find('.modal-body #id-tem').val(mid);
})

$(document).ready(function(){
    $("#deleteDates").click(function(){
        $("#important-dates-delete").submit(); // Submit the form
    });
});


function editMeritModal(lista) {
    formaterar = lista[1].split(' ')
    formaterar.splice(0, 1);
    $('#merit-descripcion-edit').val(formaterar.join(" "));
    $('#merit-porcentaje-edit').val(lista[2]);
    $('#merit-id').val(lista[3]);
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

function editSubMeritModal(lista) {
    formaterar = lista[1].split(' ')
    formaterar.splice(0, 1);
    seleccionarOpcion(lista[0]);
    disableOpcion(lista[3]);
    $('#submerit-descripcion-edit').val(formaterar.join(" "));
    $('#submerit-porcentaje-edit').val(lista[2]);
    $('#submerit-id').val(lista[3]);
}

function seleccionarOpcion(dato) {
    document.getElementById('id-option-' + dato).setAttribute('selected','');
}

function disableOpcion(dato) {
    $('option').removeAttr('disabled');
    document.getElementById('id-option-' + dato).setAttribute('disabled','');
}

$('#convocatoriaModal').on('hidden.bs.modal', () => {
    $("#conv-titulo").val("");
    $("#conv-descripcion").val("");
    $("#conv-fecha-ini").val("");
    $("#conv-fecha-fin").val("");
    document.querySelectorAll(".message-error").forEach(e => e.parentNode.removeChild(e));
});

$('#meritModal').on('hidden.bs.modal', () => {
    $("#merit-descripcion").val("");
    $("#merit-porcentaje").val("");
    document.querySelectorAll(".message-error").forEach(e => e.parentNode.removeChild(e));
});

$('#subMeritModal').on('hidden.bs.modal', () => {
    $("#submerit-descripcion").val("");
    $("#submerit-porcentaje").val("");
    document.querySelectorAll(".message-error").forEach(e => e.parentNode.removeChild(e));
});

$('#meritModalEdit').on('hidden.bs.modal', () => {
    document.querySelectorAll(".message-error").forEach(e => e.parentNode.removeChild(e));
});

$('#subMeritModalEdit').on('hidden.bs.modal', () => {
    document.querySelectorAll(".message-error").forEach(e => e.parentNode.removeChild(e));
});
