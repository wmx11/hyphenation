<?php

namespace Inc\AppStrategy;

use Inc\Controller\Words;
use Inc\Helper\Cache;
use Inc\Model\ProxyPattern;

class HyphenateWord implements AppStrategyInterface
{
    public function hyphenate($input = null)
    {
        $cache = new Cache('cache.txt');
        $words = new Words();
        $pattern = new ProxyPattern('Resources/pattern.txt');
        if ($cache->get(trim($input)) !== false) {
            echo $cache->get(trim($input)) . "\r\n";
        } else {
            $words->setWord(trim($input));
            $words->findPatternPositionInWord($pattern->getPatternsWithoutNumbers(), $words->getWord(), $pattern->getPatterns());
            $words->findNumberPositionInPattern($pattern->getPatternsWithoutCharacters());
            $words->hyphenate();
            echo $input . " " . $words->getHyphenatedWord() . "\r\n";
            $cache->set(trim($input), trim($words->getHyphenatedWord()));
        }
    }
}