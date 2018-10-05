<?php

namespace Inc\Helper;

use Psr\Log\AbstractLogger;

class Logger extends AbstractLogger
{

    public $log;

    public function __construct()
    {
        $this->log = fopen( 'logger.txt', 'a');
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return void
     */

    public function log($level, $message, array $context = array())
    {
        //print_r($message);
        fwrite($this->log, strtr($message, $context));
    }

    public function setLog($time, $hyphenatedWord)
    {
        fwrite($this->log, $time);
        fwrite($this->log, $hyphenatedWord);
    }

    public function logTime($time)
    {
        fwrite($this->log, $time);
    }
}

?>