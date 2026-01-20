<?php

namespace Admin\Models;

use Admin\Core\DataBase;

class PortadasModel extends DataBase
{
    private $bd;

    function __construct()
    {
        $this->bd = parent::connect();
    }

    // Listar todas las portadas
    public function listarPortadas()
    {
        try {
            $query = $this->bd->from('portadas')
                              ->orderBy('nombre ASC')
                              ->fetchAll();
            return $query;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    // Obtener portada por página
    public function obtenerPortada($pagina)
    {
        try {
            $query = $this->bd->from('portadas')
                              ->where('pagina', $pagina)
                              ->where('estado', 'A')
                              ->fetch();
            return $query;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    // Buscar portada por ID
    public function buscarPortadaPorId($idportada)
    {
        try {
            $query = $this->bd->from('portadas')
                              ->where('idportada', $idportada)
                              ->fetch();
            return $query;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    // Actualizar portada
    public function actualizarPortada($idportada, array $datos)
    {
        try {
            $query = $this->bd->update('portadas')
                              ->set($datos)
                              ->where('idportada', $idportada);
            $res = $query->execute();
            return $res;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    // Insertar nueva portada
    public function insertarPortada(array $datos)
    {
        try {
            $query = $this->bd->insertInto('portadas')->values($datos);
            $res = $query->execute();
            return $res;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    // Eliminar portada
    public function eliminarPortada($idportada)
    {
        try {
            $query = $this->bd->deleteFrom('portadas')
                              ->where('idportada', $idportada);
            $res = $query->execute();
            return $res;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    // Cambiar estado
    public function cambiarEstado($idportada, $estado)
    {
        try {
            $query = $this->bd->update('portadas')
                              ->set(['estado' => $estado])
                              ->where('idportada', $idportada);
            $res = $query->execute();
            return $res;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    // Verificar si existe página
    public function existePagina($pagina, $idportada = null)
    {
        try {
            $query = $this->bd->from('portadas')
                              ->where('pagina', $pagina);
            
            if ($idportada) {
                $query->where('idportada <> ?', $idportada);
            }
            
            $result = $query->fetch();
            return !empty($result);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
}