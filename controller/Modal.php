<?php

use Admin\Core\View;
use Admin\Core\Controller;
use Admin\Models\ModalModel;

class Modal extends Controller
{
    function __construct()
    {
        parent::sesionActiva();
    }

    public function index()
    {
        $objModal = new ModalModel;
        $dataModal = $objModal->obtenerPopUp();
        $view = new View();
        $view->setName(__CLASS__);
        $view->setVariable('dataModal', $dataModal);
        $view->render('modal/index');
    }

    public function guardar()
    {
        if (parent::isPost()) {
            $id = parent::getPost('id');
            $params = parent::postAll();
            unset($params['id']);
            $objModal = new ModalModel;
            $resp = $objModal->actualizarPopUp($params, $id);
            if ($resp == 1 || $resp == 0) {
                echo 'OK';
            }
        } else {
            die('Error, the request could not be processed');
        }
    }
}
