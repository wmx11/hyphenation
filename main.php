<?php

use Inc\Helper\Timer;
use Inc\PatternReader;
use Inc\Words;
use Inc\Helper\Logger;
use Inc\Helper\Cache;
use Inc\Database;
use Inc\PatternReaderDb;

spl_autoload_register(function ($className) {
    $filename = str_replace('\\', '/', $className) . '.php';

    if (file_exists($filename) === true) {
        require_once($filename);
    } else {
        print "$filename does not exist";
    }
});

$timer = new Timer();
$pattern = new PatternReader('Resources/pattern.txt');
$words = new Words();
$logger = new Logger();
$cache = new Cache('cache.txt');


if (empty($argv[1])) {
    echo "Please enter php main.php -h for help, -f to read from file, -db to read from Database, or any word to hyphenate a single word (php main.php example) \r\n";
} else {
    switch($argv[1]) {
        case "-h";
        echo "Script contains the following commands: \r\n";
        echo "php main.php -f will read and hyphenate words from a file \r\n";
        echo "php main.php -db will read and hyphenate words from the database \r\n";
        echo "php main.php word will hyphenate a single word (php main.php example) \r\n";
        break;

        case "-f":
            $wordsFile = file('Resources/test.txt');
            foreach ($wordsFile as $item) {
                if ($cache->get(trim($item)) !== false) {
                    echo $cache->get(trim($item)) . "\r\n";
                } else {
                    $words->setWord(trim($item));
                    $words->findPatternPositionInWord($pattern->getPatternsWithoutNumbers(), $words->getWord(), $pattern->getPatterns());
                    $words->findNumberPositionInPattern($pattern->getPatternsWithoutCharacters());
                    $words->hyphenate();
                    echo $item . " " . $words->getHyphenatedWord() . "\r\n";
                    $cache->set(trim($item), trim($words->getHyphenatedWord()));
                }
            }
         break;

        case "-db":
            $db = new Database();
            $dbWords = $db->returnWords();
            $dbPatterns = $db->returnPatterns();
            $patternsDb = new PatternReaderDb($dbPatterns);
            //print_r($db->returnWords());
            foreach ($dbWords as $id => $word) {
                if ($db->ifWordExists($id) === false) {
                    $words->setWord($word);
                    $words->findPatternPositionInWord($pattern->getPatternsWithoutNumbers(), $words->getWord(), $pattern->getPatterns());
                    $words->findNumberPositionInPattern($pattern->getPatternsWithoutCharacters());
                    $words->hyphenate();
                    //echo $words->getHyphenatedWord() . "\r\n";
                    $db->insertHyphenatedWord($id, $words->getHyphenatedWord());
                } else {
                    $db->ifWordExists($id);
                }
            }
        break;

        case "$argv[1]":
            if ($cache->get(trim($argv[1])) !== false) {
                echo $cache->get(trim($argv[1])) . "\r\n";
            } else {
                $words->setWord(trim($argv[1]));
                $words->findPatternPositionInWord($pattern->getPatternsWithoutNumbers(), $words->getWord(), $pattern->getPatterns());
                $words->findNumberPositionInPattern($pattern->getPatternsWithoutCharacters());
                $words->hyphenate();
                echo $argv[1] . " " . $words->getHyphenatedWord() . "\r\n";
                $cache->set(trim($argv[1]), trim($words->getHyphenatedWord()));
            }
         break;

        default: echo "Type php main.php -h for help";
        break;
    }
}

/*
if (empty($argv[1])) {
    $wordsFile = file('Resources/test.txt');
    foreach ($wordsFile as $item) {
        if ($cache->get(trim($item)) !== false) {
            echo $cache->get(trim($item)) . "\r\n";
        } else {
            $words->setWord(trim($item));
            $words->findPatternPositionInWord($pattern->getPatternsWithoutNumbers(), $words->getWord(), $pattern->getPatterns());
            $words->findNumberPositionInPattern($pattern->getPatternsWithoutCharacters());
            $words->hyphenate();
            echo $item . " " . $words->getHyphenatedWord() . "\r\n";
            $cache->set(trim($item), trim($words->getHyphenatedWord()));
        }
    }
} else {
        if ($cache->get(trim($argv[1])) !== false) {
            echo $cache->get(trim($argv[1])) . "\r\n";
        } else {
            $words->setWord(trim($argv[1]));
            $words->findPatternPositionInWord($pattern->getPatternsWithoutNumbers(), $words->getWord(), $pattern->getPatterns());
            $words->findNumberPositionInPattern($pattern->getPatternsWithoutCharacters());
            $words->hyphenate();
            echo $argv[1] . " " . $words->getHyphenatedWord() . "\r\n";
            $cache->set(trim($argv[1]), trim($words->getHyphenatedWord()));
        }

}
*/

echo $timer->getTimeElapsed() . "\r\n";
$logger->logTime($timer->getTimeElapsed() ."\r\n");
$logger->log("Items Cached: " . $cache->getNewCachedItems(), "Words Hyphenated: " . $words->getWordCount());
?>