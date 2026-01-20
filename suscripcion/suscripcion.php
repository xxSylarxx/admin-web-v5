<?php

include('./conbd.php');

$nombres = $_POST["nombre"];
$correo = $_POST["correo"] ;


$insertar = "INSERT INTO correos(nombres,correos) VALUES('$nombres','$correo')";
/* $conteo = "SELECT COUNT(*) FROM correos"; */

$resultado=mysqli_query($conex,$insertar);

if($resultado){
    echo "Suscripcion realizado";
}else {
    echo 'Error al suscribirte';
}



