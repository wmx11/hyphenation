<?php

use Inc\App;
//use Inc\Api;

require_once('Inc/Autoload.php');

//$api = new Api();
//$api->runApi();

$app = new App();
$app->runApp();
//$app->displayTime();

//$app->returnDb()->insertTransaction();
