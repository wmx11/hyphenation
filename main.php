<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once('Inc/Resources/Autoload.php');

use Inc\Injector;
use Inc\App;

$container = new Injector();
$app = new App($container);
$app->runApp();