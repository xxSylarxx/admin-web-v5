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

    <style>
        .portada-card {
            border: none;
            box-shadow: 0 4px 16px rgb(0 0 0 / 10%);
            transition: transform .3s ease;
            border-radius: 8px;
            overflow: hidden;
        }

        .portada-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgb(0 0 0 / 15%);
        }

        .portada-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .portada-card .card-body {
            padding: 20px;
        }

        .portada-card h5 {
            color: var(--color3);
            font-weight: bold;
            margin-bottom: 10px;
        }

        .portada-card .badge-pagina {
            background: var(--color2);
            color: white;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: normal;
        }
        div.card-footer {
            background: transparent;
        }
    </style>

    <section class="content">
        <div class="d-flex align-items-center mb-3 flex-wrap gap-2">
            <div class="tab-titulo me-3 mb-2 mb-md-0">
            <?= $this->translate('PORTADAS INTERNAS') ?>
            </div>
            <div class="alert alert-info my-auto me-3 mb-2 mb-md-0" style="white-space: nowrap;">
            <i class="fas fa-info-circle"></i>
            <strong>Nota:</strong> Las imágenes deben tener un tamaño recomendado de <strong>1920x400px</strong>.
            </div>
            <div class="ms-auto mb-2 mb-md-0" hidden>
            <a href="/admin/portadas/editor" class="btn btn-success">
                <i class="fas fa-plus"></i> Nueva Portada
            </a>
            </div>
        </div>
        <hr>

        <div class="row">
            <?php foreach ($this->listPortadas as $portada) : ?>
                <div class="col-lg-4 col-md-6 mb-4" id="portada_<?= $portada['idportada'] ?>">
                    <div class="card portada-card">
                        <img src="<?= !empty($portada['imagen']) ? $portada['imagen'] : 'https://via.placeholder.com/800x400?text=' . urlencode($portada['nombre']) ?>"
                            alt="<?= $portada['nombre'] ?>">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="mb-0"><?= $portada['nombre'] ?></h5>
                                <span class="badge-pagina">/<?= $portada['pagina'] ?></span>
                            </div>
                            <p class="text-muted mb-2" style="font-size: 13px;">
                                <strong>Título:</strong> <?= $portada['titulo'] ?: 'Sin título' ?>
                            </p>
                            <p class="text-muted mb-3" style="font-size: 12px;">
                                <?= $portada['subtitulo'] ? substr($portada['subtitulo'], 0, 60) . '...' : 'Sin subtítulo' ?>
                            </p>
                        </div>
                        <div class="card-footer d-flex align-items-center" style="padding-top: 12px; padding-bottom: 12px;">
                            <button class="btn btn-outline-success me-2" onclick="location.href = '/admin/portadas/editor/<?= $portada['idportada'] ?>'" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                            <button class="btn btn-outline-danger" onclick="eliminarPortada('<?= $portada['idportada'] ?>')" title="Eliminar"><i class="far fa-trash-alt"></i></button>
                            <div class="ms-auto d-flex">
                                <label class="form-check-label me-1" style="padding-top: 1px; cursor: pointer;" for="check-<?= $portada['idportada'] ?>"><?= $this->translate('Visible') ?></label>
                                <input class="form-check-input ms-1" type="checkbox" id="check-<?= $portada['idportada'] ?>" onclick="cambiarEstado('<?= $portada['idportada'] ?>')" style="border-radius: 2px; transform: scale(1.1); cursor: pointer;" <?= $portada['estado'] == 'A' ? 'checked' : '' ?>>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (empty($this->listPortadas)) : ?>
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i>
                No hay portadas registradas. <a href="/admin/portadas/editor">Crear la primera portada</a>
            </div>
        <?php endif; ?>



    </section>

    <script>
        const eliminarPortada = (idportada) => {
            Swal.fire({
                icon: 'question',
                text: '¿Estás seguro de eliminar esta portada?',
                showDenyButton: true,
                confirmButtonText: 'Sí, eliminar',
                denyButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/portadas/eliminar/${idportada}`, {
                            method: 'GET'
                        })
                        .then(res => res.text())
                        .then(res => {
                            if (res.trim() === 'OK') {
                                document.getElementById('portada_' + idportada).remove();
                                Swal.fire({
                                    icon: 'success',
                                    text: 'Portada eliminada',
                                    timer: 2000
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    text: 'Error al eliminar'
                                });
                            }
                        });
                }
            });
        }

        const cambiarEstado = (idportada) => {
            const estado = document.getElementById('check-' + idportada).checked;
            const url = `/admin/portadas/estado/${idportada}/${estado ? 'A' : 'I'}`;

            fetch(url, {
                    method: 'GET'
                })
                .then(res => res.text())
                .then(res => {
                    if (res.trim() !== 'OK') {
                        Swal.fire({
                            icon: 'error',
                            text: 'Error al cambiar estado'
                        });
                    }
                });
        }
    </script>

</body>

</html>