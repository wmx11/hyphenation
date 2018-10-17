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
            $this->container[$name] = [$name => $location];
        } elseif ($dependency === null && $filepath !== null) {
            $this->container[$name] = [$name => $location . " " . $filepath];
        } else {
            $this->container[$name] = [$name => $location . " " . $dependency];
        }
    }

    public function getClasses()
    {
        return $this->container;
    }

    public function inject($class)
    {
        $string = $this->container[$class][$class];
        $object = explode(" ", $string);
        if (empty($object[0]) !== true && empty($object[1]) === true) {
            return new $object[0];
        } elseif (empty($object[1]) !== true && class_exists($object[1]) === true) {
            return new $object[0](new $object[1]);
        } elseif (empty($object[1]) !== true && file_exists($object[1]) === true) {
            return new $object[0]($object[1]);
        }
    }
}