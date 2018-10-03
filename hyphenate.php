<?php
include('Patterns.php');

function hyphenate($input){
    $patterns = new Patterns;
    $patterns->readPatternFile('pattern.txt');
    $patterns = $patterns->getPatterns();

    $word = '.'.$input.'.';

    $pattern_without_numbers = [];
    ## Remove Numbers from the pattern
    foreach($patterns as $pattern){
        $pattern_without_numbers[] = trim(preg_replace('/[0-9]+/', '', $pattern));
    }

    $pattern_without_characters = [];
    ## Remove letters from the pattern
    foreach($patterns as $pattern){
        $pattern_without_characters[] = trim(preg_replace('/[aA-zZ.]/', '', $pattern));
    }

    $word_length = strlen($word);
    $word_letters_array = str_split($word);
    $word_length_array_empty = array_fill(0, $word_length, NULL);
    $matched_array = [];
    $pattern_position_in_word = [];

## Find Pattern Position In The Word
    foreach($pattern_without_numbers as $pattern_index => $pattern){
        $position_in_word = strpos($word, $pattern);
        if($position_in_word !== FALSE){
            //echo "$position_in_word => $patterns[$pattern_index] \r\n";
            $pattern_position_in_word[$position_in_word][$pattern_index] = $patterns[$pattern_index];
        }
    }

## Extract Numbers From Found Patterns
    foreach($pattern_position_in_word as $position_in_word => $pattern){
        foreach($pattern as $pattern_index => $full_pattern){
            $number_position_in_pattern = strpos($full_pattern, $pattern_without_characters[$pattern_index]);
            unset($pattern_position_in_word[$position_in_word][$pattern_index]);
            if($number_position_in_pattern >= 0) {
                //echo "$number_position_in_pattern => $full_pattern => $pattern_without_characters[$number_in_pattern] \r\n";
                $pattern_position_in_word[$position_in_word][$pattern_without_characters[$pattern_index]] = $number_position_in_pattern;
            }
            //echo "$pattern_index => $full_pattern";
        }
    }

## Find Number Position That Will Be Placed in Word
    foreach($pattern_position_in_word as $position_in_word => $pattern){
        foreach($pattern as $pattern_number => $number_position_in_pattern){
            if(!empty($number_position_in_pattern)){
                $place_in_word = ($position_in_word + $number_position_in_pattern);
                $word_length_array_empty[$place_in_word] = $pattern_number;
                //echo $pattern_number . " " . $word_letters_array[$place_in_word] . " " . $place_in_word . "\r\n";
            }
        }
    }

## Place letters and numbers together
    foreach($word_letters_array as $letter_position => $letter){
        //echo $word_length_array_empty[$letter_position] . "\r\n";
        $matched_array[] = $word_length_array_empty[$letter_position] . $letter;
    }

    $word_with_numbers = implode("", $matched_array);

    $remove_dots = str_replace('.', '', $word_with_numbers);
    $odd_numbers = [1,3,5,7,9];
    $even_numbers = [0,2,4,6,8];
    $remove_even_numbers = str_replace($even_numbers, '', $remove_dots);
    $hyphenate_word = str_replace($odd_numbers, '-', $remove_even_numbers);

    echo $hyphenate_word . "\r\n";
}
?>