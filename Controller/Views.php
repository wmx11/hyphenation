<?php

namespace Controller;

class Views
{
    private $views = [];

    public function create($viewName, $path = null)
    {
        $this->views[$viewName] = [$viewName => "$path/$viewName.php"];
    }

    public function load($viewName){
        echo file_get_contents($this->views[$viewName][$viewName]);
    }
}