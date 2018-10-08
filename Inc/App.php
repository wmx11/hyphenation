<?php

namespace Inc;

class App
{
    private $input;

    public function __construct($input)
    {
        $this->input = $input;
        $this->run();
    }

    public function run() {
        if (empty($this->input)) {
            echo "Type 'help' for help";
        } else {
            switch ($this->input) {
                case "help":
                    echo "This is help \r\n";
                    break;
            }
        }
    }
}