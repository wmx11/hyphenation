<?php

namespace Inc;

class Patterns implements PatternsInterface
{
    private $patterns;
    public $patternWithoutNumbers = [];
    public $patternWithoutCharacters = [];
    public $patternPositionInWord = [];

    public function __construct($fileLocation)
    {
        $input = $this->readFile($fileLocation);
        $this->setPattern($input);
        $this->removePatternNumbers();
        $this->removePatternLetters();
    }

    public function readFile($fileLocation)
    {
        return file($fileLocation);
    }

    public function setPattern($input)
    {
        $this->patterns = $input;
    }

    private function removePatternNumbers()
    {
        foreach($this->patterns as $pattern) {
            $this->patternWithoutNumbers[] = trim(preg_replace('/[0-9]+/', '', $pattern));
        }
    }

    private function removePatternLetters()
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

    public function getPatternsWithoutLetters()
    {
        return $this->patternWithoutCharacters;
    }
}
?>