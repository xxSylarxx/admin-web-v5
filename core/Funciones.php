<?php

namespace Admin\Core;

class Funciones
{
    public static function getFechaActual()
    {
        return  ucfirst(utf8_encode(strftime("%A, %d de %B %Y", strtotime(date("d-m-Y")))));
    }

    public static function parseDateTime($date)
    {
        return date('Y-m-d\TH:i', strtotime($date));
    }

    public static function obtenerFecha($date)
    {
        return date('d-m-Y', strtotime($date));
    }

    public static function obtenerHora($date)
    {
        return date("H:i", strtotime($date));
    }

    public static function generarPass($pass)
    {
        return password_hash($pass, PASSWORD_DEFAULT);
    }

    public static function formatoURL($str)
    {
        return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($str, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
    }

    public static function cleanString($str)
    {
        $str = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $str);
        $str = trim($str);
        $str = stripslashes($str);
        $str = str_ireplace("--", "", $str);
        $str = str_ireplace("^", "", $str);
        $str = str_ireplace("[", "", $str);
        $str = str_ireplace("]", "", $str);
        $str = str_ireplace("==", "", $str);
        $str = str_ireplace("<?php", "", $str);
        $str = str_ireplace("?>", "", $str);
        return $str;
    }
}
