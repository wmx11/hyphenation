<?php

namespace Inc\AppStrategy;

use Inc\Controller\Words;

class HyphenateWord implements AppStrategyInterface
{
    public function hyphenate($classInjection, $input = null)
    {
        $cache = $classInjection->inject('Cache');
        $words = new Words('TextFiles/pattern.txt');
        if ($cache->get(trim($input)) !== false) {
            echo $cache->get(trim($input)) . "\r\n";
        } else {
            $words->hyphenate(trim($input));
            echo $input . " " . $words->getHyphenatedWord() . "\r\n";
            $cache->set(trim($input), trim($words->getHyphenatedWord()));
        }
    }
}