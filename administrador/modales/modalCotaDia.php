<?php
require_once '../modelo/val-admin.php';
require_once '../modelo/datos-cota_dia.php';
require_once '../modelo/datos-planiya.php';

$id_cota = $_POST['id_cota'] ?? null;
$cedula = $_POST['cedula'] ?? null;
// 🔥 RECIBIR CEDULA CORRECTAMENTE
$cedula = $_GET['cedula'] ?? null;
$mis_cota_dia = new misCotaDia();
$res = $mis_cota_dia->viewCotaDia($cedula);
$cantidad_saldo = '';
$couta = '';

if (!empty($res)) {
    $cantidad_saldo = $res[0]['cantidad_saldo']; // o el nombre real de tu campo
    $couta = $res[0]['couta']; // o 'cuota'
}

$mis_planiyas = new misPlaniyas();
$datos_cliente = $mis_planiyas->viewPlaniyasMas($cedula, $rol_user);
$cliente = $datos_cliente[0] ?? null;

$contador = 0;
?>
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
<div class="modal fade" id="modalNuevoCotaDia">
    <div class="modal-dialog">
        <div class="modal-content shadow-lg">

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fa fa-plus-circle"></i> Nueva Cota
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <div id="msj_error_cedula" class="alert alert-danger d-none">
                    La cédula es obligatoria
                </div>

                <div class="form-group">
                    <label>Cédula Cliente</label>
                    <input type="text" id="cedula"
                        value="<?php echo $cedula; ?>"
                        readonly
                        class="form-control">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label>Fecha inicio</label>
                        <input type="date" id="fecha_cota_dia" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>Fecha fin</label>
                        <input type="date" id="fecha_cota_dia_fin" class="form-control">
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-md-6">
                        <label>Monto prestado</label>
                        <input type="number"
                            value="<?php echo $cantidad_saldo; ?>"
                            id="cantidad_saldo"
                            class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>Cuota</label>
                        <input type="number"
                            value="<?php echo $couta; ?>"
                            id="couta"
                            class="form-control">
                    </div>
                </div>

                <br>

                <div class="form-group">
                    <label>Observaciones</label>
                    <textarea id="observaciones_dia" class="form-control" rows="2"></textarea>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-success btn-block" id="guardarNuevoCotaDia">
                    <i class="fa fa-save"></i> Guardar Registro
                </button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modalEdicionCotaDia" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:linear-gradient(45deg,#3498db,#2980b9);color:white">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-calendar"></i> Control de Cota Diaria</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_cota_u">
                <input type="hidden" id="cedula_u">

                <table class="table table-bordered table-striped text-center">
                    <thead style="background:#ecf0f1">
                        <tr>
                            <th>Día</th>
                            <th>Pago</th>
                            <th>Día</th>
                            <th>Pago</th>
                            <th>Día</th>
                            <th>Pago</th>
                            <th>Día</th>
                            <th>Pago</th>
                            <th>Día</th>
                            <th>Pago</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($i = 1; $i <= 30; $i += 5) {
                            echo "<tr>";
                            for ($j = 0; $j < 5; $j++) {
                                $d = $i + $j;
                                echo "<td>$d</td>";
                                echo "<td>
                                        <label><input type='radio' name='dia$d' id='dia{$d}_si_u'> SI</label>
                                        <label><input type='radio' name='dia$d' id='dia{$d}_no_u'> NO</label>
                                      </td>";
                            }
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <br>
                <div class="form-group">
                    <label>Cantidad prestada</label>
                    <input type="number" id="cantidad_saldo_u" class="form-control input-sm">
                </div>
                <br>
                <div class="form-group">
                    <label>Couta</label>
                    <input type="number" id="couta_u" class="form-control input-sm">
                </div>
                <br>
                <!-- <div class="form-group">
                    <label>Coutas en mora</label>
                    <input type="number" id="mora_cota_u" class="form-control input-sm">
                </div>
                <br> -->
                <div class="form-group" onclick="abrirFecha('fecha_cota_dia_u')">
                    <label for="fecha_cota_dia_u">Fecha inicio</label>
                    <input type="date" id="fecha_cota_dia_u" class="form-control input-sm">
                </div>

                <br>

                <div class="form-group" onclick="abrirFecha('fecha_cota_dia_fin_u')">
                    <label for="fecha_cota_dia_fin_u">Fecha fin</label>
                    <input type="date" id="fecha_cota_dia_fin_u" class="form-control input-sm">
                </div>
            </div>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-8 text-left">
                        <label>Observaciones</label>
                        <textarea id="observaciones_dia_u" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="col-md-4 d-flex justify-content-between align-items-center" style="margin-top:25px">
                        <?php
                        if ($rol_user == 1) {
                        ?>
                            <button class="btn btn-danger btn-sm" onclick="preguntarSiNoCotaDia()">
                                <i class="fa fa-trash">Eliminar</i>
                            </button>
                            <button class="btn btn-primary btn-sm" onclick="limpiarTablaDias()">
                                <i class="fa fa-eraser">Vaciar tabla</i>
                            </button>
                        <?php
                        }
                        ?>
                        <button class="btn btn-warning btn-sm" onclick="modificarCotaDia()">
                            <i class="fa fa-refresh">Actualizar</i>
                        </button>



                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function abrirFecha(id) {
            const input = document.getElementById(id);
            input.focus();

            // Esto abre el calendario (Chrome, Edge)
            if (input.showPicker) {
                input.showPicker();
            }
        }
    </script>
</div>