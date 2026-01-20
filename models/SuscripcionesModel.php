<?php

namespace Admin\Models;

use Admin\Core\DataBase;

class SuscripcionesModel extends DataBase
{

    private $bd;

    function __construct()
    {
        $this->bd = parent::connect();
    }

    public function registrarSuscripcion($datos)
    {
        try {
            $query = $this->bd->insertInto('suscripciones')->values($datos);
            $res = $query->execute();
            return $res;
        } catch (\PDOException $e) {
            // Si hay error de duplicado (email ya existe)
            if ($e->getCode() == 23000) {
                return false;
            }
            die('Error en la base de datos: ' . $e->getMessage());
        }
    }

    public function emailExiste($email)
    {
        try {
            $email = strtolower(trim($email));
            $query = $this->bd->from('suscripciones')
                ->where('LOWER(email) = ?', $email)
                ->fetch();
            return !empty($query);
        } catch (\PDOException $e) {
            die('Error al verificar email: ' . $e->getMessage());
        }
    }

    public function listarSuscripciones()
    {
        try {
            $query = $this->bd->from('suscripciones')
                ->where('estado', 'activo')
                ->orderBy('fecha_suscripcion DESC')
                ->fetchAll();
            if (is_array($query)) {
                return $query;
            }
            return array();
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function totalSuscripciones($estado = 'activo')
    {
        try {
            $query = $this->bd->from('suscripciones')
                ->select(null)
                ->select('COUNT(*) as total')
                ->where('estado', $estado)
                ->fetch('total');
            return $query;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function eliminarSuscripcion($idsuscripcion)
    {
        try {
            $query = $this->bd->deleteFrom('suscripciones')->where('idsuscripcion', $idsuscripcion);
            $res = $query->execute();
            return $res;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function darDeBaja($idsuscripcion)
    {
        try {
            $query = $this->bd->update('suscripciones')
                ->set([
                    'estado' => 'inactivo',
                    'fecha_baja' => date('Y-m-d H:i:s')
                ])
                ->where('idsuscripcion', $idsuscripcion);
            $res = $query->execute();
            return $res;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

}
