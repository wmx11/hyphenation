<?php

include $_SERVER['DOCUMENT_ROOT'] . "/Autoload.php";

$model = new \Controller\Controller();

if (isset($_POST['submit']) && isset($_POST['word'])) {
    $word = $_POST['word'];
    $table = $_POST['table'];
    $model->model->insert($table, $word);
    if ($table === 'patterns') {
        header("location: Patterns.php");
    } elseif ($table === 'words') {
        header("location: Words.php");
    }
} elseif (isset($_POST['update'])) {
    $newWord = $_POST['word'];
    if (isset($_GET['words'])) {
        $id = $_GET['words'];
        $model->model->update('words', $newWord, $id);
        header("location: Words.php");
    } elseif (isset($_GET['patterns'])) {
        $id = $_GET['patterns'];
        $model->model->update('patterns', $newWord, $id);
        header("location: Patterns.php");
    }
}