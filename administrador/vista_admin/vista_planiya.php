<?php
require_once '../../modelo/val-admin.php';
require_once '../../modelo/datos-usuarios.php';
require_once '../../modelo/datos-rol.php';
require_once '../../modelo/datos-planiya.php';
$mis_usuarios = new misUsuarios();
$user = $mis_usuarios->viewUsuarios();


if ($rol_user != 1 && $rol_user != 2 && $rol_user != 3) {
    echo '<script>
    alert("Acceso restringido");
    window.location="../index.php";
    </script>';
}

$mis_planillas = new misPlaniyas();
// Ahora $_SESSION['cedula'] sí existe porque la definimos en el login corregido
$cedula_usuario = isset($_SESSION['cedula']) ? $_SESSION['cedula'] : null;

$res = $mis_planillas->viewPlaniyas($cedula_usuario, $rol_user);
$cant_planillas = $mis_planillas->counPlaniya($cedula_usuario, $rol_user);
?>

<div class="col-sm-12">

    <style>
        .titulo-sistema {
            background: linear-gradient(135deg, #1abc9c, #2c3e50);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .card-tabla {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .table thead {
            background: #2c3e50;
            color: white;
        }

        .btn-accion {
            padding: 6px 10px;
            border-radius: 6px;
        }
    </style>

    <div class="titulo-sistema">
        <h2>📋 Sistema de Cobro</h2>
        <small>Listado de clientes con préstamos activos</small>
    </div>

    <div class="card-tabla">

        <div class="row" style="margin-bottom:15px">

            <div class="col-md-6">
                <h4>Clientes registrados</h4>
            </div>

            <div class="col-md-6 text-right">
                <?php
                if ($rol_user == 1 ||  $rol_user == 2) :
                ?>
                    <button class="btn btn-success"
                        data-toggle="modal"
                        data-target="#modalNuevoplanilla">
                        <i class="fa fa-plus"></i> Nuevo Cliente
                    </button>
                <?php
                else:
                ?>
                    <button class="btn btn-danger disabled" title="No tienes permiso para editar">
                        <i class="fa fa-times"></i>
                    </button>

                <?php endif; ?>
            </div>
        </div>
        <div class="table-responsive">

            <table id="example"  class="table table-striped table-bordered table-hover">

                <thead>

                    <tr>

                        <th class="text-center">#</th>

                        <th class="text-center">Fecha Registro</th>

                        <th class="text-center">Cédula</th>

                        <th class="text-center">Telefono</th>

                        <th class="text-center">Cliente</th>

                        <th class="text-center">Barrio</th>

                        <th class="text-center">Dirección</th>

                        <th class="text-center">Calendario</th>

                        <th class="text-center">Acciones</th>

                    </tr>

                </thead>

                <tbody>

                    <?php
                    foreach ($res as $data) {
                        $cedula_usuario = isset($_SESSION['cedula']) ? $_SESSION['cedula'] : null;
                        $datos =
                            $data['id_planilla'] . "||" .
                            $data['cedula'] . "||" .
                            $data['nombre'] . "||" .
                            $data['apellido'] . "||" .
                            $data['fecha_inicio'] . "||" .
                            $data['fecha_fin'] . "||" .
                            $data['catidad_prestada'] . "||" .
                            $data['cantidad_mora'] . "||" .
                            $data['cota_diario'] . "||" .
                            $data['cota_ocho'] . "||" .
                            $data['cota_quince'] . "||" .
                            $data['cota_mes'] . "||" .
                            $data['barrio'] . "||" .
                            $data['direccion'] . "||" .
                            $data['observaciones'];
                    ?>

                        <tr>

                            <td class="text-center">
                                <?php echo $data['id_planilla']; ?>
                            </td>

                            <td class="text-center">
                                <?php echo $data['fecha_inicio']; ?>
                            </td>

                            <td class="text-center">
                                <?php echo $data['cedula']; ?>
                            </td>

                            <td class="text-center">
                                <?php echo $data['cantidad_mora']; ?>
                            </td>

                            <td class="text-center">
                                <?php echo $data['nombre'] . " " . $data['apellido']; ?>
                            </td>

                            <td class="text-center">
                                <?php echo $data['barrio']; ?>
                            </td>

                            <td class="text-center">
                                <?php echo $data['direccion']; ?>
                            </td>

                            <!-- <td class="text-center">
                                <strong style="color:#27ae60">
                                    $ <?php echo number_format($data['catidad_prestada']); ?>
                                </strong>
                            </td> -->

                            <td class="text-center">
                                <?php if (!empty($data['id_planilla'])): ?>
                                    <a href="cota_dia.php?cedula=<?php echo $data['cedula']; ?>"
                                        target="_blank"
                                        class="btn btn-success btn-xs"
                                        title="Cuota diaria: $<?php echo number_format($data['id_planilla']); ?>">
                                        D
                                    </a>
                                <?php endif; ?>

                                <?php if (!empty($data['id_planilla'])): ?>
                                     <a href="cota_dia.php?cedula=<?php echo $data['cedula']; ?>"
                                        class="btn btn-info btn-xs"
                                        title="Cuota cada 8 días: $<?php echo number_format($data['id_planilla']); ?>">8</a>
                                <?php endif; ?>

                                <?php if (!empty($data['id_planilla'])): ?>
                                    <a href="cota_dia.php?cedula=<?php echo $data['cedula']; ?>"
                                        class="btn btn-warning btn-xs"
                                        title="Cuota cada 15 días: $<?php echo number_format($data['id_planilla']); ?>">15</a>
                                <?php endif; ?>

                                <?php if (!empty($data['id_planilla'])): ?>
                                   <a href="cota_dia.php?cedula=<?php echo $data['cedula']; ?>"
                                        class="btn btn-danger btn-xs"
                                        title="Cuota mensual: $<?php echo number_format($data['id_planilla']); ?>">M</a>
                                <?php endif; ?>

                            </td>

                            <!-- <td class="text-center">

                                <?php
                                // if ($data['cantidad_mora'] > 0) {
                                //     echo "<span class='label label-danger'>$" . $data['cantidad_mora'] . "</span>";
                                // } else {
                                //     echo "<span class='label label-success'>0</span>";
                                // }
                                ?>

                            </td> -->


                            <td class="text-center">
                                <?php
                                if ($rol_user == 1 ||  $rol_user == 2) :
                                ?>
                                    <button
                                        class="btn btn-warning glyphicon glyphicon glyphicon-pencil"
                                        data-toggle="modal"
                                        data-target="#modalEdicionplanilla"
                                        onclick="agregarformPlaniya('<?php echo $datos ?>')">
                                        <i class="fa fa-pencil"></i>
                                    </button>

                                <?php
                                else:
                                ?>
                                    <button class="btn btn-danger disabled" title="No tienes permiso para editar">
                                        <i class="fa fa-times"></i>
                                    </button>

                                <?php endif; ?>
                            </td>

                        </tr>

                    <?php
                    }
                    ?>

                </tbody>

            </table>

        </div>

    </div>

</div>


<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>