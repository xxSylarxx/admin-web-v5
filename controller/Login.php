<?php

use Admin\Core\Controller;
use Admin\Core\Funciones;
use Admin\Core\View;
use Admin\Models\LoginModel;

class Login extends Controller
{

    public function index()
    {
        $view = new View();
        $view->setName(__CLASS__);
        $view->render('login/index');
    }

    public function auth()
    {
        if (parent::isPost()) {
            $objLogin = new LoginModel();
            $name = Funciones::cleanString(parent::getPost('nombre'));
            $pass = Funciones::cleanString(parent::getPost('pass'));
            $resp = $objLogin->validarUsuario($name, $pass);
            if ($resp == 'OK') {
                session_start();
                session_regenerate_id();
                $_SESSION['AUTH_NAME'] = $name;
                echo $resp;
            } else {
                die($resp);
            }
        } else {
            die('Error, permission denied');
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        parent::redirect('/admin/login');
    }
}
