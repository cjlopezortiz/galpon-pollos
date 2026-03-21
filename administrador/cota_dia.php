<?php
require_once '../modelo/val-admin.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Calendario</title>
	<?php
	include 'librerias-css.php';
	?>
</head>

<body id="body">
	<div class="col-sm-12">
		<?php
		include 'menu.php';
		?>
	</div>
	<div class="container-fluid">
		<div id="tablaCotaDia"></div>
	</div>

	<!-- FIN DEL CONTENIDO -->
	<?php
	include './modales/modalCotaDia.php';
	?>
	<script src="../controlador/funciones-cota-dia.js"></script>
	<?php
	include 'librerias-js.php';
	?>
	<script type="text/javascript">
		$(document).ready(function() {
			// Obtener el rol desde PHP
			rol_user = <?php echo $rol_user ?>;

			if (rol_user == 1 || rol_user == 2 || rol_user == 3) {
				// Capturamos tanto la cedula como el id_cota de la URL del navegador
				var urlParams = new URLSearchParams(window.location.search);
				var cedula = urlParams.get('cedula');
				var id_cota = urlParams.get('id_cota'); // Capturamos el ID de la cota

				// Enviamos AMBOS datos a la vista que genera la tabla
				$('#tablaCotaDia').load('./vista_admin/vista_cota_dia.php', {
					cedula: cedula,
					id_cota: id_cota // Ahora la vista interna sabrá qué registro específico buscar
				});

			} else {
				alert("Error: No tiene permisos para ver esta sección.");
				window.location.href = 'index.php'; // Redirigir por seguridad
			}

			// --- Eventos de Botones ---
			$('#guardarNuevoCotaDia').click(function() {
				agregardatosCotaDia();
			});

			$('#actualizaDatosCotaDia').click(function() {
				modificarCotaDia();
			});

			$('#eliminarDatosCotaDia').click(function() {
				preguntarSiNoCotaDia();
			});
		});
	</script>
</body>

</html>