<?php

namespace Admin\Core;

class View
{

    public $gt;
    public $view_name;

    public function __construct()
    {
        $this->gt = new GoogleTranslate;
    }

    public function setName(string $name)
    {
        $this->view_name = strtolower($name);
    }

    public function setVariable($name, $valor)
    {
        $this->{$name} = $valor;
    }

    public function translate(string $text)
    {
        return ucfirst($this->gt->translate(LANG_DEFAULT, LANG_CONVERT, $text));
    }

    public function render($view)
    {
        $fileView = dirname(__DIR__, 1) . "/views/admin/{$view}.php";
        include_once $fileView;
    }
}
