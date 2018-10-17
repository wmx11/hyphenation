<?php

namespace Inc\AppStrategy;

use Inc\Controller\Words;

class HyphenateFromDb implements AppStrategyInterface
{
    public function hyphenate($classInjection, $input = null)
    {
        $db = $classInjection->inject('HyphenationController');
        $words = new Words($db->returnPatterns());
        foreach ($db->returnWords() as $id => $word) {
            if ($db->ifWordExists($id) === false) {
                $db->insertFoundPatterns($id, $words->getPatternPositionInWord());
                $words->hyphenate($word);
                echo $words->getHyphenatedWord() . "\r\n";
                $data = array ('word_id' => $id, 'hyphenated_word' => $words->getHyphenatedWord());
                $db->insertHyphenatedWord($id, $words->getHyphenatedWord(), $data);
            } else {
                $db->ifWordExists($id);
            }
        }
    }
}