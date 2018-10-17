<?php

namespace Inc;

class Injector
{
    private $container = [];

    public function __construct()
    {
        $this->buildContainer();
    }

    public function __destruct()
    {
        $this->container = [];
    }

    public function buildContainer()
    {
        $this->setClass('Api','Inc\Api', 'Inc\Database\Database');
        $this->setClass('Timer', 'Inc\Helper\Timer');
        $this->setClass('Cache', 'Inc\Helper\Cache',null,'cache.txt');
        $this->setClass('HyphenationController', 'Inc\Controller\HyphenationController', 'Inc\Database\Database');
    }

    public function setClass($name, $location, $dependency = null, $filepath = null)
    {
        if ($dependency === null && $filepath === null) {
            $this->container[$name] = [$name => new $location];
        } elseif ($dependency === null && $filepath !== null) {
            $this->container[$name] = [$name => new $location($filepath)];
        } else {
            $this->container[$name] = [$name => new $location(new $dependency)];
        }
    }

    public function getClasses()
    {
        return $this->container;
    }

    public function inject($class)
    {
        return $this->container[$class][$class];
    }
}