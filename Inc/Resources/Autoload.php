<?php

spl_autoload_register(function ($className) {
    $filename = str_replace('\\', '/', $className) . '.php';

    if (file_exists($filename) === true) {
        include("$filename");
    } else {
        return false; //print "$filename does not exist";
    }
});