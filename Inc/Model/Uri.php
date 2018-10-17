<?php

namespace Inc\Model;

class Uri
{
    private $uri;
    private $url;
    private $path;

    public function setUriParameters()
    {
        $this->setPath();
        $this->setUrl();
        $this->setUri();
    }

    public function setPath()
    {
        if (empty($_SERVER['REQUEST_URI']) !== true) {
            $this->path = $_SERVER['REQUEST_URI'];
        }
    }

    public function setUri()
    {
        if (!empty($this->path) && strpos($this->path, "?") === false) {
            return $this->uri = explode("/", $this->path);
        } else {
            return false;
        }
    }

    public function setUrl()
    {
        if (empty($this->path) !== true) {
            $this->url = $this->path;
        }
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