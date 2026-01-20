<?php

namespace Admin\Models;

use Admin\Core\DataBase;

class CategoriasGaleriasModel extends DataBase
{

    private $bd;

    function __construct()
    {
        $this->bd = parent::connect();
    }

    public function insertar(array $params)
    {
        try {
            $query = $this->bd->insertInto('categorias_galerias')->values($params);
            $res = $query->execute();
            return $res;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function actualizarEstado(string $estado, $idcateg)
    {
        try {
            $query = $this->bd->update('categorias_galerias')->set(array('estado' => $estado))->where('idcatg', $idcateg);
            $res = $query->execute();
            return $res;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function listCategorias()
    {
        try {
            $query = $this->bd->from('categorias_galerias')->orderBy('fecreg ASC')->fetchAll();
            $listCategorias = array();
            foreach ($query as $row) {
                $key = $row['idcatg'];
                $listCategorias[$key] = $row;
                $listCategorias[$key]['totalGal'] = $this->totalGaleriasxCateg($key);
            }
            return $listCategorias;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function listCategoriasInWeb()
    {
        try {
            $query = $this->bd->from('categorias_galerias')->where("estado = 'A'")->fetchAll();
            $listCategorias = array();
            foreach ($query as $row) {
                $key = $row['idcatg'];
                $listCategorias[$key] = $row;
                $listCategorias[$key]['totalGal'] = $this->totalGaleriasxCateg($key, true);
            }
            return $listCategorias;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    private function totalGaleriasxCateg($categ, $isWeb = false)
    {
        try {
            if ($isWeb) {
                $query = $this->bd->from('galeria')->select(null)->select('COUNT(*) as total')->where("idcatg = '{$categ}' AND visible = 'S'")->fetch('total');
            } else {
                $query = $this->bd->from('galeria')->select(null)->select('COUNT(*) as total')->where("idcatg = '{$categ}'")->fetch('total');
            }
            return $query;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function buscarCategoria($categ, $id = true)
    {
        try {
            if ($id) {
                $query = $this->bd->from('categorias_galerias')->where('idcatg', [$categ])->fetch();
            } else {
                $query = $this->bd->from('categorias_galerias')->where('nombre', [$categ])->fetch();
            }
            if (is_array($query)) {
                return $query;
            }
            return null;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
}
