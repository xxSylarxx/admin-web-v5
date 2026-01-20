<?php

namespace Admin\Models;

use Admin\Core\DataBase;

class CategoriasModel extends DataBase
{

    private $bd;

    function __construct()
    {
        $this->bd = parent::connect();
    }

    public function insertar(array $params)
    {
        try {
            $query = $this->bd->insertInto('categorias')->values($params);
            $res = $query->execute();
            return $res;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function actualizarEstado(string $estado, $idcateg)
    {
        try {
            $query = $this->bd->update('categorias')->set(array('estado' => $estado))->where('idcatg', $idcateg);
            $res = $query->execute();
            return $res;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function listCategorias()
    {
        try {
            $query = $this->bd->from('categorias')->orderBy('fecreg ASC')->fetchAll();
            $listCategorias = array();
            if (PUB_SUB_CATEG) {
                foreach ($query as &$row) {
                    $key = $row['idcatg'];
                    $pad = $row['catpad'];
                    if (!empty($pad)) {
                        $listCategorias[$pad]['subs'][$key] = $row;
                        $listCategorias[$pad]['subs'][$key]['totalPub'] = $this->totalPubsxCateg($key);
                    } else {
                        $listCategorias[$key] = $row;
                        $listCategorias[$key]['totalPub'] = $this->totalPubsxCateg($key);
                    }
                }
            } else {
                foreach ($query as $row) {
                    $key = $row['idcatg'];
                    $listCategorias[$key] = $row;
                    $listCategorias[$key]['totalPub'] = $this->totalPubsxCateg($key);
                }
            }
            return $listCategorias;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function listCategoriasInWeb()
    {
        try {
            $query = $this->bd->from('categorias')->where("estado = 'A'")->fetchAll();
            $listCategorias = array();
            foreach ($query as $row) {
                $key = $row['idcatg'];
                $listCategorias[$key] = $row;
                $listCategorias[$key]['totalPub'] = $this->totalPubsxCateg($key, true);
            }
            return $listCategorias;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    private function totalPubsxCateg($categ, $isWeb = false)
    {
        try {
            if ($isWeb) {
                $query = $this->bd->from('publicacion')->select(null)->select('COUNT(*) as total')->where("idcatg LIKE '{$categ}' AND fecpub <= NOW() AND visible = 'S'")->fetch('total');
            } else {
                $query = $this->bd->from('publicacion')->select(null)->select('COUNT(*) as total')->where("idcatg LIKE '{$categ}'")->fetch('total');
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
                $query = $this->bd->from('categorias')->where('idcatg', [$categ])->fetch();
            } else {
                $query = $this->bd->from('categorias')->where('filtro', [$categ])->fetch();
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