<?php

namespace Inc\Controller;

class PatternReader implements PatternsInterface
{
    private $patterns = array ();
    private $patternWithoutNumbers = array ();
    private $patternWithoutCharacters = array ();

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

    private function setPattern($input)
    {
        $this->patterns = $input;
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

?>