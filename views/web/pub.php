<?php

use Admin\Models;

$objEmpresa = new Models\EmpresaModel;
$objCategorias = new Models\CategoriasModel;
$objPublicacion = new Models\PublicacionModel;
$dataEmpresa = $objEmpresa->listEmpresa()[1];
$dataCategorias = $objCategorias->listCategoriasInWeb();
$listPublicaciones = $objPublicacion->listPublicacionesInWeb(0, 5);
if (isset($URI[1])) {
    if ($URI[1] == 'preview') {
        $idcateg = $_POST['idcatg'];
        $dataPub = $_POST;
        $dataPub['categoria'] = $dataCategorias[$idcateg]['nombre'];
    } else {
        $tagname = $URI[1];
        $dataPub = $objPublicacion->buscarPublicacionxTag($tagname);
        $idcateg = $dataPub['idcatg'];
        $dataPub['categoria'] = $dataCategorias[$idcateg]['nombre'];
    }
} else {
    header('Location: /404');
}
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

        #publications .card h3.titulo {
            color: var(--color4);
            font-weight: bold;
        }

        #publications .card-header {
            background: transparent;
            border: none;
            padding: 0px
        }

        #publications .card-body {
            line-height: 2;
        }

        #publications p.date {
            color: var(--color2);
            font-size: 17px;
            margin-bottom: 8px;
        }

        #sidebar {
            position: sticky;
            top: 12%;
            border: none;
            width: 83%;
            margin-left: auto;
            margin-right: auto;
            background-color: #F9F9F9;
            padding: 1em;
            box-shadow: 0 0 12px rgba(78, 64, 57, .2);
        }

        #sidebar h5 {
            font-size: 16.5px;
            color: #505050;
        }

        #sidebar .pub-titulo {
            color: var(--color2);
            font-weight: 500;
        }

        #sidebar .list-group-item a {
            max-height: 50px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        /* Bloquear estilos de Bootstrap en el contenido */
        /*     .content-raw {
            all: revert;
            padding: 0.25rem !important;
        }

        .content-raw * {
            all: revert;
        } */

        #cuerpo-pub td {
            border: solid 1px black !important;
        }

    </style>

    <div class="container-fluid portada">
        <div class="container py-3 animate__animated animate__slideInLeft">
            <ol class="breadcrumb pb-0 mb-0">
                <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                <li class="breadcrumb-item"><a href="/">Publicaciones</a></li>
                <li class="breadcrumb-item"><a href=""><?= $dataPub['categoria'] ?></a></li>
            </ol>
            <div class="mt-3">
                <h2 class="text-white"><?= $dataPub['titulo'] ?></h2>
            </div>
        </div>
    </div>

    <br><br><br>

    <section class="container  animate__animated animate__zoomIn" id="publications">
        <div class="row justify-content-between">
            <div class="col-md-8 my-2">
                <div class="card border-0">
                    <div class="card-header">
                        <?php
                        if (!empty($dataPub['portada'])) { ?>
                            <img src="<?= $dataPub['portada'] ?>" width="100%" height="260" style="object-fit: cover;">
                        <?php } ?>
                        <div class="px-2 pt-4">
                            <h3 class="titulo pt-2 pb-2"><?= $dataPub['titulo'] ?></h3>
                            <p class="date">
                                <i class="far fa-calendar"></i>&nbsp; <?= date('M d, Y', strtotime($dataPub['fecpub'])) ?>
                                <i class="far fa-clock ms-3"></i> <?= date('h:i', strtotime($dataPub['fecpub'])) ?>
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div id="cuerpo-pub" class="card-body p-1">
                        <?= $dataPub['cuerpo'] ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4 my-2">
                <div class="card" id="sidebar">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Search</h5>
                        <div class="autocompletar mb-4">
                            <input type="search" class="form-control" id="txtbuscar">
                        </div>
                        <h5 class="fw-bold mb-2">Categories</h5>
                        <?php
                        foreach ($dataCategorias as $value) : ?>
                            <div class="d-flex" style="font-size: 14.5px;">
                                <a href="/publicaciones/<?= $value['filtro'] ?>"><?= $value['nombre'] ?> (<?= $value['totalPub'] ?>)</a>
                            </div>
                        <?php endforeach; ?>
                        <h5 class="fw-bold mb-2 mt-4">Recent Posts</h5>
                        <ul class="list-group list-group-flush">
                            <?php
                            foreach ($listPublicaciones as $pub) :
                                if ($pub['idpub'] == $dataPub['idpub']) {
                                    continue;
                                }
                            ?>
                                <li class="list-group-item px-0" style="font-size: 14.5px;">
                                    <a href="/pub/<?= $pub['tagname'] ?>"><?= $pub['titulo'] ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <br><br><br>


</body>

</html>