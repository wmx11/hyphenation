<?php

namespace Inc;

class PatternReaderDb
{
    private $patterns = [];
    private $patternWithoutNumbers = [];
    private $patternWithoutCharacters = [];
    private $patternPositionInWord = [];

    public function __construct($dbArray)
    {
        $this->setPattern($dbArray);
        $this->setPatternsWithoutNumbers();
        $this->setPatternsWithoutLetters();
    }


    public function setPattern($input)
    {
        foreach ($input as $index => $pattern) {
            $this->patterns[$index] = $pattern;
        }
    }

    private function setPatternsWithoutNumbers()
    {
        foreach($this->patterns as $pattern) {
            $this->patternWithoutNumbers[] = trim(preg_replace('/[0-9]+/', '', $pattern));
        }
    }

    private function setPatternsWithoutLetters()
    {
        foreach($this->patterns as $pattern) {
            $this->patternWithoutCharacters[] = trim(preg_replace('/[aA-zZ.]/', '', $pattern));
        }
    }

    public function getPatterns()
    {
        return $this->patterns;
    }


    public function getPatternsWithoutNumbers()
    {
        return $this->patternWithoutNumbers;
    }

    public function getPatternsWithoutCharacters()
    {
        return $this->patternWithoutCharacters;
    }
}