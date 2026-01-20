<?php

namespace Admin\Models;

use Admin\Core\DataBase;

class GaleriasModel extends DataBase
{

    private $bd;

    function __construct()
    {
        $this->bd = parent::connect();
    }

    public function insertarGaleria(array $params)
    {
        try {
            $query = $this->bd->insertInto('galeria')->values($params);
            $res = $query->execute();
            return $res;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function actualizarGaleria(array $params, $idGaleria)
    {
        try {
            $query = $this->bd->update('galeria')->set($params)->where('idgaleria', $idGaleria);
            $res = $query->execute();
            return $res;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function eliminarGaleria($idpub)
    {
        try {
            $query = $this->bd->deleteFrom('galeria')->where('idgaleria', $idpub);
            $res = $query->execute();
            return $res;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function buscarGaleria($idGaleria)
    {
        try {
            $query = $this->bd->from('galeria')->where('idgaleria', [$idGaleria])->fetch();
            if (is_array($query)) {
                return $query;
            }
            return null;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function listarGalerias()
    {
        try {
            $query = $this->bd->from('galeria AS g')
                ->leftJoin('categorias_galerias AS c ON g.idcatg = c.idcatg')
                ->select('g.*')
                ->select('c.nombre AS categoria')
                ->orderBy('g.fecreg DESC')
                ->fetchAll();
            if (is_array($query)) {
                return $query;
            }
            return array();
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function listarGaleriasPorCategoria($idcatg)
    {
        try {
            $query = $this->bd->from('galeria AS g')
                ->leftJoin('categorias_galerias AS c ON g.idcatg = c.idcatg')
                ->select('g.*')
                ->select('c.nombre AS categoria')
                ->where('g.idcatg', $idcatg)
                ->orderBy('g.fecreg DESC')
                ->fetchAll();
            if (is_array($query)) {
                return $query;
            }
            return array();
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function listGaleriasInWeb($inicio = 0, $limite = 9, $categoria = '%')
    {
        try {
            if ($categoria == '%') {
                $query = $this->bd->from('galeria AS g')
                    ->leftJoin('categorias_galerias AS c ON g.idcatg = c.idcatg')
                    ->select('g.*')
                    ->select('c.nombre AS categoria')
                    ->where("g.visible = 'S'")
                    ->orderBy('g.fecreg DESC')
                    ->limit($limite)
                    ->offset($inicio)
                    ->fetchAll();
            } else {
                $query = $this->bd->from('galeria AS g')
                    ->leftJoin('categorias_galerias AS c ON g.idcatg = c.idcatg')
                    ->select('g.*')
                    ->select('c.nombre AS categoria')
                    ->where("g.visible = 'S' AND g.idcatg = '{$categoria}'")
                    ->orderBy('g.fecreg DESC')
                    ->limit($limite)
                    ->offset($inicio)
                    ->fetchAll();
            }
            if (is_array($query)) {
                return $query;
            }
            return array();
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function totalGalerias($categoria = '%', $isWeb = false)
    {
        try {
            if ($isWeb) {
                if ($categoria == '%') {
                    $query = $this->bd->from('galeria')->select(null)->select('COUNT(*) as total')->where("visible = 'S'")->fetch('total');
                } else {
                    $query = $this->bd->from('galeria')->select(null)->select('COUNT(*) as total')->where("visible = 'S' AND idcatg = '{$categoria}'")->fetch('total');
                }
            } else {
                if ($categoria == '%') {
                    $query = $this->bd->from('galeria')->select(null)->select('COUNT(*) as total')->fetch('total');
                } else {
                    $query = $this->bd->from('galeria')->select(null)->select('COUNT(*) as total')->where("idcatg = '{$categoria}'")->fetch('total');
                }
            }
            return $query;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function paginationWeb($cateId, $total, $pag, $url)
    {
        $list = '';
        $numPag = ceil($total / GAL_MAX_WEB);
        $cateId = $cateId == '%' ? 'all' : $cateId;
        if ($pag == 1) {
            $list = '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
        } else {
            $list = '<li class="page-item"><a class="page-link" href="' . $url . $cateId . '/' . ($pag - 1) . '"><span aria-hidden="true">&laquo;</span></a></li>';
        }
        for ($i = 1; $i <= $numPag; $i++) :
            $active = $i == $pag ? 'active' : '';
            $list .= '<li class="page-item ' . $active . '"><a class="page-link" href="' . $url . $cateId . '/' . $i . '">' . $i . '</a></li>';
        endfor;
        if ($pag == $numPag) {
            $list .= '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>';
        } else {
            $list .= '<li class="page-item"><a class="page-link" href="' . $url . $cateId . '/' . ($pag + 1) . '"><span aria-hidden="true">&raquo;</span></a></li>';
        }
        return $list;
    }

    public function actualizarEstado(string $estado, $idGaleria)
    {
        try {
            $query = $this->bd->update('galeria')->set(array('visible' => $estado))->where('idgaleria', $idGaleria);
            $res = $query->execute();
            return $res;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function datosDefault()
    {
        return array(
            'idgaleria' => null,
            'titulo' => null,
            'detalle' => null,
            'ncolum' => 4,
            'cuerpo' => '[]',
            'modo' => 'A',
            'portada' => null,
            'idcatg' => null
        );
    }
}
