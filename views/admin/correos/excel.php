<?php

require_once('./suscripcion/conbd.php');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Recibir las fechas desde el formulario
$startDate = isset($_POST['fechaDesde']) ? $_POST['fechaDesde'] : '';
$endDate = isset($_POST['fechaHasta']) ? $_POST['fechaHasta'] : '';

// Crear hoja de cálculo
$objPHPExcel = new Spreadsheet();

// Propiedades del archivo
$objPHPExcel->getProperties()
    ->setCreator("AxelDev")
    ->setLastModifiedBy("AxelDev")
    ->setTitle("Reporte")
    ->setSubject("Reporte")
    ->setDescription("Reporte de clientes")
    ->setKeywords("usuarios phpexcel")
    ->setCategory("reportes");

// Consulta SQL filtrando por rango de fechas si están disponibles
if ($startDate && $endDate) {
    $query = mysqli_query($conex, "SELECT nombres, correos, DATE_FORMAT(fecha_registro, '%Y-%m-%d') as fecha_registro FROM correos WHERE fecha_registro BETWEEN '$startDate' AND '$endDate' ORDER BY idcorreo DESC");
} else {
    // Si no se proporcionan las fechas, mostrar todos los registros
    $query = mysqli_query($conex, "SELECT nombres, correos, DATE_FORMAT(fecha_registro, '%Y-%m-%d') as fecha_registro FROM correos ORDER BY idcorreo DESC");
}

// Escribir encabezados
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Nombre')
    ->setCellValue('B1', 'E-mail')
    ->setCellValue('C1', 'Fecha de suscripción');

// Empezamos en la fila 2, ya que la fila 1 tiene los encabezados
$fila = 2;

// Iteramos sobre los resultados de la base de datos
while ($row = mysqli_fetch_array($query)) {
    // Rellenamos las celdas con los datos de la base de datos
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . $fila, $row['nombres'])
        ->setCellValue('B' . $fila, $row['correos'])
        ->setCellValue('C' . $fila, $row['fecha_registro']);
    
    // Avanzamos a la siguiente fila
    $fila++;
}

// Dar nombre a la hoja
$objPHPExcel->getActiveSheet()->setTitle('Registros');
$objPHPExcel->setActiveSheetIndex(0);

// Crear el escritor de XLSX
$writer = new Xlsx($objPHPExcel);

// Encabezados para la descarga
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="reporte_clientes.xlsx"'); // Nombre del archivo
header('Cache-Control: max-age=0');

// Generar y enviar el archivo al navegador
$writer->save('php://output');
exit;

?>
