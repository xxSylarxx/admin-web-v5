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

        .carousel-item {
            position: relative;
        }

        .banner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        #carouselBanner .carousel-caption {
            position: absolute;
            z-index: 2;
            padding: 20px 30px;
            bottom: 0;
            top:40%;
            left: 50%;
            right: auto;
            transform: translateX(-50%);
            width: 90%;
            max-width: 1200px;
        }

        #carouselBanner .carousel-caption h3 {
            text-align: start;
            font-size: 2.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
            margin-bottom: 15px;
        }

        #carouselBanner .carousel-caption p {
            text-align: start;
            font-size: 1.2rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
            margin-bottom: 0;
        }

        @media screen and (max-width: 768px) {
            #carouselBanner .carousel-caption {
                padding: 15px 20px;
                width: 95%;
            }

            #carouselBanner .carousel-caption h3 {
                font-size: 1.5rem;
                margin-bottom: 10px;
            }

            #carouselBanner .carousel-caption p {
                font-size: 0.9rem;
            }
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
                            <?php if (!empty($val['titulo']) || !empty($val['detalle'])) : ?>
                                <div class="banner-overlay"></div>
                                <div class="carousel-caption d-block">
                                    <?php if (!empty($val['titulo'])) : ?>
                                        <h3 class="fw-bold text-white"><?= $val['titulo'] ?></h3>
                                    <?php endif; ?>
                                    <?php if (!empty($val['detalle'])) : ?>
                                        <p class="text-white"><?= $val['detalle'] ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
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
                <div class="col-lg-8">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold">¡Contáctanos!</h2>
                        <p class="text-muted">Completa el formulario y nos pondremos en contacto contigo</p>
                    </div>
                    <form id="formSuscripcion" onsubmit="enviarSuscripcion(event)">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombresInput" class="form-label">Nombres <span class="text-danger">*</span></label>
                                <input type="text" name="nombres" class="form-control" id="nombresInput" 
                                       pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" 
                                       minlength="2" maxlength="50" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="apellidosInput" class="form-label">Apellidos <span class="text-danger">*</span></label>
                                <input type="text" name="apellidos" class="form-control" id="apellidosInput" 
                                       pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" 
                                       minlength="2" maxlength="50" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="emailInput" class="form-label">Correo electrónico <span class="text-danger">*</span></label>
                            <input type="email" name="correo" class="form-control" id="emailInput" 
                                   maxlength="100" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nivelInput" class="form-label">Nivel <span class="text-danger">*</span></label>
                                <select name="nivel" class="form-select" id="nivelInput" required onchange="actualizarGrados()">
                                    <option value="">Seleccionar...</option>
                                    <option value="Inicial">Inicial</option>
                                    <option value="Primaria">Primaria</option>
                                    <option value="Secundaria">Secundaria</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="gradoInput" class="form-label">Grado <span class="text-danger">*</span></label>
                                <select name="grado" class="form-select" id="gradoInput" required disabled>
                                    <option value="">Primero selecciona un nivel...</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="consultaInput" class="form-label">Consulta <span class="text-danger">*</span></label>
                            <textarea name="consulta" class="form-control" id="consultaInput" rows="4" 
                                      minlength="10" maxlength="500" required 
                                      placeholder="Escribe tu consulta aquí..."></textarea>
                            <div class="form-text">Máximo 500 caracteres</div>
                        </div>
                        <input type="hidden" name="asunto" value="informes">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg" id="btnSuscribir">
                                <i class="fas fa-paper-plane"></i> Enviar Consulta
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
        // Actualizar opciones de grado según nivel seleccionado
        function actualizarGrados() {
            const nivelSelect = document.getElementById('nivelInput');
            const gradoSelect = document.getElementById('gradoInput');
            const nivel = nivelSelect.value;
            
            // Limpiar opciones
            gradoSelect.innerHTML = '<option value="">Seleccionar...</option>';
            
            if (!nivel) {
                gradoSelect.disabled = true;
                gradoSelect.innerHTML = '<option value="">Primero selecciona un nivel...</option>';
                return;
            }
            
            gradoSelect.disabled = false;
            
            if (nivel === 'Inicial') {
                gradoSelect.innerHTML = `
                    <option value="">Seleccionar...</option>
                    <option value="3 años">3 años</option>
                    <option value="4 años">4 años</option>
                    <option value="5 años">5 años</option>
                `;
            } else if (nivel === 'Primaria') {
                gradoSelect.innerHTML = `
                    <option value="">Seleccionar...</option>
                    <option value="1er grado">1er grado</option>
                    <option value="2do grado">2do grado</option>
                    <option value="3er grado">3er grado</option>
                    <option value="4to grado">4to grado</option>
                    <option value="5to grado">5to grado</option>
                    <option value="6to grado">6to grado</option>
                `;
            } else if (nivel === 'Secundaria') {
                gradoSelect.innerHTML = `
                    <option value="">Seleccionar...</option>
                    <option value="1er año">1er año</option>
                    <option value="2do año">2do año</option>
                    <option value="3er año">3er año</option>
                    <option value="4to año">4to año</option>
                    <option value="5to año">5to año</option>
                `;
            }
        }

        function enviarSuscripcion(e) {
            e.preventDefault();
            
            const btn = document.getElementById('btnSuscribir');
            const form = document.getElementById('formSuscripcion');
            const nombres = form.nombres.value.trim();
            const apellidos = form.apellidos.value.trim();
            const correo = form.correo.value.trim();
            const nivel = form.nivel.value;
            const grado = form.grado.value;
            const consulta = form.consulta.value.trim();

            // Validaciones adicionales
            if (nombres.length < 2) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Nombres muy cortos',
                    text: 'Los nombres deben tener al menos 2 caracteres'
                });
                return;
            }

            if (apellidos.length < 2) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Apellidos muy cortos',
                    text: 'Los apellidos deben tener al menos 2 caracteres'
                });
                return;
            }

            // Validar formato de email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(correo)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Correo inválido',
                    text: 'Por favor ingresa un correo electrónico válido'
                });
                return;
            }

            if (!nivel || !grado) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos incompletos',
                    text: 'Por favor selecciona el nivel y grado'
                });
                return;
            }

            if (consulta.length < 10) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Consulta muy corta',
                    text: 'La consulta debe tener al menos 10 caracteres'
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
                        title: '¡Consulta enviada!',
                        text: 'Gracias por contactarnos. Nos pondremos en contacto contigo pronto.',
                        confirmButtonText: 'Entendido'
                    });
                    form.reset();
                } else if (res.includes('duplicado') || res.includes('duplicate')) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Correo ya registrado',
                        text: 'Este correo ya ha sido registrado anteriormente.',
                        confirmButtonText: 'Entendido'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: res || 'No se pudo enviar la consulta. Intenta nuevamente.'
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
                btn.innerHTML = '<i class="fas fa-paper-plane"></i> Enviar Consulta';
            });
        }
    </script>
</body>
</html>