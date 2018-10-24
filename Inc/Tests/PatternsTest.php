<?php

use PHPUnit\Framework\TestCase;

require_once('../Resources/Autoload.php');

class PatternsTest extends TestCase
{
    private $patterns;
    private $patternsArray = array ();

    public function setUp()
    {
        $this->patternsArray = array (".foo2", "fo1o", "f4oo.");
        $this->patterns = new \Inc\Controller\PatternReader($this->patternsArray);
    }

    public function testPatternReading()
    {
        $expectation = $this->patternsArray;
        $this->patterns->setPattern($this->patternsArray);
        $readPatterns = $this->patterns->getPatterns();

        $this->assertEquals($expectation, $readPatterns);
    }

    public function testNumberRemovingFromPatterns()
    {
        $excpectation = array (".foo", "foo", "foo.", ".foo", "foo", "foo.");
        $this->patterns->setPatternsWithoutNumbers();
        $patternsWithoutNumbers = $this->patterns->getPatternsWithoutNumbers();

        $this->assertEquals($excpectation, $patternsWithoutNumbers);
    }

    public function testLetterRemovingFromPatterns()
    {
        $excpectation = array (2, 1, 4, 2, 1 , 4);
        $this->patterns->setPatternsWithoutLetters();
        $patternsWithoutLetters = $this->patterns->getPatternsWithoutCharacters();

        $this->assertEquals($excpectation, $patternsWithoutLetters);
    }
}
