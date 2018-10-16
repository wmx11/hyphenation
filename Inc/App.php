<?php

namespace Inc;

use Inc\Helper\Logger;
use Inc\Helper\Timer;
use Inc\Database\Database;
use Inc\AppStrategy\AppStrategy;

class App
{
    private $api;
    private $con;
    private $timer;
    private $logger;

    public function __construct()
    {
        $this->timer = new Timer();
        $this->logger = Logger::init();
    }

    public function runApp()
    {
        if (empty($_SERVER['REQUEST_URI']) !== true) {
            $this->con = new Database();
            $this->api = new Api($this->con);
            $this->api->runApi();
        } else {
            echo file_get_contents("Resources/StartMessage.txt") . "\r\n";
            $input = readline("What would you like to do?: ");
            if (empty($input)) {
                echo "Type help to display all functions \r\n";
            } else {
                $app = new AppStrategy($input);
            }
        }
    }

    public function displayTime()
    {
        echo $this->timer->getTimeElapsed() . "\r\n";
        $this->log();
    }

    public function log()
    {
        $this->logger->logTime($this->timer->getTimeElapsed() . "\r\n");
        $this->logger->log("Items Cached: " . $this->cache->getNewCachedItems(), "Words Hyphenated: " . $this->words->getWordCount());
    }
}