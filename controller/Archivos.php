<?php

use Admin\Core\View;
use Admin\Core\Controller;
use Admin\Models\ArchivosModel;

class Archivos extends Controller
{

    function __construct()
    {
        parent::sesionActiva();
    }

    public function index()
    {
        $objArchivos = new ArchivosModel();
        $listArchivos = $objArchivos->listarArchivos('img/galeria/');
        $view = new View();
        $view->setName(__CLASS__);
        $view->setVariable('listArchivos', $listArchivos);
        $view->render('archivos/index');
    }

    public function listar($params)
    {
        if (parent::isPost()) {
            $objArchivos = new ArchivosModel();
            $files_path = parent::getPost('path');
            $listArchivos = $objArchivos->listarArchivos($files_path);
            if (is_null($params)) {
                echo json_encode($listArchivos, JSON_UNESCAPED_UNICODE);
            } else {
                $iniF = $params[0];
                $maxF = $iniF + 25;
                $totalF = count($listArchivos);
                $listFiles = array();
                if ($iniF < $totalF) {
                    for ($i = $iniF; $i < $maxF; $i++) :
                        if (isset($listArchivos[$i])) {
                            $listFiles[] = $listArchivos[$i];
                        }
                    endfor;
                }
                echo json_encode(array('files' => $listFiles, 'total' => $totalF), JSON_UNESCAPED_UNICODE);
            }
        } else {
            die('Error, the request could not be processed');
        }
    }

    public function guardar()
    {
        if (parent::isPost()) {
            $objArchivos = new ArchivosModel();
            $file_path = parent::getPost('file_path');
            $file_name = parent::getPost('file_name');
            $ARCHIVO = parent::getFile('archivo');
            $resp = $objArchivos->guardarArchivo($ARCHIVO, $file_path, $file_name);
            if ($resp) {
                echo 'OK';
            }
        } else {
            die('Error, the request could not be processed');
        }
    }

    public function eliminar()
    {
        if (parent::isPost()) {
            $objArchivos = new ArchivosModel();
            $file_path = parent::getPost('file_path');
            $resp = $objArchivos->eliminarArchivo($file_path);
            if ($resp) {
                echo 'OK';
            } else {
                die('Error, no se pudo eliminar el archivo');
            }
        } else {
            die('Error, the request could not be processed');
        }
    }
}
