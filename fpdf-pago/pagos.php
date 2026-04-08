<?php
require_once '../modelo/val-admin.php';
require_once '../modelo/datos-cota_dia.php';
require_once '../modelo/datos-planiya.php';

include_once '../fpdf/fpdf.php';
include 'exfpdf.php';
include 'easyTable.php';

// 1. CAPTURAR DATOS POR GET
$id_cota = $_GET['id_cota'] ?? null;
$cedula  = $_GET['cedula'] ?? null;

if (!$id_cota) {
    die("Error: No se recibió el ID de la cota.");
}

$mis_cota_dia = new misCotaDia();
$mis_planiyas = new misPlaniyas();

// 2. OBTENER EL REGISTRO ESPECÍFICO
$res_completo = $mis_cota_dia->viewCotaDia($cedula);
$data_especifica = null;

if ($res_completo) {
    foreach ($res_completo as $r) {
        if ($r['id_cota'] == $id_cota) {
            $data_especifica = $r;
            break;
        }
    }
}

// 3. OBTENER DATOS DEL CLIENTE
$datos_cliente = $mis_planiyas->viewPlaniyasMas($cedula, $rol_user);
$cliente = $datos_cliente[0] ?? null;

// 4. LÓGICA DE CÁLCULO AJUSTADA
$valor_cuota_num = (isset($data_especifica['couta']) && is_numeric($data_especifica['couta'])) ? $data_especifica['couta'] : 0;
$prestado = $data_especifica['cantidad_saldo'] ?? 0;
$seguro = $data_especifica['mora_cota'] ?? 0;

$total_recaudado = 0;
$total_no_recaudado = 0;
$dias_pagados = 0;
$dias_no_pagados = 0;

if ($data_especifica) {
    for ($i = 1; $i <= 31; $i++) {
        $si = $data_especifica["dia" . $i . "_si"] ?? 0;
        $no = $data_especifica["dia" . $i . "_no"] ?? 0;

        if ($si == 1) {
            $total_recaudado += $valor_cuota_num;
            $dias_pagados++;
        } elseif ($no == 2) {
            $total_no_recaudado += $valor_cuota_num;
            $dias_no_pagados++;
        }
    }
}

// NUEVO: Cálculo del saldo restante real
$total_restante = ($prestado) - $total_recaudado;
if ($total_restante < 0) $total_restante = 0;

// 5. CLASE PDF
class PDF_HF extends exFPDF
{
    function Header()
    {
        $this->SetFillColor(23, 32, 42);
        $this->Rect(0, 0, 216, 45, 'F');

        if (file_exists('../imagenes/dolar2.jpg')) {
            $this->Image('../imagenes/dolar2.jpg', 12, 10, 25);
        }

        $this->SetY(12);
        $this->SetFont('helvetica', 'B', 22);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 12, utf8_decode('ESTADO DE CUENTA'), 0, 1, 'C');

        $this->SetFont('helvetica', 'B', 9);
        $this->SetTextColor(46, 204, 113);
        $this->Cell(0, 5, utf8_decode('SISTEMA DE GESTIÓN DE CARTERA PROFESIONAL'), 0, 1, 'C');

        $this->SetFillColor(46, 204, 113);
        $this->Rect(0, 43, 216, 2, 'F');
        $this->Ln(20);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->SetTextColor(120);
        $this->Cell(0, 10, utf8_decode('Reporte de control interno - Generado el: ') . date('d/m/Y H:i'), 0, 0, 'L');
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'R');
    }
}

$pdf = new PDF_HF('P', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->AddPage();

// --- TABLA DE DATOS DEL CLIENTE ---
$tableCli = new easyTable($pdf, '{100, 100}', 'width:100%; border:0; font-family:helvetica; font-size:10; padding:4;');
$tableCli->rowStyle('fillcolor:242, 244, 244; font-style:B; text-color:23, 32, 42;');
$tableCli->easyCell(utf8_decode("  DATOS DEL CLIENTE"), 'border:L,3,46, 204, 113;');
$tableCli->easyCell(utf8_decode("  RESUMEN DEL CRÉDITO"), 'border:L,3,52, 152, 219;');
$tableCli->printRow();

$tableCli->rowStyle('border:B; border-color:235, 235, 235;');
$tableCli->easyCell(utf8_decode("Nombre: ") . mb_strtoupper(($cliente['nombre'] ?? '') . ' ' . ($cliente['apellido'] ?? 'N/A')));
$tableCli->easyCell(utf8_decode("Capital Prestado: $") . number_format($prestado, 0, ',', '.'), 'font-style:B; text-color:39, 174, 96;');
$tableCli->printRow();

$tableCli->rowStyle('border:B; border-color:235, 235, 235;');
$tableCli->easyCell(utf8_decode("Cédula: ") . ($cliente['cedula'] ?? 'N/A'));
$tableCli->easyCell(utf8_decode("Valor Cuota: $") . number_format($valor_cuota_num, 0, ',', '.'), 'font-style:B;');
$tableCli->printRow();

$tableCli->rowStyle('border:B; border-color:235, 235, 235;');
$tableCli->easyCell(utf8_decode("Barrio: ") . ($cliente['barrio'] ?? 'No registrada'));
$tableCli->easyCell(utf8_decode("Mora Actual (X): $") . number_format($total_no_recaudado, 0, ',', '.'), 'text-color:192, 57, 43; font-style:B; background:254, 240, 240;');
$tableCli->printRow();

$tableCli->rowStyle('border:B; border-color:235, 235, 235;');
$tableCli->easyCell(utf8_decode("Dirección: ") . ($cliente['direccion'] ?? 'No registrada'));
$tableCli->easyCell(utf8_decode("Seguro: $") . number_format($seguro, 0, ',', '.'), 'text-color:192, 57, 43; font-style:B; background:254, 240, 240;');
$tableCli->printRow();
$tableCli->endTable(10);

// --- CALENDARIO DE PAGOS ---
if ($data_especifica) {
    $pdf->SetFont('helvetica', 'B', 11);
    $pdf->SetTextColor(44, 62, 80);
    $pdf->Cell(0, 10, utf8_decode("CALENDARIO DE PAGOS: " . $data_especifica['fecha_cota_dia'] . " AL " . $data_especifica['fecha_cota_dia_fin']), 0, 1, 'L');

    $tablePagos = new easyTable($pdf, 15, 'width:100%; border:1; border-color:220,220,220; font-family:helvetica; font-size:8; padding:2.5;');

    for ($bloque = 0; $bloque < 3; $bloque++) {
        $tablePagos->rowStyle('fillcolor:52, 73, 94; text-color:255; font-style:B;');
        $inicio = ($bloque * 15) + 1;
        $fin = $inicio + 14;

        for ($i = $inicio; $i <= $fin; $i++) {
            if ($i <= 31) {
                $tablePagos->easyCell("D$i", 'align:C;');
            } else {
                $tablePagos->easyCell('', 'align:C;');
            }
        }
        $tablePagos->printRow();

        for ($i = $inicio; $i <= $fin; $i++) {
            $si = $data_especifica["dia" . $i . "_si"] ?? 0;
            $no = $data_especifica["dia" . $i . "_no"] ?? 0;

            if ($si == 1) {
                $tablePagos->easyCell('OK', 'align:C; background:234, 250, 241; text-color:25, 111, 61; font-style:B;');
            } elseif ($no == 2) {
                $tablePagos->easyCell('X', 'align:C; background:253, 237, 236; text-color:176, 58, 46; font-style:B;');
            } else {
                $tablePagos->easyCell('-', 'align:C; text-color:160, 160, 160;');
            }
        }
        $tablePagos->printRow();
    }
    $tablePagos->endTable(10);

    // --- RESUMEN FINAL ---
    $tableTot = new easyTable($pdf, '{130, 70}', 'width:100%; border:1; border-color:210,210,210; font-family:helvetica; font-size:11; padding:5;');
    $tableTot->rowStyle('fillcolor:44, 62, 80; text-color:255; font-style:B;');
    $tableTot->easyCell(utf8_decode("INDICADORES DE COBRO"), 'align:R;');
    $tableTot->easyCell("VALORES", 'align:C;');
    $tableTot->printRow();

    $tableTot->easyCell(utf8_decode("SEGURO:"), 'align:R;');
    $tableTot->easyCell("$" . number_format($seguro, 0, ',', '.'),  'align:C; font-style:B; text-color:39, 174, 96;');
    $tableTot->printRow();

    $tableTot->easyCell(utf8_decode("Total Días Pagados (OK):"), 'align:R;');
    $tableTot->easyCell($dias_pagados . " dias", 'align:C; font-style:B; text-color:39, 174, 96;');
    $tableTot->printRow();

    $tableTot->easyCell(utf8_decode("Total Días No Pagados (X):"), 'align:R;');
    $tableTot->easyCell($dias_no_pagados . " dias", 'align:C; font-style:B; text-color:192, 57, 43;');
    $tableTot->printRow();

    $tableTot->easyCell(utf8_decode("CARTERA PENDIENTE (MORA):"), 'align:R;');
    $tableTot->easyCell("$" . number_format($total_no_recaudado, 0, ',', '.'), 'align:C; font-style:B; text-color:192, 57, 43; background:254, 240, 240;');
    $tableTot->printRow();

    $tableTot->rowStyle('fillcolor:244, 246, 247; font-style:B;');
    $tableTot->easyCell("SALDO RESTANTE TOTAL:", 'align:R;');
    $tableTot->easyCell("$" . number_format($total_restante, 0, ',', '.'), 'align:C; text-color:192, 57, 43; font-size:13;');
    $tableTot->printRow();

    $tableTot->rowStyle('fillcolor:244, 246, 247; font-style:B;');
    $tableTot->easyCell("TOTAL RECAUDADO EN EL MES:", 'align:R;');
    $tableTot->easyCell("$" . number_format($total_recaudado, 0, ',', '.'), 'align:C; text-color:39, 174, 96; font-size:13;');
    $tableTot->printRow();
    $tableTot->endTable();
}

$pdf->Output('I', 'Reporte_Pagos_' . $cedula . '.pdf');
