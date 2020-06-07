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
    // date_create_from_format('d/m/Y:H:i:s', );
    $('#id-datos-edit').val(listDates['id']);
    $('#titulo-evento-edit').val(listDates['titulo_evento']);
    $('#lugar-evento-edit').val(listDates['lugar_evento']);
    $('#fecha-ini-evento-edit').val(listDates['fecha_inicio'].replace(" ", "T"));
    $('#fecha-fin-evento-edit').val(listDates['fecha_final'].replace(" ", "T"));
}

function editEvaluadorMeritos(evaluadorMeritos) {
    $('#id-dato-edit').val(evaluadorMeritos['id']);
    $('#adm-meritos-ci-edit').val(evaluadorMeritos['ci']);
    $('#adm-meritos-nombre-edit').val(evaluadorMeritos['nombre']);
    $('#adm-meritos-apellidos-edit').val(evaluadorMeritos['apellido']);
    $('#adm-meritos-correo-edit').val(evaluadorMeritos['correo']);
    $('#adm-meritos-correo-alter-edit').val(evaluadorMeritos['correo_alt']);
}

function comprobarEvaluadorMerit(listaCi) {
    let existe = true;
    let evaluadorExist;
    for (const item of listaCi) {
        if($('#adm-meritos-ci').val() == item['ci']) {
            existe = false;
            $('#ci-no-existe').removeClass('d-none');
            $('#ci-existe').addClass('d-none');
            setTimeout(() => {
                $('#ci-no-existe').addClass('d-none');
            }, 5000);
            evaluadorExist = item;
        }else{
        }
    }
    if (existe) {
        $('#ci-existe').removeClass('d-none');
        $('#ci-no-existe').addClass('d-none');
        setTimeout(() => {
            $('#ci-existe').addClass('d-none');
        }, 5000);
    }else{
        $('#adm-meritos-nombre').val(evaluadorExist['nombre']);
        $('#adm-meritos-apellidos').val(evaluadorExist['apellido']);
        $('#adm-meritos-correo').val(evaluadorExist['correo']);
        $('#adm-meritos-correo-alter').val(evaluadorExist['correo_alt']);
    }
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
        modal.find('.modal-body #id-tematica-edit').val(mid);
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

function editPorcentajes(porcentaje) {
    $('#porcent-merit').val(porcentaje);
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


function selectAuxiliaturaModal(mporcentajes,mtematicas) {
    var selecte = document.getElementById("id-req");
    var mid_req = selecte.options[selecte.selectedIndex].value;
    console.log(mporcentajes);
    console.log(mtematicas);
    console.log(mid_req);
    var x = document.getElementsByClassName('porcentaje-aux');
    var cont = 0;
    for(i = 0; i < mporcentajes.length; i++) {
        if(mporcentajes[i].id_requerimiento == mid_req){
            for(j = 0; j < mtematicas.length; j++){
                if(mporcentajes[i].id_tematica == mtematicas[j].id){
                    x[cont].value = mporcentajes[i].porcentaje;    
                    cont++; 
                }
            }
        }
    }
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

$(document).ready(function() {
    $('.select2').select2({
        width: "100%",
        language: "es",
        allowClear: true,
        theme: "classic",
        placeholder: "Selecciona tus opciones"
    });
});

function comprobar(listaEva) {
    let existe = true;
    for (const item of listaEva) {
        if($('#adm-cono-ci').val() == item['ci']) {
            existe = false;
            $('#ci-no-existe').removeClass('d-none');
            $('#ci-existe').addClass('d-none');
            setTimeout(() => {
                $('#ci-no-existe').addClass('d-none');
            }, 5000);
            document.getElementById("adm-nom").value = item['nombre'];
            document.getElementById("adm-ape").value = item['apellido'];
            document.getElementById("adm-correo").value = item['correo'];
            document.getElementById("adm-correo2").value = item['correo_alt'];
        }
    }

    if (existe) {
        document.getElementById("adm-nom").disabled = false;
        document.getElementById("adm-ape").disabled = false;
        document.getElementById("adm-correo").disabled = false;
        document.getElementById("adm-correo2").disabled = false;
        $('#ci-existe').removeClass('d-none');
        $('#ci-no-existe').addClass('d-none');
        setTimeout(() => {
            $('#ci-existe').addClass('d-none');
        }, 5000);
    }
}


$('#recipeCarousel').carousel({
    interval: 10000
  })
  
  $('.carousel .carousel-item').each(function(){
      var minPerSlide = 3;
      var next = $(this).next();
      if (!next.length) {
      next = $(this).siblings(':first');
      }
      next.children(':first-child').clone().appendTo($(this));
      
      for (var i=0;i<minPerSlide;i++) {
          next=next.next();
          if (!next.length) {
              next = $(this).siblings(':first');
            }
          
          next.children(':first-child').clone().appendTo($(this));
        }
  });

  $('#upload-pdf').on('change', function () {
    //get the file name
    var fileName = $(this).val();
    //replace the "Choose a file" label
    $(this).next('.custom-file-label').html(fileName);
  })
 
  function editEvalConociminetos(evaluador, tematicas, tematicasAll){
    console.log(tematicas);
    console.log(tematicasAll);
    $('#id-evaluador').val(evaluador.id);
    $('#adm-cono-ci-edit').val(evaluador.ci);
    $('#adm-cono-nombre-edit').val(evaluador.nombre);
    $('#adm-cono-apellidos-edit').val(evaluador.apellido);
    $('#adm-cono-correo-edit').val(evaluador.correo);
}