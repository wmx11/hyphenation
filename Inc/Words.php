<?php

namespace Inc;

class Words implements WordsInterface
{
    private $word;
    private $wordLength;
    private $wordLettersArray;
    private $wordLengthArrayEmpty;
    private $matchedArray = [];
    private $patternPositionInWord = [];
    const ODD_NUMBERS = [1, 3, 5, 7, 9];
    const EVEN_NUMBERS = [0, 2, 4, 6, 8];
    private $hyphenateWord = "";
    private $wordCount = 0;

    public function __destruct()
    {
        $this->wordCount = 0;
    }

    public function hyphenate()
    {
        $this->findNumberPositionInWord($this->patternPositionInWord);
        $this->addNumbersAndLetters($this->wordLettersArray, $this->wordLengthArrayEmpty);
        $this->cleanWord($this->matchedArray);
        $this->wordCount++;
    }

    public function setWord($input)
    {
        $this->word = ".{$input}.";
        $this->setWordLength($this->word);
        $this->setWordLettersArray($this->word);
        $this->setWordLengthArrayEmpty();
    }


    private function setWordLength($input)
    {
        $input = $this->word;
        $this->wordLength = strlen($input);
    }

    private function setWordLettersArray($input)
    {
        $input = $this->word;
        $this->wordLettersArray = str_split($input);
    }

    private function setWordLengthArrayEmpty()
    {
        $this->wordLengthArrayEmpty = array_fill(0, $this->wordLength, null);
    }

    public function findNumberPositionInWord($patternPositionInWord)
    {
        foreach ($patternPositionInWord as $positionInWord => $pattern) {
            foreach ($pattern as $patternNumber => $numberPositionInPattern) {
                if (!empty ($numberPositionInPattern)) {
                    $placeInWord = ($positionInWord + $numberPositionInPattern);
                    $this->wordLengthArrayEmpty[$placeInWord] = $patternNumber;
                }
            }
        }
    }

    public function findPatternPositionInWord($patternWithoutNumbers, $word, $patterns)
    {
        foreach ($patternWithoutNumbers as $patternIndex => $pattern) {
            $positionInWord = strpos($word, $pattern);
            if ($positionInWord !== false) {
                $this->patternPositionInWord[$positionInWord][$patternIndex] = $patterns[$patternIndex];
            }
        }
    }

    public function findNumberPositionInPattern($patternWithoutCharacters)
    {
        foreach ($this->patternPositionInWord as $positionInWord => $pattern) {
            foreach ($pattern as $patternIndex => $fullPattern) {
                $numberPositionInPattern = strpos($fullPattern, $patternWithoutCharacters[$patternIndex]);
                unset ($this->patternPositionInWord[$positionInWord][$patternIndex]);
                if ($numberPositionInPattern >= 0) {
                    $this->patternPositionInWord[$positionInWord][$patternWithoutCharacters[$patternIndex]] = $numberPositionInPattern;
                }
            }
        }
    }

    private function addNumbersAndLetters($wordLettersArray, $wordLengthArrayEmpty)
    {
        if (!empty($this->matchedArray)) {
            unset($this->matchedArray);
        }
        foreach ($wordLettersArray as $letterPosition => $letter) {
            $this->matchedArray[] = $wordLengthArrayEmpty[$letterPosition] . $letter;
        }
    }

    private function cleanWord($matchedArray)
    {
        $wordWithNumbers = implode("", $matchedArray);
        $removeDots = str_replace('.', '', $wordWithNumbers);
        $removeEvenNumbers = str_replace(self::EVEN_NUMBERS, '', $removeDots);
        $removeOddNumbers = str_replace(self::ODD_NUMBERS, '-', $removeEvenNumbers);
        $this->hyphenateWord = $removeOddNumbers;
    }

    public function getWord()
    {
        return trim($this->word);
    }

    public function getWordCount()
    {
        return $this->wordCount;
    }

    public function getPatternPositionInWord()
    {
        return $this->patternPositionInWord;
    }

    public function getHyphenatedWord()
    {
        return trim($this->hyphenateWord);
    }
}

?>