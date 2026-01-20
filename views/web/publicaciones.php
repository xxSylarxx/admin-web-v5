<?php

use Admin\Models;

$objEmpresa = new Models\EmpresaModel;
$objCategorias = new Models\CategoriasModel;
$objPublicaciones = new Models\PublicacionModel;
$dataEmpresa = $objEmpresa->listEmpresa()[1];

$filter = isset($URI[1]) ? $URI[1] : 'all';
$pagina = isset($URI[2]) ? $URI[2] : '1';
$initPub = (PUB_MAX_WEB * $pagina) - PUB_MAX_WEB;

if ($filter !== 'all') {
    $dataCategoria = $objCategorias->buscarCategoria($URI[1], false);
    $idCateg = $dataCategoria['idcatg'];
    $nameCategoria = $dataCategoria['nombre'];
    $dataPublicaciones = $objPublicaciones->listPublicacionesInWeb($initPub, PUB_MAX_WEB, $idCateg);
} else {
    $idCateg = '%';
    $nameCategoria = 'All';
    $dataPublicaciones = $objPublicaciones->listPublicacionesInWeb($initPub, PUB_MAX_WEB, $idCateg);
}

// total de publicaciones
$total = $objPublicaciones->totalPublicaciones($idCateg, true);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= mb_strtoupper($dataEmpresa['nombre'], 'UTF-8') ?></title>
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
        .portada {
            background-color: var(--color3);
        }

        .portada h2 {
            letter-spacing: 0.1em;
            word-spacing: 0.1em;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            color: white;
        }

        .breadcrumb-item>a {
            color: white;
            font-size: 14.5px;
        }

        #publications div.card {
            border: none;
            box-shadow: 0 4px 16px rgb(0 0 0 / 10%);
            transition: transform .3s ease-in-out;
            border-bottom: 2px solid transparent;
            background-color: white;
        }

        #publications div.card:hover {
            transform: scale(1.03);
            border-bottom: 2px solid var(--color2);
        }

        #publications div.categoria {
            position: absolute;
            padding: 4px 12px;
            top: 14px;
            background-color: var(--color2);
            color: blanchedalmond;
            margin-left: -10px;
            font-size: 14px;
            border-radius: 3px;
            box-shadow: 0 4px 16px rgb(0 0 0 / 10%);
        }

        #publications p.date {
            color: var(--color3);
            font-size: 14.5px;
            margin-bottom: 8px;
        }

        #publications h5.titulo {
            font-weight: bold;
            max-height: 75px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            color: var(--color4);
            line-height: 1.4;
            font-size: 16.5px;
        }

        #publications p.detalle {
            text-align: justify;
            font-size: 14.5px;
            line-height: 1.7;
            margin-bottom: 0px;
            color: rgb(100, 100, 100);
        }
    </style>

    <div class="container-fluid portada">
        <div class="container py-3 animate__animated animate__slideInLeft">
            <ol class="breadcrumb pb-0 mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/publicaciones/all">Publicaciones</a></li>
                <?php if ($nameCategoria != 'All') { ?>
                    <li class="breadcrumb-item"><a href=""><?= $nameCategoria ?></a></li>
                <?php } ?>
            </ol>
            <div class="mt-3">
                <h2 class="text-white"><?= $nameCategoria == 'All' ? 'Publicaciones' : $nameCategoria ?> </h2>
            </div>
        </div>
    </div>

    <br><br><br>

    <div class="container animate__animated animate__zoomIn" id="publications">
        <div class="row justify-content-center">
            <?php foreach ($dataPublicaciones as $key => $pub) : ?>
                <div class="col-lg-4 my-3 px-3">
                    <div class="card h-100">
                        <div class="categoria"><?= $pub['categoria'] ?></div>
                        <img src="<?= $pub['portada'] ?>" width="100%" height="240" style="object-fit: cover;">
                        <div class="card-body px-4">
                            <p class="date">
                                <i class="far fa-calendar"></i>&nbsp; <?= date('M d, Y', strtotime($pub['fecpub'])) ?>
                            </p>
                            <a href="/pub/<?= $pub['tagname'] ?>">
                                <h5 class="titulo"><?= $pub['titulo'] ?></h5>
                            </a>
                            <p class="detalle"><?= $pub['detalle'] ?> &nbsp;<a href="/pub/<?= $pub['tagname'] ?>">Leer Más <i class="fas fa-long-arrow-alt-right"></i></a></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="row pt-4">
            <div class="col-lg pt-3">
                <ul class="pagination justify-content-center">
                    <?= $objPublicaciones->paginationWeb($filter, $total, $pagina, "/publicaciones/"); ?>
                </ul>
            </div>
        </div>
    </div>

    <br><br><br>

</body>

</html>