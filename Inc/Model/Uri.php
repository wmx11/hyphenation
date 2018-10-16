<?php

namespace Inc\Model;

class Uri
{
    private $uri;
    private $url;

    public function setUri()
    {
        if (!empty($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], "?") === false) {
            return $this->uri = explode("/", $_SERVER['REQUEST_URI']);
        } else {
            return false;
        }
    }

    public function setUrl()
    {
        if (empty($_SERVER['REQUEST_URI']) !== true) {
            $url = $_SERVER['REQUEST_URI'];
            $this->url = $url;
        }
    }

    public function setUriParameters()
    {
        $this->setUrl();
        $this->setUri();
    }

    public function segment($position)
    {
        $uri = $this->uri;
        if (is_array($uri)) {
            if (array_key_exists($position, $uri) === true) {
                return $this->uri[$position];
            }
        }
    }

    public function getUrl()
    {
        return $this->url;
    }
}