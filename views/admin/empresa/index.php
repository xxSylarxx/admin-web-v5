<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex" />
    <title>ADMIN - <?= mb_strtoupper(EMPRESA, 'UTF-8') ?></title>
    <link rel="shortcut icon" href="<?= PATH_PUBLIC ?>/img/icons/escudo.png" type="image/png">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link rel="stylesheet" href="<?= PATH_PUBLIC ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= PATH_PUBLIC ?>/css/admin.css">
    <link rel="stylesheet" href="<?= PATH_PUBLIC ?>/css/sweetalert2.min.css">
</head>

<body>

    <script async src="<?= PATH_PUBLIC ?>/js/sweetalert2.min.js"></script>

    <?php include_once PATH_ROOT . '/views/admin/header.php'; ?>
    <?php include_once PATH_ROOT . '/views/admin/menu.php'; ?>

    <!-- ESTILOS -->
    <style>
        h5 {
            font-size: var(--fontsize);
            color: var(--color3);
        }

        h5.linea {
            position: relative;
            z-index: 1;
        }

        h5.linea:before {
            border-top: 1px solid rgb(190, 190, 190);
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            z-index: -1;
        }

        h5.linea span {
            background: #fff;
            padding: 0 15px 0px 4px;
        }
    </style>

    <!-- CUERPO -->
    <section class="content" id="app">

        <div id="preloader">
            <div class="loading">
                <div class="circle"></div>
            </div>
        </div>

        <form id="formEmpresa" onsubmit="actualizar(event)" onkeypress="return event.keyCode != 13;">
            <div class="d-flex align-items-center">
                <div class="tab-titulo">
                    <?= $this->translate('EMPRESA') ?>
                </div>
                <div class="ms-auto d-flex align-items-center">
                    <?php
                    if (count($this->locales) > 1) { ?>
                        <div class="me-3">
                            <select class="form-select" onchange="cambiarLocal(this.value)">
                                <?php
                                foreach ($this->locales as $key => $val) { ?>
                                    <option value="<?= $val ?>" <?= $this->empresa['idemp'] == $val ? 'selected' : '' ?>>Local 0<?= $key + 1 ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>
                    <button class="btn btn-success text-white"><i class="fas fa-sync-alt"></i>&nbsp; <?= $this->translate('Actualizar datos') ?></button>
                </div>
            </div>
            <hr>
            <h5 class="linea mt-4 mb-2"><span><?= $this->translate('Datos principales') ?></span></h5>
            <div class="row px-2">
                <div class="col-sm-4 my-2">
                    <label><?= $this->translate('Nombre de la institución') ?>:</label>
                    <input type="text" class="form-control mt-1" name="nombre" value="<?php echo $this->empresa['nombre'] ?>" required>
                </div>
                <div class="col-sm-4 my-2">
                    <label><?= $this->translate('Teléfono') ?>:</label>
                    <input type="text" class="form-control mt-1" name="telefono" value="<?php echo $this->empresa['telefono'] ?>">
                </div>
                <div class="col-sm-4 my-2">
                    <label><?= $this->translate('Célular') ?>:</label>
                    <input type="text" class="form-control mt-1" name="celular" value="<?php echo $this->empresa['celular'] ?>">
                </div>
                <div class="col-sm-4 my-2">
                    <label><?= $this->translate('Dirección') ?> 01:</label>
                    <input type="text" class="form-control mt-1" name="direccion" value="<?php echo $this->empresa['direccion'] ?>">
                </div>
                <div class="col-sm-4 my-2">
                    <label><?= $this->translate('Dirección') ?> 02:</label>
                    <input type="text" class="form-control mt-1" name="direccion2" value="<?php echo $this->empresa['direccion2'] ?>">
                </div>
                <div class="col-sm-4 my-2">
                    <label><?= $this->translate('Correo') ?> 01:</label>
                    <input type="email" class="form-control mt-1" name="correo1" value="<?php echo $this->empresa['correo1'] ?>">
                </div>
                <div class="col-sm-4 my-2">
                    <label><?= $this->translate('Correo') ?> 02:</label>
                    <input type="email" class="form-control mt-1" name="correo2" value="<?php echo $this->empresa['correo2'] ?>">
                </div>
                <div class="col-sm-2 my-2">
                    <label><?= $this->translate('Año de Admisión') ?>:</label>
                    <input type="number" class="form-control mt-1" name="anio_admision" value="<?php echo $this->empresa['anio_admision'] ?>" min="0">
                </div>
            </div>
            <h5 class="linea mt-4 mb-2"><span><?= $this->translate('Redes sociales') ?></span></h5>
            <div class="row px-2">
                <div class="col-sm-4 my-2">
                    <label>Facebook:</label>
                    <input type="text" class="form-control mt-1" name="facebook" value="<?php echo $this->empresa['facebook'] ?>">
                </div>
                <div class="col-sm-4 my-2">
                    <label>Instagram:</label>
                    <input type="text" class="form-control mt-1" name="instagram" value="<?php echo $this->empresa['instagram'] ?>">
                </div>
                <div class="col-sm-4 my-2">
                    <label>Youtube:</label>
                    <input type="text" class="form-control mt-1" name="youtube" value="<?php echo $this->empresa['youtube'] ?>">
                </div>
                <div class="col-sm-4 my-2">
                    <label>Twitter:</label>
                    <input type="text" class="form-control mt-1" name="twitter" value="<?php echo $this->empresa['twitter'] ?>">
                </div>
                <div class="col-sm-4 my-2">
                    <label>Whatsapp 01:</label>
                    <input type="text" class="form-control mt-1" name="whatsapp1" value="<?php echo $this->empresa['whatsapp1'] ?>">
                </div>
                <div class="col-sm-4 my-2">
                    <label>Whatsapp 02:</label>
                    <input type="text" class="form-control mt-1" name="whatsapp2" value="<?php echo $this->empresa['whatsapp2'] ?>">
                </div>
                <div class="col-sm-4 my-2">
                    <label>Linkedin:</label>
                    <input type="text" class="form-control mt-1" name="linkedin" value="<?php echo $this->empresa['linkedin'] ?>">
                </div>
                <div class="col-sm-4 my-2">
                    <label>Tiktok:</label>
                    <input type="text" class="form-control mt-1" name="tiktok" value="<?php echo $this->empresa['tiktok'] ?>">
                </div>
                <div class="col-sm-4 my-2">
                    <label><?= $this->translate('Intranet') ?>:</label>
                    <input type="text" class="form-control mt-1" name="intranet" value="<?php echo $this->empresa['intranet'] ?>">
                </div>
            </div>
            <h5 class="linea mt-4 mb-2"><span><?= $this->translate('Libro de reclamaciones') ?></span></h5>
            <div class="row px-2">
                <div class="col-sm-4 my-2">
                    <label><?= $this->translate('Link del formulario') ?>:</label>
                    <input type="text" class="form-control mt-1" name="liblink" value="<?php echo $this->empresa['liblink'] ?>">
                </div>
                <div class="col-sm-4 my-2">
                    <label><?= $this->translate('Correo destino') ?>:</label>
                    <input type="text" class="form-control mt-1" name="libmail" value="<?php echo $this->empresa['libmail'] ?>">
                </div>
            </div>
            <h5 class="linea mt-4 mb-2"><span><?= $this->translate('Otro datos (opcionales)') ?></span></h5>
            <div class="row px-2">
                <div class="col-sm-8 my-2">
                    <label><?= $this->translate('Descripción de empresa') ?>:</label>
                    <input type="text" class="form-control mt-1" name="metades" value="<?php echo $this->empresa['metades'] ?>" maxlength="250">
                </div>
            </div>
            <input type="hidden" name="idemp" value="<?php echo $this->empresa['idemp'] ?>">
        </form>
        <br>
    </section>

    <form id="formLocal" action="/admin/empresa" method="post">
        <input type="hidden" name="idemp" id="idemp">
    </form>

    <script>
        const sweetAlert = (mensaje, icon) => {
            Swal.fire({
                icon: icon,
                text: mensaje,
            });
        }

        const cambiarLocal = (idemp) => {
            document.getElementById('idemp').value = idemp;
            document.getElementById('formLocal').submit();
        }

        const actualizar = (e) => {
            e.preventDefault();
            const form = new FormData(document.getElementById('formEmpresa'));
            fetch('/admin/empresa/actualizar', {
                method: 'POST',
                body: form
            }).then(function(res) {
                return res.text();
            }).then(function(res) {
                if (res.trim() == 'OK') {
                    sweetAlert('<?= $this->translate('Datos actualizados') ?>', 'success');
                } else {
                    sweetAlert(res, 'error');
                }
            });
        }

        setTimeout(() => {
            let loader = document.getElementById('preloader');
            loader.style.opacity = '0';
            setTimeout(() => {
                loader.style.display = 'none';
            }, 500);
        }, 2500);
    </script>

</body>

</html>