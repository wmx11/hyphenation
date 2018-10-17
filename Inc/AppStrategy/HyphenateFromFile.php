<?php

namespace Inc\AppStrategy;

use Inc\Controller\Words;

class HyphenateFromFile implements AppStrategyInterface
{
    public function hyphenate($classInjection, $input = null)
    {
        $cache = $classInjection->inject('Cache');
        $words = new Words('TextFiles/pattern.txt');
        $wordsFile = file('TextFiles/test.txt');
        foreach ($wordsFile as $word) {
            if ($cache->get(trim($word)) !== false) {
                echo $cache->get(trim($word)) . "\r\n";
            } else {
                $words->hyphenate(trim($word));
                echo $words->getHyphenatedWord() . "\r\n";
                $cache->set(trim($word), trim($words->getHyphenatedWord()));
            }
        }
    }
}