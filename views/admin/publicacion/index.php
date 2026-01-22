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
        div.crop img {
            width: 100%;
            height: 210px;
            object-fit: cover;
        }

        div.card {
            background-color: rgb(247, 247, 247);
        }

        div.card-footer {
            background: transparent;
        }

        h6.pub-categoria {
            color: var(--color3);
            font-size: 14px;
            text-transform: uppercase;
        }

        a.pub-titulo {
            font-size: 15px;
            max-height: 70px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        p.pub-fecha {
            font-size: 14.5px;
            margin-bottom: 0px;
            color: rgb(80, 80, 80);
        }

        div.card-footer button.btn {
            min-width: 33px;
            min-height: 33px;
            width: 33px;
            height: 33px;
            padding: 0px;
        }

        div.card-footer button.btn:hover {
            color: white;
        }

        div.grid-pub {
            width: 100%;
            display: inline-flex;
            flex-wrap: wrap;
        }

        div.grid-pub div.pub-card {
            width: calc(100% / 4);
        }

        .pub-card .card {
            overflow: hidden;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 16px rgb(0 0 0 / 10%);
            transition: transform .3s ease;
            background: transparent;
        }

        .pub-card .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgb(0 0 0 / 15%);
        }


        @media only screen and (max-width: 1560px) {
            div.grid-pub div.pub-card {
                width: calc(100% / 3);
            }
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
                <?= $this->translate('PUBLICACIONES') ?>
            </div>
            <div class="ms-auto d-flex align-items-center">
                <?php if (count($this->listCategorias) > 1) : ?>
                    <div><?= $this->translate('Categoría') ?> :</div>
                    <div class="ms-2 me-3">
                        <?php if (PUB_SUB_CATEG) { ?>
                            <select class="form-select" onchange="cambiarCategoria(this.value)">
                                <option value="all"><?= $this->translate('Todas') ?></option>
                                <?php foreach ($this->listCategorias as $key => $categ) : ?>
                                    <optgroup label="<?= $categ['nombre'] ?>">
                                        <?php foreach ($categ['subs'] as $key => $sub) : ?>
                                            <option value="<?= $sub['idcatg'] ?>" <?= $this->categoriaId == $key ? 'selected' : '' ?>><?= $sub['nombre'] ?></option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                <?php endforeach; ?>
                            </select>
                        <?php } else { ?>
                            <select class="form-select" onchange="cambiarCategoria(this.value)">
                                <option value="all"><?= $this->translate('Todas') ?></option>
                                <?php foreach ($this->listCategorias as $key => $categ) :
                                    if ($categ['estado'] == 'I') {
                                        continue;
                                    }
                                ?>
                                    <option value="<?= $categ['idcatg'] ?>" <?= $this->categoriaId == $key ? 'selected' : '' ?>><?= $categ['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php } ?>
                    </div>
                <?php endif; ?>

                <button class="btn btn-danger me-3" data-bs-toggle="modal" data-bs-target="#modalCategorias"><i class="far fa-list-alt"></i>&nbsp; Ver categorías</button>
                <a href="/admin/publicacion/editor" class="btn btn-success text-white"><i class="fas fa-plus"></i>&nbsp; <?= $this->translate('Nueva publicación') ?></a>
            </div>
        </div>
        <hr>
        <?php if (empty($this->listPublicaciones)) { ?>
            <div class="text-center pt-3">
                <h5 class="text-muted">No se encontraron resultados</h5>
            </div>
        <?php } ?>
        <div class="grid-pub">
            <?php
            foreach ($this->listPublicaciones as $key => $pub) : ?>
                <div class="pub-card my-2 px-2 py-1" id="pub_<?= $pub['idpub'] ?>">
                    <div class="card h-100">
                        <div class="crop">
                            <?php if (!empty($pub['portada'])) { ?>
                                <img src="<?= $pub['portada'] ?>" onerror="this.src = `/public/img/icons/portada-default.png`">
                            <?php } else { ?>
                                <div class="d-flex justify-content-center"><img src="/public/img/icons/escudo.png" style="width: 50%;display:block;" alt="Sin portada"></div>
                            <?php } ?>
                            <!-- <img src="<//?= $pub['portada'] ?>" onerror="this.src = `/public/img/icons/portada-default.png`"> -->
                        </div>
                        <div class="card-body py-3">
                            <h6 class="pub-categoria text-uppercase fw-bold"><?= $pub['categoria'] ?></h6>
                            <a href="/pub/<?= $pub['tagname'] ?>" class="pub-titulo text-uppercase" target="_blank"><?= $pub['titulo'] ?></a>
                            <p class="pub-fecha mt-2"><i class="far fa-calendar-alt"></i> <?= \Admin\Core\Funciones::obtenerFecha($pub['fecpub']) ?>&nbsp;&nbsp; <i class="far fa-clock"></i> <?= \Admin\Core\Funciones::obtenerHora($pub['fecpub']) ?></p>
                        </div>
                        <div class="card-footer d-flex align-items-center" style="padding-top: 12px; padding-bottom: 12px;">
                            <button class="btn btn-outline-success me-2" onclick="location.href = '/admin/publicacion/editor/<?= $pub['idpub'] ?>'" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                            <button class="btn btn-outline-danger" onclick="eliminarPub('<?= $pub['idpub'] ?>')" title="Eliminar"><i class="far fa-trash-alt"></i></button>
                            <div class="ms-auto d-flex">
                                <label class="form-check-label me-1" style="padding-top: 1px; cursor: pointer;" for="check-<?= $pub['idpub'] ?>"><?= $this->translate('Visible') ?></label>
                                <input class="form-check-input ms-1" type="checkbox" id="check-<?= $pub['idpub'] ?>" onclick="cambiarEstado('<?= $pub['idpub'] ?>')" style="border-radius: 2px; transform: scale(1.1); cursor: pointer;" <?= $pub['visible'] == 'S' ? 'checked' : '' ?>>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;
            ?>
        </div>
        <hr>
        <div class="row pb-4 align-items-center">
            <div class="col-sm-2" style="margin-top: -5px;">
                Total de publicaciones : &nbsp; <span id="totalPub"><?= $this->totalPublicaciones ?></span>
            </div>
            <div class="col-sm">
                <ul class="pagination justify-content-end mb-0">
                    <?php echo count($this->listPublicaciones) > 0 ? $this->listPagination : null ?>
                </ul>
            </div>
        </div>

        <div class="modal fade" id="modalCategorias" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Categorías de Publicaciones</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- <div class="input-group w-50 mb-4 mt-3 mx-auto">
                            <input type="text" class="form-control" id="txtcategoria" placeholder="Nombre de categoría">
                            <span class="btn btn-success text-white" onclick="actionCategoria('save')"><i class="fas fa-plus"></i>&nbsp; Agregar</span>
                        </div> -->
                        <table class="table">
                            <thead style="font-size: 13px;">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>NOMBRE</th>
                                    <th class="text-center">TOTAL</th>
                                    <th class="text-center">FECHA DE REGISTRO</th>
                                    <th>ACTIVO</th>
                                </tr>
                            </thead>
                            <tbody style="border-top: none;">
                                <?php foreach ($this->listCategorias as $key => $categ) { ?>
                                    <tr>
                                        <td class="text-center"><?= $categ['idcatg'] ?></td>
                                        <td><?= $categ['nombre'] ?></td>
                                        <td class="text-center"><?= $categ['totalPub'] ?></td>
                                        <td class="text-center"><?= $categ['fecreg'] ?></td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" id="catcheck-<?= $categ['idcatg'] ?>" onchange="actionCategoria('estado', <?= $categ['idcatg'] ?>)" <?= $categ['estado'] == 'A' ? 'checked' : '' ?>>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        let totalPub = parseInt('<?= $this->totalPublicaciones ?>');

        const sweetAlert = (mensaje, icon) => {
            Swal.fire({
                icon: icon,
                text: mensaje,
            });
        }

        const eliminarPub = (idpub) => {
            Swal.fire({
                icon: 'question',
                text: '¿Está seguro de eliminar esta publicación?',
                showDenyButton: true,
                allowOutsideClick: false,
                confirmButtonText: 'Aceptar',
                denyButtonText: 'Cancelar',
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const url = `/admin/publicacion/eliminar/${idpub}`;
                    fetch(url, {
                        method: 'GET'
                    }).then(function(res) {
                        return res.text();
                    }).then(function(res) {
                        if (res.trim() == 'OK') {
                            document.getElementById('pub_' + idpub).remove();
                            totalPub -= 1;
                            document.getElementById('totalPub').innerText = totalPub;
                            sweetAlert('Publicación eliminada', 'success');
                        } else {
                            sweetAlert(res, 'error');
                        }
                    });
                }
            });
        }

        const cambiarEstado = (idpub) => {
            const estado = document.getElementById('check-' + idpub).checked;
            const url = `/admin/publicacion/estado/${idpub}/${estado ? 'S' : 'N'}`;
            fetch(url, {
                method: 'GET'
            }).then(function(res) {
                return res.text();
            }).then(function(res) {
                if (res.trim() !== 'OK') {
                    sweetAlert(res, 'error');
                }
            });
        }

        const actionCategoria = (action, idcateg = null) => {
            let url = '/admin/publicacion/categoria';
            if (action == 'save') {
                const name = document.getElementById('txtcategoria').value;
                if (name == '') return;
                url += '/save/' + name;
            } else if (action == 'estado') {
                const estado = document.getElementById('catcheck-' + idcateg).checked;
                url += `/${idcateg}/${estado ? 'A' : 'I'}`;
            }
            console.log(url);
            fetch(url, {
                method: 'GET'
            }).then(function(res) {
                return res.text();
            }).then(function(res) {
                if (res.trim() == 'OK') {
                    if (action == 'save') {
                        location.reload();
                    }
                } else {
                    alert(res);
                }
            });
        }

        const cambiarCategoria = (value) => {
            location.href = '/admin/publicacion/' + value;
        }

        setTimeout(() => {
            let loader = document.getElementById('preloader');
            loader.style.opacity = '0';
            setTimeout(() => {
                loader.style.display = 'none';
            }, 500);
        }, 2000);
    </script>

</body>

</html>