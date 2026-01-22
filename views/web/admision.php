<?php

use Admin\Models;
use Admin\Core\Controller;

$objEmpresa = new Models\EmpresaModel;
$dataEmpresa = $objEmpresa->listEmpresa()[1];

$objPortada = new Models\PortadasModel;
$dataPortada = $objPortada->obtenerPortada('admision');

// Verificar si es vista previa
if (isset($_POST['preview']) && $_POST['preview'] == '1') {
    $dataAdmision = [
        'titulo' => $_POST['titulo_preview'] ?? '',
        'cuerpo' => $_POST['cuerpo_preview'] ?? ''
    ];
} else {
    $objAdmision = new Models\AdmisionModel;
    $dataAdmision = $objAdmision->obtenerAdmision();
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Proceso de Admisión - <?= $dataEmpresa['nombre'] ?>">
    <title>Admisión - <?= mb_strtoupper($dataEmpresa['nombre'], 'UTF-8') ?></title>
    <link rel="shortcut icon" href="<?= PATH_PUBLIC ?>/img/icons/escudo.png" type="image/png">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link rel="stylesheet" href="<?= PATH_PUBLIC ?>/css/animate.min.css">
    <link rel="stylesheet" href="<?= PATH_PUBLIC ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= PATH_PUBLIC ?>/css/web.css">
</head>

<body>

    <script src="<?= PATH_PUBLIC ?>/js/bootstrap.min.js"></script>

    <?php include_once PATH_ROOT . '/views/web/partials/header.php'; ?>

    <style>
        /* Portada */
        .portada-admision {
            position: relative;
            width: 100%;
            height: 400px;
            background-image: url('<?= !empty($dataPortada['imagen']) ? $dataPortada['imagen'] : 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1200' ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .portada-admision::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.4));
        }

        .portada-admision .content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
        }

        .portada-admision h1 {
            font-size: 3.5rem;
            font-weight: bold;
            letter-spacing: 0.08em;
            margin-bottom: 15px;
        }

        /* Introducción */
        .intro-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        .intro-section h2 {
            color: var(--color3);
            font-weight: bold;
            margin-bottom: 25px;
        }

        .intro-section p {
            font-size: 16px;
            line-height: 1.8;
            color: #555;
        }

        /* Estilos para contenido HTML del editor */
        .content-html {
            font-size: 15.5px;
            line-height: 1.8;
            color: #555;
            text-align: justify;
        }

        .content-html table {
            margin: 20px 0;
            border-collapse: collapse;
        }

        .content-html table.table {
            width: 100%;
        }

        .content-html table.table-bordered {
            border: 1px solid #dee2e6;
        }

        .content-html table.table-bordered th,
        .content-html table.table-bordered td {
            border: 1px solid #dee2e6;
            padding: 8px;
        }

        .content-html table.table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .content-html img {
            max-width: 100%;
            height: auto;
            margin: 15px 0;
            border-radius: 8px;
        }

        .content-html ul,
        .content-html ol {
            margin: 15px 0;
            padding-left: 30px;
        }

        .content-html li {
            margin-bottom: 8px;
        }

        .content-html strong {
            font-weight: bold;
            color: var(--color3);
        }

        /* Pasos del proceso */
        .proceso-section {
            padding: 80px 0;
        }

        .proceso-section h2 {
            color: var(--color3);
            font-weight: bold;
            margin-bottom: 50px;
            text-align: center;
        }

        .step-card {
            text-align: center;
            padding: 30px;
            border-radius: 10px;
            background: white;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            height: 100%;
        }

        .step-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .step-card .icon-box {
            width: 80px;
            height: 80px;
            background: var(--color2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .step-card .icon-box i {
            font-size: 35px;
            color: white;
        }

        .step-card h4 {
            color: var(--color3);
            font-weight: bold;
            margin-bottom: 15px;
        }

        .step-card p {
            color: #666;
            font-size: 14.5px;
            line-height: 1.6;
        }

        .step-card .content-html {
            color: #666;
            font-size: 14.5px;
            line-height: 1.6;
            text-align: center;
        }

        /* Requisitos */
        .requisitos-section {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .requisitos-section h2 {
            color: var(--color3);
            font-weight: bold;
            margin-bottom: 30px;
        }

        .requisitos-section p {
            font-size: 15.5px;
            line-height: 1.8;
            color: #555;
        }

        /* CTA */
        .cta-section {
            padding: 100px 0;
            background: linear-gradient(135deg, var(--color3) 0%, var(--color2) 100%);
            color: white;
            text-align: center;
        }

        .cta-section h2 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .cta-section p {
            font-size: 18px;
            margin-bottom: 30px;
            opacity: 0.95;
        }

        .cta-section .btn-cta {
            background: white;
            color: var(--color3);
            padding: 15px 40px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .cta-section .btn-cta:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 768px) {
            .portada-admision h1 {
                font-size: 2.5rem;
            }
        }
        iframe {
            width: 70%;
        }
    </style>

    <!-- PORTADA -->
    <?php if (!empty($dataPortada)) { ?>
        <div class="portada-admision">
            <div class="content">
                <div class="container animate__animated animate__fadeInDown">
                    <ol class="breadcrumb pb-0 mb-3">
                        <li class="breadcrumb-item"><a href="/" style="color: white;">Inicio</a></li>
                        <li class="breadcrumb-item active" style="color: rgba(255,255,255,0.8);">Admisión</li>
                    </ol>
                    <h1><?= !empty($dataPortada['titulo']) ? $dataPortada['titulo'] : 'Admisión' ?></h1>
                    <p class="lead"><?= !empty($dataPortada['subtitulo']) ? $dataPortada['subtitulo'] : 'Inicia tu proceso de admisión' ?></p>
                </div>
            </div>
        </div>
    <?php } ?>

    <!-- CONTENIDO DE ADMISIÓN -->
    <?php if (!empty($dataAdmision['cuerpo'])) : ?>
        <section class="intro-section">
            <div class="container animate__animated animate__fadeInUp">
                <div class="row">
                    <div class="col-lg-12">
                        <?php if (!empty($dataAdmision['titulo'])) : ?>
                            <h2 class="text-center mb-4"><?= $dataAdmision['titulo'] ?></h2>
                        <?php endif; ?>
                        <div class="content-html"><?= $dataAdmision['cuerpo'] ?></div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php include_once PATH_ROOT . '/views/web/partials/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const contentHtml = document.querySelector('.content-html');

            if (contentHtml) {
                const iframes = contentHtml.querySelectorAll('iframe');
                let pdfCounter = 0;

                iframes.forEach(iframe => {
                    const initialSrc = iframe.src;

                    if (initialSrc && initialSrc.toLowerCase().includes('.pdf')) {
                        pdfCounter++;
                        const pdfJsViewerUrl = "/lib/pdfjs/web/viewer.html?file=";
                        const newSrc = pdfJsViewerUrl + encodeURIComponent(initialSrc);

                        iframe.id = 'pdfViewer' + pdfCounter;
                        iframe.src = newSrc;
                        iframe.frameBorder = "0";

                        let width = iframe.style.width || iframe.getAttribute('width');
                        
                        if (width) {
                           
                            const widthInPixels = parseInt(width);
                            if (!isNaN(widthInPixels)) {
                                const containerWidth = contentHtml.offsetWidth;
                                const percentage = (widthInPixels / containerWidth) * 100;
                              
                                if (percentage >= 90) {
                                    iframe.style.width = "100%";
                                } else if (percentage >= 70) {
                                    iframe.style.width = "80%";
                                } else if (percentage >= 40) {
                                    iframe.style.width = "50%";
                                }
                               
                            }
                        } else {
                           
                            iframe.style.width = "100%";
                        }

                        if (!iframe.style.height && !iframe.getAttribute('height')) {
                            iframe.style.height = "600px";
                        }

                        const parent = iframe.parentElement;
                        if (parent) {
                            const parentAlign = window.getComputedStyle(parent).textAlign;

                            if (parentAlign === 'center' || iframe.getAttribute('align') === 'center') {
                               
                                iframe.style.display = 'block';
                                iframe.style.margin = '0 auto';
                            }
                        }
                    }
                });
            }
        });
    </script>
</body>


</html>