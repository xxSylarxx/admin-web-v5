<?php

// Permitir solicitudes desde cualquier origen
header("Access-Control-Allow-Origin: *");

// Permitir los métodos GET, POST, OPTIONS
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// Permitir los encabezados de solicitud que incluyan: Content-Type, Authorization, X-Requested-With
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Permitir que las cookies se incluyan en las solicitudes
header("Access-Control-Allow-Credentials: true");

// Si la solicitud es del tipo OPTIONS, responde con un código de estado 200
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}

// Resto de tu código para establecer el idioma de la sesión
$lang = isset($_GET['set']) ? $_GET['set'] : 'ES';
session_start();
$_SESSION['lang'] = $lang;


/* Codigo BK de producion */
/*RewriteEngine on 
 RewriteBase /  
RewriteCond %{REQUEST_URI} !^/sapiens/ 
RewriteCond %{HTTP_HOST} ^(www\.)?sapiensconsultingperu\.  
RewriteRule ^(.*)$ /sapiens/$1 [L] */