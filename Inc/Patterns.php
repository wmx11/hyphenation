<?php
//namespace Inc;
class Patterns implements PatternsInterface
{
    private $patterns;
    public $pattern_without_numbers = [];
    public $pattern_without_characters = [];
    public $pattern_position_in_word = [];

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
            $this->pattern_without_numbers[] = trim(preg_replace('/[0-9]+/', '', $pattern));
        }
    }

    private function removePatternLetters()
    {
        foreach($this->patterns as $pattern) {
            $this->pattern_without_characters[] = trim(preg_replace('/[aA-zZ.]/', '', $pattern));
        }
    }

    public function getPatterns()
    {
        return $this->patterns;
    }


    public function getPatternsWithoutNumbers()
    {
        return $this->pattern_without_numbers;
    }

    public function getPatternsWithoutLetters()
    {
        return $this->pattern_without_characters;
    }
}
?>