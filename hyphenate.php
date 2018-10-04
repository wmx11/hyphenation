<?php
spl_autoload_register(function($class_name){
    $path = 'Inc/';
    $filename = $path . str_replace('\\', '/', $class_name) . '.php';
    require_once($filename);
});

function hyphenate($input){
    $pattern = new Patterns('Resources/pattern.txt');
    $words = new Words($input);
    $patterns = $pattern->patterns;
    $pattern_without_numbers = $pattern->pattern_without_numbers;
    $pattern_without_characters = $pattern->pattern_without_characters;
    $word = $words->word;
    $word_letters_array = $words->word_letters_array;
    $words->findPatternPositionInWord($pattern_without_numbers, $word, $patterns);
    $words->findNumberPositionInPattern($pattern_without_characters);
    $pattern_position_in_word = $words->pattern_position_in_word;
    $words->findNumberPositionInWord($pattern_position_in_word);
    $word_length_array_empty = $words->word_length_array_empty;
    $words->addNumbersAndLetters($word_letters_array, $word_length_array_empty);
    $matched_array = $words->matched_array;
    $words->cleanWord($matched_array);
    $words->printWord();
}
?>
