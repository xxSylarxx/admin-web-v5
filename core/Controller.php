<?php

namespace Admin\Core;

class Controller
{

    public function isPost()
    {
        return empty($_POST) ? false : true;
    }

    public function getPost(string $name, $default = null)
    {
        return isset($_POST[$name]) ? $_POST[$name] : $default;
    }

    public function postAll()
    {
        return $_POST;
    }

    public function getFile(string $name)
    {
        return isset($_FILES[$name]) ? $_FILES[$name] : null;
    }

    public function redirect($ruta)
    {
        header("Location: " . $ruta);
    }

    public function sesionActiva()
    {
        session_start();
        if (isset($_SESSION['AUTH_NAME'])) {
            define("SUPER_ADMIN", $_SESSION['AUTH_NAME'] == 'admin');
            return;
        } else {
            $this->redirect('/admin/login');
        }
    }
}
