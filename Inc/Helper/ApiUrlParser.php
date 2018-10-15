<?php

namespace Inc\Helper;

class ApiUrlParser
{
    private $url;

    public function setUrl()
    {
        if (!empty($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], "?") === false) {
            $this->url = explode("/", $_SERVER['REQUEST_URI']);
            return $this->url;
        }
    }
}