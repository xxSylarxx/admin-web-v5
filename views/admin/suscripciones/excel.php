<?php

use Admin\Models\SuscripcionesModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


$ids = $this->ids ?? null;
$formato = $this->formato ?? 'xlsx';

// Obtener suscripciones
$objSuscripciones = new SuscripcionesModel();

// Si hay IDs específicos, filtrar por ellos; si no, obtener todos
if ($ids && !empty($ids)) {
    $idsArray = explode(',', $ids);
    $suscripciones = $objSuscripciones->listarSuscripcionesPorIds($idsArray);
} else {
    $suscripciones = $objSuscripciones->listarSuscripciones();
}


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();


$spreadsheet->getProperties()
    ->setCreator(EMPRESA)
    ->setLastModifiedBy(EMPRESA)
    ->setTitle("Reporte de Suscripciones")
    ->setSubject("Suscripciones")
    ->setDescription("Reporte de suscripciones al boletín")
    ->setKeywords("suscripciones reporte excel")
    ->setCategory("Reportes");


$sheet->setCellValue('A1', 'REPORTE DE SUSCRIPCIONES');
$sheet->mergeCells('A1:J1');
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


$sheet->setCellValue('A2', 'Generado: ' . date('d/m/Y H:i:s'));
$totalRegistros = count($suscripciones);
$sheet->setCellValue('A3', "Total de registros: {$totalRegistros}");
$sheet->mergeCells('A2:J2');
$sheet->mergeCells('A3:J3');
$sheet->getStyle('A2:A3')->getFont()->setItalic(true)->setSize(10);

// Encabezados de columnas (fila 5)
$headers = ['#', 'Nombres', 'Apellidos', 'Correo', 'Nivel', 'Grado', 'Asunto', 'Consulta', 'Fecha', 'Estado'];
$column = 'A';
foreach ($headers as $header) {
    $sheet->setCellValue($column . '5', $header);
    $column++;
}

// Estilos de encabezado
$sheet->getStyle('A5:J5')->applyFromArray([
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF'],
        'size' => 11
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '4472C4']
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => '000000']
        ]
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER
    ]
]);

$row = 6;
$contador = 1;
foreach ($suscripciones as $suscripcion) {
    $sheet->setCellValue('A' . $row, $contador);
    $sheet->setCellValue('B' . $row, $suscripcion['nombres'] ?? $suscripcion['nombre_completo'] ?? '-');
    $sheet->setCellValue('C' . $row, $suscripcion['apellidos'] ?? '-');
    $sheet->setCellValue('D' . $row, $suscripcion['correo'] ?? $suscripcion['email'] ?? '-');
    $sheet->setCellValue('E' . $row, $suscripcion['nivel'] ?? '-');
    $sheet->setCellValue('F' . $row, $suscripcion['grado'] ?? '-');
    $sheet->setCellValue('G' . $row, $suscripcion['asunto'] ?? '-');
    $sheet->setCellValue('H' . $row, $suscripcion['consulta'] ?? '-');
    $sheet->setCellValue('I' . $row, date('d/m/Y H:i', strtotime($suscripcion['fecha_suscripcion'])));
    $sheet->setCellValue('J' . $row, ucfirst($suscripcion['estado'] ?? 'activo'));
    
    // Estilo alternado
    if ($contador % 2 == 0) {
        $sheet->getStyle('A' . $row . ':J' . $row)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('F2F2F2');
    }
    
    // Color del estado
    $estado = $suscripcion['estado'] ?? 'activo';
    if ($estado == 'inactivo') {
        $sheet->getStyle('J' . $row)->getFont()->getColor()->setRGB('FF0000');
    } else {
        $sheet->getStyle('J' . $row)->getFont()->getColor()->setRGB('008000');
    }
    
    $row++;
    $contador++;
}

// Bordes finales
if ($row > 6) {
    $sheet->getStyle('A5:J' . ($row - 1))->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['rgb' => '000000']
            ]
        ]
    ]);
}

// Fila de totales
$sheet->setCellValue('A' . $row, 'TOTAL REGISTROS:');
$sheet->setCellValue('B' . $row, count($suscripciones));
$sheet->mergeCells('A' . $row . ':A' . $row);
$sheet->getStyle('A' . $row . ':B' . $row)->getFont()->setBold(true);
$sheet->getStyle('A' . $row . ':B' . $row)->getFill()
    ->setFillType(Fill::FILL_SOLID)
    ->getStartColor()->setRGB('D9E1F2');

// Ajustar ancho de columnas
$sheet->getColumnDimension('A')->setWidth(8);
$sheet->getColumnDimension('B')->setWidth(20);  // Nombres
$sheet->getColumnDimension('C')->setWidth(20);  // Apellidos
$sheet->getColumnDimension('D')->setWidth(35);  // Correo
$sheet->getColumnDimension('E')->setWidth(15);  // Nivel
$sheet->getColumnDimension('F')->setWidth(10);  // Grado
$sheet->getColumnDimension('G')->setWidth(15);  // Asunto
$sheet->getColumnDimension('H')->setWidth(50);  // Consulta
$sheet->getColumnDimension('I')->setWidth(18);  // Fecha
$sheet->getColumnDimension('J')->setWidth(12);  // Estado

// Centrar columnas específicas
$sheet->getStyle('A6:A' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('E6:G' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('I6:J' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Ajustar texto en consulta
$sheet->getStyle('H6:H' . ($row - 1))->getAlignment()->setWrapText(true);

// Dar nombre a la hoja
$sheet->setTitle('Suscripciones');

// Generar archivo según formato
$filename = 'suscripciones_' . date('Y-m-d_His');

if ($formato === 'csv') {
    $writer = new Csv($spreadsheet);
    $writer->setDelimiter(';');
    $writer->setEnclosure('"');
    $writer->setLineEnding("\r\n");
    $writer->setSheetIndex(0);
    
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
} else {
    $writer = new Xlsx($spreadsheet);
    
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '.xlsx"');
}

header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: cache, must-revalidate');
header('Pragma: public');

$writer->save('php://output');
exit;
