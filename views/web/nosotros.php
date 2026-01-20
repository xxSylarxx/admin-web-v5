<?php

use Admin\Models;

$objEmpresa = new Models\EmpresaModel;
$dataEmpresa = $objEmpresa->listEmpresa()[1];

$objPortada = new Models\PortadasModel;
$dataPortada = $objPortada->obtenerPortada('nosotros');

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Conoce más sobre <?= $dataEmpresa['nombre'] ?>">
    <title>Nosotros - <?= mb_strtoupper($dataEmpresa['nombre'], 'UTF-8') ?></title>
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
        /* Portada interna */
        .portada-nosotros {
            position: relative;
            width: 100%;
            height: 400px;
            background-image: url('<?= !empty($dataPortada['imagen']) ? $dataPortada['imagen'] : 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200' ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .portada-nosotros::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.4));
        }

        .portada-nosotros .content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
        }

        .portada-nosotros h1 {
            font-size: 3.5rem;
            font-weight: bold;
            letter-spacing: 0.08em;
            margin-bottom: 15px;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            color: white;
        }

        .breadcrumb-item>a {
            color: white;
            font-size: 14.5px;
            text-decoration: none;
        }

        .breadcrumb-item>a:hover {
            color: var(--color2);
        }

        .breadcrumb-item.active {
            color: rgba(255, 255, 255, 0.8);
        }

        /* Sección de contenido */
        #nosotros-content {
            padding: 80px 0;
        }

        #nosotros-content h2 {
            color: var(--color3);
            font-weight: bold;
            margin-bottom: 25px;
            font-size: 2.2rem;
        }

        #nosotros-content h3 {
            color: var(--color4);
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        #nosotros-content p {
            text-align: justify;
            line-height: 1.8;
            font-size: 15.5px;
            color: rgb(80, 80, 80);
            margin-bottom: 20px;
        }

        /* Tarjetas de valores */
        .valores-card {
            border: none;
            box-shadow: 0 4px 16px rgb(0 0 0 / 10%);
            transition: transform .3s ease-in-out;
            border-radius: 10px;
            overflow: hidden;
        }

        .valores-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 24px rgb(0 0 0 / 15%);
        }

        .valores-card .icon-box {
            width: 70px;
            height: 70px;
            background-color: var(--color2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .valores-card .icon-box i {
            font-size: 30px;
            color: white;
        }

        .valores-card h5 {
            color: var(--color3);
            font-weight: bold;
            margin-bottom: 15px;
        }

        .valores-card p {
            text-align: center;
            font-size: 14.5px;
            margin-bottom: 0;
        }

        /* Sección de estadísticas */
        .stats-section {
            background-color: var(--color3);
            color: white;
            padding: 60px 0;
        }

        .stats-box {
            text-align: center;
        }

        .stats-box i {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .stats-box h3 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .stats-box p {
            font-size: 16px;
            margin-bottom: 0;
            color: rgba(255, 255, 255, 0.9);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .portada-nosotros h1 {
                font-size: 2.5rem;
            }

            #nosotros-content {
                padding: 50px 0;
            }
        }
    </style>

    <!-- PORTADA INTERNA -->
     <?php if(!empty($dataPortada)){ ?>
    <div class="portada-nosotros">
        <div class="content">
            <div class="container animate__animated animate__fadeInDown">
                <ol class="breadcrumb pb-0 mb-3">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item active">Nosotros</li>
                </ol>
                <h1><?= !empty($dataPortada['titulo']) ? $dataPortada['titulo'] : 'Nosotros' ?></h1>
                <p class="lead"><?= !empty($dataPortada['subtitulo']) ? $dataPortada['subtitulo'] : 'Conoce más sobre nuestra institución' ?></p>
            </div>
        </div>
    </div>
    <?php } ?>
    <!-- CONTENIDO PRINCIPAL -->
    <section id="nosotros-content">
        <div class="container animate__animated animate__fadeInUp">
            <!-- Quiénes Somos -->
            <div class="row mb-5">
                <div class="col-lg-6">
                    <h2>¿Quiénes Somos?</h2>
                    <p>
                        Somos una institución comprometida con la excelencia y el desarrollo integral de nuestra comunidad. 
                        Con años de experiencia en el sector, nos hemos posicionado como líderes en brindar servicios de calidad 
                        que transforman vidas.
                    </p>
                    <p>
                        Nuestro equipo está conformado por profesionales altamente calificados, dedicados a ofrecer soluciones 
                        innovadoras y personalizadas que satisfacen las necesidades de nuestros usuarios. Creemos en el poder 
                        de la educación, la colaboración y el compromiso social.
                    </p>
                    <p>
                        A través de nuestros programas y servicios, buscamos generar un impacto positivo en la sociedad, 
                        promoviendo valores de responsabilidad, respeto y trabajo en equipo.
                    </p>
                </div>
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=800" 
                         alt="Nosotros" class="img-fluid rounded shadow-sm" style="width: 100%; height: 400px; object-fit: cover;">
                </div>
            </div>

            <!-- Misión y Visión -->
            <div class="row mb-5">
                <div class="col-lg-6 order-lg-2">
                    <h3><i class="fas fa-bullseye text-primary"></i> Misión</h3>
                    <p>
                        Nuestra misión es proporcionar servicios de alta calidad que superen las expectativas de nuestros usuarios, 
                        promoviendo el desarrollo integral y sostenible de la comunidad. Nos comprometemos a mantener los más altos 
                        estándares de profesionalismo, ética y responsabilidad social en todo lo que hacemos.
                    </p>
                </div>
                <div class="col-lg-6 order-lg-1">
                    <h3><i class="fas fa-eye text-success"></i> Visión</h3>
                    <p>
                        Ser reconocidos como la institución líder en nuestro sector, caracterizada por la innovación, la excelencia 
                        y el compromiso con el desarrollo de nuestra comunidad. Aspiramos a ser un referente de calidad y a generar 
                        un impacto positivo y duradero en la sociedad.
                    </p>
                </div>
            </div>

            <!-- Valores -->
            <div class="row mt-5">
                <div class="col-12 text-center mb-4">
                    <h2>Nuestros Valores</h2>
                    <p class="lead">Los principios que guían nuestro trabajo diario</p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card valores-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="icon-box">
                                <i class="fas fa-heart"></i>
                            </div>
                            <h5>Compromiso</h5>
                            <p>Dedicación total a nuestros objetivos y a las personas que servimos.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card valores-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="icon-box">
                                <i class="fas fa-award"></i>
                            </div>
                            <h5>Excelencia</h5>
                            <p>Búsqueda constante de la calidad y mejora continua en nuestros servicios.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card valores-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="icon-box">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <h5>Integridad</h5>
                            <p>Honestidad y transparencia en todas nuestras acciones y decisiones.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card valores-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="icon-box">
                                <i class="fas fa-users"></i>
                            </div>
                            <h5>Trabajo en Equipo</h5>
                            <p>Colaboración y sinergia para alcanzar metas comunes.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ESTADÍSTICAS -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <div class="stats-box animate__animated animate__fadeInUp">
                        <i class="fas fa-users"></i>
                        <h3 class="counter">1500+</h3>
                        <p>Usuarios Satisfechos</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <div class="stats-box animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
                        <i class="fas fa-trophy"></i>
                        <h3 class="counter">25+</h3>
                        <p>Años de Experiencia</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <div class="stats-box animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                        <i class="fas fa-project-diagram"></i>
                        <h3 class="counter">100+</h3>
                        <p>Proyectos Exitosos</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-box animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
                        <i class="fas fa-smile"></i>
                        <h3 class="counter">98%</h3>
                        <p>Satisfacción</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <br><br><br>

    <?php include_once PATH_ROOT . '/views/web/partials/footer.php'; ?>

</body>

</html>