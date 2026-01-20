<?php

namespace Admin\Models;

use Admin\Core\DataBase;

class CorreosModel extends DataBase
{

    private $bd;

    function __construct()
    {
        $this->bd = parent::connect();
    }

    /* public function registrarCorreos($params)
    {
        try {
            $query = $this->bd->insertInto('correos')->values($params);
            $res = $query->execute();
            return $res;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    } */
    public function listarCorreos()
    {
        try {
            /* $query = $this->bd->from('correos')->orderBy('idcorreo DESC LIMIT 0,11')->fetchAll(); */
            $query = $this->bd->from('correos')->orderBy('idcorreo DESC')->fetchAll();
            if (is_array($query)) {
                return $query;
            }
            return array();
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
    public function totalcorreos($idcorreo = '%')
    {
        try {

            $query = $this->bd->from('correos')->select(null)->select('COUNT(*) as total')->where("idcorreo LIKE '{$idcorreo}'")->fetch('total');

            return $query;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
    public function eliminarCorreos($idcorreo)
    {
        try {
            $query = $this->bd->deleteFrom('correos')->where('idcorreo', $idcorreo);
            $res = $query->execute();
            return $res;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

}
