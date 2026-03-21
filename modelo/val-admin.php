<?php
session_start();
require_once 'datos-usuarios.php';
$mis_usuarios = new misUsuarios();

if (isset($_SESSION['codigo'])) {
    $user_codigo = $_SESSION['codigo'];
    $user_cedula = $_SESSION['cedula']; // Esta es la que usan tus consultas SQL
    $rol_user = $_SESSION['rol_id'];
    $user_nombre = $_SESSION['nombre'];

    $mi_usuarios = $mis_usuarios->viewUsuario($user_codigo);
    
    if (count($mi_usuarios) == 0) {
        session_destroy();
        header("Location: ../index.php");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}