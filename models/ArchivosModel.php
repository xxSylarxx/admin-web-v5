<?php

namespace Admin\Models;

class ArchivosModel
{

    public function guardarArchivo(array $file, string $ruta, string $file_name)
    {
        $path = PATH_ROOT . "/public/{$ruta}" . $file_name;
        if (in_array($file['type'], array('image/jpg', 'image/png', 'image/jpeg', 'image/webp', 'image/gif'))) {
            if ($ruta !== 'img/banner/') {
                return $this->redimensionarImagen($file, $path);
            } else {
                return move_uploaded_file($file['tmp_name'], $path);
            }
        } else {
            return move_uploaded_file($file['tmp_name'], $path);
        }
    }

    public function eliminarArchivo(string $ruta)
    {
        $path = PATH_ROOT . $ruta;
        if (file_exists($path)) {
            if (unlink($path)) {
                return true;
            }
        }
        return false;
    }

    public function listarArchivos(string $ruta)
    {
        $path = PATH_ROOT . "/public/{$ruta}";
        if (!file_exists($path)) {
            die('La ruta de archivos no existe');
        }
        $dir = dir($path);
        $list = array();
        while (($file = $dir->read()) !== false) {
            if ($file != '..' && $file != '.') :
                $list[] = array(
                    "id" => rand(100, 99999),
                    "name" => utf8_encode($file),
                    "type" => pathinfo($file, PATHINFO_EXTENSION),
                    "size" => $this->obtenerSize($dir->path . $file),
                    "date" => date("d M Y H:i", filemtime($dir->path . $file)),
                    "time" => filemtime($dir->path . $file),
                    "path" => "/public/{$ruta}" . utf8_encode($file),
                    "icon" => $this->obtenerIcono(pathinfo($file, PATHINFO_EXTENSION)),
                    "remove" => $this->isRemoveFile(utf8_encode($file))
                );
            endif;
        }
        usort($list, function ($a, $b) {
            return $a['time'] < $b['time'];
        });
        return $list;
    }

    private function redimensionarImagen(array $file, string $ruta)
    {
        $max_width = 950;
        $max_height = 950;
        
        $imageInfo = getimagesize($file['tmp_name']);
        if ($imageInfo === false) {
            die("Error: No se pudo obtener información de la imagen");
        }
        
        list($widht, $height, $imageType) = $imageInfo;

        if ($widht >= $max_width) {
            // Usar el tipo de imagen detectado en lugar del MIME type reportado
            switch ($imageType) {
                case IMAGETYPE_JPEG:
                    $imagenAux = imagecreatefromjpeg($file['tmp_name']);
                    break;
                case IMAGETYPE_PNG:
                    $imagenAux = imagecreatefrompng($file['tmp_name']);
                    break;
                case IMAGETYPE_WEBP:
                    if (function_exists('imagecreatefromwebp')) {
                        $imagenAux = imagecreatefromwebp($file['tmp_name']);
                    } else {
                        die("Error: WebP no está soportado en esta versión de PHP");
                    }
                    break;
                case IMAGETYPE_GIF:
                    $imagenAux = imagecreatefromgif($file['tmp_name']);
                    break;
                default:
                    die("Error: Tipo de imagen no soportado");
            }
            
            if ($imagenAux === false) {
                die("Error: No se pudo crear la imagen desde el archivo");
            }

            $x_ratio = $max_width / $widht;
            $y_ratio = $max_height / $height;

            if (($widht <= $max_width) && ($widht <= $max_height)) {
                $ancho_final = $widht;
                $alto_final = $height;
            } elseif (($x_ratio * $height) < $max_height) {
                $alto_final = ceil($x_ratio * $height);
                $ancho_final = $max_width;
            } else {
                $ancho_final = ceil($y_ratio * $widht);
                $alto_final = $max_width;
            }

            $lienzo = imagecreatetruecolor($ancho_final, $alto_final);

            if ($imageType == IMAGETYPE_PNG || $imageType == IMAGETYPE_WEBP) {
                imagealphablending($lienzo, false);
                imagesavealpha($lienzo, true);
            }
            
            imagecopyresampled($lienzo, $imagenAux, 0, 0, 0, 0, $ancho_final, $alto_final, $widht, $height);

            $resultado = false;
            switch ($imageType) {
                case IMAGETYPE_JPEG:
                    $resultado = imagejpeg($lienzo, $ruta, 90);
                    break;
                case IMAGETYPE_PNG:
                    $resultado = imagepng($lienzo, $ruta, 9);
                    break;
                case IMAGETYPE_WEBP:
                    if (function_exists('imagewebp')) {
                        $resultado = imagewebp($lienzo, $ruta, 90);
                    }
                    break;
                case IMAGETYPE_GIF:
                    $resultado = imagegif($lienzo, $ruta);
                    break;
            }
            
            imagedestroy($imagenAux);
            imagedestroy($lienzo);
            
            return $resultado;
        } else {
            return move_uploaded_file($file['tmp_name'], $ruta);
        }
    }

    private function obtenerIcono($tipoFile)
    {
        $icono = 'far fa-file';
        switch ($tipoFile) {
            case 'pdf':
                $icono = 'far fa-file-pdf';
                break;
            case 'zip':
            case 'rar':
                $icono = 'far fa-file-archive';
                break;
            case 'mp4':
                $icono = 'fas fa-film';
                break;
            case 'docx':
                $icono = 'far fa-file-word';
                break;
            case 'mp3':
                $icono = 'fas fa-volume-down';
                break;
        }
        return $icono;
    }

    /** 
     * poner dentro del array
     * el nombre de los archivos que no se deben eliminar
     */
    private function isRemoveFile($file)
    {
        $list = array('1366_2000.jpeg');
        return in_array($file, $list);
    }

    private function obtenerSize($file)
    {
        $bytes = filesize($file);
        $label = array('B', 'KB', 'MB', 'GB');
        for ($i = 0; $bytes >= 1024 && $i < (count($label) - 1); $bytes /= 1024, $i++);
        return (round($bytes, 2) . ' ' . $label[$i]);
    }
}
