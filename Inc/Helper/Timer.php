<?php

namespace Inc\Helper;

use DateTime;

class Timer
{
    public $start;
    public $startMs;
    public $endMs;
    public $end;

    public function __construct()
    {
        $this->start = new DateTime('now');
        $this->startMs = microtime(true);
    }

    public function start()
    {
        $this->start = new DateTime('now');
    }

    public function end()
    {
        $this->end = new DateTime('now');
    }

    public function printTimeElapsed()
    {
        $end = new DateTime('now');
        $this->endMs = microtime(true);
        $diff = $this->start->diff($end);
        echo "Time Elapsed: " . $diff->format('%i minutes, %s seconds, ') . number_format(($this->endMs - $this->startMs), 6) . " milliseconds" . "\r\n";
    }

    public function getTimeElapsed()
    {
        $end = new DateTime('now');
        $diff = $this->start->diff($end);
        return "Time Elapsed: " . $diff->format('%i minutes, %s seconds, ') . number_format(($this->endMs - $this->startMs), 6) . " milliseconds" . "\r\n";
    }
}
?>