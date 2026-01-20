<?php

namespace Admin\Models;

use Admin\Core\DataBase;

class ModalModel extends DataBase
{
    private $bd;

    function __construct()
    {
        $this->bd = parent::connect();
    }

    public function actualizarPopUp($params, $id)
    {
        try {
            $query = $this->bd->update('popup')->set($params)->where('id', $id);
            $res = $query->execute();
            return $res;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function obtenerPopUp()
    {
        try {
            $query = $this->bd->from('popup')->fetch();
            if (is_array($query)) {
                return $query;
            }
            return array();
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
}
