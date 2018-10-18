<?php
include $_SERVER['DOCUMENT_ROOT'] . "/Autoload.php";

if (isset($_GET['id'])) {
    $model = new Model\Model();
    $model->delete($_GET['id']);
    header("location: Words.php");
}
?>