<?php

namespace Inc\Application\Core;

use Inc\Model\Uri;

class Controller
{
    private $uri;
    private $controller;
    private $method;
    private $callClass = null;
    private $callMethod = null;
    const POSITION_CONTROLLER_NAME = 2;
    const POSITION_METHOD_NAME = 3;

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
        $this->setControllerName();
        $this->setMethodName();
        $this->loadClass();
        $this->loadMethod();
    }

    public function setControllerName()
    {
        if (empty($this->uri->segment(self::POSITION_CONTROLLER_NAME)) !== true) {
            $this->controller = ucfirst($this->uri->segment(self::POSITION_CONTROLLER_NAME));
        } else {
            $this->controller = null;
        }
    }

    public function setMethodName()
    {
        if (empty($this->uri->segment(self::POSITION_METHOD_NAME)) !== true) {
            $this->method = $this->uri->segment(self::POSITION_METHOD_NAME);
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
        } elseif ($this->controller === null) {
            header('Location: index.php/index');
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
        $path = "Inc/Application/View/$viewName.phtml";
        if (is_file($path) === true) {
            ob_start();
            extract($data);
            include($path);
            print ob_get_clean();
        } else {
            print "Page Not Found";
        }
    }
}