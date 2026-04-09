<?php
require_once 'datos-cota_dia.php';
$mis_cota_dia = new misCotaDia();
date_default_timezone_set("America/Bogota");
require_once 'conexion.php';
$conexion = new Conexion();

if (isset($_GET['accion'])) {
    $accion = $_GET['accion'];

    if ($accion == 'registrar') {

        $maxCotaDia = $mis_cota_dia->maxCotaDias();
        $id_cota = $maxCotaDia;

        $cedula = $_POST['cedula'];
        $fecha_cota_dia = $_POST['fecha_cota_dia'];
        $fecha_cota_dia_fin = $_POST['fecha_cota_dia_fin'];
        $cantidad_saldo = $_POST['cantidad_saldo'];
        $couta = $_POST['couta'];
        $mora_cota = $_POST['mora_cota'];
        $observaciones_dia = $_POST['observaciones_dia'];

        // DIAS
        for ($i = 1; $i <= 31; $i++) {

            ${"dia" . $i . "_si"} = isset($_POST["dia" . $i . "_si"]) ? $_POST["dia" . $i . "_si"] : 0;
            ${"dia" . $i . "_no"} = isset($_POST["dia" . $i . "_no"]) ? $_POST["dia" . $i . "_no"] : 0;
        }

        $sql = "INSERT INTO cota_diaria (id_cota,cedula,fecha_cota_dia,fecha_cota_dia_fin,cantidad_saldo,couta,mora_cota,";

        for ($i = 1; $i <= 31; $i++) {
            $sql .= "dia" . $i . "_si,dia" . $i . "_no,";
        }

        $sql .= "observaciones_dia) VALUES (?,?,?,?,?,?,?,";

        for ($i = 1; $i <= 31; $i++) {
            $sql .= "?, ?,";
        }

        $sql .= "?)";

        $reg = $conexion->prepare($sql);

        $i = 1;

        $reg->bindParam($i++, $id_cota);
        $reg->bindParam($i++, $cedula);
        $reg->bindParam($i++, $fecha_cota_dia);
        $reg->bindParam($i++, $fecha_cota_dia_fin);
        $reg->bindParam($i++, $cantidad_saldo);
        $reg->bindParam($i++, $couta);
        $reg->bindParam($i++, $mora_cota);

        for ($d = 1; $d <= 31; $d++) {

            $reg->bindParam($i++, ${"dia" . $d . "_si"});
            $reg->bindParam($i++, ${"dia" . $d . "_no"});
        }

        $reg->bindParam($i++, $observaciones_dia);

        if ($reg->execute()) {
            echo 1;
        } else {
            echo 0;
        }
    } else if ($accion == 'modificar') {

        $id_cota = $_POST['id_cota'];
        $cedula = $_POST['cedula'];
        $fecha_cota_dia = $_POST['fecha_cota_dia'];
        $fecha_cota_dia_fin = $_POST['fecha_cota_dia_fin'];
        $cantidad_saldo = $_POST['cantidad_saldo'];
        $couta = $_POST['couta'];
        $mora_cota = $_POST['mora_cota'];
        $observaciones_dia = $_POST['observaciones_dia'];

        for ($i = 1; $i <= 31; $i++) {
            ${"dia" . $i . "_si"} = isset($_POST["dia" . $i . "_si"]) ? $_POST["dia" . $i . "_si"] : 0;
            ${"dia" . $i . "_no"} = isset($_POST["dia" . $i . "_no"]) ? $_POST["dia" . $i . "_no"] : 0;
        }

        $sql = "UPDATE cota_diaria SET

                cedula=:cedula,
                fecha_cota_dia=:fecha_cota_dia,
                fecha_cota_dia_fin=:fecha_cota_dia_fin,
                cantidad_saldo=:cantidad_saldo,
                couta=:couta,
                mora_cota=:mora_cota,

                dia1_si=:dia1_si,dia1_no=:dia1_no,
                dia2_si=:dia2_si,dia2_no=:dia2_no,
                dia3_si=:dia3_si,dia3_no=:dia3_no,
                dia4_si=:dia4_si,dia4_no=:dia4_no,
                dia5_si=:dia5_si,dia5_no=:dia5_no,
                dia6_si=:dia6_si,dia6_no=:dia6_no,
                dia7_si=:dia7_si,dia7_no=:dia7_no,
                dia8_si=:dia8_si,dia8_no=:dia8_no,
                dia9_si=:dia9_si,dia9_no=:dia9_no,
                dia10_si=:dia10_si,dia10_no=:dia10_no,
                dia11_si=:dia11_si,dia11_no=:dia11_no,
                dia12_si=:dia12_si,dia12_no=:dia12_no,
                dia13_si=:dia13_si,dia13_no=:dia13_no,
                dia14_si=:dia14_si,dia14_no=:dia14_no,
                dia15_si=:dia15_si,dia15_no=:dia15_no,
                dia16_si=:dia16_si,dia16_no=:dia16_no,
                dia17_si=:dia17_si,dia17_no=:dia17_no,
                dia18_si=:dia18_si,dia18_no=:dia18_no,
                dia19_si=:dia19_si,dia19_no=:dia19_no,
                dia20_si=:dia20_si,dia20_no=:dia20_no,
                dia21_si=:dia21_si,dia21_no=:dia21_no,
                dia22_si=:dia22_si,dia22_no=:dia22_no,
                dia23_si=:dia23_si,dia23_no=:dia23_no,
                dia24_si=:dia24_si,dia24_no=:dia24_no,
                dia25_si=:dia25_si,dia25_no=:dia25_no,
                dia26_si=:dia26_si,dia26_no=:dia26_no,
                dia27_si=:dia27_si,dia27_no=:dia27_no,
                dia28_si=:dia28_si,dia28_no=:dia28_no,
                dia29_si=:dia29_si,dia29_no=:dia29_no,
                dia30_si=:dia30_si,dia30_no=:dia30_no,
                dia31_si=:dia31_si,dia31_no=:dia31_no,

                observaciones_dia=:observaciones_dia

                WHERE id_cota=:id_cota";

        $reg = $conexion->prepare($sql);

        $reg->bindParam(":id_cota", $id_cota);
        $reg->bindParam(":cedula", $cedula);
        $reg->bindParam(":fecha_cota_dia", $fecha_cota_dia);
        $reg->bindParam(":fecha_cota_dia_fin", $fecha_cota_dia_fin);
        $reg->bindParam(":cantidad_saldo", $cantidad_saldo);
        $reg->bindParam(":couta", $couta);
        $reg->bindParam(":mora_cota", $mora_cota);

        for ($d = 1; $d <= 31; $d++) {
            $reg->bindParam(":dia" . $d . "_si", ${"dia" . $d . "_si"});
            $reg->bindParam(":dia" . $d . "_no", ${"dia" . $d . "_no"});
        }

        $reg->bindParam(":observaciones_dia", $observaciones_dia);

        if ($reg->execute()) {
            echo 1;
        } else {
            echo 0;
        }
    } else if ($accion == 'eliminar') {

        $id_cota = $_POST['id_cota'];

        $sql = "DELETE FROM cota_diaria WHERE id_cota=:id_cota";

        $del = $conexion->prepare($sql);
        $del->bindParam(":id_cota", $id_cota);

        if ($del->execute()) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 2;
    }
} else {
    echo 3;
}
