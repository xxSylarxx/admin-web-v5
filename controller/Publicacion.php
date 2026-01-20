<?php

use Admin\Core\View;
use Admin\Core\Funciones;
use Admin\Core\Controller;
use Admin\Models\CategoriasModel;
use Admin\Models\PublicacionModel;

class Publicacion extends Controller
{

    function __construct()
    {
        parent::sesionActiva();
    }

    public function index()
    {
        parent::redirect('/admin/publicacion/all');
    }

    public function __call($method, $params)
    {
        $params = $params[0];
        $pagina = isset($params[0]) ? $params[0] : 1;
        $objCategorias = new CategoriasModel();
        $objPublicaciones = new PublicacionModel();
        $listCategorias = $objCategorias->listCategorias();
        $listIdsCategorias = $objCategorias->listCategoriasInWeb();
        if (in_array($method, array_column($listIdsCategorias, 'idcatg')) || $method == 'all') {
            $categoriaID = $method == 'all' ? '%' : $method;
            $initPub = (PUB_MAX_ADMIN * $pagina) - PUB_MAX_ADMIN;
            $listPublicaciones = $objPublicaciones->listarPublicaciones($initPub, $categoriaID);
            $totalPublicaciones = $objPublicaciones->totalPublicaciones($categoriaID);
            $listPagination = $objPublicaciones->paginationAdmin($categoriaID, $totalPublicaciones, $pagina);
            $view = new View();
            $view->setName(__CLASS__);
            $view->setVariable('categoriaId', $categoriaID);
            $view->setVariable('listCategorias', $listCategorias);
            $view->setVariable('listPublicaciones', $listPublicaciones);
            $view->setVariable('totalPublicaciones', $totalPublicaciones);
            $view->setVariable('listPagination', $listPagination);
            $view->render("publicacion/index");
        } else {
            die();
        }
    }

    public function editor($params)
    {
        $idpub = $params;
        $objCategorias = new CategoriasModel();
        $objPublicaciones = new PublicacionModel();
        $listCategorias = $objCategorias->listCategorias();
        if (is_null($idpub)) {
            $dataPublicacion = $objPublicaciones->datosDefault();
            $dataPublicacion['action'] = 'guardar';
        } else {
            $dataPublicacion = $objPublicaciones->buscarPublicacion($idpub);
            $dataPublicacion['action'] = 'actualizar';
        }
        $view = new View();
        $view->setName(__CLASS__);
        $view->setVariable('dataPub', $dataPublicacion);
        $view->setVariable('listCategorias', $listCategorias);
        $view->render("publicacion/editor");
    }

    public function guardar()
    {
        if (parent::isPost()) {
            $params = parent::postAll();
            $params['tagname'] = Funciones::formatoURL($params['titulo']);
            unset($params['idpub']);
            $objPublicaciones = new PublicacionModel();
            $resp = $objPublicaciones->insertarPublicacion($params);
            if ($resp) {
                echo 'OK';
            }
        } else {
            die('Error, the request could not be processed');
        }
    }

    public function actualizar()
    {
        if (parent::isPost()) {
            $params = parent::postAll();
            $idpub = $params['idpub'];
            $objPublicaciones = new PublicacionModel();
            $resp = $objPublicaciones->actualizarPublicacion($params, $idpub);
            if ($resp == '1' || $resp == '0') {
                echo 'OK';
            }
        } else {
            die('Error, the request could not be processed');
        }
    }

    public function estado($params)
    {
        $idpub = isset($params[0]) ? $params[0] : null;
        $estado = isset($params[1]) ? $params[1] : null;
        if (!is_null($idpub)) {
            $objPublicaciones = new PublicacionModel();
            $resp = $objPublicaciones->actualizarEstado($estado, $idpub);
            if ($resp == '1' || $resp == '0') {
                echo 'OK';
            }
        } else {
            die('Error, the request could not be processed');
        }
    }

    public function eliminar($params)
    {
        $idpub = isset($params[0]) ? $params[0] : null;
        if (!is_null($idpub)) {
            $objPublicaciones = new PublicacionModel();
            $resp = $objPublicaciones->eliminarPublicacion($idpub);
            if ($resp == '1' || $resp == '0') {
                echo 'OK';
            }
        } else {
            die('Error, the request could not be processed');
        }
    }

    public function categoria($params)
    {
        if (!is_null($params)) {
            $action = $params[0];
            $value = $params[1];
            $objCategorias = new CategoriasModel;
            if ($action == 'save') {
                $params = array();
                $params['nombre'] = $value;
                $params['filtro'] = Funciones::formatoURL($value);
                $params['estado'] = 'A';
                $resp = $objCategorias->insertar($params);
            } else {
                $resp = $objCategorias->actualizarEstado($value, $action);
            }
            if ($resp) {
                echo 'OK';
            }
        } else {
            die('Error, the request could not be processed');
        }
    }
}
