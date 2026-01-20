<?php
// Conexión a la base de datos usando mysqli
$conex = mysqli_connect("localhost", "root", "", "admin_v2", "3307");

// Verificar la conexión
if (mysqli_connect_errno()) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Establecer el juego de caracteres a utf8mb4
mysqli_set_charset($conex, "utf8mb4");
?>
