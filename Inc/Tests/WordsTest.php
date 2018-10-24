<?php

use PHPUnit\Framework\TestCase;

require_once('../Resources/Autoload.php');

class WordsTest extends TestCase
{
    private $words;

    public function setUp()
    {
        $this->words = new Inc\Controller\Words('../../TextFiles/pattern.txt');
    }

    public function testAdditionOfDotsToWord()
    {
        $expectation = ".foo.";
        $word = "foo";
        $this->words->createWord($word);
        $returnedWord = $this->words->getWord();

        $this->assertEquals($expectation, $returnedWord);
    }

    public function testCalculationOfWordLength()
    {
        $word = "foo";
        $expectation = 5;
        $input = $this->words->createWord($word);
        $this->words->setWordLength($input);
        $length = $this->words->getWordLength();

        $this->assertEquals($expectation, $length);
    }

    public function testWordSplitToLetters()
    {
        $word = "foo";
        $expectation = [".", "f", "o", "o", "."];
        $input = $this->words->createWord($word);
        $this->words->setWordLettersArray($input);
        $lettersArray = $this->words->getWordLettersArray();

        $this->assertEquals($expectation, $lettersArray);
    }

    public function testWordLengthEmptyArray()
    {
        $word = "foo";
        $expectation = ["", "", "", "", ""];
        $input = $this->words->createWord($word);
        $this->words->setWordLength($input);
        $this->words->setWordLengthArrayEmpty();
        $emptyArray  = $this->words->getWordLengthArrayEmpty();

        $this->assertEquals($expectation, $emptyArray);
    }

    public function testWordCleaningFromNumbersAndDots()
    {
        $word = [".","f4","o2","o","."];
        $expectation = "foo";
        $this->words->cleanWord($word);
        $cleanWord = $this->words->getHyphenatedWord();

        $this->assertEquals($expectation, $cleanWord);
    }

    public function testWordHyphenation()
    {
        $word = "mistranslate";
        $expectation = "mis-trans-late";
        $this->words->hyphenate($word);
        $hyphenatedWord = $this->words->getHyphenatedWord();

        $this->assertEquals($expectation, $hyphenatedWord);
    }
}