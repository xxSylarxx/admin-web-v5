<?php

namespace Admin\Models;

use Admin\Core\DataBase;

class LoginModel extends DataBase
{

    private $bd;

    function __construct()
    {
        $this->bd = parent::connect();
    }

    public function validarUsuario($usuario, $pass)
    {
        try {
            $passHash = $this->bd->from('usuarios')->where("nombre = BINARY '{$usuario}'")->fetch('pass');
            if (!empty($passHash)) {
                if (password_verify($pass, $passHash)) {
                    return 'OK';
                }
                return 'Contraseña es incorrecta';
            }
            return 'Usuario no registrado';
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }
}
