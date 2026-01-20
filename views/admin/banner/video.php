<!-- <//?php
var_dump($this->dataBanner);
die();
?> -->
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

    <script src="<?= PATH_PUBLIC ?>/js/bootstrap.min.js"></script>
    <script async src="<?= PATH_PUBLIC ?>/js/sweetalert2.min.js"></script>

    <?php include_once PATH_ROOT . '/views/admin/header.php'; ?>
    <?php include_once PATH_ROOT . '/views/admin/menu.php'; ?>

    <!-- ESTILOS -->
    <style>
        #link-youtube {
            display: <?php echo $this->dataBanner['opciones']['youtube'] ? 'block' : 'none' ?>;
        }

        #btn-buscar {
            display: <?php echo $this->dataBanner['opciones']['youtube'] ? 'none' : 'block' ?>;
        }

        input.form-check-input {
            transform: scale(1.05);
        }

        .responsive {
            position: relative;
            height: 0;
            overflow: hidden;
            padding-bottom: 56.2%;
            margin-bottom: 20px;
        }

        .responsive iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        h5.modal-title {
            font-size: 17px;
        }

        div.file-item {
            display: flex;
            flex-direction: row;
            align-items: center;
            border: 1px solid rgb(140, 140, 140);
            white-space: nowrap;
            padding: .6em .9em;
            border-radius: 3px;
        }

        div.file-item:hover {
            color: var(--color3);
            border: 1px solid var(--color3);
            cursor: pointer;
        }

        div.file-item-detalle {
            margin-left: 12px;
            max-width: 100%;
            text-overflow: ellipsis;
            overflow: hidden;
        }
    </style>

    <!-- CUERPO -->
    <section class="content" id="app">

        <div id="preloader">
            <div class="loading">
                <div class="circle"></div>
            </div>
        </div>

        <div class="d-flex align-items-center">
            <div class="tab-titulo">
                <?= $this->translate('BANNER') ?>
            </div>
            <div class="ms-auto d-flex align-items-center">
                <div class="me-3">
                    <select class="form-select" onchange="cambiarTipo(this.value)">
                        <option value="slider" <?php echo $this->tipo == 'slider' ? 'selected' : '' ?>><?= $this->translate('Banner slider') ?></option>
                        <option value="video" <?php echo $this->tipo == 'video' ? 'selected' : '' ?>><?= $this->translate('Banner video') ?></option>
                    </select>
                </div>
                <button class="btn btn-danger text-white me-3" id="btn-buscar" data-bs-toggle="modal" data-bs-target="#modalFiles"><i class="fas fa-search"></i>&nbsp; <?= $this->translate('Buscar videos') ?></button>
                <button class="btn btn-success text-white" onclick="actualizarvideo()"><i class="fas fa-save"></i>&nbsp; <?= $this->translate('Guardar cambios') ?></button>
            </div>
        </div>
        <hr>
        <div class="d-flex pt-2">
            <div style="width: 280px;">
                <div class="card bg-light shadow-sm">
                    <div class="card-header">
                        <span class="fw-bold" style="font-size: 13px;"><i class="fas fa-bars"></i>&nbsp; <?= $this->translate('OPCIONES') ?></span>
                    </div>
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="check1" <?php echo $this->dataBanner['opciones']['controls'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="check1"> &nbsp;<?= $this->translate('Controles') ?></label>
                        </div>
                        <hr>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="check2" <?php echo $this->dataBanner['opciones']['autoplay'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="check2"> &nbsp;<?= $this->translate('Automático') ?></label>
                        </div>
                        <hr>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="check3" <?php echo $this->dataBanner['opciones']['muted'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="check3"> &nbsp;<?= $this->translate('Muteado') ?></label>
                        </div>
                        <hr>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="check4" <?php echo $this->dataBanner['opciones']['dimensionar'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="check4"> &nbsp;<?= $this->translate('Ajustar a pantalla') ?></label>
                        </div>
                        <hr>
                        <div class="form-check">
                            <input class="form-check-input" onchange="mostrarInput()" type="checkbox" id="check5" <?php echo $this->dataBanner['opciones']['youtube'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="check5"> &nbsp;<?= $this->translate('Insertar de Youtube') ?></label>
                        </div>
                        <input type="text" class="form-control mt-2" id="link-youtube" value="<?= $this->dataBanner['cuerpo'] ?>" placeholder="<?= $this->translate("Link video de youtube") ?>" onchange="modoYoutube(this.value)">
                    </div>
                </div>
            </div>
            <div id="video-body" class="ps-4" style="width: calc(100% - 280px);">
                <?php
                if ($this->dataBanner['opciones']['youtube']) { ?>
                    <div class="responsive" id="video-youtube"><iframe src="<?php echo $this->dataBanner['cuerpo'] ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                <?php } else { ?>
                    <video src="<?php echo $this->dataBanner['cuerpo'] ?>" id="video-src" width="100%" controls></video>
                <?php } ?>
            </div>
        </div>

        <div class="modal fade" id="modalFiles" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?= $this->translate('Seleccionar video') ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row px-2">
                            <?php
                            foreach ($this->listArchivos as $file) : ?>
                                <div class="col-sm-3" style="padding: 6px;">
                                    <div class="file-item" onclick="selectVideo('<?= $file['path'] ?>')">
                                        <i class="fas fa-film fs-3"></i>
                                        <div class="file-item-detalle" title="<?= $file['name'] ?>">
                                            <div><?= $file['name'] ?></div>
                                            <div style="font-size: 13px;"><?= $file['size'] ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="modal-footer d-flex align-items-center">
                        <span class="ms-auto">Resultados <?= count($this->listArchivos) . ' de ' . count($this->listArchivos) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script>
        let modal = new bootstrap.Modal(document.getElementById('modalFiles'));
        let path_video = `<?php echo $this->dataBanner['cuerpo'] ?>`;

        const sweetAlert = (mensaje, icon) => {
            Swal.fire({
                icon: icon,
                text: mensaje,
            });
        }

        const cambiarTipo = (tipo) => {
            location.href = '/admin/banner/' + tipo;
        }

        const selectVideo = (src) => {
            path_video = src;
            document.getElementById('video-src').setAttribute('src', src);
            modal.hide();
        }

        const mostrarInput = () => {
            let value = document.getElementById("check5").checked;
            document.getElementById('link-youtube').value = '';
            document.getElementById('link-youtube').style.display = value ? 'block' : 'none';
            document.getElementById('btn-buscar').style.display = !value ? 'block' : 'none';
        }

        const modoYoutube = (src) => {
            let videoId = src.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
            if (videoId != null) {
                let embed = `https://www.youtube.com/embed/${videoId[1]}`;
                path_video = embed;
                let iframe = `<div class="responsive"><iframe src="${embed}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>`;
                document.getElementById('video-body').innerHTML = iframe;
            } else {
                sweetAlert('<?= $this->translate("Enlace no válido") ?>', 'warning');
            }
        }

        const actualizarvideo = () => {
            const opciones = {
                controls: document.getElementById("check1").checked,
                autoplay: document.getElementById("check2").checked,
                muted: document.getElementById("check3").checked,
                dimensionar: document.getElementById("check4").checked,
                youtube: document.getElementById("check5").checked
            }
            const data = new FormData();
            data.append('tipo', 'video');
            data.append('cuerpo', path_video);
            data.append('opciones', JSON.stringify(opciones));
            fetch('/admin/banner/actualizarvideo', {
                method: 'POST',
                body: data
            }).then(function(res) {
                return res.text();
            }).then(function(res) {
                if (res.trim('OK')) {
                    sweetAlert('<?= $this->translate("Banner actualizado") ?>', 'success');
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