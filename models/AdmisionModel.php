<?php

namespace Admin\Models;

use Admin\Core\DataBase;

class AdmisionModel extends DataBase
{
    private $bd;

    function __construct()
    {
        $this->bd = parent::connect();
    }

    // Obtener configuración de admisión
    public function obtenerAdmision()
    {
        try {
            $query = $this->bd->from('admision')
                              ->where('idadmision', 1)
                              ->fetch();
            // Si no existe, devolver valores por defecto
            if (!$query) {
                return [
                    'idadmision' => 1,
                    'titulo' => '',
                    'cuerpo' => ''
                ];
            }
            return $query;
        } catch (\PDOException $e) {
            // Si la tabla no existe, devolver valores por defecto
            return [
                'idadmision' => 1,
                'titulo' => '',
                'cuerpo' => ''
            ];
        }
    }

    // Actualizar admisión
    public function actualizarAdmision(array $datos)
    {
        try {
            // Verificar si existe el registro con idadmision = 1
            $existe = $this->bd->from('admision')
                               ->where('idadmision', 1)
                               ->fetch();
            
            if ($existe) {
                // Actualizar el registro
                $query = $this->bd->update('admision')
                                  ->set($datos)
                                  ->where('idadmision', 1);
                $res = $query->execute();
            } else {
                // Insertar nuevo registro con idadmision = 1
                $datos['idadmision'] = 1;
                $query = $this->bd->insertInto('admision')->values($datos);
                $res = $query->execute();
            }
            return $res;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }


}
