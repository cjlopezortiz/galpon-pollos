<?php

class misCotaDia
{


    function viewCotaDia($cedula)
    {
        require_once 'conexion.php';
        $conexion = new Conexion();
        $arreglo = array();
        // Se seleccionan todos los campos: generales + los 30 días (si/no)
        $consulta = "SELECT 
                    id_cota, 
                    cedula, 
                    fecha_cota_dia, 
                    fecha_cota_dia_fin, 
                    cantidad_saldo, 
                    couta, 
                    mora_cota, 
                    si, 
                    no, 
                    observaciones_dia,
                    dia1_si, dia1_no,
                    dia2_si, dia2_no,
                    dia3_si, dia3_no,
                    dia4_si, dia4_no,
                    dia5_si, dia5_no,
                    dia6_si, dia6_no,
                    dia7_si, dia7_no,
                    dia8_si, dia8_no,
                    dia9_si, dia9_no,
                    dia10_si, dia10_no,
                    dia11_si, dia11_no,
                    dia12_si, dia12_no,
                    dia13_si, dia13_no,
                    dia14_si, dia14_no,
                    dia15_si, dia15_no,
                    dia16_si, dia16_no,
                    dia17_si, dia17_no,
                    dia18_si, dia18_no,
                    dia19_si, dia19_no,
                    dia20_si, dia20_no,
                    dia21_si, dia21_no,
                    dia22_si, dia22_no,
                    dia23_si, dia23_no,
                    dia24_si, dia24_no,
                    dia25_si, dia25_no,
                    dia26_si, dia26_no,
                    dia27_si, dia27_no,
                    dia28_si, dia28_no,
                    dia29_si, dia29_no,
                    dia30_si, dia30_no,
                    dia31_si, dia31_no
                FROM cota_diaria 
                WHERE cedula = :cedula";

        $modules = $conexion->prepare($consulta);
        $modules->bindParam(":cedula", $cedula);
        $modules->execute();

        // El método fetchAll simplifica el proceso de llenar el arreglo
        $arreglo = $modules->fetchAll(PDO::FETCH_ASSOC);

        return $arreglo;
    }

    function viewCotaDias()
    {
        require_once 'conexion.php';
        $conexion = new Conexion();
        $arreglo = array();
        $consulta = "SELECT 
                    id_cota, 
                    cedula,
                    fecha_cota_dia, 
                    fecha_cota_dia_fin, 
                    cantidad_saldo,mora_cota
                    couta, 
                    mora_cota, 
                    si, 
                    no, 
                    observaciones_dia,
                    dia1_si, dia1_no,
                    dia2_si, dia2_no,
                    dia3_si, dia3_no,
                    dia4_si, dia4_no,
                    dia5_si, dia5_no,
                    dia6_si, dia6_no,
                    dia7_si, dia7_no,
                    dia8_si, dia8_no,
                    dia9_si, dia9_no,
                    dia10_si, dia10_no,
                    dia11_si, dia11_no,
                    dia12_si, dia12_no,
                    dia13_si, dia13_no,
                    dia14_si, dia14_no,
                    dia15_si, dia15_no,
                    dia16_si, dia16_no,
                    dia17_si, dia17_no,
                    dia18_si, dia18_no,
                    dia19_si, dia19_no,
                    dia20_si, dia20_no,
                    dia21_si, dia21_no,
                    dia22_si, dia22_no,
                    dia23_si, dia23_no,
                    dia24_si, dia24_no,
                    dia25_si, dia25_no,
                    dia26_si, dia26_no,
                    dia27_si, dia27_no,
                    dia28_si, dia28_no,
                    dia29_si, dia29_no,
                    dia30_si, dia30_no,
                    dia31_si, dia31_no
                FROM cota_diaria 
                ORDER BY id_cota ASC";
        $modules = $conexion->prepare($consulta);
        $modules->execute();
        $total = $modules->rowCount();
        if ($total > 0) {
            $i = 0;
            while ($data = $modules->fetch(PDO::FETCH_ASSOC)) {
                $arreglo[$i] = $data;
                $i++;
            }
        }
        return $arreglo;
    }

    function counCotaDias()
    {
        require_once 'conexion.php';
        $conexion = new Conexion();
        $consulta = "SELECT count(id_cota) as cant
                     FROM cota_diaria";
        $modules = $conexion->prepare($consulta);
        $modules->execute();
        $data = $modules->fetch(PDO::FETCH_ASSOC);
        $total = 0;
        $total = $data['cant'];
        return $total;
    }


    // MAXIMO ID
    public function maxCotaDias()
    {
        require_once 'conexion.php';
        $conexion = new Conexion();

        $sqlcon = "SELECT max(id_cota) as maximo FROM cota_diaria";

        $rescon = $conexion->prepare($sqlcon);
        $rescon->execute();

        $rowcon = $rescon->fetch(PDO::FETCH_ASSOC);

        $consecutivo = $rowcon['maximo'];
        $consecutivo++;

        return $consecutivo;
    }
}
