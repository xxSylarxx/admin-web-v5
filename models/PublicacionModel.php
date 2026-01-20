<?php

namespace Admin\Models;

use Admin\Core\DataBase;

class PublicacionModel extends DataBase
{

    private $bd;

    function __construct()
    {
        $this->bd = parent::connect();
    }

    public function insertarPublicacion(array $params)
    {
        try {
            $query = $this->bd->insertInto('publicacion')->values($params);
            $res = $query->execute();
            return $res;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function actualizarPublicacion(array $params, $idpub)
    {
        try {
            $query = $this->bd->update('publicacion')->set($params)->where('idpub', $idpub);
            $res = $query->execute();
            return $res;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function actualizarEstado(string $estado, $idpub)
    {
        try {
            $query = $this->bd->update('publicacion')->set(array('visible' => $estado))->where('idpub', $idpub);
            $res = $query->execute();
            return $res;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function eliminarPublicacion($idpub)
    {
        try {
            $query = $this->bd->deleteFrom('publicacion')->where('idpub', $idpub);
            $res = $query->execute();
            return $res;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function listarPublicaciones($init, $categoria = '%')
    {
        try {
            $query = $this->bd->from('publicacion pb')
                ->innerJoin('categorias ct ON ct.idcatg = pb.idcatg')
                ->select(null)
                ->select('pb.idpub, pb.idcatg, ct.nombre as categoria, pb.titulo, pb.tagname, pb.portada, pb.fecpub, pb.visible')
                ->where("pb.idcatg LIKE '{$categoria}'")
                ->orderBy('fecpub DESC')
                ->limit(PUB_MAX_ADMIN)
                ->offset($init)
                ->fetchAll();
            return $query;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function listPublicacionesInWeb($init, $limt, $categoria = '%')
    {
        try {
            $query = $this->bd->from('publicacion pb')
                ->innerJoin('categorias ct ON ct.idcatg = pb.idcatg')
                ->select(null)
                ->select('pb.idpub, pb.idcatg, ct.nombre as categoria, pb.titulo, pb.tagname, pb.portada, pb.detalle, pb.fecpub, pb.visible')
                ->where("pb.idcatg LIKE '{$categoria}' AND pb.fecpub <= NOW() AND pb.visible = 'S'")
                ->orderBy('fecpub DESC')
                ->limit($limt)
                ->offset($init)
                ->fetchAll();
            return $query;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function buscarPublicacion($idpub)
    {
        try {
            $query = $this->bd->from('publicacion')->where('idpub', [$idpub])->fetch();
            if (is_array($query)) {
                return $query;
            }
            return null;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function buscarPublicacionxTag($tagname)
    {
        try {
            $query = $this->bd->from('publicacion')->where('tagname', [$tagname])->fetch();
            if (is_array($query)) {
                return $query;
            }
            return null;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function totalPublicaciones($categoria = '%', $isWeb = false)
    {
        try {
            if ($isWeb) {
                $query = $this->bd->from('publicacion')->select(null)->select('COUNT(*) as total')->where("idcatg LIKE '{$categoria}' AND fecpub <= NOW() AND visible = 'S'")->fetch('total');
            } else {
                $query = $this->bd->from('publicacion')->select(null)->select('COUNT(*) as total')->where("idcatg LIKE '{$categoria}'")->fetch('total');
            }
            return $query;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function paginationAdmin($cateId, $total, $pag)
    {
        $list = '';
        $numPag = ceil($total / PUB_MAX_ADMIN);
        $cateId = $cateId == '%' ? 'all' : $cateId;
        if ($pag == 1) {
            $list = '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
        } else {
            $list = '<li class="page-item"><a class="page-link" href="/admin/publicacion/' . $cateId . '/' . ($pag - 1) . '"><span aria-hidden="true">&laquo;</span></a></li>';
        }
        for ($i = 1; $i <= $numPag; $i++) :
            $active = $i == $pag ? 'active' : '';
            $list .= '<li class="page-item ' . $active . '"><a class="page-link" href="/admin/publicacion/' . $cateId . '/' . $i . '">' . $i . '</a></li>';
        endfor;
        if ($pag == $numPag) {
            $list .= '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>';
        } else {
            $list .= '<li class="page-item"><a class="page-link" href="/admin/publicacion/' . $cateId . '/' . ($pag + 1) . '"><span aria-hidden="true">&raquo;</span></a></li>';
        }
        return $list;
    }

    public function paginationWeb($cateId, $total, $pag, $url)
    {
        $list = '';
        $numPag = ceil($total / PUB_MAX_WEB);
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

    public function datosDefault()
    {
        return array(
            'idpub' => null,
            'titulo' => null,
            'idcatg' => null,
            'portada' => null,
            'cuerpo' => null,
            'fecpub' => date('Y-m-d\TH:i'),
            'detalle' => null
        );
    }
}
