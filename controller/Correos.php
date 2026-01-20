<?php

use Admin\Core\Controller;
use Admin\Core\View;
use Admin\Models\CorreosModel;

class Correos extends Controller
{
    function __construct()
    {
        parent::sesionActiva();
    }

    public function index()
    {
        $objCorreos = new CorreosModel();
        $listCorreos = $objCorreos->listarCorreos();
        $contCorreos = $objCorreos->totalcorreos();
        $view = new View();
        $view->setName(__CLASS__);
        $view->setVariable('listCorreos', $listCorreos);
        $view->setVariable('contCorreos', $contCorreos);
        $view->render("correos/index");
    }
    public function excel()
    {
        /* $objCorreos1 = new CorreosModel();        */
        $view = new View();
        $view->render("correos/excel");
    }
    public function eliminar()
    {
        if (parent::isPost()) {
            // Recibimos el idcorreo del formulario (como parámetro POST)
            $idcorreo = parent::getPost('idcorreo');
            if (!is_null($idcorreo)) {
                $objCorreos = new CorreosModel();
                $resp = $objCorreos->eliminarCorreos($idcorreo);
                if ($resp) {
                    echo 'OK';  // Respuesta exitosa
                } else {
                    die('Error, no se pudo eliminar el correo');
                }
            } else {
                die('Error, idcorreo no proporcionado');
            }
        } else {
            die('Error, la solicitud no pudo ser procesada');
        }
    }

    /* public function guardar($params)
    {
        $idgaleria = isset($params[0]) ? $params[0] : null;
        if (!is_null($idgaleria)) {
            $objGalerias = new CorreosModel();
            $resp = $objGalerias->registrarCorreos($idgaleria);
            if ($resp == '1' || $resp == '0') {
                echo 'OK';
            }
        } else {
            die('Error, the request could not be processed');
        }
    }
   

    public function eliminar($params)
    {
        $idcorreo = isset($params[0]) ? $params[0] : null;
        if (!is_null($idcorreo)) {
            $objCorreos = new CorreosModel();
            $resp = $objCorreos->eliminarCorreos($idcorreo);
            if ($resp == '1' || $resp == '0') {
                echo 'OK';
            }
        } else {
            die('Error, the request could not be processed');
        }
    } */
}
