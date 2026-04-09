$(document).ready(function() {

    $('#guardarNuevoCotaDia').click(function(evt) {
        evt.preventDefault();

        if (validarRegistro()) {
            agregardatosCotaDia();
        }
    });

    $('#modalNuevoCotaDia').on('show.bs.modal', function() {
        limpiarModalCotaDia();
    });

    $('#modalEdicionCotaDia').on('hidden.bs.modal', function() {
        limpiarModalEdicion();
    });

});


// ===============================
// VALIDAR REGISTRO
// ===============================
function validarRegistro() {
    let cedula = document.getElementById('cedula').value;
    let contenedorError = document.getElementById('msj_error_cedula');

    if (cedula.trim() === "") {
        contenedorError.style.display = 'block';
        document.getElementById('cedula').focus();
        return false;
    } else {
        contenedorError.style.display = 'none';
        return true;
    }
}


// ===============================
// LIMPIAR MODAL NUEVO
// ===============================
function limpiarModalCotaDia() {
    $('#cedula').val('');
    $('#fecha_cota_dia').val('');
    $('#fecha_cota_dia_fin').val('');
    $('#cantidad_saldo').val('');
    $('#couta').val('');
    $('#mora_cota').val('');
    $('#observaciones_dia').val('');
}


// ===============================
// LIMPIAR MODAL EDICION
// ===============================
function limpiarModalEdicion() {

    $('#id_cota_u').val('');
    $('#cedula_u').val('');
    $('#fecha_cota_dia_u').val('');
    $('#fecha_cota_dia_fin_u').val('');
    $('#cantidad_saldo_u').val('');
    $('#couta_u').val('');
    $('#mora_cota_u').val('');
    $('#observaciones_dia_u').val('');

    for (var i = 1; i <= 31; i++) {
        $('#dia' + i + '_si_u').prop('checked', false);
        $('#dia' + i + '_no_u').prop('checked', false);
    }
}


// ===============================
// LIMPIAR SOLO LOS DIAS (BOTON)
// ===============================
function limpiarTablaDias() {

    for (var i = 1; i <= 31; i++) {
        $('#dia' + i + '_si_u').prop('checked', false);
        $('#dia' + i + '_no_u').prop('checked', false);
    }

    // 👉 OPCIONAL: guardar automáticamente
    // modificarCotaDia();
}


// ===============================
// REGISTRAR
// ===============================
function agregardatosCotaDia() {

    var cadena = "cedula=" + $('#cedula').val() +
        "&fecha_cota_dia=" + $('#fecha_cota_dia').val() +
        "&fecha_cota_dia_fin=" + $('#fecha_cota_dia_fin').val() +
        "&cantidad_saldo=" + $('#cantidad_saldo').val() +
        "&couta=" + $('#couta').val() +
        "&mora_cota=" + $('#mora_cota').val() +
        "&observaciones_dia=" + $('#observaciones_dia').val();

    $.ajax({
        type: "POST",
        url: "../modelo/acciones-cota_dia.php?accion=registrar",
        data: cadena,
        success: function(r) {
            if (r == 1) {
                alertify.success("La planilla se registró con éxito");
                $('#modalNuevoCotaDia').modal('hide');
                cargarTablaCotaDia();
                setTimeout(function() {
                    location.reload();
                }, 1000);
            } else {
                alertify.error("Error de registro");
            }
        }
    });
}


// ===============================
// CARGAR DATOS EN MODAL
// ===============================
function agregarformCotaDia(datos) {

    limpiarModalEdicion();

    var d = datos.split('||');

    $('#id_cota_u').val(d[0]);
    $('#cedula_u').val(d[1]);
    $('#fecha_cota_dia_u').val(d[2]);

    var pos = 3;

    for (var i = 1; i <= 31; i++) {

        if (d[pos] == 1) {
            $('#dia' + i + '_si_u').prop('checked', true);
        }

        if (d[pos + 1] == 2) {
            $('#dia' + i + '_no_u').prop('checked', true);
        }

        pos += 2;
    }

    $('#observaciones_dia_u').val(d[pos]);
    $('#fecha_cota_dia_fin_u').val(d[pos + 1]);
    $('#cantidad_saldo_u').val(d[pos + 2]);
    $('#couta_u').val(d[pos + 3]);
    $('#mora_cota_u').val(d[pos + 4]);
}


// ===============================
// MODIFICAR
// ===============================
function modificarCotaDia() {

    var cadena = "id_cota=" + $('#id_cota_u').val() +
        "&cedula=" + $('#cedula_u').val() +
        "&fecha_cota_dia=" + $('#fecha_cota_dia_u').val() +
        "&fecha_cota_dia_fin=" + $('#fecha_cota_dia_fin_u').val() +
        "&cantidad_saldo=" + $('#cantidad_saldo_u').val() +
        "&couta=" + $('#couta_u').val() +
        "&mora_cota=" + $('#mora_cota_u').val() +
        "&observaciones_dia=" + $('#observaciones_dia_u').val();

    for (var i = 1; i <= 31; i++) {

        var si = $('#dia' + i + '_si_u').is(':checked') ? 1 : 0;
        var no = $('#dia' + i + '_no_u').is(':checked') ? 2 : 0;

        cadena += "&dia" + i + "_si=" + si +
                   "&dia" + i + "_no=" + no;
    }

    $.ajax({
        type: "POST",
        url: "../modelo/acciones-cota_dia.php?accion=modificar",
        data: cadena,
        success: function(r) {
            if (r == 1) {
                alertify.success("Modificado con éxito");
                setTimeout(function() {
                    location.reload();
                }, 1000);
            } else {
                alertify.error("Error al actualizar");
            }
        }
    });
}


// ===============================
// ELIMINAR
// ===============================
function preguntarSiNoCotaDia() {

    var id_cota = $("#id_cota_u").val();

    alertify.confirm(
        'Eliminar Registro',
        '¿Está seguro de eliminar esta planilla?',
        function() {
            eliminarDatos(id_cota);
        },
        function() {
            alertify.error('Cancelado');
        }
    );
}


function eliminarDatos(id_cota) {

    $.ajax({
        type: "POST",
        url: "../modelo/acciones-cota_dia.php?accion=eliminar",
        data: "id_cota=" + id_cota,
        success: function(r) {
            if (r == 1) {
                alertify.success("Eliminado correctamente");
                cargarTablaCotaDia();
                setTimeout(function() {
                    location.reload();
                }, 1000);
            } else {
                alertify.error("No se pudo eliminar");
            }
        }
    });
}


// ===============================
// RECARGAR TABLA
// ===============================
function cargarTablaCotaDia() {

    $.ajax({
        type: "POST",
        url: "../administrador/cota_dia.php",
        success: function(respuesta) {
            $("#tablaCotaDia").html(respuesta);
        }
    });
}


// ===============================
// ABRIR INPUT DATE AUTOMATICO
// ===============================
function abrirFecha(id) {

    const input = document.getElementById(id);
    input.focus();

    if (input.showPicker) {
        input.showPicker();
    }
}