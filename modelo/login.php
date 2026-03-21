<?php
session_start(); // Iniciar sesión al principio
require_once 'conexion.php';
$conexion = new Conexion();

if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    $loginNombre = $_POST["usuario"];
    $loginPassword = $_POST["contrasena"];
    
    // Consulta simple: el filtrado de estados se hace mejor en el PHP o con OR
    $sql = "SELECT * FROM usuario WHERE usuario=:usuario AND contrasena=:contrasena";
    $modules = $conexion->prepare($sql);
    $modules->bindParam(":usuario", $loginNombre);
    $modules->bindParam(":contrasena", $loginPassword);
    $modules->execute();
    
    if ($row = $modules->fetch(PDO::FETCH_ASSOC)) {
        // CORRECCIÓN: Usar OR (||) para los estados, no AND (&&)
        $estado_valido = ($row['estado'] == 1);
        $reporte_valido = ($row['estado_reporte_id'] >= 1 && $row['estado_reporte_id'] <= 4);

        if ($estado_valido || $reporte_valido) {
            $_SESSION['codigo'] = $row['codigo'];
            $_SESSION['cedula'] = $row['numero_documento']; // Unificado para las consultas
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['rol_id'] = $row['rol_id'];
            $_SESSION['usuario'] = $row['usuario'];
            
            header("Location: ../administrador/index.php");
            exit();
        } else {
            echo '<script>alert("Usuario inactivo."); self.location="../index.php";</script>';
        }
    } else {
        echo '<script>alert("Datos incorrectos."); self.location="../index.php";</script>';
    }
}