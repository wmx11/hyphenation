<?php

spl_autoload_register(function ($className) {
    $filename = str_replace('\\', '/', $className) . '.php';

    if (file_exists($filename) === true) {
        require_once($filename);
    } else {
        print "$filename does not exist";
    }
});