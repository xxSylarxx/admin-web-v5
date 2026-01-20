<?php

use Admin\Models\SuscripcionesModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


$fechaDesde = $this->fechaDesde ?? null;
$fechaHasta = $this->fechaHasta ?? null;
$formato = $this->formato ?? 'xlsx';


$objSuscripciones = new SuscripcionesModel();
$suscripciones = $objSuscripciones->listarSuscripciones();


if ($fechaDesde && $fechaHasta) {
    $suscripciones = array_filter($suscripciones, function($suscripcion) use ($fechaDesde, $fechaHasta) {
        $fecha = date('Y-m-d', strtotime($suscripcion['fecha_suscripcion']));
        return $fecha >= $fechaDesde && $fecha <= $fechaHasta;
    });
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
$sheet->mergeCells('A1:F1');
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


$sheet->setCellValue('A2', 'Generado: ' . date('d/m/Y H:i:s'));
if ($fechaDesde && $fechaHasta) {
    $sheet->setCellValue('A3', 'Período: ' . date('d/m/Y', strtotime($fechaDesde)) . ' - ' . date('d/m/Y', strtotime($fechaHasta)));
} else {
    $sheet->setCellValue('A3', 'Período: Todos los registros');
}
$sheet->mergeCells('A2:F2');
$sheet->mergeCells('A3:F3');
$sheet->getStyle('A2:A3')->getFont()->setItalic(true)->setSize(10);

// Encabezados de columnas (fila 5)
$headers = ['#', 'Nombre Completo', 'Correo Electrónico', 'Fecha Suscripción', 'Estado', 'IP Registro'];
$column = 'A';
foreach ($headers as $header) {
    $sheet->setCellValue($column . '5', $header);
    $column++;
}


$sheet->getStyle('A5:F5')->applyFromArray([
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
    $sheet->setCellValue('B' . $row, $suscripcion['nombre_completo']);
    $sheet->setCellValue('C' . $row, $suscripcion['email']);
    $sheet->setCellValue('D' . $row, date('d/m/Y H:i', strtotime($suscripcion['fecha_suscripcion'])));
    $sheet->setCellValue('E' . $row, ucfirst($suscripcion['estado']));
    $sheet->setCellValue('F' . $row, $suscripcion['ip_registro'] ?? 'N/A');
    

    if ($contador % 2 == 0) {
        $sheet->getStyle('A' . $row . ':F' . $row)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('F2F2F2');
    }
    

    if ($suscripcion['estado'] == 'inactivo') {
        $sheet->getStyle('E' . $row)->getFont()->getColor()->setRGB('FF0000');
    } else {
        $sheet->getStyle('E' . $row)->getFont()->getColor()->setRGB('008000');
    }
    
    $row++;
    $contador++;
}


if ($row > 6) {
    $sheet->getStyle('A5:F' . ($row - 1))->applyFromArray([
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
$sheet->getColumnDimension('B')->setWidth(30);
$sheet->getColumnDimension('C')->setWidth(35);
$sheet->getColumnDimension('D')->setWidth(20);
$sheet->getColumnDimension('E')->setWidth(12);
$sheet->getColumnDimension('F')->setWidth(18);

// Centrar columnas específicas
$sheet->getStyle('A6:A' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('D6:D' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('E6:E' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('F6:F' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

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
