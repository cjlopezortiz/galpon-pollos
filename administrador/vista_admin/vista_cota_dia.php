<?php
require_once '../../modelo/val-admin.php';
require_once '../../modelo/datos-cota_dia.php';
require_once '../../modelo/datos-planiya.php';

$id_cota = $_POST['id_cota'] ?? null;
$cedula = $_POST['cedula'] ?? null;

$mis_cota_dia = new misCotaDia();
$res = $mis_cota_dia->viewCotaDia($cedula);

$mis_planiyas = new misPlaniyas();
$datos_cliente = $mis_planiyas->viewPlaniyasMas($cedula, $rol_user);
$cliente = $datos_cliente[0] ?? null;

$contador = 0;
?>

<style>
    .header-calendario {
        background: linear-gradient(135deg, #3498db, #2c3e50);
        color: white;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 15px;
    }

    .tabla-calendario td {
        height: 60px;
        vertical-align: middle;
        text-align: center;
        font-size: 20px;
    }

    .pagado {
        color: #27ae60;
        font-size: 24px;
        font-weight: bold;
    }

    .nopago {
        color: #e74c3c;
        font-size: 24px;
        font-weight: bold;
    }

    .footer-calendario {
        background: #ecf0f1;
        padding: 10px;
        border-radius: 8px;
        margin-top: 10px;
    }

    .botones {
        margin-top: 10px;
    }
</style>

<div class="col-sm-12">
    <?php if ($res) {
        foreach ($res as $data) {
            $contador++;

            // GENERAR DATOS INDEPENDIENTES PARA CADA FILA
            $datosFila = $data['id_cota'] . "||" . $data['cedula'] . "||" . $data['fecha_cota_dia'];
            for ($d = 1; $d <= 31; $d++) {
                $datosFila .= "||" . $data["dia" . $d . "_si"] . "||" . $data["dia" . $d . "_no"];
            }
            $datosFila .= "||" . $data['observaciones_dia'] . "||" . $data['fecha_cota_dia_fin'] . "||" . $data['cantidad_saldo'] . "||" . $data['couta'] . "||" . $data['mora_cota'];
    ?>
            <style>
                .header-calendario {
                    border-radius: 12px;
                    background: linear-gradient(135deg, #2c5f7c, #3c8dbc);
                    color: #fff;
                }

                .header-calendario h4 {
                    font-weight: 600;
                }

                .header-calendario .datos {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 15px;
                    font-size: 14px;
                }

                .header-calendario .datos span {
                    background: rgba(255, 255, 255, 0.1);
                    padding: 5px 10px;
                    border-radius: 6px;
                }

                .header-calendario .acciones .btn {
                    margin-left: 5px;
                }
            </style>

            <div class="header-calendario card shadow-sm p-3 mb-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <?php
                    // Inicializamos contadores
                    $cuotas_pagadas = 0;
                    $cuotas_no_pagadas = 0;
                    $valor_cuota = $data['couta'] ?? 0;

                    for ($i = 1; $i <= 31; $i++) {
                        $si = $data["dia" . $i . "_si"];
                        $no = $data["dia" . $i . "_no"];

                        echo "<td>";
                        if ($si == 1) {
                            echo "<span class='pagado'></span>";
                            $cuotas_pagadas++; // Sumar al contador de pagados
                        } else if ($no == 2) {
                            echo "<span class='nopago'></span>";
                            $cuotas_no_pagadas++; // Sumar al contador de no pagados
                        } else {
                            echo "";
                        }
                        echo "</td>";
                    }

                    // Calculamos totales en dinero
                    $total_pagado = $cuotas_pagadas * $valor_cuota;
                    $total_no_pagado = $cuotas_no_pagadas * $valor_cuota;
                    ?>
                    <!-- INFO CLIENTE -->
                    <div class="info-cliente">
                        <h4 class="mb-2">📅 Calendario de Cobro Diario</h4>
                        <div class="datos">
                            <span><strong>Cédula:</strong> <?php echo $cliente['cedula'] ?? ''; ?></span>
                            <span><strong>Cliente:</strong> <?php echo ($cliente['nombre'] ?? '') . ' ' . ($cliente['apellido'] ?? ''); ?></span>
                            <span><strong>Inicio:</strong> <?php echo $data['fecha_cota_dia']; ?></span>
                            <span><strong>Seguro:</strong> $<?php echo number_format($data['mora_cota'] ?? 0, 0, ',', '.'); ?></span>
                            <span><strong>Monto:</strong> $<?php echo number_format($data['cantidad_saldo'] ?? 0, 0, ',', '.'); ?></span>
                            <span><strong>Cuota:</strong> $<?php echo number_format($data['couta'] ?? 0, 0, ',', '.'); ?></span>
                            <span><strong style="color: #e74c3c;">Saldo en mora:</strong> $<?php echo number_format($total_no_pagado ?? 0, 0, ',', '.'); ?></span>
                            <span><strong>Fin:</strong> <?php echo $data['fecha_cota_dia_fin']; ?></span>
                        </div>
                    </div>
                    <br>
                    <!-- BOTONES -->
                    <div class="acciones mt-3 mt-md-0">
                        <?php
                        if ($rol_user == 1 ||  $rol_user == 2) :
                        ?>
                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalNuevoCotaDia">
                                <i class="fa fa-plus"></i> CREAR PLANILLA
                            </button>

                            <button class="btn btn-warning btn-sm" onclick="agregarformCotaDia('<?php echo $datosFila ?>')" data-toggle="modal" data-target="#modalEdicionCotaDia">
                                <i class="fa fa-edit"></i> EDITAR
                            </button>
                               <a href="../fpdf-pago/pagos.php?id_cota=<?php echo $data['id_cota']; ?>&cedula=<?php echo $data['cedula']; ?>"
                                target="_blank"
                                class="btn btn-danger btn-sm">
                                <i class="fa fa-file-pdf-o"></i> PDF REPORTE PAGOS
                            </a>
                        <?php
                        else:
                        ?>
                            <button class="btn btn-danger disabled" title="No tienes permiso">
                                <i class="fa fa-times"></i>
                            </button>

                        <?php endif; ?>
                        <button class="btn btn-secondary btn-sm" onclick="window.location.href='planiya.php'">
                            <i class="fa fa-arrow-left">Volver</i>
                        </button>
                    </div>

                </div>
            </div>

            <div class="table-responsive">
                <table class="table tabla-calendario table-bordered">
                    <thead style="background:#2c3e50;color:white">
                        <tr>
                            <?php for ($i = 1; $i <= 31; $i++) echo "<th>Día $i</th>"; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            // Inicializamos contadores
                            $cuotas_pagadas = 0;
                            $cuotas_no_pagadas = 0;
                            $valor_cuota = $data['couta'] ?? 0;

                            for ($i = 1; $i <= 31; $i++) {
                                $si = $data["dia" . $i . "_si"];
                                $no = $data["dia" . $i . "_no"];

                                echo "<td>";
                                if ($si == 1) {
                                    echo "<span class='pagado'>✔</span>";
                                    $cuotas_pagadas++; // Sumar al contador de pagados
                                } else if ($no == 2) {
                                    echo "<span class='nopago'>✖</span>";
                                    $cuotas_no_pagadas++; // Sumar al contador de no pagados
                                } else {
                                    echo "-";
                                }
                                echo "</td>";
                            }

                            // Calculamos totales en dinero
                            $total_pagado = $cuotas_pagadas * $valor_cuota;
                            $total_no_pagado = $cuotas_no_pagadas * $valor_cuota;
                            ?>
                        </tr>
                    </tbody>
                </table>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="alert alert-success" style="background-color: #d4edda; border-color: #c3e6cb; color: #155724;">
                            <strong>✅ Cuotas Pagadas:</strong> <?php echo $cuotas_pagadas; ?>
                            <br>
                            <strong>Total Recaudado:</strong> $<?php echo number_format($total_pagado, 0, ',', '.'); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="alert alert-danger" style="background-color: #f8d7da; border-color: #f5c6cb; color: #721c24;">
                            <strong>❌ Cuotas No Pagadas:</strong> <?php echo $cuotas_no_pagadas; ?>
                            <br>
                            <strong>Total Pendiente:</strong> $<?php echo number_format($total_no_pagado, 0, ',', '.'); ?>
                        </div>
                    </div>
                </div>

                <div class="footer-calendario">
                    <strong>Observaciones:</strong> <?php echo $data['observaciones_dia']; ?>
                </div>
            </div>
            <hr>
        <?php } ?>
    <?php } else { ?>
        <div class="header-calendario">
            <h3>📅 Calendario de Cobro Diario</h3>
            <?php
            if ($rol_user == 1 ||  $rol_user == 2) :
            ?>
                <button class="btn btn-success" data-toggle="modal" data-target="#modalNuevoCotaDia">CREAR PLANILLA</button>
            <?php endif; ?>
            <button class="btn btn-secondary btn-sm" onclick="window.location.href='planiya.php'">
                <i class="fa fa-arrow-left">Volver</i>
            </button>
        </div>
        <div class="alert alert-info">No hay registros para este cliente.</div>
    <?php } ?>
</div>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>