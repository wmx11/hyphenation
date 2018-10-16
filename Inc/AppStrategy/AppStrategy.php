<?php

namespace Inc\AppStrategy;

class AppStrategy
{
    private $app = null;

    public function __construct($input)
    {
        $word = null;
        switch ($input) {
            case "hyphenate -file":
                $this->app = new HyphenateFromFile();
                break;

            case "hyphenate -db":
                $this->app = new HyphenateFromDb();
                break;

            case "hyphenate":
                $word = readline("Enter a word to hyphenate: ");
                $this->app = new HyphenateWord($word);
                break;

            case "exit":
                die();
                break;

            default:
                echo "Type help to display all functions \r\n";
                break;
        }
        $this->app->hyphenate($word);
    }
}