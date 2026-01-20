<?php

namespace Admin\Models;

use Admin\Core\DataBase;

class EmpresaModel extends DataBase
{

    private $bd;

    function __construct()
    {
        $this->bd = parent::connect();
    }

    public function actualizarEmp(array $params, $idemp)
    {
        try {
            $query = $this->bd->update('empresa')->set($params)->where('idemp', $idemp);
            $res = $query->execute();
            return $res;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function listEmpresa()
    {
        try {
            $query = $this->bd->from('empresa')->fetchAll();
            $listEmpresa = array();
            foreach ($query as $row) {
                $key = $row['idemp'];
                $listEmpresa[$key] = $row;
            }
            return $listEmpresa;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function obtenerNombre()
    {
        try {
            $bd = new DataBase();
            $conn = $bd->connect();
            $query = $conn->from('empresa')->select(null)->select('nombre')->fetch();
            return $query['nombre'];
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
}
