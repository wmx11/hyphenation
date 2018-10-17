<?php

namespace Inc;

use Inc\Helper\Logger;
use Inc\AppStrategy\AppStrategy;

class App
{
    private $container;
    private $timer;
    private $logger;
    private $cache;

    public function __construct($container)
    {
        $this->container = $container;
        $this->timer = $this->container->inject('Timer');
        $this->cache = $this->container->inject('Cache');
        $this->logger = Logger::init();
    }

    public function runApp()
    {
        if (empty($_SERVER['REQUEST_URI']) !== true) {
            $this->container->inject('Api')->runApi();
        } else {
            echo file_get_contents("TextFiles/StartMessage.txt") . "\r\n";
            $input = readline("What would you like to do?: ");
            if (empty($input)) {
                echo "Type help to display all functions \r\n";
            } else {
                $app = new AppStrategy($input, $this->container);
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
        $this->logger->log("Items Cached: " . $this->cache->getNewCachedItems(), "Words Hyphenated: ");
    }
}