<?php
date_default_timezone_set("America/Bogota");
session_start();

require_once 'conexion.php';
require_once 'datos-planiya.php';

$conexion = new Conexion();
$mis_planiyas = new misPlaniyas();

if (isset($_GET['accion'])) {

	$accion = $_GET['accion'];

	if ($accion == 'registrar') {

		$maxPlanilla = $mis_planiyas->maxPlaniya();
		$id_planilla = $maxPlanilla;

		$asignador_id = $_SESSION['codigo']; // 🔥 CLAVE

		$fecha_inicio = $_POST['fecha_inicio'];
		$fecha_fin = $_POST['fecha_fin'];
		$catidad_prestada = $_POST['catidad_prestada'];
		$cantidad_mora = $_POST['cantidad_mora'];
		$cota_diario = $_POST['cota_diario'];
		$cota_ocho = $_POST['cota_ocho'];
		$cota_quince = $_POST['cota_quince'];
		$cota_mes = $_POST['cota_mes'];
		$cedula = $_POST['cedula'];
		$nombre = $_POST['nombre'];
		$apellido = $_POST['apellido'];
		$direccion = $_POST['direccion'];
		$barrio = $_POST['barrio'];
		$observaciones = $_POST['observaciones'];

		$sql = "INSERT INTO planiya_datos (
			id_planilla,
			fecha_inicio,
			fecha_fin,
			catidad_prestada,
			cantidad_mora,
			cota_diario,
			cota_ocho,
			cota_quince,
			cota_mes,
			cedula,
			nombre,
			apellido,
			direccion,
			barrio,
			observaciones,
			asignador_id
		) 
		VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

		$reg = $conexion->prepare($sql);

		$reg->bindParam(1, $id_planilla);
		$reg->bindParam(2, $fecha_inicio);
		$reg->bindParam(3, $fecha_fin);
		$reg->bindParam(4, $catidad_prestada);
		$reg->bindParam(5, $cantidad_mora);
		$reg->bindParam(6, $cota_diario);
		$reg->bindParam(7, $cota_ocho);
		$reg->bindParam(8, $cota_quince);
		$reg->bindParam(9, $cota_mes);
		$reg->bindParam(10, $cedula);
		$reg->bindParam(11, $nombre);
		$reg->bindParam(12, $apellido);
		$reg->bindParam(13, $direccion);
		$reg->bindParam(14, $barrio);
		$reg->bindParam(15, $observaciones);
		$reg->bindParam(16, $asignador_id); // 🔥

		echo ($reg->execute()) ? 1 : 0;

	} else if ($accion == 'modificar') {

		$id_planilla = $_POST['id_planilla'];

		$sql = "UPDATE planiya_datos SET 
			fecha_inicio=:fecha_inicio,
			fecha_fin=:fecha_fin,
			catidad_prestada=:catidad_prestada,
			cantidad_mora=:cantidad_mora,
			cota_diario=:cota_diario,
			cota_ocho=:cota_ocho,
			cota_quince=:cota_quince,
			cota_mes=:cota_mes,
			cedula=:cedula,
			nombre=:nombre,
			apellido=:apellido,
			direccion=:direccion,
			barrio=:barrio,
			observaciones=:observaciones
		WHERE id_planilla = :id_planilla";

		$reg = $conexion->prepare($sql);

		$reg->bindParam(":id_planilla", $id_planilla);
		$reg->bindParam(":fecha_inicio", $_POST['fecha_inicio']);
		$reg->bindParam(":fecha_fin", $_POST['fecha_fin']);
		$reg->bindParam(":catidad_prestada", $_POST['catidad_prestada']);
		$reg->bindParam(":cantidad_mora", $_POST['cantidad_mora']);
		$reg->bindParam(":cota_diario", $_POST['cota_diario']);
		$reg->bindParam(":cota_ocho", $_POST['cota_ocho']);
		$reg->bindParam(":cota_quince", $_POST['cota_quince']);
		$reg->bindParam(":cota_mes", $_POST['cota_mes']);
		$reg->bindParam(":cedula", $_POST['cedula']);
		$reg->bindParam(":nombre", $_POST['nombre']);
		$reg->bindParam(":apellido", $_POST['apellido']);
		$reg->bindParam(":direccion", $_POST['direccion']);
		$reg->bindParam(":barrio", $_POST['barrio']);
		$reg->bindParam(":observaciones", $_POST['observaciones']);

		echo ($reg->execute()) ? 1 : 0;

	} else if ($accion == 'eliminar') {

		$id_planilla = $_POST['id_planilla'];

		$sql = "DELETE FROM planiya_datos WHERE id_planilla = :id_planilla";
		$del = $conexion->prepare($sql);
		$del->bindParam(":id_planilla", $id_planilla);

		echo ($del->execute()) ? 1 : 0;

	} else {
		echo 2;
	}

} else {
	echo 3;
}