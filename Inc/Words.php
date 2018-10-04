<?php

class Words implements WordsInterface
{
    public $word;
    public $word_length;
    public $word_letters_array;
    public $word_length_array_empty;
    public $matched_array = [];
    public $pattern_position_in_word = [];
    const ODD_NUMBERS = [1, 3, 5, 7, 9];
    const EVEN_NUMBERS = [0, 2, 4, 6, 8];
    public $hyphenate_word;

    public function __construct($word)
    {
        $this->getWord($word);
        $this->getWordLength($word);
        $this->getWordLettersArray($word);
        $this->getWordLengthArrayEmpty();
    }

    public function hyphenate()
    {
        $this->findNumberPositionInWord($this->pattern_position_in_word);
        $this->addNumbersAndLetters($this->word_letters_array, $this->word_length_array_empty);
        $this->cleanWord($this->matched_array);
        $this->printWord();
    }

    public function getWord($input)
    {
        $this->word = '.' . $input . '.';
        //return $this->word;
    }

    public function getWordLength($input)
    {
        $input = $this->word;
        $this->word_length = strlen($input);
        //return $this->word_length;
    }

    public function getWordLettersArray($input)
    {
        $input = $this->word;
        $this->word_letters_array = str_split($input);
        //return $this->word_letters_array;
    }

    public function getWordLengthArrayEmpty()
    {
        $this->word_length_array_empty = array_fill(0, $this->word_length, null);
        return $this->word_length_array_empty;
    }

    public function findNumberPositionInWord($pattern_position_in_word)
    {
        foreach ($pattern_position_in_word as $position_in_word => $pattern) {
            foreach ($pattern as $pattern_number => $number_position_in_pattern) {
                if (!empty ($number_position_in_pattern)){
                    $place_in_word = ($position_in_word + $number_position_in_pattern);
                    $this->word_length_array_empty[$place_in_word] = $pattern_number;
                }
            }
        }
    }

    public function findPatternPositionInWord($pattern_without_numbers, $word, $patterns)
    {
        foreach ($pattern_without_numbers as $pattern_index => $pattern) {
            $position_in_word = strpos($word, $pattern);
            if ($position_in_word !== false) {
                $this->pattern_position_in_word[$position_in_word][$pattern_index] = $patterns[$pattern_index];
            }
        }
    }

    public function findNumberPositionInPattern($pattern_without_characters)
    {
        foreach ($this->pattern_position_in_word as $position_in_word => $pattern) {
            foreach ($pattern as $pattern_index => $full_pattern) {
                $number_position_in_pattern = strpos($full_pattern, $pattern_without_characters[$pattern_index]);
                unset ($this->pattern_position_in_word[$position_in_word][$pattern_index]);
                if ($number_position_in_pattern >= 0) {
                    $this->pattern_position_in_word[$position_in_word][$pattern_without_characters[$pattern_index]] = $number_position_in_pattern;
                }
            }
        }
    }

    public function getPatternPositionInWord()
    {
        return $this->pattern_position_in_word;
    }

    public function addNumbersAndLetters($word_letters_array, $word_length_array_empty)
    {
        foreach ($word_letters_array as $letter_position => $letter) {
            $this->matched_array[] = $word_length_array_empty[$letter_position] . $letter;
        }
    }

    public function cleanWord($matched_array)
    {
        $word_with_numbers = implode("", $matched_array);
        $remove_dots = str_replace('.', '', $word_with_numbers);
        $remove_even_numbers = str_replace(self::EVEN_NUMBERS, '', $remove_dots);
        $this->hyphenate_word = str_replace(self::ODD_NUMBERS, '-', $remove_even_numbers);
    }

    public function printWord()
    {
        echo $this->hyphenate_word . "\r\n";
    }

}

?>