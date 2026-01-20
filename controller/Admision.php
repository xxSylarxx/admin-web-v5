<?php

use Admin\Core\Controller;
use Admin\Core\View;
use Admin\Models\AdmisionModel;
use Admin\Models\ArchivosModel;
use Admin\Models\PortadasModel;

class Admision extends Controller
{

    function __construct()
    {
        parent::sesionActiva();
    }

    public function index()
    {
        $objAdmision = new AdmisionModel();
        $objPortadas = new PortadasModel();
        
        $dataAdmision = $objAdmision->obtenerAdmision();
        $dataPortada = $objPortadas->obtenerPortada('admision');

        $view = new View();
        $view->setName(__CLASS__);
        $view->setVariable('dataAdmision', $dataAdmision);
        $view->setVariable('dataPortada', $dataPortada);
        $view->render("admision/index");
    }

    public function actualizar()
    {
        if (parent::isPost()) {
            $objAdmision = new AdmisionModel();
            
            $datos = [
                'titulo' => parent::getPost('titulo'),
                'cuerpo' => parent::getPost('cuerpo')
            ];

            $resp = $objAdmision->actualizarAdmision($datos);
            
            if ($resp == '1' || $resp == '0') {
                echo 'OK';
            } else {
                echo 'ERROR: No se pudo actualizar';
            }
        } else {
            die('Error, the request could not be processed');
        }
    }


}
