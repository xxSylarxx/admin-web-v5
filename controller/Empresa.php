<?php

use Admin\Core\Controller;
use Admin\Core\View;
use Admin\Models\EmpresaModel;

class Empresa extends Controller
{

    function __construct()
    {
        parent::sesionActiva();
    }

    public function index()
    {
        $objEmpresa = new EmpresaModel();
        $listEmpresa = $objEmpresa->listEmpresa();
        $idemp = parent::getPost('idemp', '1');
        $empresa = $listEmpresa[$idemp];
        $locales = $this->listarLocales($listEmpresa);
        $view = new View();
        $view->setName(__CLASS__);
        $view->setVariable('locales', $locales);
        $view->setVariable('empresa', $empresa);
        $view->render('empresa/index');
    }

    public function actualizar()
    {
        if (parent::isPost()) {
            $objEmpresa = new EmpresaModel();
            $params = parent::postAll();
            $idemp = parent::getPost('idemp');
            unset($params['idemp']);
            $resp = $objEmpresa->actualizarEmp($params, $idemp);
            if ($resp == '1' || $resp == '0') :
                echo 'OK';
            endif;
        }
    }

    private function listarLocales($list)
    {
        $locales = array();
        foreach ($list as $local) {
            $locales[] = $local['idemp'];
        }
        return $locales;
    }
}
