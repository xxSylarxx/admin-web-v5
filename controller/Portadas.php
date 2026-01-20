<?php

use Admin\Core\Controller;
use Admin\Core\View;
use Admin\Models\ArchivosModel;
use Admin\Models\PortadasModel;

class Portadas extends Controller
{

    function __construct()
    {
        parent::sesionActiva();
    }

    public function index()
    {
        $objPortadas = new PortadasModel();
        $objArchivos = new ArchivosModel();
        
        $listPortadas = $objPortadas->listarPortadas();
        $listArchivos = $objArchivos->listarArchivos('img/portadas/');

        $view = new View();
        $view->setName(__CLASS__);
        $view->setVariable('listPortadas', $listPortadas);
        $view->setVariable('listArchivos', $listArchivos);
        $view->render("portadas/index");
    }

    public function editor($params = null)
    {
        $objPortadas = new PortadasModel();
        $objArchivos = new ArchivosModel();
        
        $idportada = $params[0] ?? null;
        
        if ($idportada) {
            $dataPortada = $objPortadas->buscarPortadaPorId($idportada);
            if (!$dataPortada) {
                parent::redirect('/admin/portadas');
                return;
            }
        } else {
            $dataPortada = [
                'idportada' => null,
                'pagina' => '',
                'nombre' => '',
                'imagen' => '',
                'titulo' => '',
                'subtitulo' => '',
                'estado' => 'A'
            ];
        }

        $listArchivos = $objArchivos->listarArchivos('img/portadas/');

        $view = new View();
        $view->setName(__CLASS__);
        $view->setVariable('dataPortada', $dataPortada);
        $view->setVariable('listArchivos', $listArchivos);
        $view->render("portadas/editor");
    }

    public function guardar()
    {
        if (parent::isPost()) {
            $objPortadas = new PortadasModel();
            
            $datos = [
                'pagina' => parent::getPost('pagina'),
                'nombre' => parent::getPost('nombre'),
                'imagen' => parent::getPost('imagen'),
                'titulo' => parent::getPost('titulo'),
                'subtitulo' => parent::getPost('subtitulo'),
                'estado' => parent::getPost('estado', 'A')
            ];

            // Validar que la página no exista
            if ($objPortadas->existePagina($datos['pagina'])) {
                echo 'ERROR: Ya existe una portada con ese identificador de página';
                return;
            }

            $resp = $objPortadas->insertarPortada($datos);
            
            if ($resp) {
                echo 'OK';
            } else {
                echo 'ERROR: No se pudo guardar';
            }
        } else {
            die('Error, the request could not be processed');
        }
    }

    public function actualizar()
    {
        if (parent::isPost()) {
            $objPortadas = new PortadasModel();
            
            $idportada = parent::getPost('idportada');
            $datos = [
                'pagina' => parent::getPost('pagina'),
                'nombre' => parent::getPost('nombre'),
                'imagen' => parent::getPost('imagen'),
                'titulo' => parent::getPost('titulo'),
                'subtitulo' => parent::getPost('subtitulo'),
                'estado' => parent::getPost('estado', 'A')
            ];

            // Validar que la página no exista (excepto la actual)
            if ($objPortadas->existePagina($datos['pagina'], $idportada)) {
                echo 'ERROR: Ya existe una portada con ese identificador de página';
                return;
            }

            $resp = $objPortadas->actualizarPortada($idportada, $datos);
            
            if ($resp == '1' || $resp == '0') {
                echo 'OK';
            } else {
                echo 'ERROR: No se pudo actualizar';
            }
        } else {
            die('Error, the request could not be processed');
        }
    }

    public function eliminar($params)
    {
        $objPortadas = new PortadasModel();
        $idportada = $params[0] ?? null;
        
        if ($idportada) {
            $resp = $objPortadas->eliminarPortada($idportada);
            echo $resp ? 'OK' : 'ERROR';
        } else {
            echo 'ERROR: ID no válido';
        }
    }

    public function estado($params)
    {
        $objPortadas = new PortadasModel();
        $idportada = $params[0] ?? null;
        $estado = $params[1] ?? 'A';
        
        if ($idportada) {
            $resp = $objPortadas->cambiarEstado($idportada, $estado);
            echo $resp ? 'OK' : 'ERROR';
        } else {
            echo 'ERROR: ID no válido';
        }
    }
}