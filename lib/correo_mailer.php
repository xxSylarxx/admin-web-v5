<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$mensaje = $_POST['mensaje'];


$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = false;
    $mail->isSMTP();
    $mail->Host       = 'correo.cubicol.com.pe';
    $mail->SMTPAutoTLS = false;
    $mail->SMTPSecure = false;
    $mail->Port       = 25;

    $mail->CharSet = 'UTF-8';
	$mail->Encoding = 'base64';
    if (empty($_POST['nombres']) || empty($_POST['apellidos']) || empty($_POST['correo']) || empty($_POST['telefono']) || empty($_POST['mensaje'])) {
        echo 'Por favor, completa todos los campos del formulario.';
        exit; // Detén la ejecución si falta algún campo
    }

    //Recipients
    $mail->setFrom('sjblasalle@cubicol.com.pe', 'PAG. WEB');

    $mail->FromName = 'PAG. WEB';
    $mail->addAddress('axelmol2018@gmail.com', 'COLEGIO SJB LA SALLE');
    //$mail->AddAddress('secretaria.iepsjls@gmail.com', 'COLEGIO SJB LA SALLE');
    //$mail->addCC('iepsjls@gmail.com');

    //Content
    $mail->isHTML(true);
    $mail->Subject = 'REGISTRO PARA RECIBIR NOTICIAS REFERENTE A ADMISION Y VACANTES ESCOLARES';
    $mail->Body    = '
    <h4><b>INFORMACIÓN</b></h4>
                    <p><b>Nombres : </b>' . htmlspecialchars($nombres) . '</p>
                    <p><b>Apellidos : </b>' . htmlspecialchars($apellidos) . '</p>
                    <p><b>Correo : </b>' . htmlspecialchars($correo) . '</p>
                    <p><b>Telefono : </b>' . htmlspecialchars($telefono) . '</p>
                    <p><b>Mensaje : </b>' . htmlspecialchars($mensaje) . '</p>';

                    if ($mail->Send()) {

                        echo "SE ENVIÓ LA CONSULTA CORRECTAMENTE";
                    }
                } catch (Exception $e) {
                    echo 'OCURRIÓ UN ERROR, NO SE PUDO PROCESAR EL ENVÍO';
                }
//print_r($_POST);
