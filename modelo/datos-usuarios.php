<?php

class misUsuarios
{
    function viewUsuarios()
    {
        require_once 'conexion.php';
        $conexion = new Conexion();
        $arreglo = array();

        $consulta = "SELECT *
                     FROM usuario
                     ORDER BY numero_documento ASC";

        $modules = $conexion->prepare($consulta);
        $modules->execute();

        while ($data = $modules->fetch(PDO::FETCH_ASSOC)) {
            $arreglo[] = $data;
        }

        return $arreglo;
    }

    function viewUsuariosDocumento($numero_documento)
    {
        require_once 'conexion.php';
        $conexion = new Conexion();
        $arreglo = array();

        $consulta = "SELECT *
                     FROM usuario
                     WHERE numero_documento = :numero_documento";

        $modules = $conexion->prepare($consulta);
        $modules->bindParam(":numero_documento", $numero_documento);
        $modules->execute();

        while ($data = $modules->fetch(PDO::FETCH_ASSOC)) {
            $arreglo[] = $data;
        }

        return $arreglo;
    }

    function viewUsuario($codigo)
    {
        require_once 'conexion.php';
        $conexion = new Conexion();
        $arreglo = array();

        $consulta = "SELECT *
                     FROM usuario
                     WHERE codigo = :codigo";

        $modules = $conexion->prepare($consulta);
        $modules->bindParam(":codigo", $codigo);
        $modules->execute();

        while ($data = $modules->fetch(PDO::FETCH_ASSOC)) {
            $arreglo[] = $data;
        }

        return $arreglo;
    }

    // 🔥 NUEVA FUNCIÓN CLAVE
    function viewClientesPorAsignador($asignador_id)
    {
        require_once 'conexion.php';
        $conexion = new Conexion();
        $arreglo = array();

        $consulta = "SELECT *
                     FROM usuario
                     WHERE rol_id = 3
                     AND asignador_id = :asignador_id";

        $modules = $conexion->prepare($consulta);
        $modules->bindParam(":asignador_id", $asignador_id);
        $modules->execute();

        while ($data = $modules->fetch(PDO::FETCH_ASSOC)) {
            $arreglo[] = $data;
        }

        return $arreglo;
    }

    function countUsuarios()
    {
        require_once 'conexion.php';
        $conexion = new Conexion();

        $consulta = "SELECT count(codigo) as cant FROM usuario";
        $modules = $conexion->prepare($consulta);
        $modules->execute();

        $data = $modules->fetch(PDO::FETCH_ASSOC);
        return $data['cant'];
    }
    // Contar clientes totales (solo rol 3)
    // Contar clientes por asignador
    function countClientesPorAsignador($asignador_id)
    {
        require_once 'conexion.php';
        $conexion = new Conexion();

        $consulta = "SELECT COUNT(codigo) as cant
                 FROM usuario
                 WHERE rol_id = 3
                 AND asignador_id = :asignador_id";

        $modules = $conexion->prepare($consulta);
        $modules->bindParam(":asignador_id", $asignador_id);
        $modules->execute();

        $data = $modules->fetch(PDO::FETCH_ASSOC);
        return $data['cant'];
    }

    // Contar clientes totales (solo rol 3)
    function countClientes()
    {
        require_once 'conexion.php';
        $conexion = new Conexion();

        $consulta = "SELECT COUNT(codigo) as cant
                 FROM usuario
                 WHERE rol_id = 3";

        $modules = $conexion->prepare($consulta);
        $modules->execute();

        $data = $modules->fetch(PDO::FETCH_ASSOC);
        return $data['cant'];
    }
    public function maxUsuarios()
    {
        require_once 'conexion.php';
        $conexion = new Conexion();

        $sqlcon = "SELECT max(codigo) as maximo FROM usuario";
        $rescon = $conexion->prepare($sqlcon);
        $rescon->execute();

        $rowcon = $rescon->fetch(PDO::FETCH_ASSOC);
        return $rowcon['maximo'] + 1;
    }
    function viewUsuariosPorAdmin($admin_id)
    {
        require_once 'conexion.php';
        $conexion = new Conexion();
        $arreglo = array();

        $consulta = "SELECT * FROM usuario
                 WHERE 
                 codigo = :admin_id  -- 🔥 EL MISMO ADMIN
                 OR asignador_id = :admin_id
                 OR asignador_id IN (
                     SELECT codigo FROM usuario 
                     WHERE asignador_id = :admin_id
                 )
                 ORDER BY numero_documento ASC";

        $modules = $conexion->prepare($consulta);
        $modules->bindParam(":admin_id", $admin_id);
        $modules->execute();

        while ($data = $modules->fetch(PDO::FETCH_ASSOC)) {
            $arreglo[] = $data;
        }

        return $arreglo;
    }
    function countUsuariosPorAdmin($admin_id)
    {
        require_once 'conexion.php';
        $conexion = new Conexion();

        $consulta = "SELECT COUNT(codigo) as cant
                 FROM usuario
                 WHERE 
                 codigo = :admin_id
                 OR asignador_id = :admin_id
                 OR asignador_id IN (
                     SELECT codigo FROM usuario 
                     WHERE asignador_id = :admin_id
                 )";

        $modules = $conexion->prepare($consulta);
        $modules->bindParam(":admin_id", $admin_id);
        $modules->execute();

        $data = $modules->fetch(PDO::FETCH_ASSOC);
        return $data['cant'];
    }
}
