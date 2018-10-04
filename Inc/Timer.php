<?php

//namespace Timer;
//use DateTime;

class Timer
{
    public $start;
    public $end;

    public function __construct()
    {
        $this->start = new DateTime('now');
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
        $diff = $this->start->diff($end);
        echo "Time Elapsed: " . $diff->format('%i minutes, %s seconds') . "\r\n";
    }
}
?>