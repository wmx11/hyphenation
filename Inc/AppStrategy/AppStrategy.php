<?php

namespace Inc\AppStrategy;

class AppStrategy
{
    private $app = null;

    public function __construct($input, $container)
    {
        $word = null;
        $classInjection = $container;

        switch ($input) {
            case "hyphenate -file":
                $this->app = new HyphenateFromFile();
                break;

            case "hyphenate -db":
                $this->app = new HyphenateFromDb();
                break;

            case "hyphenate":
                $word = readline("Enter a word to hyphenate: ");
                $this->app = new HyphenateWord();
                break;

            case "exit":
                die();
                break;

            default:
                return;
                break;
        }
        $this->app->hyphenate($classInjection, $word);
    }
}