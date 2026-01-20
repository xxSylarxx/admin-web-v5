<?php

use Admin\Models;

$objModal = new Models\ModalModel;
$objBanner = new Models\BannerModel;
$objEmpresa = new Models\EmpresaModel;
$objPublicaciones = new Models\PublicacionModel;
$objSuscripciones = new Models\SuscripcionesModel;

$dataEmpresa = $objEmpresa->listEmpresa()[1];
$dataBanner = $objBanner->listBannerInWeb();
$dataModal = $objModal->obtenerPopUp();
$dataPublicaciones = $objPublicaciones->listPublicacionesInWeb(0, 3);


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $dataEmpresa['metades'] ?>">
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
        /* estilos del banner dinámico */
        #carouselBanner div.carousel-item img {
            height: <?= isset($dataBanner['opciones']['dimensionar']) && $dataBanner['opciones']['dimensionar']
                        ? 'calc(' . ($dataBanner['opciones']['height'] ?? '100') . 'vh - 90px)'
                        : '100%' ?>;
        }

        div.content-banner .frame-responsive {
            position: relative;
            height: 0;
            overflow: hidden;
            padding-bottom: 56.2%;
            margin-bottom: 20px;
        }

        div.content-banner .frame-responsive iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: <?= $dataBanner['opciones']['dimensionar'] ? 'calc(100vh - 90px)' : '100%' ?>;
        }

        div.content-banner video {
            width: 100%;
            height: <?= $dataBanner['opciones']['dimensionar'] ? 'calc(100vh - 90px)' : '100%' ?>;
        }

        /* estilos de publicaciones */
        #publications div.card {
            border: none;
            box-shadow: 0 4px 16px rgb(0 0 0 / 10%);
            transition: transform .3s ease-in-out;
            border-bottom: 2px solid transparent;
            background-color: white;
        }

        #publications div.card:hover {
            transform: scale(1.04);
            border-bottom: 2px solid var(--color4);
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
            color: var(--color2);
            line-height: 1.4;
            font-size: 16px;
        }

        #publications p.detalle {
            text-align: justify;
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 0px;
            color: rgb(100, 100, 100);
        }

        @media screen and (max-width:1200px) {
            #carouselBanner div.carousel-item img {
                height: 100%;
            }

            div.content-banner .frame-responsive iframe {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }

            div.content-banner video {
                width: 100%;
                height: 100%;
            }
        }
    </style>

    <!-- admin - ventana emergente -->
    <?php if ($dataModal['visible'] == 'S') : ?>
        <style>
            #modalAdmin div.responsive {
                position: relative;
                height: 0;
                overflow: hidden;
                padding-bottom: 56%;
                margin-bottom: 20px;
            }

            #modalAdmin div.responsive iframe {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }
        </style>
        <div class="modal" id="modalAdmin" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content animate__animated <?= $dataModal['animation'] ?>" style="<?= ($dataModal['margen'] == 'N' && $dataModal['header'] == 'N') ? 'background: transparent; border: none;' : null ?>">
                    <?php if ($dataModal['header'] == 'S') { ?>
                        <div class="modal-header border-0">
                            <h5 class="modal-title fw-bold"><?= $dataModal['titulo'] ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    <?php } ?>
                    <div class="modal-body <?= $dataModal['margen'] == 'N' ? 'p-0' : null ?>">
                        <?= $dataModal['cuerpo'] ?>
                    </div>
                </div>
            </div>
        </div>
        <script>
            // instancia y muestra la ventana
            let modalAdmin = new bootstrap.Modal(document.getElementById('modalAdmin'));
            modalAdmin.show();
            // al cierre de la ventana eliminamos el contenido
            let modalAdmin2 = document.getElementById('modalAdmin');
            modalAdmin2.addEventListener('hide.bs.modal', function(event) {
                document.querySelector('.modal-body').remove();
            });
        </script>
    <?php endif; ?>

    <!-- admin - banner dinámico -->
    <div class="container-fluid content-banner px-0">
        <?php
        if ($dataBanner['tipo'] == 'slider') { ?>
            <div id="carouselBanner" class="carousel slide <?= $dataBanner['opciones']['fade'] ? 'carousel-fade' : null ?>" data-bs-ride="carousel">
                <?php if ($dataBanner['opciones']['indicadores']) { ?>
                    <div class="carousel-indicators">
                        <?php
                        foreach ($dataBanner['cuerpo'] as $key => $val) : ?>
                            <button type="button" data-bs-target="#carouselBanner" data-bs-slide-to="<?= $key ?>" class="<?= $key == 0 ? 'active' : '' ?>"></button>
                        <?php endforeach; ?>
                    </div>
                <?php } ?>
                <div class="carousel-inner">
                    <?php
                    foreach ($dataBanner['cuerpo'] as $key => $val) : ?>
                        <div class="carousel-item <?= $key == 0 ? 'active' : '' ?>">
                            <?php if (empty($val['enlace'])) { ?>
                                <img src="<?= $val['imagen'] ?>" class="d-block w-100" style="<?= $dataBanner['opciones']['dimensionar'] ? 'object-fit: cover;' : null ?>;">
                            <?php } else { ?>
                                <a href="<?= $val['enlace'] ?>">
                                    <img src="<?= $val['imagen'] ?>" class="d-block w-100" style="<?= $dataBanner['opciones']['dimensionar'] ? 'object-fit: cover;' : null ?>;">
                                </a>
                            <?php } ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev <?= $dataBanner['opciones']['flechas'] ? '' : 'd-none' ?>" type="button" data-bs-target="#carouselBanner" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next <?= $dataBanner['opciones']['flechas'] ? '' : 'd-none' ?>" type="button" data-bs-target="#carouselBanner" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        <?php } else if ($dataBanner['tipo'] == 'video' && $dataBanner['opciones']['youtube'] == true) {
            $src  = $dataBanner['cuerpo'] . '?rel=0&showinfo=0';
            $src .= $dataBanner['opciones']['controls'] ? '&controls=1' : '&controls=0';
            $src .= $dataBanner['opciones']['autoplay'] ? '&autoplay=1' : '&autoplay=0';
            $src .= $dataBanner['opciones']['muted'] ? '&mute=1' : '&mute=0';
        ?>
            <div class="frame-responsive"><iframe src="<?= $src ?>" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
        <?php } else {
            $target  = 'src="' . $dataBanner['cuerpo'] . '"';
            $target .= $dataBanner['opciones']['controls'] ? ' controls ' : '';
            $target .= $dataBanner['opciones']['autoplay'] ? ' autoplay ' : '';
            $target .= $dataBanner['opciones']['muted'] ? ' muted' : '';
        ?>
            <video <?= $target ?> width="100%" style="display: block; <?= $dataBanner['opciones']['dimensionar'] ? 'object-fit: cover;' : null ?>;" loop></video>
        <?php } ?>
    </div>

    <!-- Sección de suscripción -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold">¡Suscríbete!</h2>
                        <p class="text-muted">Recibe las últimas noticias y actualizaciones</p>
                    </div>
                    <form id="formSuscripcion" onsubmit="enviarSuscripcion(event)">
                        <div class="mb-3">
                            <label for="nombreInput" class="form-label">Nombres completos</label>
                            <input type="text" name="nombre_completo" class="form-control" id="nombreInput" 
                                   pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" 
                                   minlength="3" maxlength="100" required>
                            <div class="form-text">Ingresa tu nombre completo</div>
                        </div>
                        <div class="mb-3">
                            <label for="emailInput" class="form-label">Correo electrónico</label>
                            <input type="email" name="email" class="form-control" id="emailInput" 
                                   maxlength="100" required>
                            <div class="form-text">Tu correo no será compartido</div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg" id="btnSuscribir">
                                <i class="fas fa-envelope"></i> Suscribirse
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include_once PATH_ROOT . '/views/web/partials/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function enviarSuscripcion(e) {
            e.preventDefault();
            
            const btn = document.getElementById('btnSuscribir');
            const form = document.getElementById('formSuscripcion');
            const nombre = form.nombre_completo.value.trim();
            const email = form.email.value.trim();

            // Validaciones adicionales
            if (nombre.length < 3) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Nombre muy corto',
                    text: 'El nombre debe tener al menos 3 caracteres'
                });
                return;
            }

            // Validar formato de email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Correo inválido',
                    text: 'Por favor ingresa un correo electrónico válido'
                });
                return;
            }

            // Deshabilitar botón durante el envío
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';

            const data = new FormData(form);
            
            fetch('/admin/suscripciones/guardar', {
                method: 'POST',
                body: data
            })
            .then(res => res.text())
            .then(res => {
                if (res.trim() === 'OK') {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Suscripción exitosa!',
                        text: 'Gracias por suscribirte. Recibirás noticias en tu correo.',
                        confirmButtonText: 'Entendido'
                    });
                    form.reset();
                } else if (res.includes('duplicado') || res.includes('duplicate')) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Ya estás suscrito',
                        text: 'Este correo ya está registrado en nuestra lista.',
                        confirmButtonText: 'Entendido'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: res || 'No se pudo completar la suscripción. Intenta nuevamente.'
                    });
                }
            })
            .catch(err => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'Hubo un problema al procesar tu solicitud. Verifica tu conexión e intenta de nuevo.'
                });
                console.error('Error:', err);
            })
            .finally(() => {
                // Rehabilitar botón
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-envelope"></i> Suscribirse';
            });
        }
    </script>
</body>
</html>