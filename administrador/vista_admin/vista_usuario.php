<?php
require_once '../../modelo/val-admin.php';
require_once '../../modelo/datos-usuarios.php';
require_once '../../modelo/datos-rol.php';

// Validamos el usuario
if ($rol_user != 1 && $rol_user != 2 && $rol_user != 3) {
    echo "No tiene permisos";
    exit();
}

// Instancias
$mis_usuarios = new misUsuarios();
$mis_roles = new misRoles();

// 🔥 CONTROL POR ROL
if ($rol_user == 1) {
    $res = $mis_usuarios->viewUsuariosPorAdmin($user_codigo);

} elseif ($rol_user == 2) {
    $res = $mis_usuarios->viewClientesPorAsignador($user_codigo);

} elseif ($rol_user == 3) {
    $res = $mis_usuarios->viewUsuariosDocumento($user_cedula);
}
?>

<div class="col-sm-12">

    <div class="page-head-modern" style="background: linear-gradient(135deg, #0000ff, #ffffff); padding: 25px 30px; border-radius: 12px; color: #fff;">
        <h1>Usuarios</h1>
    </div>

    <ul class="breadcrumb breadcrumb-modern">
        <li>
            <a href="index.php">Inicio</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="active">Lista de usuarios</span>
        </li>
    </ul>

    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
                <th class="text-center">Item</th>
                <th class="text-center">Identificación</th>
                <th class="text-center">Nombre</th>
                <th class="text-center">Teléfono</th>
                <th class="text-center">Correo</th>
                <th class="text-center">Estado</th>
                <th class="text-center">Editar</th>
            </thead>

            <tbody>
                <?php foreach ($res as $data) {

                    $estado = ($data['estado'] == 1) ? "Activo" : "Inactivo";

                    $datos = $data['codigo'] . "||" .
                        $data['tipo_documento'] . "||" .
                        $data['numero_documento'] . "||" .
                        $data['nombre'] . "||" .
                        $data['usuario'] . "||" .
                        $data['contrasena'] . "||" .
                        $data['email'] . "||" .
                        $data['telefono'] . "||" .
                        $data['estado'] . "||" .
                        $data['rol_id'];
                ?>

                    <tr>
                        <td class="text-center"><?php echo $data['codigo']; ?></td>
                        <td class="text-center"><?php echo $data['numero_documento']; ?></td>
                        <td class="text-center"><?php echo $data['nombre']; ?></td>
                        <td class="text-center"><?php echo $data['telefono']; ?></td>
                        <td class="text-center"><?php echo $data['email']; ?></td>
                        <td class="text-center"><?php echo $estado; ?></td>

                        <td class="text-center">
                            <?php if ($rol_user != 3) { ?>
                                <button class="btn btn-primary glyphicon glyphicon-pencil"
                                    data-toggle="modal"
                                    data-target="#modalEdicionUsuario"
                                    onclick="agregarformUsuario('<?php echo $datos ?>')">
                                </button>
                            <?php } ?>
                        </td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>
    </div>

    <br>

    <!-- SOLO ADMIN Y ASIGNADOR PUEDEN CREAR -->
    <?php if ($rol_user == 1 || $rol_user == 2) { ?>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalNuevoUsuario">
            Crear usuario
        </button>
    <?php } ?>

</div>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>