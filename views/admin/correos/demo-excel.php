<?php
/* Esto es un archivo para demostrar que funciona la libreria PHPExcel */
require_once './PHPExcel-1.8/Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();


$objPHPExcel->
getProperties()
->setCreator("TEDnologia.com")
->setLastModifiedBy("TEDnologia.com")
->setTitle("Exportar Excel con PHP")
->setSubject("Documento de prueba")
->setDescription("Documento generado con PHPExcel")
->setKeywords("usuarios phpexcel")
->setCategory("reportes");

/* Escribiendo Data */

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'Nombre')
->setCellValue('B1', 'E-mail')
->setCellValue('C1', 'Twitter')
->setCellValue('A2', 'David')
->setCellValue('B2', 'dvd@gmail.com')
->setCellValue('C2', '@davidvd');

/* Dar nombre a la hoja */
$objPHPExcel->getActiveSheet()->setTitle('Usuarios');
$objPHPExcel->setActiveSheetIndex(0);

/* Descargar el archivo */

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="01simple.xls"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;
