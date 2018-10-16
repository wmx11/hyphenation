<?php

namespace Inc;

class PatternReaderDb
{
    private $patterns = array ();
    private $patternWithoutNumbers = array ();
    private $patternWithoutCharacters = array ();

    public function __construct($dbArray)
    {
        $this->setPattern($dbArray);
        $this->setPatternsWithoutNumbers();
        $this->setPatternsWithoutLetters();
    }

    private function setPattern($input)
    {
        foreach ($input as $index => $pattern) {
            $this->patterns[$index] = $pattern;
        }
    }

    private function setPatternsWithoutNumbers()
    {
        foreach ($this->patterns as $pattern) {
            $this->patternWithoutNumbers[] = trim(preg_replace('/[0-9]+/', '', $pattern));
        }
    }

    private function setPatternsWithoutLetters()
    {
        foreach ($this->patterns as $pattern) {
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