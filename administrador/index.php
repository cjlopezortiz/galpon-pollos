<?php
date_default_timezone_set("America/Bogota");

require_once '../modelo/val-admin.php';
require_once '../modelo/datos-usuarios.php';
require '../modelo/datos-planiya.php';
require_once '../modelo/datos-rol.php';

$mis_usuarios = new misUsuarios();
$mis_planillas = new misPlaniyas();
$mis_roles = new misRoles();

$cedula_usuario = $_SESSION['cedula'] ?? null;

// 🔥 CONTADOR INTELIGENTE POR ROL
if ($rol_user == 1) {
    $cant_usuarios = $mis_usuarios->countUsuariosPorAdmin($_SESSION['codigo']);
} elseif ($rol_user == 2) {
    // 🔥 ASIGNADOR → solo sus clientes
    $cant_usuarios = $mis_usuarios->countClientesPorAsignador($_SESSION['codigo']);
} elseif ($rol_user == 3) {
    // 🔥 CLIENTE → solo él
    $cant_usuarios = 1;
} else {
    $cant_usuarios = 0;
}

// 🔥 YA LO TENÍAS BIEN
$cant_panillas = $mis_planillas->counPlaniya($cedula_usuario, $rol_user);
$rol = $mis_roles->viewRoles();

// Título dinámico
if ($rol_user == 1) {
    $pagina = "Administrador";
} elseif ($rol_user == 2) {
    $pagina = "Asignador";
} elseif ($rol_user == 3) {
    $pagina = "Cliente";
} else {
    $pagina = "";
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $pagina ?></title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <?php include 'librerias-css.php'; ?>

    <style>
        :root {
            --primary: #2c3e50;
            --success: #27ae60;
            --info: #3498db;
            --bg: #f8f9fa;
        }

        body {
            background: var(--bg);
            font-family: 'Segoe UI', Roboto, Arial;
        }

        .main-content {
            padding-top: 20px;
        }

        .welcome-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .welcome-text h3 {
            margin: 0;
            color: var(--primary);
            font-weight: 700;
        }

        .card-loan {
            background: white;
            border-radius: 15px;
            padding: 30px 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: .3s;
            margin-bottom: 30px;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .card-loan:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .card-loan::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
        }

        .card-plantilla::after {
            background: var(--success);
        }

        .card-usuarios::after {
            background: var(--info);
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
            margin-bottom: 20px;
            font-size: 35px;
        }

        .bg-light-success {
            background: #e8f5e9;
            color: var(--success);
        }

        .bg-light-info {
            background: #e3f2fd;
            color: var(--info);
        }

        .card-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 10px;
        }

        .card-count {
            font-size: 16px;
            color: #7f8c8d;
            margin-bottom: 25px;
        }

        .btn-enter {
            display: inline-block;
            padding: 10px 30px;
            border-radius: 25px;
            color: white !important;
            text-decoration: none !important;
            font-weight: 600;
        }

        .btn-success-loan {
            background: var(--success);
        }

        .btn-info-loan {
            background: var(--info);
        }

        .btn-disabled {
            background: #95a5a6;
            cursor: not-allowed;
        }
    </style>

</head>

<body>

<<<<<<< HEAD
    <div class="container main-content">
=======
        <!-- END PAGE HEAD-->
        <!-- BEGIN PAGE BREADCRUMB -->
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="index.php">Inicio:</a>
                <i class="fa fa-circle"></i>
            </li>
            <li class="text-primary">
                <span class="active">Proyecto Galpon:</span>
                <i class="fa fa-circle"></i>
            </li>
            <li class="text-primary">
                <span class="active">Panel principal:</span>
                <i class="fa fa-circle"></i>
            </li>
        </ul>
        <!-- END PAGE BREADCRUMB -->
        <!-- BEGIN PAGE BASE CONTENT -->
        <h3 class="text-right">Bienvenido: <?php echo $user_nombre; ?></h3>
        <?php
        if ($rol_user == 1 || $rol_user == 2) {
        ?>
            <style>
                .galpon-card {
                    border-radius: 15px;
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                    transition: transform .2s;
                    padding: 20px;
                    text-align: center;
                    background: #ffffff;
                    margin-bottom: 25px;
                }
>>>>>>> 7e85e95eded65972d0d4d885394847d48708a139

        <?php include 'menu.php'; ?>

        <nav aria-label="breadcrumb">
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="index.php"><i class="fa fa-home"></i> Inicio</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="active">Panel Principal</li>
            </ul>
        </nav>

        <div class="welcome-section">
            <div class="welcome-text">
                <h3><i class="fa fa-chart-pie"></i> Panel de Administración</h3>
            </div>

            <div class="user-badge">
                <span class="label label-primary" style="padding:10px;border-radius:5px;">
                    <i class="fa fa-user"></i> <?php echo $user_nombre; ?>
                </span>
            </div>
        </div>

        <div class="row">

            <!-- CARD PLANILLAS -->
            <div class="col-md-6">
                <a href="planiya.php" style="text-decoration:none;">
                    <div class="card-loan card-plantilla">
                        <div class="icon-circle bg-light-success">
                            <i class="fa fa-hand-holding-dollar"></i>
                        </div>

                        <div class="card-title">Cobranza / Plantillas</div>

                        <div class="card-count">
                            Total Registros: <strong><?php echo $cant_panillas; ?></strong>
                        </div>

                        <span class="btn-enter btn-success-loan">
                            Gestionar Carteras <i class="fa fa-arrow-right"></i>
                        </span>
                    </div>
                </a>
            </div>

            <!-- CARD USUARIOS -->
            <div class="col-md-6">

                <?php if ($rol_user == 1 || $rol_user == 2) { ?>

                    <a href="usuarios.php" style="text-decoration:none;">
                        <div class="card-loan card-usuarios">

                            <div class="icon-circle bg-light-info">
                                <i class="fa fa-users-gear"></i>
                            </div>

                            <div class="card-title">Personal / Clientes</div>

                            <div class="card-count">
                                <div class="card-count">
                                    <div class="card-count" style="display:flex;justify-content:center;align-items:center;gap:10px;">

                                        <?php if ($rol_user == 1) { ?>
                                            <span>Total usuarios:</span>
                                            <span style="
                                                    background:#3498db;
                                                    color:white;
                                                    padding:5px 12px;
                                                    border-radius:20px;
                                                    font-weight:bold;
                                                    font-size:14px;
                                                ">
                                                <?php echo $cant_usuarios; ?>
                                            </span>

                                        <?php } elseif ($rol_user == 2) { ?>
                                            <span>Mis clientes:</span>
                                            <span style="
                                                    background:#27ae60;
                                                    color:white;
                                                    padding:5px 12px;
                                                    border-radius:20px;
                                                    font-weight:bold;
                                                    font-size:14px;
                                                ">
                                                <?php echo $cant_usuarios; ?>
                                            </span>

                                        <?php } else { ?>
                                            <span>Mis datos:</span>
                                            <span style="
                                                background:#95a5a6;
                                                color:white;
                                                padding:5px 12px;
                                                border-radius:20px;
                                                font-weight:bold;
                                                font-size:14px;
                                            ">
                                                <?php echo $cant_usuarios; ?>
                                            </span>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>

                            <span class="btn-enter btn-info-loan">
                                Administrar Personal <i class="fa fa-arrow-right"></i>
                            </span>

                        </div>
                    </a>

                <?php } else { ?>

                    <div class="card-loan card-usuarios" style="opacity:0.6;">
                        <div class="icon-circle bg-light-info">
                            <i class="fa fa-users-gear"></i>
                        </div>

                        <div class="card-title">Personal / Clientes</div>

                        <div class="card-count">
                            Mis datos: <strong><?php echo $cant_usuarios; ?></strong>
                        </div>

                        <span class="btn-enter btn-disabled">
                            Sin permisos <i class="fa fa-lock"></i>
                        </span>
                    </div>

                <?php } ?>

            </div>

        </div>

    </div>

    <?php include 'librerias-js.php'; ?>

</body>

</html>
