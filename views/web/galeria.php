<?php

use Admin\Models;

$objEmpresa = new Models\EmpresaModel();
$objGalerias = new Models\GaleriasModel();
$objCategorias = new Models\CategoriasGaleriasModel();
$dataEmpresa = $objEmpresa->listEmpresa()[1];

if (isset($URI[1]) && is_numeric($URI[1])) {
    $idGaleria = $URI[1];
    $dataGaleria = $objGalerias->buscarGaleria($idGaleria);
    
    if ($dataGaleria) {
        $dataGaleria['cuerpo'] = json_decode($dataGaleria['cuerpo'], true);
        
        // Obtener nombre de categoría si existe
        if (!empty($dataGaleria['idcatg'])) {
            $categoria = $objCategorias->buscarCategoria($dataGaleria['idcatg']);
            $dataGaleria['categoria'] = $categoria['nombre'] ?? '';
        } else {
            $dataGaleria['categoria'] = '';
        }
    } else {
        header('Location: /galeria-lista');
        exit;
    }
} else {
    header('Location: /galeria-lista');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= !empty($dataGaleria['detalle']) ? $dataGaleria['detalle'] : $dataGaleria['titulo'] ?> - <?= $dataEmpresa['nombre'] ?>">
    <title><?= $dataGaleria['titulo'] ?> - <?= mb_strtoupper($dataEmpresa['nombre'], 'UTF-8') ?></title>
    <link rel="shortcut icon" href="<?= PATH_PUBLIC ?>/img/icons/escudo.png" type="image/png">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link rel="stylesheet" href="<?= PATH_PUBLIC ?>/css/animate.min.css">
    <link rel="stylesheet" href="<?= PATH_PUBLIC ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= PATH_PUBLIC ?>/css/venobox.css">
    <link rel="stylesheet" href="<?= PATH_PUBLIC ?>/css/web.css">
</head>

<body>

    <!-- archivos JS or CDN -->
    <script src="<?= PATH_PUBLIC ?>/js/bootstrap.min.js"></script>
    <script src="<?= PATH_PUBLIC ?>/js/venobox.js"></script>

    <!-- partial header  -->
    <?php include_once PATH_ROOT . '/views/web/partials/header.php'; ?>

    <style>
        .portada-galeria {
            position: relative;
            width: 100%;
            height: 350px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-image: url('<?= !empty($dataGaleria['portada']) ? $dataGaleria['portada'] : PATH_PUBLIC . '/img/icons/portada_galeria.jpg' ?>');
        }

        .portada-galeria::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.5));
        }

        .portada-galeria .content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
        }

        .portada-galeria h1 {
            font-size: 2.8rem;
            font-weight: bold;
            letter-spacing: 0.05em;
            margin-bottom: 10px;
        }

        .portada-galeria .detalle {
            font-size: 1.1rem;
            opacity: 0.95;
            margin-top: 10px;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            color: white;
        }

        .breadcrumb-item>a {
            color: white;
            font-size: 14.5px;
        }

        .breadcrumb-item.active {
            color: rgba(255, 255, 255, 0.8);
        }

        .galeria-info {
            background: #f8f9fa;
            padding: 30px 0;
            margin-bottom: 50px;
        }

        .galeria-info .categoria-badge {
            display: inline-block;
            background: var(--color3);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .galeria-info .fecha {
            color: #666;
            font-size: 15px;
        }

        #content-grid {
            columns: <?= $dataGaleria['ncolum'] ?>;
            column-gap: 6px;
        }

        #content-grid>a.img-links {
            -webkit-column-break-inside: avoid;
            page-break-inside: avoid;
            break-inside: avoid;
            margin-bottom: 6px;
            overflow: hidden;
            display: block;
            position: relative;
            border-radius: 8px;
        }

        #content-grid>a.img-links::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        #content-grid>a.img-links:hover::after {
            opacity: 1;
        }

        #content-grid img {
            height: <?= $dataGaleria['modo'] == 'A' ? 'auto' : '240px' ?>;
            object-fit: cover;
            width: 100%;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        #content-grid>a.img-links:hover img {
            transform: scale(1.05);
        }

        .btn-volver {
            background: var(--color3);
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-volver:hover {
            background: var(--color2);
            color: white;
            transform: translateX(-5px);
        }

        @media (max-width: 768px) {
            .portada-galeria h1 {
                font-size: 2rem;
            }

            #content-grid {
                columns: 2;
            }
        }
    </style>

    <!-- Portada -->
    <div class="portada-galeria">
        <div class="content">
            <div class="container animate__animated animate__fadeInUp">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pb-0 mb-0">
                        <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="/galeria-lista">Galerías</a></li>
                        <li class="breadcrumb-item active"><?= $dataGaleria['titulo'] ?></li>
                    </ol>
                </nav>
                <h1 class="mt-4"><?= $dataGaleria['titulo'] ?></h1>
                <?php if (!empty($dataGaleria['detalle'])) : ?>
                    <p class="detalle"><?= $dataGaleria['detalle'] ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Información de la Galería -->
    <?php if (!empty($dataGaleria['categoria']) || !empty($dataGaleria['fecreg'])) : ?>
        <div class="galeria-info">
            <div class="container text-center">
                <?php if (!empty($dataGaleria['categoria'])) : ?>
                    <div class="categoria-badge"><?= $dataGaleria['categoria'] ?></div>
                <?php endif; ?>
                <div class="fecha">
                    <i class="far fa-calendar-alt"></i>
                    <?= date('d \d\e F \d\e Y', strtotime($dataGaleria['fecreg'])) ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Grid de Imágenes/Videos -->
    <section class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-xl-9">
                <div id="content-grid">
                    <?php
                    foreach ($dataGaleria['cuerpo'] as $val) : ?>
                        <?php
                        if ($val['tipo'] == 'I') { ?>
                            <a class="img-links" data-gall="gallery01" title="<?= $dataGaleria['titulo'] ?>" href="<?= $val['content'] ?>">
                                <img src="<?= $val['portada'] ?>" alt="<?= $dataGaleria['titulo'] ?>">
                            </a>
                        <?php } else if ($val['tipo'] == 'V') { ?>
                            <a class="img-links" data-gall="gallery01" data-autoplay="true" data-vbtype="video" data-maxwidth="900px" href="<?= $val['content'] ?>">
                                <img src="<?= $val['portada'] ?>" alt="Video - <?= $dataGaleria['titulo'] ?>">
                            </a>
                        <?php } ?>
                    <?php endforeach;  ?>
                </div>

                <div class="text-center mt-5">
                    <a href="/galeria-lista" class="btn-volver">
                        <i class="fas fa-arrow-left"></i> Volver a Galerías
                    </a>
                </div>
            </div>
        </div>
    </section>


    <script>
        new VenoBox({
            selector: '.img-links',
            numeration: true,
            infinigall: true,
            navSpeed: 300,
        });
    </script>

</body>

</html>