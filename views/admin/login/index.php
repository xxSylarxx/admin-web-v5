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

    <style>
        html {
            height: 100%;
        }

        body {
            background: var(--color1);
            height: 100%;
        }

        div.card-login {
            width: 340px;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -52%);
            background-color: white;
            padding: 2em 2.3em;
            border-radius: 8px;
        }
    </style>

    <div class="card card-login">
        <div class="text-center">
            <img src="/public/img/icons/escudo.png" height="90">
            <h4 class="fw-bold my-3">Web Admin</h4>
        </div>
        <form id="formLogin" onsubmit="verifyUsuario(event)">
            <label>Usuario</label>
            <input type="text" class="form-control mt-1 mb-3" name="nombre" value="admin" autocomplete="off" required>
            <label>Contraseña</label>
            <input type="password" class="form-control mt-1 mb-4" name="pass" value="admin" required>
            <button class="btn btn-primary w-100" type="submit">Ingresar <i class="fas fa-sign-in-alt"></i></button>
        </form>
    </div>

    <section class="fixed-bottom text-center pb-3">
        <span style="color: rgba(255, 255, 255, .5);">AdminWeb. 4.5</span>
    </section>

    <script>
        const sweetAlert = (mensaje, icon) => {
            Swal.fire({
                icon: icon,
                text: mensaje,
            });
        }

        const verifyUsuario = (e) => {
            e.preventDefault();
            const data = new FormData(document.getElementById('formLogin'));
            fetch('/admin/login/auth', {
                method: 'POST',
                body: data,
                headers: new Headers({
                    'Access-Control-Allow-Origin': '*',
                    'Acces-Control-Allow-Methods': 'GET,POST'
                })
            }).then(function(res) {
                return res.text();
            }).then(function(res) {
                if (res.trim() == 'OK')
                    location.href = '/admin/empresa';
                else
                    sweetAlert(res, "warning");
            }).catch(error => sweetAlert(res, "error"));
        }
    </script>
</body>

</html>