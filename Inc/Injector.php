<?php

namespace Inc;

use \ReflectionClass;

class Injector
{
    private $container = [];
    private $dependency;
    const CLASSNAME = 0;
    const DEPENDENCY = 1;

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
        $this->setClass('Api', 'Inc\Api');
        $this->setClass('Timer', 'Inc\Helper\Timer');
        $this->setClass('Cache', 'Inc\Helper\Cache', 'cache.txt');
        $this->setClass('HyphenationController', 'Inc\Controller\HyphenationController');
    }

    public function setClass($name, $nameSpace, $filepath = null)
    {
        $this->getDependency($nameSpace);
        if ($this->dependency === null && $filepath === null) {
            $this->container[$name] = [$name => $nameSpace];
        } elseif ($this->dependency === null && $filepath !== null) {
            $this->container[$name] = [$name => $nameSpace . " " . $filepath];
        } elseif ($this->dependency !== null && $filepath === null) {
            $this->container[$name] = [$name => $nameSpace . " " . $this->dependency];
        }
    }

    public function getDependency($class)
    {
        $reflector = new ReflectionClass($class);
        $dependencyClass = $reflector->getConstructor()->getParameters();
        if (!empty($dependencyClass) && !empty($dependencyClass[self::CLASSNAME]->getClass()->name)) {
            return $this->dependency = $dependencyClass[self::CLASSNAME]->getClass()->name;
        } else {
            return $this->dependency = null;
        }
    }

    public function getClasses()
    {
        return $this->container;
    }

    public function inject($class)
    {
        $classname = $this->container[$class][$class];
        $object = explode(" ", $classname);
        if (empty($object[self::CLASSNAME]) !== true && empty($object[self::DEPENDENCY]) === true) {
            return new $object[self::CLASSNAME];
        } elseif (empty($object[self::DEPENDENCY]) !== true && class_exists($object[self::DEPENDENCY]) === true) {
            return new $object[self::CLASSNAME](new $object[self::DEPENDENCY]);
        } elseif (empty($object[self::DEPENDENCY]) !== true && file_exists($object[self::DEPENDENCY]) === true) {
            return new $object[self::CLASSNAME]($object[self::DEPENDENCY]);
        }
    }
}