<?php

namespace Admin\Models;

use Admin\Core\DataBase;

class BannerModel extends DataBase
{

    private $bd;

    function __construct()
    {
        $this->bd = parent::connect();
    }

    public function actualizarBanner(array $params, $id = 1)
    {
        try {
            // Desactivar todos los banners primero
            $this->bd->update('banner')
                ->set(['estado' => 'N'])
                ->where("1", 1) // Importante: requerimiento de FluentPDO
                ->execute();

            // Activar y actualizar el seleccionado
            $res = $this->bd->update('banner')
                ->set($params)
                ->where('id', $id)
                ->execute();

            return $res;
        } catch (\PDOException $e) {
            error_log("Error en actualizarBanner: " . $e->getMessage());
            return false;
        }
    }


    public function actualizarBannerVideo(array $params, $id = 2)
    {
        try {
            // Desactivar todos los banners excepto el actual
            $this->bd->update('banner')
                ->set(['estado' => 'N'])
                ->where('id != ?', $id) // Notación segura para FluentPDO
                ->execute();

            // Actualizar el banner de video con los nuevos datos
            $res = $this->bd->update('banner')
                ->set($params)
                ->where('id', $id)
                ->execute();

            return $res;
        } catch (\PDOException $e) {
            error_log("Error en actualizarBannerVideo: " . $e->getMessage());
            return false;
        }
    }

    /* public function listarBanner()
    {
        try {
            $query = $this->bd->from('banner')->where('estado', 'S')->fetchAll();
            if (is_array($query)) {
            return $query;
            }
            return null;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    } */
    public function listarBanner()
    {
        try {
            $query = $this->bd->from('banner')->fetchAll();

            if (empty($query)) {
                return null;
            }


            return (count($query) === 1) ? $query[0] : $query;
        } catch (\PDOException $e) {
            error_log("Error en listarBanner: " . $e->getMessage()); // Evita die() en producción
            return null;
        }
    }
    public function listarBannerslider()
    {
        try {
            $query = $this->bd->from('banner')->where('tipo', 'slider')->fetchAll();

            if (empty($query)) {
                return null;
            }


            return (count($query) === 1) ? $query[0] : $query;
        } catch (\PDOException $e) {
            error_log("Error en listarBanner: " . $e->getMessage());
            return null;
        }
    }
    public function listarBannervideo()
    {
        try {
            $query = $this->bd->from('banner')->where('tipo', 'video')->fetchAll();

            if (empty($query)) {
                return null;
            }


            return (count($query) === 1) ? $query[0] : $query;
        } catch (\PDOException $e) {
            error_log("Error en listarBanner: " . $e->getMessage()); // Evita die() en producción
            return null;
        }
    }

    public function listBannerInWeb()
    {
        try {
            $query = $this->bd->from('banner')->where('estado', 'S')->fetch();
            if (is_array($query)) {
                if ($query['tipo'] == 'slider') {
                    $query['cuerpo'] = json_decode($query['cuerpo'], true);
                }
                $query['opciones'] = json_decode($query['opciones'], true);
                return $query;
            }
            return null;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
}
