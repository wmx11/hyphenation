<?php

namespace Inc\AppStrategy;

use Inc\Controller\Words;
use Inc\Database\Database;
use Inc\Controller\HyphenationController;
use Inc\Controller\PatternReaderDb;

class HyphenateFromDb implements AppStrategyInterface
{
    public function hyphenate($input = null)
    {
        $con = new Database();
        $words = new Words();
        $db = new HyphenationController($con);
        $dbWords = $db->returnWords();
        $dbPatterns = $db->returnPatterns();
        $patternsDb = new PatternReaderDb($dbPatterns);
        foreach ($dbWords as $id => $word) {
            if ($db->ifWordExists($id) === false) {
                $words->setWord($word);
                $words->findPatternPositionInWord($patternsDb->getPatternsWithoutNumbers(), $words->getWord(), $patternsDb->getPatterns());
                $db->insertFoundPatterns($id, $words->getPatternPositionInWord());
                $words->findNumberPositionInPattern($patternsDb->getPatternsWithoutCharacters());
                $words->hyphenate();
                echo $words->getHyphenatedWord() . "\r\n";
                $data = array ('word_id' => $id, 'hyphenated_word' => $words->getHyphenatedWord());
                $db->insertHyphenatedWord($id, $words->getHyphenatedWord(), $data);
            } else {
                $db->ifWordExists($id);
            }
        }
    }
}