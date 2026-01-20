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

    <script src="<?= PATH_PUBLIC ?>/js/jquery.min.js"></script>
    <script src="<?= PATH_PUBLIC ?>/js/jquery-ui.min.js"></script>
    <script src="<?= PATH_PUBLIC ?>/js/bootstrap.min.js"></script>
    <script async src="<?= PATH_PUBLIC ?>/js/sweetalert2.min.js"></script>

    <?php include_once PATH_ROOT . '/views/admin/header.php'; ?>
    <?php include_once PATH_ROOT . '/views/admin/menu.php'; ?>

    <!-- ESTILOS -->
    <style>
        div.gallery ul {
            margin: 0;
            padding: 0;
            list-style-type: none;
        }

        div.gallery ul li {
            float: left;
            width: auto;
            height: auto;
            display: inline;
            width: calc(100% / 3);
            padding: 0 .6%;
        }

        div.gallery div.box-img {
            position: relative;
            border: 1px solid #afb0b1;
            height: 140px;
        }

        div.gallery ul li img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            cursor: move;
            background-color: white;
        }

        div.gallery .detail {
            position: absolute;
            bottom: 0;
            width: 100%;
            line-height: 37px;
            background-color: rgba(0, 0, 0, .6);
        }

        div.gallery a {
            cursor: pointer;
            font-size: 14px;
        }

        h5.modal-title {
            font-size: 17px;
        }

        #pantallaHeight {
            display: <?= $this->dataBanner['opciones']['dimensionar'] ? 'block' : 'none' ?>
        }

        #modalFiles .file-item {
            border: 1px solid rgb(222, 222, 222);
            border-radius: 1px;
            overflow: hidden;
        }

        #modalFiles .file-item:hover {
            cursor: pointer;
        }

        #modalFiles .file-item:hover img {
            transform: scale(1.1);
        }

        #modalFiles .file-item img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 1px;
            transition: transform .2s ease-in-out;
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
                <button class="btn btn-danger text-white me-3" data-bs-toggle="modal" data-bs-target="#modalFiles"><i class="fas fa-search"></i>&nbsp; <?= $this->translate('Buscar imágenes') ?></button>
                <button class="btn btn-success text-white" onclick="actualizar()"><i class="fas fa-save"></i>&nbsp; <?= $this->translate('Guardar cambios') ?></button>
            </div>
        </div>
        <hr>
        <div class="d-flex pt-2">
            <div class="" style="width: 280px;">
                <div class="card bg-light shadow-sm">
                    <div class="card-header">
                        <span class="fw-bold" style="font-size: 13px;"><i class="fas fa-bars"></i>&nbsp; <?= $this->translate('OPCIONES') ?></span>
                    </div>
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="check1" <?php echo $this->dataBanner['opciones']['fade'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="check1"> &nbsp;<?= $this->translate('Animación fade') ?></label>
                        </div>
                        <hr>
                        <div class="d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="check2" onchange="ajustarPantalla()" <?php echo $this->dataBanner['opciones']['dimensionar'] ? 'checked' : '' ?>>
                                <label class="form-check-label" for="check2"> &nbsp;<?= $this->translate('Ajustar a pantalla') ?></label>
                            </div>
                            <div class="ms-auto"><input type="number" class="form-control form-control-sm" id="pantallaHeight" value="<?= $this->dataBanner['opciones']['height'] ?>" min="65" max="100" onkeypress='return event.charCode >= 48 && event.charCode <= 57'></div>
                        </div>
                        <hr>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="check3" <?php echo $this->dataBanner['opciones']['indicadores'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="check3"> &nbsp;<?= $this->translate('Mostrar indicadores') ?></label>
                        </div>
                        <hr>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="check4" <?php echo $this->dataBanner['opciones']['flechas'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="check4"> &nbsp;<?= $this->translate('Mostrar flechas') ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ps-4" style="width: calc(100% - 280px);">
                <div class="gallery">
                    <ul class="reorder_ul reorder-photos-list" id="list-items"></ul>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalFiles" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?= $this->translate('Seleccionar imagen') ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row px-2">
                            <?php
                            foreach ($this->listArchivos as $file) : ?>
                                <div class="col-sm-3 pb-1 p-1">
                                    <div class="file-item">
                                        <img src="<?= $file['path'] ?>" title="<?= $file['name'] ?>" onclick="agregarImagen(this.src)">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="modal-footer d-flex align-items-center">
                        <a href="javascript:void(0)" onclick="agregarImagen(null, true)"><i class="fas fa-link"></i>&nbsp; <?= $this->translate("Insertar imagen vía link") ?></a>
                        <span class="ms-auto">Resultados <?= count($this->listArchivos) . ' de ' . count($this->listArchivos) ?></span>
                    </div>
                </div>
            </div>
        </div>

    </section>


    <script>
        let listItems = JSON.parse('<?= $this->dataBanner['cuerpo'] ?>');

        $("ul.reorder-photos-list").sortable();

        const sweetAlert = (mensaje, icon) => {
            Swal.fire({
                icon: icon,
                text: mensaje,
            });
        }

        const cambiarTipo = (tipo) => {
            location.href = '/admin/banner/' + tipo;
        }

        const ajustarPantalla = () => {
            const valor = document.getElementById("check2").checked;
            document.getElementById('pantallaHeight').style.display = valor ? 'block' : 'none';
        }

        const listarImagenes = () => {
            let html = "";
            listItems.forEach((element, index) => {
                html += `<li id="item_${index}" class="ui-sortable-handle mb-3">
                    <div class="box-img">
                        <div class="detail d-flex justify-content-end align-items-center px-2">
                            <a class="me-2 text-white" onclick="TituloImagen(${index})" title="Agregar Titulo"><i class="fas fa-pen"></i> Título</a>
                            <a class="me-2 text-white" onclick="DetalleImagen(${index})" title="Agregar Detalle"><i class="far fa-file-alt"></i>&nbsp;Detalle</a>
                            <a class="me-2 text-white" onclick="enlaceImagen(${index})" title="Agregar enlace"><i class="fas fa-link"></i> Enlace</a>
                            <a class="ms-1 text-white" onclick="eliminarImagen(${index})" title="Eliminar"><i class="far fa-trash-alt"></i> Eliminar</a>
                        </div>
                        <img src="${element.imagen}" width="100%">
                    </div>
                </li>`;
            });
            $("#list-items").html(html);
        }

        const agregarImagen = (src, isLink = false) => {
            if (isLink) {
                src = prompt('Ingrese link de una imagen', '');
                if (src.length == 0) {
                    sweetAlert('Debe ingresar el link de la imagen', 'error');
                    return;
                }
            }
            listItems.push({
                imagen: src,
                enlace: null,
                titulo: null,
                detalle: null
            });
            listarImagenes();
            $('#modalFiles').modal('hide');
        }

        const eliminarImagen = (index) => {
            listItems.splice(index, 1);
            listarImagenes();
        }

        const TituloImagen = (index) => {
            Swal.fire({
                text: 'Ingresa el titulo de la portada',
                input: 'text',
                inputValue: listItems[index].titulo,
                confirmButtonText: 'Aceptar',
            }).then((result) => {
                if (result.isConfirmed) {
                    listItems[index].titulo = result.value;
                }
            });
        }
        const DetalleImagen = (index) => {
            Swal.fire({
                text: 'Ingresa el detalle de la portada',
                input: 'textarea',
                inputValue: listItems[index].detalle,
                confirmButtonText: 'Aceptar',
            }).then((result) => {
                if (result.isConfirmed) {
                    listItems[index].detalle = result.value.replace(/\n/g, '<br>');//para permitir saltos de línea y no causar error
                }
            });
        }
        const enlaceImagen = (index) => {
            Swal.fire({
                text: 'Ingresa el enlace a direccionar',
                input: 'text',
                inputValue: listItems[index].enlace,
                confirmButtonText: 'Aceptar',
            }).then((result) => {
                if (result.isConfirmed) {
                    listItems[index].enlace = result.value;
                }
            });
        }

        const actualizar = () => {

            let pantallaHeight = document.getElementById('pantallaHeight');

            if (listItems.length < 1) {
                sweetAlert("<?= $this->translate('Debes agregar mínimo una imagen para continuar.'); ?>", "warning");
                return;
            }

            if (pantallaHeight.value > 100 || pantallaHeight.value <= 65) {
                sweetAlert('<?= $this->translate("El rango permitido es de 65 a 100%") ?>', 'warning');
                pantallaHeight.focus();
                return;
            }

            let itemsAux = [];
            $("ul.reorder-photos-list li").each(
                function() {
                    let id = $(this).attr('id').substr(5);
                    itemsAux.push({
                        imagen: listItems[id].imagen,
                        enlace: listItems[id].enlace,
                        titulo: listItems[id].titulo,
                        detalle: listItems[id].detalle
                    });
                }
            );

            const opciones = {
                fade: document.getElementById("check1").checked,
                dimensionar: document.getElementById("check2").checked,
                height: pantallaHeight.value,
                indicadores: document.getElementById("check3").checked,
                flechas: document.getElementById("check4").checked
            }

            const data = new FormData();
            data.append("tipo", "<?= $this->tipo ?>");
            data.append("cuerpo", JSON.stringify(itemsAux));
            data.append('opciones', JSON.stringify(opciones));
            fetch("/admin/banner/actualizar", {
                method: "POST",
                body: data
            }).then(function(res) {
                return res.text()
            }).then(function(res) {
                if (res.trim() == "OK") {
                    sweetAlert("<?= $this->translate('Cambios guardados correctamente'); ?>", "success");
                } else {
                    sweetAlert(res, "error");
                }
            });
        }

        listarImagenes();

        setTimeout(() => {
            let loader = document.getElementById('preloader');
            loader.style.opacity = '0';
            setTimeout(() => {
                loader.style.display = 'none';
            }, 500);
        }, 2100);
    </script>

</body>

</html>