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

$timer = new Timer();
$pattern = new Patterns('Resources/pattern.txt');
$words = new Words();
$logger = new Logger();
$cache = new Cache('cache.txt');

//$words->setWord($argv[1]);
//$words->findPatternPositionInWord($pattern->getPatternsWithoutNumbers(), $words->getWord(), $pattern->getPatterns());
//$words->findNumberPositionInPattern($pattern->getPatternsWithoutCharacters());
//$words->hyphenate();
//$cache->set($argv[1], $words->getHyphenatedWord());

$wordsFile = file('Resources/words.txt');
foreach ($wordsFile as $item) {
    $words->setWord(trim($item));
    $words->findPatternPositionInWord($pattern->getPatternsWithoutNumbers(), $words->getWord(), $pattern->getPatterns());
    $words->findNumberPositionInPattern($pattern->getPatternsWithoutCharacters());
    $words->hyphenate();
    echo $words->getHyphenatedWord();
    $logger->setLog(trim($item), trim($words->getHyphenatedWord()));
    $cache->set($item, $words->getHyphenatedWord());
}

echo $timer->getTimeElapsed() . "\r\n";
$logger->setLog(trim($timer->getTimeElapsed()), $words->getHyphenatedWord());

?>