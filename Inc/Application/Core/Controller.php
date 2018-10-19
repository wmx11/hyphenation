<?php

namespace Inc\Application\Core;

use Inc\Model\Uri;

class Controller
{
    public $uri;
    private $controller;
    private $method;
    private $callClass = null;
    private $callMethod = null;
    const CONTROLLER = 2;
    const METHOD = 3;

    public function __destruct()
    {
        $this->controller = null;
        $this->method = null;
        $this->callClass = null;
        $this->callMethod = null;
    }

    public static function init()
    {
        $controller = null;
        if ($controller === null) {
            $controller = new Controller();
            $controller->uri = new Uri();
            $controller->uri->setUriParameters();
            $controller->setParameters();
        }
        return $controller;
    }

    public function setParameters()
    {
        $this->setController();
        $this->setMethod();
        $this->loadClass();
        $this->loadMethod();
    }

    public function setController()
    {
        if (empty($this->uri->segment(self::CONTROLLER)) !== true) {
            $this->controller = ucfirst($this->uri->segment(self::CONTROLLER));
        } else {
            $this->controller = null;
        }
    }

    public function setMethod()
    {
        if (empty($this->uri->segment(self::METHOD)) !== true) {
            $this->method = $this->uri->segment(self::METHOD);
        } else {
            $this->method = null;
        }
    }

    public function loadClass()
    {
        $class = "Inc\Application\Controller\\" . $this->controller;
        $callClass = $this->callClass;
        if (class_exists($class) === true && $callClass === null) {
            return $this->callClass = new $class();
        }  else {
            echo "Page Not Found";
        }
    }

    public function loadMethod()
    {
        $callMethod = $this->method;
        $controller = $this->callClass;
        if ($callMethod !== null && method_exists($controller, $callMethod)) {
            return $controller->$callMethod();
        } else {
            return $controller->home();
        }
    }

    public function loadView($viewName, $data = [])
    {
        $path = "Inc/Application/View/$viewName.php";
        if (is_file($path) === true) {
            ob_start();
            extract($data);
            include($path);
            return ob_get_clean();
        } else {
            echo "Page Not Found";
        }
    }

    public function validateMethod()
    {
        if ($this->method === null) {
            return false;
        } else {
            return true;
        }
    }
}