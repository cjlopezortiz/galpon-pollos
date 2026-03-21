// -------- VARIABLES --------
var cmp_cedula           = document.getElementById('cedula');
var cmp_nombre           = document.getElementById('nombre');
var cmp_apellido         = document.getElementById('apellido');
var cmp_direccion        = document.getElementById('direccion');
var cmp_barrio           = document.getElementById('barrio');

var cmp_fecha_inicio     = document.getElementById('fecha_inicio');
var cmp_fecha_fin        = document.getElementById('fecha_fin');

var cmp_catidad_prestada = document.getElementById('catidad_prestada');
var cmp_cantidad_mora    = document.getElementById('cantidad_mora');

var cmp_cota_diario      = document.getElementById('cota_diario');
var cmp_cota_ocho        = document.getElementById('cota_ocho');
var cmp_cota_quince      = document.getElementById('cota_quince');
var cmp_cota_mes         = document.getElementById('cota_mes');

var cmp_observaciones    = document.getElementById('observaciones');


// -------- INICIALIZACIÓN --------
function initPlaniya() {
    $('#guardarNuevoplanilla').click(function (evt) {
        evt.preventDefault();
        validarPlaniya();
    });
}


// -------- VALIDACIONES --------
function validarPlaniya() {

    var restriccion = 0;

    if (!cmp_cedula.value) {
        restriccion++;
        alert("Debe ingresar la cédula");
    }

    if (!cmp_nombre.value) {
        restriccion++;
        alert("Debe ingresar el nombre");
    }

    if (restriccion < 1) {

        agregardatosPlaniya();

    } else {

        console.log("Debe revisar los errores");

    }
}


//función para registrar la información
function agregardatosPlaniya() {

    cedula = $('#cedula').val();
    nombre = $('#nombre').val();
    apellido = $('#apellido').val();
    direccion = $('#direccion').val();
    barrio = $('#barrio').val();

    fecha_inicio = $('#fecha_inicio').val();
    fecha_fin = $('#fecha_fin').val();

    catidad_prestada = $('#catidad_prestada').val();
    cantidad_mora = $('#cantidad_mora').val();

    cota_diario = $('#cota_diario').val();
    cota_ocho = $('#cota_ocho').val();
    cota_quince = $('#cota_quince').val();
    cota_mes = $('#cota_mes').val();

    observaciones = $('#observaciones').val();


    cadena = "cedula=" + cedula +
        "&nombre=" + nombre +
        "&apellido=" + apellido +
        "&direccion=" + direccion +
        "&barrio=" + barrio +
        "&fecha_inicio=" + fecha_inicio +
        "&fecha_fin=" + fecha_fin +
        "&catidad_prestada=" + catidad_prestada +
        "&cantidad_mora=" + cantidad_mora +
        "&cota_diario=" + cota_diario +
        "&cota_ocho=" + cota_ocho +
        "&cota_quince=" + cota_quince +
        "&cota_mes=" + cota_mes +
        "&observaciones=" + observaciones;
            accion = "registrar";
            mensaje_si = "La planilla registrada con exito";
            mensaje_no = "Error de registro";

    $.ajax({
        type: "POST",
        url: "../modelo/acciones-planiya.php?accion=registrar",
        data: cadena,
         success: function(r) {
            console.log(r);
            if (r == 0) {
                alertify.error(mensaje_no);
            } else {
                alertify.success(mensaje_si);
                cargarTablaPlaniya(); 
                location.reload();
            }
        }
    });
}


// Función para cargar información a modificar
function agregarformPlaniya(datos) {

    d = datos.split('||');

    $('#id_planilla_u').val(d[0]);
    $('#cedula_u').val(d[1]);
    $('#nombre_u').val(d[2]);
    $('#apellido_u').val(d[3]);
    $('#fecha_inicio_u').val(d[4]);
    $('#fecha_fin_u').val(d[5]);
    $('#catidad_prestada_u').val(d[6]);
    $('#cantidad_mora_u').val(d[7]);
    $('#cota_diario_u').val(d[8]);
    $('#cota_ocho_u').val(d[9]);
    $('#cota_quince_u').val(d[10]);
    $('#cota_mes_u').val(d[11]);
    $('#barrio_u').val(d[12]);
    $('#direccion_u').val(d[13]);
    $('#observaciones_u').val(d[14]);

}


// Función para modificar
function modificarPlaniya() {

    id_planilla = $('#id_planilla_u').val();
    cedula = $('#cedula_u').val();
    nombre = $('#nombre_u').val();
    apellido = $('#apellido_u').val();

    fecha_inicio = $('#fecha_inicio_u').val();
    fecha_fin = $('#fecha_fin_u').val();

    catidad_prestada = $('#catidad_prestada_u').val();
    cantidad_mora = $('#cantidad_mora_u').val();

    cota_diario = $('#cota_diario_u').val();
    cota_ocho = $('#cota_ocho_u').val();
    cota_quince = $('#cota_quince_u').val();
    cota_mes = $('#cota_mes_u').val();

    barrio = $('#barrio_u').val();
    direccion = $('#direccion_u').val();
    observaciones = $('#observaciones_u').val();


    cadena = "id_planilla=" + id_planilla +
        "&cedula=" + cedula +
        "&nombre=" + nombre +
        "&apellido=" + apellido +
        "&fecha_inicio=" + fecha_inicio +
        "&fecha_fin=" + fecha_fin +
        "&catidad_prestada=" + catidad_prestada +
        "&cantidad_mora=" + cantidad_mora +
        "&cota_diario=" + cota_diario +
        "&cota_ocho=" + cota_ocho +
        "&cota_quince=" + cota_quince +
        "&cota_mes=" + cota_mes +
        "&barrio=" + barrio +
        "&direccion=" + direccion +
        "&observaciones=" + observaciones;

            accion = "modificar";
            mensaje_si = "La planilla modificado con exito";
            mensaje_no = "Error de registro";
    $.ajax({
        type: "POST",
        url: "../modelo/acciones-planiya.php?accion=modificar",
        data: cadena,
         success: function(r) {
            console.log(r);
            if (r == 0) {
                alertify.error(mensaje_no);
            } else {
                alertify.success(mensaje_si);
                cargarTablaPlaniya(); 
                location.reload();
            }
        }
    });

}
   // Función para cargar información de la vista
function cargarTablaPlaniya() {
    $.ajax({
        type: "POST",
        url: "../administrador/planiya.php",
        async: true,
        success: function(respuesta) {
           // console.log(respuesta);
            $("#tablaPlaniya").html("");
            $("#tablaPlaniya").html(respuesta);
        },
        error: function(request, error) {
            alertify.success(error);
        }
    });
}

// Confirmar eliminación
function preguntarSiNoPlaniya() {

    id_planilla = $("#id_planilla_u").val();

    var opcion = confirm("¿Esta seguro de eliminar el registro?");

    if (opcion == true) {

        eliminarDatos(id_planilla);

    } else {

        alert("El proceso fue cancelado.");

    }

}


function eliminarDatos(id_planilla) {
    cadena = "id_planilla=" + id_planilla;
    accion = "eliminar";
    mensaje_si = "Los datos de los galpñon se han borrado correctamente.";
    mensaje_no = "Error.. NO se eliminólos datos.";
    $.ajax({

        type: "POST",
        url: "../modelo/acciones-planiya.php?accion=eliminar",
        data: cadena,

        success: function(r) {
            console.log(r);
            if (r == 0) {
                alertify.error(mensaje_no);
            } else {
                alertify.success(mensaje_si);
                cargarTablaPlaniya(); 
                location.reload();
            }
        }

    });

}