<?php

use Admin\Models;

$objEmpresa = new Models\EmpresaModel;
$dataEmpresa = $objEmpresa->listEmpresa()[1];

$objPortada = new Models\PortadasModel;
$dataPortada = $objPortada->obtenerPortada('servicios');

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Conoce todos los servicios que ofrece <?= $dataEmpresa['nombre'] ?>">
    <title>Servicios - <?= mb_strtoupper($dataEmpresa['nombre'], 'UTF-8') ?></title>
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
        .portada-servicios {
            position: relative;
            width: 100%;
            height: 400px;
            background-image: url('<?= !empty($dataPortada['imagen']) ? $dataPortada['imagen'] : 'https://images.unsplash.com/photo-1556761175-b413da4baf72?w=1200' ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .portada-servicios::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.4));
        }

        .portada-servicios .content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
        }

        .portada-servicios h1 {
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
        #servicios-content {
            padding: 80px 0;
        }

        #servicios-content h2 {
            color: var(--color3);
            font-weight: bold;
            margin-bottom: 25px;
            font-size: 2.2rem;
            text-align: center;
        }

        #servicios-content p.lead {
            text-align: center;
            color: rgb(100, 100, 100);
            margin-bottom: 50px;
        }

        /* Tarjetas de servicios */
        .service-card {
            border: none;
            box-shadow: 0 4px 16px rgb(0 0 0 / 10%);
            transition: all .3s ease-in-out;
            border-radius: 10px;
            overflow: hidden;
            height: 100%;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 24px rgb(0 0 0 / 20%);
        }

        .service-card .service-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--color2), var(--color3));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: -40px auto 20px;
            position: relative;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .service-card .service-icon i {
            font-size: 35px;
            color: white;
        }

        .service-card .card-header {
            background: linear-gradient(135deg, var(--color1), var(--color2));
            height: 120px;
            border: none;
        }

        .service-card h5 {
            color: var(--color4);
            font-weight: bold;
            margin-bottom: 15px;
            font-size: 1.3rem;
        }

        .service-card p {
            text-align: justify;
            font-size: 14.5px;
            line-height: 1.7;
            color: rgb(80, 80, 80);
            margin-bottom: 15px;
        }

        .service-card ul {
            list-style: none;
            padding: 0;
            margin-bottom: 20px;
        }

        .service-card ul li {
            padding: 5px 0;
            font-size: 14px;
            color: rgb(90, 90, 90);
        }

        .service-card ul li i {
            color: var(--color2);
            margin-right: 8px;
        }

        .service-card .btn {
            background-color: var(--color3);
            border: none;
            color: white;
            padding: 8px 25px;
            border-radius: 5px;
            transition: all .3s;
        }

        .service-card .btn:hover {
            background-color: var(--color4);
            transform: scale(1.05);
        }

        /* Sección CTA */
        .cta-section {
            background: linear-gradient(135deg, var(--color3), var(--color4));
            color: white;
            padding: 60px 0;
            text-align: center;
        }

        .cta-section h3 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .cta-section p {
            font-size: 16px;
            margin-bottom: 30px;
            color: rgba(255, 255, 255, 0.95);
        }

        .cta-section .btn {
            background-color: white;
            color: var(--color3);
            padding: 12px 40px;
            font-weight: bold;
            border-radius: 5px;
            border: none;
            transition: all .3s;
        }

        .cta-section .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
        }

        /* Proceso de trabajo */
        .proceso-item {
            text-align: center;
            margin-bottom: 30px;
        }

        .proceso-item .numero {
            width: 60px;
            height: 60px;
            background-color: var(--color2);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 24px;
            font-weight: bold;
        }

        .proceso-item h5 {
            color: var(--color3);
            font-weight: bold;
            margin-bottom: 10px;
        }

        .proceso-item p {
            font-size: 14px;
            color: rgb(90, 90, 90);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .portada-servicios h1 {
                font-size: 2.5rem;
            }

            #servicios-content {
                padding: 50px 0;
            }

            .service-card .card-header {
                height: 100px;
            }
        }
    </style>

    <!-- PORTADA INTERNA -->
      <?php if(!empty($dataPortada)){ ?>
    <div class="portada-servicios">
        <div class="content">
            <div class="container animate__animated animate__fadeInDown">
                <ol class="breadcrumb pb-0 mb-3">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item active">Servicios</li>
                </ol>
                <h1><?= !empty($dataPortada['titulo']) ? $dataPortada['titulo'] : 'Nuestros Servicios' ?></h1>
                <p class="lead"><?= !empty($dataPortada['subtitulo']) ? $dataPortada['subtitulo'] : 'Soluciones profesionales adaptadas a tus necesidades' ?></p>
            </div>
        </div>
    </div>
    <?php } ?>

    <!-- CONTENIDO PRINCIPAL -->
    <section id="servicios-content">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12">
                    <h2>¿Qué Ofrecemos?</h2>
                    <p class="lead">
                        Brindamos servicios de alta calidad diseñados para satisfacer las necesidades de nuestros clientes.
                        Nuestro equipo de profesionales está comprometido con la excelencia.
                    </p>
                </div>
            </div>

            <!-- Grid de Servicios -->
            <div class="row animate__animated animate__fadeInUp">
                
                <!-- Servicio 1 -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card service-card">
                        <div class="card-header"></div>
                        <div class="card-body text-center px-4 pb-4">
                            <div class="service-icon">
                                <i class="fas fa-laptop-code"></i>
                            </div>
                            <h5>Desarrollo Web</h5>
                            <p>
                                Creamos sitios web modernos, responsivos y optimizados para tu negocio. 
                                Desde landing pages hasta plataformas complejas.
                            </p>
                            <ul class="text-start">
                                <li><i class="fas fa-check-circle"></i> Diseño responsivo</li>
                                <li><i class="fas fa-check-circle"></i> SEO optimizado</li>
                                <li><i class="fas fa-check-circle"></i> Alta velocidad</li>
                                <li><i class="fas fa-check-circle"></i> Seguridad garantizada</li>
                            </ul>
                            <a href="#" class="btn">Más información</a>
                        </div>
                    </div>
                </div>

                <!-- Servicio 2 -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card service-card">
                        <div class="card-header"></div>
                        <div class="card-body text-center px-4 pb-4">
                            <div class="service-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h5>Marketing Digital</h5>
                            <p>
                                Estrategias efectivas para aumentar tu presencia online y atraer 
                                más clientes a tu negocio.
                            </p>
                            <ul class="text-start">
                                <li><i class="fas fa-check-circle"></i> Gestión de redes sociales</li>
                                <li><i class="fas fa-check-circle"></i> Publicidad en Google Ads</li>
                                <li><i class="fas fa-check-circle"></i> Email marketing</li>
                                <li><i class="fas fa-check-circle"></i> Análisis de métricas</li>
                            </ul>
                            <a href="#" class="btn">Más información</a>
                        </div>
                    </div>
                </div>

                <!-- Servicio 3 -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card service-card">
                        <div class="card-header"></div>
                        <div class="card-body text-center px-4 pb-4">
                            <div class="service-icon">
                                <i class="fas fa-paint-brush"></i>
                            </div>
                            <h5>Diseño Gráfico</h5>
                            <p>
                                Creamos identidades visuales únicas que reflejan la esencia de tu marca 
                                y conectan con tu audiencia.
                            </p>
                            <ul class="text-start">
                                <li><i class="fas fa-check-circle"></i> Logos y branding</li>
                                <li><i class="fas fa-check-circle"></i> Material publicitario</li>
                                <li><i class="fas fa-check-circle"></i> Diseño editorial</li>
                                <li><i class="fas fa-check-circle"></i> Ilustraciones personalizadas</li>
                            </ul>
                            <a href="#" class="btn">Más información</a>
                        </div>
                    </div>
                </div>

                <!-- Servicio 4 -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card service-card">
                        <div class="card-header"></div>
                        <div class="card-body text-center px-4 pb-4">
                            <div class="service-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <h5>Aplicaciones Móviles</h5>
                            <p>
                                Desarrollamos apps nativas e híbridas para iOS y Android con 
                                interfaces intuitivas y funcionales.
                            </p>
                            <ul class="text-start">
                                <li><i class="fas fa-check-circle"></i> Apps iOS y Android</li>
                                <li><i class="fas fa-check-circle"></i> UI/UX profesional</li>
                                <li><i class="fas fa-check-circle"></i> Integración API</li>
                                <li><i class="fas fa-check-circle"></i> Mantenimiento continuo</li>
                            </ul>
                            <a href="#" class="btn">Más información</a>
                        </div>
                    </div>
                </div>

                <!-- Servicio 5 -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card service-card">
                        <div class="card-header"></div>
                        <div class="card-body text-center px-4 pb-4">
                            <div class="service-icon">
                                <i class="fas fa-headset"></i>
                            </div>
                            <h5>Consultoría</h5>
                            <p>
                                Asesoramiento experto para optimizar tus procesos digitales y 
                                tomar decisiones estratégicas informadas.
                            </p>
                            <ul class="text-start">
                                <li><i class="fas fa-check-circle"></i> Análisis de necesidades</li>
                                <li><i class="fas fa-check-circle"></i> Planificación estratégica</li>
                                <li><i class="fas fa-check-circle"></i> Optimización de procesos</li>
                                <li><i class="fas fa-check-circle"></i> Soporte personalizado</li>
                            </ul>
                            <a href="#" class="btn">Más información</a>
                        </div>
                    </div>
                </div>

                <!-- Servicio 6 -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card service-card">
                        <div class="card-header"></div>
                        <div class="card-body text-center px-4 pb-4">
                            <div class="service-icon">
                                <i class="fas fa-server"></i>
                            </div>
                            <h5>Hosting y Dominios</h5>
                            <p>
                                Servicios de alojamiento web seguros, rápidos y confiables con 
                                soporte técnico 24/7.
                            </p>
                            <ul class="text-start">
                                <li><i class="fas fa-check-circle"></i> Hosting de alto rendimiento</li>
                                <li><i class="fas fa-check-circle"></i> Certificados SSL gratis</li>
                                <li><i class="fas fa-check-circle"></i> Backups automáticos</li>
                                <li><i class="fas fa-check-circle"></i> Soporte 24/7</li>
                            </ul>
                            <a href="#" class="btn">Más información</a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- PROCESO DE TRABAJO -->
    <section style="background-color: #f8f9fa; padding: 60px 0;">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2 style="color: var(--color3); font-weight: bold; margin-bottom: 20px;">Nuestro Proceso</h2>
                    <p class="lead" style="color: rgb(100, 100, 100);">Trabajamos de manera organizada y eficiente</p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="proceso-item animate__animated animate__fadeInUp">
                        <div class="numero">1</div>
                        <h5>Análisis</h5>
                        <p>Entendemos tus necesidades y objetivos específicos</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="proceso-item animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
                        <div class="numero">2</div>
                        <h5>Planificación</h5>
                        <p>Diseñamos una estrategia personalizada para tu proyecto</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="proceso-item animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                        <div class="numero">3</div>
                        <h5>Desarrollo</h5>
                        <p>Ejecutamos el proyecto con los más altos estándares</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="proceso-item animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
                        <div class="numero">4</div>
                        <h5>Entrega</h5>
                        <p>Lanzamos y brindamos soporte continuo</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CALL TO ACTION -->
    <section class="cta-section">
        <div class="container">
            <div class="animate__animated animate__zoomIn">
                <h3>¿Listo para comenzar tu proyecto?</h3>
                <p>Contáctanos hoy y descubre cómo podemos ayudarte a alcanzar tus objetivos</p>
                <a href="#" class="btn">Solicitar Cotización</a>
            </div>
        </div>
    </section>

    <br><br>

    <?php include_once PATH_ROOT . '/views/web/partials/footer.php'; ?>

</body>

</html>