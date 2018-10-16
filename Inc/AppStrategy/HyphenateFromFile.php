<?php

namespace Inc\AppStrategy;

use Inc\Controller\Words;
use Inc\Helper\Cache;
use Inc\Model\ProxyPattern;

class HyphenateFromFile implements AppStrategyInterface
{
    public function hyphenate($input = null)
    {
        $wordsFile = file('Resources/test.txt');
        $cache = new Cache('cache.txt');
        $words = new Words();
        $pattern = new ProxyPattern('Resources/pattern.txt');
        foreach ($wordsFile as $item) {
            if ($cache->get(trim($item)) !== false) {
                echo $cache->get(trim($item)) . "\r\n";
            } else {
                $words->setWord(trim($item));
                $words->findPatternPositionInWord($pattern->getPatternsWithoutNumbers(), $words->getWord(), $pattern->getPatterns());
                $words->findNumberPositionInPattern($pattern->getPatternsWithoutCharacters());
                $words->hyphenate();
                echo $item . " " . $words->getHyphenatedWord() . "\r\n";
                $cache->set(trim($item), trim($words->getHyphenatedWord()));
            }
        }
    }
}