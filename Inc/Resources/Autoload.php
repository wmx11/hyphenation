<?php

spl_autoload_register(function ($className) {
    $filename = str_replace('\\', '/', $className) . '.php';

    if (file_exists($filename) === true) {
        include($_SERVER['DOCUMENT_ROOT'] . "/$filename");
    } else {
        print "$filename does not exist";
    }
});