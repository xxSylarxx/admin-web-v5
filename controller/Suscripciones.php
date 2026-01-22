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
        $ids = parent::getPost('ids'); // IDs separados por coma
        $formato = parent::getPost('formato') ?? 'xlsx';
        
        $view = new View();
        $view->setVariable('ids', $ids);
        $view->setVariable('formato', $formato);
        $view->render("suscripciones/excel");
    }

    public function pdf()
    {
        $ids = parent::getPost('ids'); // IDs separados por coma
        
        $view = new View();
        $view->setVariable('ids', $ids);
        $view->render("suscripciones/pdf");
    }

    public function guardar()
    {
        if (parent::isPost()) {
            // Obtener y sanitizar datos nuevos
            $nombres = trim(parent::getPost('nombres'));
            $apellidos = trim(parent::getPost('apellidos'));
            $correo = trim(parent::getPost('correo'));
            $nivel = trim(parent::getPost('nivel'));
            $grado = trim(parent::getPost('grado'));
            $consulta = trim(parent::getPost('consulta'));
            $asunto = trim(parent::getPost('asunto')) ?: 'informes';

            // Validaciones del lado del servidor
            if (empty($nombres) || empty($apellidos) || empty($correo) || empty($nivel) || empty($grado) || empty($consulta)) {
                die('Error: Todos los campos son obligatorios');
            }

            // Validar longitud
            if (strlen($nombres) < 2 || strlen($nombres) > 50) {
                die('Error: Los nombres deben tener entre 2 y 50 caracteres');
            }

            if (strlen($apellidos) < 2 || strlen($apellidos) > 50) {
                die('Error: Los apellidos deben tener entre 2 y 50 caracteres');
            }

            if (strlen($correo) > 100) {
                die('Error: El correo es demasiado largo');
            }

            if (strlen($consulta) < 10 || strlen($consulta) > 500) {
                die('Error: La consulta debe tener entre 10 y 500 caracteres');
            }

            // Validar formato de email
            if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                die('Error: Formato de correo electrónico inválido');
            }

            // Sanitizar nombres y apellidos (solo letras, espacios y caracteres acentuados)
            $nombres = preg_replace('/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/', '', $nombres);
            $apellidos = preg_replace('/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/', '', $apellidos);

            // Obtener IP del usuario
            $ip = $_SERVER['REMOTE_ADDR'] ?? null;

            // Preparar datos para insertar con los nuevos campos
            // También llenar campos antiguos para compatibilidad
            $datos = [
                'nombres' => $nombres,
                'apellidos' => $apellidos,
                'correo' => strtolower($correo),
                'nivel' => $nivel,
                'grado' => $grado,
                'consulta' => $consulta,
                'asunto' => $asunto,
                // Campos antiguos para compatibilidad
                'nombre_completo' => $nombres . ' ' . $apellidos,
                'email' => strtolower($correo),
                'fecha_suscripcion' => date('Y-m-d H:i:s'),
                'estado' => 'activo',
                'ip_registro' => $ip
            ];

            $objSuscripciones = new SuscripcionesModel();
            
            // Verificar si el email ya existe
            if ($objSuscripciones->emailExiste($correo)) {
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
