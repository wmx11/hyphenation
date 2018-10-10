<?php

use Inc\App;

require_once('Inc/Autoload.php');

$app = new App();
$app->runApp();
$app->displayTime();

//$app->returnDb()->insertTransaction();
?>