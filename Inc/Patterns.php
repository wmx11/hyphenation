<?php

namespace Inc;

class Patterns implements PatternsInterface
{
    private $patterns;
    private $patternWithoutNumbers = [];
    private $patternWithoutCharacters = [];
    private $patternPositionInWord = [];

    public function __construct($fileLocation)
    {
        $input = $this->readFile($fileLocation);
        $this->setPattern($input);
        $this->setPatternsWithoutNumbers();
        $this->setPatternsWithoutLetters();
    }

    public function readFile($fileLocation)
    {
        return file($fileLocation);
    }

    public function setPattern($input)
    {
        $this->patterns = $input;
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
?>