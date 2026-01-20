<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex" />
    <title>404 NOT FOUND</title>
    <link rel="shortcut icon" href="<?= PATH_PUBLIC ?>/img/icons/escudo.png" type="image/png">
    <link rel="stylesheet" href="<?= PATH_PUBLIC ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= PATH_PUBLIC ?>/css/admin.css">
</head>

<body>

    <style>
        html {
            height: 100%;
        }

        body {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:svgjs='http://svgjs.com/svgjs' width='2400' height='1600' preserveAspectRatio='none' viewBox='0 0 2400 1600'%3e%3cg mask='url(%26quot%3b%23SvgjsMask1118%26quot%3b)' fill='none'%3e%3crect width='2400' height='1600' x='0' y='0' fill='rgba(242%2c 243%2c 245%2c 1)'%3e%3c/rect%3e%3cpath d='M0%2c890.29C173.01%2c884.825%2c363.674%2c882.611%2c494.034%2c768.732C620.9%2c657.906%2c589.361%2c453.943%2c669.262%2c305.642C757.55%2c141.772%2c982.931%2c44.589%2c984.465%2c-141.545C985.981%2c-325.565%2c812.294%2c-461.966%2c676.611%2c-586.287C552.429%2c-700.071%2c395.388%2c-753.968%2c241.46%2c-822.336C62.418%2c-901.859%2c-108.463%2c-1063.472%2c-299.443%2c-1019.809C-490.337%2c-976.166%2c-619.646%2c-785.332%2c-700.496%2c-606.983C-771.346%2c-450.692%2c-705.164%2c-274.131%2c-715.136%2c-102.821C-724.031%2c49.985%2c-789.109%2c195.795%2c-755.925%2c345.22C-717.909%2c516.403%2c-656.741%2c698.029%2c-514.507%2c800.589C-370.38%2c904.514%2c-177.599%2c895.9%2c0%2c890.29' fill='%23e4e6ea'%3e%3c/path%3e%3cpath d='M2400 2587.84C2580.642 2565.989 2708.92 2417.122 2864.639 2322.992 3025.733 2225.6130000000003 3227.526 2182.444 3330.895 2025.126 3440.0370000000003 1859.021 3500.0969999999998 1639.512 3437.733 1450.797 3376.777 1266.345 3150.573 1206.171 3014.4539999999997 1067.5720000000001 2889.758 940.604 2836.206 741.657 2672.574 671.697 2503.676 599.485 2303.346 621.966 2133.009 690.713 1970.425 756.331 1869.748 908.549 1755.723 1041.731 1642.403 1174.09 1520.9560000000001 1299.809 1469.106 1466.158 1411.394 1651.312 1374.439 1855.4279999999999 1445.9009999999998 2035.722 1518.615 2219.177 1686.229 2346.035 1857.0320000000002 2444.875 2022.371 2540.553 2210.355 2610.7799999999997 2400 2587.84' fill='white'%3e%3c/path%3e%3c/g%3e%3cdefs%3e%3cmask id='SvgjsMask1118'%3e%3crect width='2400' height='1600' fill='white'%3e%3c/rect%3e%3c/mask%3e%3c/defs%3e%3c/svg%3e");
            background-size: 100% 100%;
            height: 100%;
        }

        .content {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -55%);
            width: 480px;
        }

        div.img-404 {
            width: 120px;
            height: 120px;
            background-image: url('<?= PATH_PUBLIC ?>/img/icons/404.png');
            background-size: 100% 100%;
            background-repeat: no-repeat;
        }

        p,
        a {
            font-size: 17px;
        }
    </style>

    <div class="content">
        <div class="img-404 mx-auto mb-3"></div>
        <div class="text-center">
            <h1 class="display-1 fw-bold mb-3">404</h1>
            <p>Lo sentimos, pero la página que busca no existe, ha sido eliminada. el nombre cambió o no está disponible temporalmente</p>
            <a class="text-primary" style="cursor: pointer;" onclick="history.back();">Back to homepage</a>
        </div>
    </div>

</body>

</html>