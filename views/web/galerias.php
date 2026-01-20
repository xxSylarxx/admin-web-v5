<?php

use Admin\Models;

$objEmpresa = new Models\EmpresaModel;
$objGalerias = new Models\GaleriasModel;
$objPortada = new Models\PortadasModel;
$objCategorias = new Models\CategoriasGaleriasModel;

$dataEmpresa = $objEmpresa->listEmpresa()[1];
$dataPortada = $objPortada->obtenerPortada('galerias');
$listCategorias = $objCategorias->listCategoriasInWeb();

// Filtro y paginación similar a publicaciones
$filter = isset($URI[1]) ? $URI[1] : 'all';
$pagina = isset($URI[2]) ? $URI[2] : '1';
$initGal = (GAL_MAX_WEB * $pagina) - GAL_MAX_WEB;

if ($filter !== 'all') {
    $dataCategoria = $objCategorias->buscarCategoria($filter, true);
    if ($dataCategoria) {
        $idCateg = $dataCategoria['idcatg'];
        $nameCategoria = $dataCategoria['nombre'];
    } else {
        $idCateg = '%';
        $nameCategoria = 'Todas';
        $filter = 'all';
    }
    $dataGalerias = $objGalerias->listGaleriasInWeb($initGal, GAL_MAX_WEB, $idCateg);
} else {
    $idCateg = '%';
    $nameCategoria = 'Todas';
    $dataGalerias = $objGalerias->listGaleriasInWeb($initGal, GAL_MAX_WEB, $idCateg);
}

// Total de galerías
$total = $objGalerias->totalGalerias($idCateg, true);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Galerías - <?= $dataEmpresa['nombre'] ?>">
    <title>Galerías - <?= mb_strtoupper($dataEmpresa['nombre'], 'UTF-8') ?></title>
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
        .portada-galerias {
            position: relative;
            width: 100%;
            height: 400px;
            background-image: url('<?= !empty($dataPortada['imagen']) ? $dataPortada['imagen'] : 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=1200' ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .portada-galerias::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.4));
        }

        .portada-galerias .content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
        }

        .portada-galerias h1 {
            font-size: 3.5rem;
            font-weight: bold;
            letter-spacing: 0.08em;
            margin-bottom: 15px;
        }

        .portada-galerias p {
            font-size: 1.2rem;
            opacity: 0.95;
        }

        /* Filtros */
        .filter-section {
            background: #f8f9fa;
            padding: 30px 0;
            border-bottom: 2px solid #e9ecef;
        }

        .filter-btn {
            margin: 5px;
            padding: 10px 25px;
            border: 2px solid var(--color3);
            background: white;
            color: var(--color3);
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: var(--color3);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Cards de Galerías */
        .galerias-section {
            padding: 80px 0;
        }

        .gallery-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            background: white;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .gallery-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }

        .gallery-card .img-container {
            position: relative;
            width: 100%;
            height: 280px;
            overflow: hidden;
        }

        .gallery-card .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .gallery-card:hover .img-container img {
            transform: scale(1.1);
        }

        .gallery-card .img-container .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.7));
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gallery-card:hover .img-container .overlay {
            opacity: 1;
        }

        .gallery-card .img-container .overlay i {
            font-size: 3rem;
            color: white;
        }

        .gallery-card .card-body {
            padding: 25px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .gallery-card .categoria {
            color: var(--color2);
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 10px;
        }

        .gallery-card h3 {
            font-size: 1.3rem;
            font-weight: bold;
            color: var(--color3);
            margin-bottom: 12px;
            line-height: 1.4;
        }

        .gallery-card .detalle {
            color: #666;
            font-size: 14.5px;
            line-height: 1.6;
            margin-bottom: 15px;
            flex: 1;
        }

        .gallery-card .meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 15px;
            border-top: 1px solid #e9ecef;
            color: #999;
            font-size: 13px;
        }

        .gallery-card .ver-galeria {
            color: var(--color3);
            font-weight: bold;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .gallery-card .ver-galeria:hover {
            color: var(--color2);
            padding-left: 5px;
        }

        .empty-state {
            text-align: center;
            padding: 100px 0;
        }

        .empty-state i {
            font-size: 5rem;
            color: #ddd;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: #999;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .portada-galerias h1 {
                font-size: 2.5rem;
            }

            .filter-btn {
                padding: 8px 20px;
                font-size: 14px;
            }
        }
    </style>

    <!-- Portada -->
    <div class="portada-galerias">
        <div class="content">
            <div class="container">
                <h1 class="animate__animated animate__fadeInDown">GALERÍAS</h1>
                <p class="animate__animated animate__fadeInUp">Revive nuestros mejores momentos</p>
            </div>
        </div>
    </div>

    <!-- Filtros por Categoría -->
    <?php if (count($listCategorias) > 0) : ?>
        <div class="filter-section">
            <div class="container text-center">
                <a href="/galerias/all" class="filter-btn <?= $filter == 'all' ? 'active' : '' ?>">
                    Todas
                </a>
                <?php foreach ($listCategorias as $categ) : ?>
                    <a href="/galerias/<?= $categ['idcatg'] ?>" class="filter-btn <?= $filter == $categ['idcatg'] ? 'active' : '' ?>">
                        <?= $categ['nombre'] ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Lista de Galerías -->
    <div class="galerias-section">
        <div class="container">
            <?php if (count($dataGalerias) > 0) : ?>
                <div class="row g-4">
                    <?php foreach ($dataGalerias as $galeria) : ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="gallery-card animate__animated animate__fadeInUp">
                                <div class="img-container">
                                    <img src="<?= !empty($galeria['portada']) ? $galeria['portada'] : PATH_PUBLIC . '/img/icons/portada_galeria.jpg' ?>" 
                                         alt="<?= $galeria['titulo'] ?>">
                                    <div class="overlay">
                                        <i class="fas fa-images"></i>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($galeria['categoria'])) : ?>
                                        <div class="categoria"><?= $galeria['categoria'] ?></div>
                                    <?php endif; ?>
                                    <h3><?= $galeria['titulo'] ?></h3>
                                    <?php if (!empty($galeria['detalle'])) : ?>
                                        <div class="detalle"><?= $galeria['detalle'] ?></div>
                                    <?php endif; ?>
                                    <div class="meta">
                                        <span>
                                            <i class="far fa-calendar-alt"></i>
                                            <?= date('d/m/Y', strtotime($galeria['fecreg'])) ?>
                                        </span>
                                        <a href="/galeria/<?= $galeria['idgaleria'] ?>" class="ver-galeria">
                                            Ver galería <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="empty-state">
                    <i class="far fa-images"></i>
                    <h3>No hay galerías disponibles</h3>
                    <p class="text-muted">Próximamente agregaremos nuevas galerías</p>
                </div>
            <?php endif; ?>

            <!-- Paginación -->
            <div class="row pt-5">
                <div class="col-lg">
                    <ul class="pagination justify-content-center">
                        <?= $objGalerias->paginationWeb($filter, $total, $pagina, "/galerias/"); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?php include_once PATH_ROOT . '/views/web/partials/footer.php'; ?>

</body>

</html>