<?php

use Admin\Core\Controller;
use Admin\Core\View;
use Admin\Models\SuscripcionesModel;

class Suscripciones extends Controller
{
    function __construct()
    {
        parent::sesionActiva();
    }

    public function index()
    {
        $objSuscripciones = new SuscripcionesModel();
        $listSuscripciones = $objSuscripciones->listarSuscripciones();
        $totalSuscripciones = $objSuscripciones->totalSuscripciones();
        $view = new View();
        $view->setName(__CLASS__);
        $view->setVariable('listSuscripciones', $listSuscripciones);
        $view->setVariable('totalSuscripciones', $totalSuscripciones);
        $view->render("suscripciones/index");
    }

    public function excel()
    {
        $fechaDesde = parent::getPost('fechaDesde');
        $fechaHasta = parent::getPost('fechaHasta');
        $formato = parent::getPost('formato') ?? 'xlsx';
        
        $view = new View();
        $view->setVariable('fechaDesde', $fechaDesde);
        $view->setVariable('fechaHasta', $fechaHasta);
        $view->setVariable('formato', $formato);
        $view->render("suscripciones/excel");
    }

    public function pdf()
    {
        $fechaDesde = parent::getPost('fechaDesde');
        $fechaHasta = parent::getPost('fechaHasta');
        
        $view = new View();
        $view->setVariable('fechaDesde', $fechaDesde);
        $view->setVariable('fechaHasta', $fechaHasta);
        $view->render("suscripciones/pdf");
    }

    public function guardar()
    {
        if (parent::isPost()) {
            // Obtener y sanitizar datos
            $nombre = trim(parent::getPost('nombre_completo'));
            $email = trim(parent::getPost('email'));

            // Validaciones del lado del servidor
            if (empty($nombre) || empty($email)) {
                die('Error: Todos los campos son obligatorios');
            }

            // Validar longitud
            if (strlen($nombre) < 3 || strlen($nombre) > 100) {
                die('Error: El nombre debe tener entre 3 y 100 caracteres');
            }

            if (strlen($email) > 100) {
                die('Error: El email es demasiado largo');
            }

            // Validar formato de email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                die('Error: Formato de correo electrónico inválido');
            }

            // Sanitizar nombre (solo letras, espacios y caracteres acentuados)
            $nombre = preg_replace('/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/', '', $nombre);

            // Obtener IP del usuario
            $ip = $_SERVER['REMOTE_ADDR'] ?? null;

            // Preparar datos para insertar
            $datos = [
                'nombre_completo' => $nombre,
                'email' => strtolower($email),
                'fecha_suscripcion' => date('Y-m-d H:i:s'),
                'estado' => 'activo',
                'ip_registro' => $ip
            ];

            $objSuscripciones = new SuscripcionesModel();
            
            // Verificar si el email ya existe
            if ($objSuscripciones->emailExiste($email)) {
                die('Este correo ya está registrado en nuestra lista de suscripciones');
            }

            $resp = $objSuscripciones->registrarSuscripcion($datos);
            
            if ($resp) {
                echo 'OK';
            } else {
                die('Error: No se pudo completar el registro');
            }
        } else {
            die('Error: Método no permitido');
        }
    }

    public function eliminar()
    {
        if (parent::isPost()) {
            $idsuscripcion = parent::getPost('idsuscripcion');
            if (!is_null($idsuscripcion)) {
                $objSuscripciones = new SuscripcionesModel();
                $resp = $objSuscripciones->eliminarSuscripcion($idsuscripcion);
                if ($resp) {
                    echo 'OK';
                } else {
                    die('Error, no se pudo eliminar la suscripción');
                }
            } else {
                die('Error, ID de suscripción no proporcionado');
            }
        } else {
            die('Error, la solicitud no pudo ser procesada');
        }
    }
}
