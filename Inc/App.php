<?php

namespace Inc;

use Inc\Helper\Timer;
use Inc\PatternReader;
use Inc\Words;
use Inc\Helper\Logger;
use Inc\Helper\Cache;
use Inc\PatternReaderDb;
use Inc\QueryDb;

class App
{
    private $timer;
    private $pattern;
    private $words;
    private $logger;
    private $cache;
    private $db;
    private $input;

    public function __construct()
    {
        $this->timer = new Timer();
        $this->pattern = new PatternReader('Resources/pattern.txt');
        $this->words = new Words();
        $this->logger = new Logger();
        $this->cache = new Cache('cache.txt');
        $this->db = new QueryDb();
    }

    public function runApp()
    {
        $startMsg = "Welcome to the hyphenator! \r\n";
        $startMsg .= "Here are the following functions: \r\n";
        $startMsg .= "hyphenate -file (Will hyphenate words from a file) \r\n";
        $startMsg .= "hyphenate -db (Will hyphenate words from a database) \r\n";
        $startMsg .= "hyphenate (Will hyphenate a single word) \r\n";
        $startMsg .= "Type help to display all functions \r\n";
        echo $startMsg;

        $input = readline('What would you like to do?: ');

        if (empty($input)) {
            echo "Type help to display all functions \r\n";
        } else {
            switch($input) {
                case "hyphenate -file":
                    $this->hyphenateFromFile();
                break;

                case "hyphenate -db":
                    $this->hyphenateFromDb();
                break;

                case "hyphenate":
                    $input = readline("Enter a word to hyphenate: ");
                    $this->hyphenateWord($input);
                break;

                default:
                    echo "Sorry";
                break;
            }
        }
    }

    public function hyphenateFromFile()
    {
        $wordsFile = file('Resources/test.txt');
        foreach ($wordsFile as $item) {
            if ($this->cache->get(trim($item)) !== false) {
                echo $this->cache->get(trim($item)) . "\r\n";
            } else {
                $this->words->setWord(trim($item));
                $this->words->findPatternPositionInWord($this->pattern->getPatternsWithoutNumbers(), $this->words->getWord(), $this->pattern->getPatterns());
                $this->words->findNumberPositionInPattern($this->pattern->getPatternsWithoutCharacters());
                $this->words->hyphenate();
                echo $item . " " . $this->words->getHyphenatedWord() . "\r\n";
                $this->cache->set(trim($item), trim($this->words->getHyphenatedWord()));
            }
        }
    }

    public function hyphenateFromDb()
    {
        $dbWords = $this->db->returnWords();
        $dbPatterns = $this->db->returnPatterns();
        $patternsDb = new PatternReaderDb($dbPatterns);
        foreach ($dbWords as $id => $word) {
            if ($this->db->ifWordExists($id) === false) {
                $this->words->setWord($word);
                $this->words->findPatternPositionInWord($patternsDb->getPatternsWithoutNumbers(), $this->words->getWord(), $patternsDb->getPatterns());
                $this->db->insertFoundPatterns($id, $this->words->getPatternPositionInWord());
                $this->words->findNumberPositionInPattern($patternsDb->getPatternsWithoutCharacters());
                $this->words->hyphenate();
                echo $this->words->getHyphenatedWord() . "\r\n";
                $data = ['word_id' => $id, 'hyphenated_word' => $this->words->getHyphenatedWord()];
                $this->db->insertHyphenatedWord($id, $this->words->getHyphenatedWord(), $data);
            } else {
                $this->db->ifWordExists($id);
            }
        }
    }

    public function hyphenateWord($input)
    {
        if ($this->cache->get(trim($input)) !== false) {
            echo $this->cache->get(trim($input)) . "\r\n";
        } else {
            $this->words->setWord(trim($input));
            $this->words->findPatternPositionInWord($this->pattern->getPatternsWithoutNumbers(), $this->words->getWord(), $this->pattern->getPatterns());
            $this->words->findNumberPositionInPattern($this->pattern->getPatternsWithoutCharacters());
            $this->words->hyphenate();
            echo $input . " " . $this->words->getHyphenatedWord() . "\r\n";
            $this->cache->set(trim($input), trim($this->words->getHyphenatedWord()));
        }
    }

    public function displayTime()
    {
        echo $this->timer->getTimeElapsed() . "\r\n";
        $this->log();
    }

    public function log()
    {
        $this->logger->logTime($this->timer->getTimeElapsed() ."\r\n");
        $this->logger->log("Items Cached: " . $this->cache->getNewCachedItems(), "Words Hyphenated: " . $this->words->getWordCount());
    }
}