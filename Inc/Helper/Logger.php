<?php

namespace Inc\Helper;

use Psr\Log\AbstractLogger;

class Logger extends AbstractLogger
{

    private $log;

    public function __construct()
    {
        $this->log = fopen( 'logger.txt', 'a');
    }

    public function __destruct()
    {
        fclose($this->log);
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
        fwrite($this->log, "$level . \r\n");
        fwrite($this->log, "$message . \r\n");
    }

    public function setLog($time, $hyphenatedWord)
    {
        fwrite($this->log, $time);
        fwrite($this->log, "$hyphenatedWord \r\n");
    }

    public function logTime($time)
    {
        fwrite($this->log, $time);
    }
}

?>