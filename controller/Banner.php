<?php

use Admin\Core\Controller;
use Admin\Core\View;
use Admin\Models\ArchivosModel;
use Admin\Models\BannerModel;

class Banner extends Controller
{

    function __construct()
    {
        parent::sesionActiva();
    }

    public function index()
    {
        $objBanner = new BannerModel();
        $dataBanner = $objBanner->listarBanner();

        if (empty($dataBanner)) {
            return;
        }

        // Normaliza: siempre usa array de banners
        $banners = is_array($dataBanner) && isset($dataBanner[0]) ? $dataBanner : [$dataBanner];

        // Buscar el banner con estado 'S'
        foreach ($banners as $banner) {
            if ($banner['estado'] === 'S') {
                parent::redirect('/admin/banner/' . $banner['tipo']);
                return;
            }
        }
    }



    public function slider()
    {
        $objBanner =  new BannerModel();
        $objArchivos = new ArchivosModel();
        $dataBanner = $objBanner->listarBannerslider();
        $listArchivos = $objArchivos->listarArchivos('img/banner/');
        if ($dataBanner['tipo'] == 'video') {
            $opciones = array();
            $opciones['fade'] = false;
            $opciones['dimensionar'] = false;
            $opciones['height'] = 100;
            $opciones['indicadores'] = false;
            $opciones['flechas'] = false;
            $dataBanner['cuerpo'] = '[]';
        } else {
            $opciones = json_decode($dataBanner['opciones'], true);
        }
        $dataBanner['opciones'] = $opciones;
        $view = new View();
        $view->setName(__CLASS__);
        $view->setVariable('tipo', 'slider');
        $view->setVariable('listArchivos', $listArchivos);
        $view->setVariable('dataBanner', $dataBanner);
        $view->render("banner/slider");
    }

    public function video()
    {
        $objBanner =  new BannerModel();
        $objArchivos = new ArchivosModel();
        $dataBanner = $objBanner->listarBannervideo();

        $listArchivos = $objArchivos->listarArchivos('video/');
        if ($dataBanner['tipo'] == 'slider') {
            $opciones = array();
            $opciones['path'] = null;
            $opciones['controls'] = true;
            $opciones['autoplay'] = false;
            $opciones['muted'] = false;
            $opciones['dimensionar'] = false;
            $opciones['youtube'] = false;
            $dataBanner['cuerpo'] = null;
        } else {
            $opciones = json_decode($dataBanner['opciones'], true);
        }
        $dataBanner['opciones'] = $opciones;
        $view = new View();
        $view->setName(__CLASS__);
        $view->setVariable('tipo', 'video');
        $view->setVariable('listArchivos', $listArchivos);
        $view->setVariable('dataBanner', $dataBanner);
        $view->render("banner/video");
    }

    public function actualizar()
    {
        if (parent::isPost()) {
            $objBanner =  new BannerModel();
            $data = array(
                'tipo' => parent::getPost('tipo'),
                'cuerpo' => parent::getPost('cuerpo'),
                'opciones' => parent::getPost('opciones'),
                'estado' => 'S'
            );
            $resp = $objBanner->actualizarBanner($data);
            if ($resp == '1' || $resp == '0') {
                echo 'OK';
            }
        } else {
            die('Error, the request could not be processed');
        }
    }
    public function actualizarvideo()
    {
        if (parent::isPost()) {
            $objBanner =  new BannerModel();
            $data = array(
                'tipo' => parent::getPost('tipo'),
                'cuerpo' => parent::getPost('cuerpo'),
                'opciones' => parent::getPost('opciones'),
                'estado'   => 'S'
            );
            $resp = $objBanner->actualizarBannerVideo($data);
            if ($resp == '1' || $resp == '0') {
                echo 'OK';
            }
        } else {
            die('Error, the request could not be processed');
        }
    }
}
