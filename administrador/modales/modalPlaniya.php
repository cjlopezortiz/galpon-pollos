<script type="text/javascript">
    rol_user = <?php echo $rol_user ?>;
</script>
<style>
    .modal-content {
        border-radius: 12px;
    }

    .tabla-cotas thead {
        background: #f4f6f9;
        font-weight: bold;
    }

    .tabla-cotas td {
        vertical-align: middle;
    }

    .radio-si {
        color: #27ae60;
        margin-right: 5px;
    }

    .radio-no {
        color: #e74c3c;
    }

    .table-hover tbody tr:hover {
        background: #f9f9f9;
    }
</style>
<!-- MODAL NUEVA PLANILLA -->
<div class="modal fade" id="modalNuevoplanilla" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">

            <div class="modal-header" style="background:#27ae60;color:white;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <i class="fa fa-plus"></i> Nueva Planilla de Cobro
                </h4>
            </div>

            <div class="modal-body">

                <div class="row">
                    <div id="msj_error_cedula" class="alert alert-danger d-none">
                        La cédula es obligatoria
                    </div>
                    <div class="col-md-6">
                        <label>Fecha Registro</label>
                        <input type="date" id="fecha_inicio" class="form-control input-sm">
                        <br>
                        <label>Nombre</label>
                        <input type="text" id="nombre" class="form-control input-sm">
                        <br>
                    </div>
                    <div class="col-md-6">
                        <label>Cédula Cliente</label>
                        <input type="number" id="cedula" class="form-control input-sm">
                        <br>
                        <label>Apellido</label>
                        <input type="text" id="apellido" class="form-control input-sm">
                        <br>
                    </div>
                    <div class="col-md-6">
                        <label>Dirección</label>
                        <input type="text" id="direccion" class="form-control input-sm">
                        <br>
                        <!-- <label>Cantidad Prestada</label>
                        <input type="number" id="catidad_prestada" class="form-control input-sm"> -->
                    </div>
                    <div class="col-md-6">
                        <label>Barrio</label>
                        <input type="text" id="barrio" class="form-control input-sm">
                        <br>
                    </div>

                </div>
                <!-- <div class="row">

                    <div class="col-md-3">
                        <label>Cuota Diario</label>
                        <input type="number" id="cota_diario" class="form-control input-sm">
                    </div>

                    <div class="col-md-3">
                        <label>Cuota 8 Días</label>
                        <input type="number" id="cota_ocho" class="form-control input-sm">
                    </div>

                    <div class="col-md-3">
                        <label>Cuota 15 Días</label>
                        <input type="number" id="cota_quince" class="form-control input-sm">
                    </div>

                    <div class="col-md-3">
                        <label>Cuota Mes</label>
                        <input type="number" id="cota_mes" class="form-control input-sm">
                    </div>

                </div> -->

                <br>

                <label>Observaciones</label>
                <textarea id="observaciones" class="form-control" rows="2"></textarea>

            </div>

            <div class="modal-footer">

                <button class="btn btn-primary" id="guardarNuevoplanilla">
                    Guardar Registro
                </button>

            </div>

        </div>
    </div>
</div>



<!-- MODAL EDITAR PLANILLA -->
<div class="modal fade" id="modalEdicionplanilla" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-md" role="document">

        <div class="modal-content">

            <div class="modal-header" style="background:#3498db;color:white;">

                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <h4 class="modal-title">
                    <i class="fa fa-edit"></i> Actualizar Planilla
                </h4>

            </div>

            <div class="modal-body">

                <input type="hidden" id="id_planilla_u">

                <div class="row">

                    <div class="col-md-6">

                        <label>Cédula</label>
                        <input type="number" id="cedula_u" class="form-control input-sm">

                        <br>

                        <label>Nombre</label>
                        <input type="text" id="nombre_u" class="form-control input-sm">

                        <!-- <br>

                        <label>Monto Prestado</label>
                        <input type="number" id="catidad_prestada_u" class="form-control input-sm"> -->

                        <br>

                        <label>Barrio</label>
                        <input type="text" id="barrio_u" class="form-control input-sm">



                    </div>

                    <div class="col-md-6">

                        <label>Fecha Registro</label>
                        <input type="date" id="fecha_inicio_u" class="form-control input-sm">

                        <br>

                        <label>Apellido</label>
                        <input type="text" id="apellido_u" class="form-control input-sm">


                        <br>
                        <label>Dirección</label>
                        <input type="text" id="direccion_u" class="form-control input-sm">

                        <br>
                        <!-- 
                       <label>Monto En Mora Actual</label>
                        <input type="number" id="cantidad_mora_u" class="form-control input-sm"> -->
                    </div>

                </div>



                <!-- <div class="row">

                    <div class="col-md-3">
                        <label>Día</label>
                        <input type="number" id="cota_diario_u" class="form-control input-sm">
                    </div>

                    <div class="col-md-3">
                        <label>8 Días</label>
                        <input type="number" id="cota_ocho_u" class="form-control input-sm">
                    </div>

                    <div class="col-md-3">
                        <label>15 Días</label>
                        <input type="number" id="cota_quince_u" class="form-control input-sm">
                    </div>

                    <div class="col-md-3">
                        <label>Mes</label>
                        <input type="number" id="cota_mes_u" class="form-control input-sm">
                    </div>

                </div> -->

                <br>

                <label>Observaciones</label>
                <textarea id="observaciones_u" class="form-control" rows="2"></textarea>

            </div>

            <div class="modal-footer">
                <?php
                if ($rol_user == 1) {
                ?>
                    <button class="btn btn-danger pull-left"
                        onclick="preguntarSiNoPlaniya()">
                        Eliminar
                    </button>
                <?php
                }
                ?>
                <button class="btn btn-warning"
                    onclick="modificarPlaniya()">
                    Actualizar Información
                </button>

            </div>

        </div>

    </div>

</div>