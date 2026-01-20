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

    <section class="content" id="app">

        <div id="preloader">
            <div class="loading">
                <div class="circle"></div>
            </div>
        </div>

        <div class="d-flex align-items-center">
            <div class="tab-titulo">
                <?= $this->translate('FACEBOOK FEED') ?>
            </div>
        </div>
        <hr>
        <div class="w-100">

            <?php
            if (!is_null($this->loginURl)) { ?>
                <a href="<?= $this->loginURl ?>" class="btn btn-primary btn-lg px-3">
                    <i class="fab fa-facebook-square"></i>&nbsp; <?= $this->translate('Iniciar sesión') ?>
                </a>
            <?php } else if (!is_null($this->fb_user_data)) { ?>
                <div class="row pt-2">
                    <div class="col-md">
                        <div class="card border-0 list-group-item-success">
                            <div class="card-body">
                                <div class="text-success" style="font-size: 16px;"><i class="far fa-check-circle"></i>&nbsp; Inicio de sesión completado</div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="d-flex pt-2">
                    <div class="" style="width: 280px;">
                        <div class="card bg-light shadow-sm">
                            <div class="card-header">
                                <span class="fw-bold" style="font-size: 13px;"><i class="fas fa-bars"></i>&nbsp; <?= $this->translate('DATOS DE USUARIO') ?></span>
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-3 mt-1">
                                    <img src="<?= $this->fb_user_data['fb_user_picture'] ?>" class="rounded-circle shadow-sm" width="120" height="120">
                                </div>
                                <span><?= $this->translate('Nombres') ?>:</span>
                                <input type="text" class="form-control mb-3 mt-1" value="<?= $this->fb_user_data['fb_user_first_name'] ?>" readonly>
                                <span><?= $this->translate('Primer apellido') ?>:</span>
                                <input type="text" class="form-control mb-3 mt-1" value="<?= $this->fb_user_data['fb_user_last_name'] ?>" readonly>
                                <span><?= $this->translate('Email') ?>:</span>
                                <input type="text" class="form-control mb-3 mt-1" value="<?= $this->fb_user_data['fb_user_email'] ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="row pt-2">
                    <div class="col-md">
                        <div class="card border-0 list-group-item-danger">
                            <div class="card-body">
                                <div class="text-success" style="font-size: 16px;"><i class="fas fa-ban"></i>&nbsp; Ocurrio un error</div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>


    <script>
        const sweetAlert = (mensaje, icon) => {
            Swal.fire({
                icon: icon,
                text: mensaje,
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