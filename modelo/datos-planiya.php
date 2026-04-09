<?php

class misPlaniyas
{
    // 🔥 LISTAR PLANILLAS CON CONTROL POR ROL
    function viewPlaniyas($cedula_usuario, $rol_user)
    {
        require_once 'conexion.php';
        $conexion = new Conexion();
        $arreglo = array();

        if ($rol_user == 1) {

            // 👑 ADMIN → SOLO SU ESTRUCTURA
            $admin_id = $_SESSION['codigo'];

            $consulta = "SELECT *
                         FROM planiya_datos
                         WHERE 
                         asignador_id = :admin_id
                         OR asignador_id IN (
                             SELECT codigo FROM usuario 
                             WHERE asignador_id = :admin_id
                         )
                         ORDER BY id_planilla ASC";

            $modules = $conexion->prepare($consulta);
            $modules->bindParam(":admin_id", $admin_id);
            $modules->execute();
        } elseif ($rol_user == 2) {

            // 👨‍💼 ASIGNADOR → solo sus planillas
            $asignador_id = $_SESSION['codigo'];

            $consulta = "SELECT *
                         FROM planiya_datos
                         WHERE asignador_id = :asignador_id
                         ORDER BY id_planilla ASC";

            $modules = $conexion->prepare($consulta);
            $modules->bindParam(":asignador_id", $asignador_id);
            $modules->execute();
        } else {

            // 👤 CLIENTE → solo su cedula
            $consulta = "SELECT *
                         FROM planiya_datos
                         WHERE cedula = :cedula
                         ORDER BY id_planilla ASC";

            $modules = $conexion->prepare($consulta);
            $modules->bindParam(":cedula", $cedula_usuario);
            $modules->execute();
        }

        while ($data = $modules->fetch(PDO::FETCH_ASSOC)) {
            $arreglo[] = $data;
        }

        return $arreglo;
    }

 function viewPlaniyasMas($cedula, $rol_user)
    {
        require_once 'conexion.php';
        $conexion = new Conexion();
        $arreglo = array();

        // ADMIN Y ASIGNADOR ven todo
        if ($rol_user == 1 || $rol_user == 2 || $rol_user == 3) {

            $consulta = "SELECT id_planilla,
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
                            observaciones
                    FROM planiya_datos
                    WHERE cedula = :cedula
                    ORDER BY id_planilla ASC";

            $modules = $conexion->prepare($consulta);
            $modules->bindParam(":cedula", $cedula);
            $modules->execute();
        } else {

            // CLIENTE solo su cedula
            $consulta = "SELECT id_planilla,
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
                            observaciones
                    FROM planiya_datos
                    WHERE cedula = :cedula
                    ORDER BY id_planilla ASC";

            $modules = $conexion->prepare($consulta);
            $modules->bindParam(":cedula", $cedula_usuario);
            $modules->execute();
        }

        while ($data = $modules->fetch(PDO::FETCH_ASSOC)) {
            $arreglo[] = $data;
        }

        return $arreglo;
    }
    // 🔥 CONTADOR CON FILTRO POR ROL
    function counPlaniya($cedula_usuario, $rol_user)
    {
        require_once 'conexion.php';
        $conexion = new Conexion();

        if ($rol_user == 1) {

            // 👑 ADMIN → SOLO SU ESTRUCTURA
            $admin_id = $_SESSION['codigo'];

            $consulta = "SELECT COUNT(id_planilla) as cant
                         FROM planiya_datos
                         WHERE 
                         asignador_id = :admin_id
                         OR asignador_id IN (
                             SELECT codigo FROM usuario 
                             WHERE asignador_id = :admin_id
                         )";

            $modules = $conexion->prepare($consulta);
            $modules->bindParam(":admin_id", $admin_id);
            $modules->execute();
        } elseif ($rol_user == 2) {

            // 👨‍💼 ASIGNADOR
            $asignador_id = $_SESSION['codigo'];

            $consulta = "SELECT COUNT(id_planilla) as cant
                         FROM planiya_datos
                         WHERE asignador_id = :asignador_id";

            $modules = $conexion->prepare($consulta);
            $modules->bindParam(":asignador_id", $asignador_id);
            $modules->execute();
        } else {

            // 👤 CLIENTE
            $consulta = "SELECT COUNT(id_planilla) as cant
                         FROM planiya_datos
                         WHERE cedula = :cedula";

            $modules = $conexion->prepare($consulta);
            $modules->bindParam(":cedula", $cedula_usuario);
            $modules->execute();
        }

        $data = $modules->fetch(PDO::FETCH_ASSOC);
        return $data['cant'];
    }


    // 🔎 VER UNA PLANILLA
    function viewPlaniya($id_planilla)
    {
        require_once 'conexion.php';
        $conexion = new Conexion();
        $arreglo = array();

        $consulta = "SELECT *
                     FROM planiya_datos
                     WHERE id_planilla = :id_planilla";

        $modules = $conexion->prepare($consulta);
        $modules->bindParam(":id_planilla", $id_planilla);
        $modules->execute();

        while ($data = $modules->fetch(PDO::FETCH_ASSOC)) {
            $arreglo[] = $data;
        }

        return $arreglo;
    }


    // 🔝 MAX ID
    public function maxPlaniya()
    {
        require_once 'conexion.php';
        $conexion = new Conexion();

        $sqlcon = "SELECT max(id_planilla) as maximo FROM planiya_datos";
        $rescon = $conexion->prepare($sqlcon);
        $rescon->execute();

        $rowcon = $rescon->fetch(PDO::FETCH_ASSOC);
        return $rowcon['maximo'] + 1;
    }
   
}
