<?php

use Admin\Models\SuscripcionesModel;
use Dompdf\Dompdf;
use Dompdf\Options;

// Limpiar cualquier output previo
if (ob_get_length()) ob_end_clean();

$ids = $this->ids ?? null;

// Obtener suscripciones
$objSuscripciones = new SuscripcionesModel();

// Si hay IDs específicos, filtrar por ellos; si no, obtener todos
if ($ids && !empty($ids)) {
    $idsArray = explode(',', $ids);
    $suscripciones = $objSuscripciones->listarSuscripcionesPorIds($idsArray);
} else {
    $suscripciones = $objSuscripciones->listarSuscripciones();
}


$activos = count(array_filter($suscripciones, fn($s) => ($s['estado'] ?? 'activo') == 'activo'));
$inactivos = count(array_filter($suscripciones, fn($s) => ($s['estado'] ?? 'activo') == 'inactivo'));

$html = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 20mm;
            margin-bottom: 15mm;
        }
        
        body {
            font-family: "Helvetica", "Arial", sans-serif;
            font-size: 10pt;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #4472C4;
            padding-bottom: 15px;
        }
        
        .header h1 {
            color: #4472C4;
            font-size: 24pt;
            margin: 0 0 10px 0;
            font-weight: bold;
        }
        
        .header .empresa {
            font-size: 14pt;
            color: #666;
            margin-bottom: 5px;
        }
        
        .info-box {
            background-color: #f5f5f5;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            border-left: 4px solid #4472C4;
        }
        
        .info-box p {
            margin: 5px 0;
            font-size: 9pt;
        }
        
        .stats {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .stat-box {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 8px;
            margin-right: 10px;
        }
        
        .stat-box:last-child {
            margin-right: 0;
        }
        
        .stat-box.green {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }
        
        .stat-box.red {
            background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
        }
        
        .stat-number {
            font-size: 28pt;
            font-weight: bold;
            margin: 0;
        }
        
        .stat-label {
            font-size: 10pt;
            margin: 5px 0 0 0;
            opacity: 0.9;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        thead {
            background: #4472C4;
            color: white;
        }
        
        thead th {
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 10pt;
            border: 1px solid #2952a3;
        }
        
        tbody tr {
            border-bottom: 1px solid #ddd;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        tbody tr:hover {
            background-color: #f0f5ff;
        }
        
        tbody td {
            padding: 10px 8px;
            font-size: 9pt;
            border: 1px solid #e0e0e0;
        }
        
        .text-center {
            text-align: center;
        }
        
        .estado {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 8pt;
            font-weight: bold;
            display: inline-block;
        }
        
        .estado.activo {
            background-color: #d4edda;
            color: #155724;
        }
        
        .estado.inactivo {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 40px;
            text-align: center;
            font-size: 8pt;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .page-number:after {
            content: counter(page);
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="empresa">' . strtoupper(EMPRESA) . '</div>
        <h1>Reporte de Suscripciones</h1>
    </div>
    
    <div class="info-box">
        <p><strong>Fecha de generación:</strong> ' . date('d/m/Y H:i:s') . '</p>';
        
if ($fechaDesde && $fechaHasta) {
    $html .= '<p><strong>Período:</strong> ' . date('d/m/Y', strtotime($fechaDesde)) . ' al ' . date('d/m/Y', strtotime($fechaHasta)) . '</p>';
} else {
    $html .= '<p><strong>Período:</strong> Todos los registros</p>';
}

$html .= '
    </div>
    
    <div class="stats">
        <div class="stat-box">
            <p class="stat-number">' . count($suscripciones) . '</p>
            <p class="stat-label">Total Suscripciones</p>
        </div>
        <div class="stat-box green">
            <p class="stat-number">' . $activos . '</p>
            <p class="stat-label">Activos</p>
        </div>
        <div class="stat-box red">
            <p class="stat-number">' . $inactivos . '</p>
            <p class="stat-label">Inactivos</p>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">#</th>
                <th width="30%">Nombre Completo</th>
                <th width="30%">Correo Electrónico</th>
                <th width="18%" class="text-center">Fecha</th>
                <th width="12%" class="text-center">Estado</th>
                <th width="15%" class="text-center">IP</th>
            </tr>
        </thead>
        <tbody>';

$contador = 1;
foreach ($suscripciones as $suscripcion) {
    $html .= '
            <tr>
                <td class="text-center">' . $contador . '</td>
                <td>' . htmlspecialchars($suscripcion['nombre_completo']) . '</td>
                <td>' . htmlspecialchars($suscripcion['email']) . '</td>
                <td class="text-center">' . date('d/m/Y H:i', strtotime($suscripcion['fecha_suscripcion'])) . '</td>
                <td class="text-center">
                    <span class="estado ' . $suscripcion['estado'] . '">' . ucfirst($suscripcion['estado']) . '</span>
                </td>
                <td class="text-center">' . ($suscripcion['ip_registro'] ?? 'N/A') . '</td>
            </tr>';
    $contador++;
}

$html .= '
        </tbody>
    </table>
    
    <div class="footer">
        Página <span class="page-number"></span> | ' . EMPRESA . ' - Reporte generado automáticamente
    </div>
</body>
</html>';

// Configurar Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'Helvetica');
$options->set('dpi', 96);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

// Generar nombre del archivo
$filename = 'suscripciones_' . date('Y-m-d_His') . '.pdf';

// Limpiar output buffer antes de enviar el PDF
while (ob_get_level()) {
    ob_end_clean();
}

// Enviar el PDF al navegador para visualización (Attachment => false para ver en navegador)
$dompdf->stream($filename, ['Attachment' => false]);
exit;
