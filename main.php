<?php

use Inc\Helper\Timer;
use Inc\Patterns;
use Inc\Words;
use Inc\Helper\Logger;
use Inc\Helper\Cache;

spl_autoload_register(function ($className) {
    $filename = str_replace('\\', '/', $className) . '.php';

    if (file_exists($filename) === true) {
        require_once($filename);
    } else {
        print "$filename does not exist";
    }
});

$wordCount = 0;

$timer = new Timer();
$pattern = new Patterns('Resources/pattern.txt');
$words = new Words();
$logger = new Logger();
$cache = new Cache('cache.txt');

$words->readWord($argv[1]);
$words->findPatternPositionInWord($pattern->patternWithoutNumbers, $words->word, $pattern->getPatterns());
$words->findNumberPositionInPattern($pattern->patternWithoutCharacters);
$words->hyphenate();
$cache->set($argv[1], $words->logWord());

//$wordsFile = file('Resources/words.txt');
//for ($i=0; $i < 50; $i++) {
//    $words->readWord($wordsFile[$i]);
//    $words->findPatternPositionInWord($pattern->patternWithoutNumbers, $words->word, $pattern->getPatterns());
//    $words->findNumberPositionInPattern($pattern->patternWithoutCharacters);
//    $words->hyphenate();
//    $cache->set($wordsFile[$i], $words->logWord());
//
//}

$timer->printTimeElapsed();
$logger->setLog($timer->getTimeElapsed(), $words->logWord());

?>