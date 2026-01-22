<?php

use Admin\Core\Controller;
use Admin\Core\View;
use Admin\Models\GaleriasModel;
use Admin\Models\CategoriasGaleriasModel;

class Galerias extends Controller
{
    function __construct()
    {
        parent::sesionActiva();
    }

    public function index($params = null)
    {
        $categoriaId = isset($params[0]) ? $params[0] : 'all';
        
        // Redirigir a /admin/galerias/all si no hay parámetros
        if (!isset($params[0])) {
            header('Location: /admin/galerias/all');
            exit;
        }
        
        $objGalerias = new GaleriasModel();
        $objCategorias = new CategoriasGaleriasModel();
        
        if ($categoriaId == 'all') {
            $listGalerias = $objGalerias->listarGalerias();
        } else {
            $listGalerias = $objGalerias->listarGaleriasPorCategoria($categoriaId);
        }
        
        $listCategorias = $objCategorias->listCategorias();
        $view = new View();
        $view->setName(__CLASS__);
        $view->setVariable('listGalerias', $listGalerias);
        $view->setVariable('listCategorias', $listCategorias);
        $view->setVariable('categoriaId', $categoriaId);
        $view->render("galerias/index");
    }


    public function editor($params)
    {
        $objGalerias = new GaleriasModel();
        $objCategorias = new CategoriasGaleriasModel();
        
        if (!is_null($params)) {
            $idgaleria = $params[0];
            $dataGaleria = $objGalerias->buscarGaleria($idgaleria);
            $dataGaleria['action'] = 'actualizar';
        } else {
            $dataGaleria = $objGalerias->datosDefault();
            $dataGaleria['action'] = 'guardar';
        }
        
        $listCategorias = $objCategorias->listCategorias();
        $view = new View();
        $view->setName(__CLASS__);
        $view->setVariable('galeria', $dataGaleria);
        $view->setVariable('listCategorias', $listCategorias);
        $view->render("galerias/editor");
    }

    public function guardar()
    {
        if (parent::isPost()) {
            $params = parent::postAll();
            unset($params['idgaleria']);
            
            // Asegurar que idcatg sea NULL si está vacío
            if (isset($params['idcatg']) && $params['idcatg'] === '') {
                $params['idcatg'] = null;
            }
            
            $params['fecreg'] = date('Y-m-d H:i:s');
            
            $objGalerias = new GaleriasModel();
            $resp = $objGalerias->insertarGaleria($params);
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
            $idGaleria = parent::getPost('idgaleria');
            unset($params['idgaleria']);

            if (isset($params['idcatg']) && $params['idcatg'] === '') {
                $params['idcatg'] = null;
            }
            
            $objGalerias = new GaleriasModel();
            $resp = $objGalerias->actualizarGaleria($params, $idGaleria);
            if ($resp == '1' || $resp == '0') {
                echo 'OK';
            }
        } else {
            die('Error, the request could not be processed');
        }
    }

    public function eliminar($params)
    {
        $idgaleria = isset($params[0]) ? $params[0] : null;
        if (!is_null($idgaleria)) {
            $objGalerias = new GaleriasModel();
            $resp = $objGalerias->eliminarGaleria($idgaleria);
            if ($resp == '1' || $resp == '0') {
                echo 'OK';
            }
        } else {
            die('Error, the request could not be processed');
        }
    }

    public function estado($params)
    {
        $idgaleria = isset($params[0]) ? $params[0] : null;
        $estado = isset($params[1]) ? $params[1] : null;
        if (!is_null($idgaleria)) {
            $objPublicaciones = new GaleriasModel();
            $resp = $objPublicaciones->actualizarEstado($estado, $idgaleria);
            if ($resp == '1' || $resp == '0') {
                echo 'OK';
            }
        } else {
            die('Error, the request could not be processed');
        }
    }

    public function categoria($params)
    {
        $action = isset($params[0]) ? $params[0] : null;
        $objCategorias = new CategoriasGaleriasModel();

        if ($action == 'save') {
            $nombre = isset($params[1]) ? urldecode($params[1]) : null;
            if (!is_null($nombre)) {
                $data = array(
                    'nombre' => $nombre,
                    'estado' => 'A',
                    'fecreg' => date('Y-m-d H:i:s')
                );
                $resp = $objCategorias->insertar($data);
                if ($resp) {
                    echo 'OK';
                }
            }
        } else {
            $idcateg = isset($params[0]) ? $params[0] : null;
            $estado = isset($params[1]) ? $params[1] : null;
            if (!is_null($idcateg) && !is_null($estado)) {
                $resp = $objCategorias->actualizarEstado($estado, $idcateg);
                if ($resp == '1' || $resp == '0') {
                    echo 'OK';
                }
            }
        }
    }
}
