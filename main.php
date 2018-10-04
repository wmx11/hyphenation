<?php

spl_autoload_register(function($class_name){
    $path = 'Inc/';
    $filename = $path . str_replace('\\', '/', $class_name) . '.php';
    require_once($filename);
});


$timer = new Timer();


$pattern = new Patterns('Resources/pattern.txt');
$words = new Words($argv[1]);

$words->findPatternPositionInWord($pattern->pattern_without_numbers, $words->word, $pattern->getPatterns());
$words->findNumberPositionInPattern($pattern->pattern_without_characters);
$words->hyphenate();

$timer->printTimeElapsed();
?>