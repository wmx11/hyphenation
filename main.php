<?php

//use Inc\App;

require_once __DIR__ . '/vendor/autoload.php';
require_once('Inc/Autoload.php');

$container = new DI\Container();
//$builder = new DI\ContainerBuilder();
//$builder->addDefinitions('App');
$app = $container->get();

//$app = new App();
$app->runApp();