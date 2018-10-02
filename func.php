<?php

function syllables($input){
    ## Read File
    $pattern = file('pattern.txt');

    ## Pattern without numbers
    $pattern_without_numbers = [];
    ## Remove Numbers from the pattern
    foreach($pattern as $item){
        $pattern_without_numbers[] = trim(preg_replace('/[0-9]+/', '', $item));
    }

    ## Pattern numbers
    $pattern_only_numbers = [];
    ## Remove letters from the pattern
    foreach($pattern as $item){
        $pattern_only_numbers[] = trim(preg_replace('/[aA-zZ.]/', '', $item));
    }

    ## Add dots to the input word to determine the beginning and end
    $word = $input;
    $str_length = strlen($word);
    $word_array = array_fill(0, $str_length, '');
    $letters_array = str_split($word);
    $position_index = [];
    $pattern_index = [];
    $word_with_numbers_array = [];
    $pattern_numbers_all = [];
    $pattern_number_position = [];
    $finished_word = "";



    foreach($pattern_without_numbers as $key => $item) { // Find Patterns Without Numbers in a word
        $pos = strpos($word, $item, 0); // Find the position on patterns
        if ($pos !== FALSE) {
             $pattern_numbers_all[$key] = $position_index[] = $pattern_only_numbers[$key];
             $pattern_index[] = $key;
//            echo "Position: " . $pos . "\r\n";
//            echo "Pattern: " . $pattern[$key] . "\r\n";
//            echo "Pattern Number: " . $pattern_only_numbers[$key] . "\r\n";
//            echo "\r\n";
            $num_pos = strpos($pattern[$key], $pattern_numbers_all[$key], 0);
            if($num_pos !== FALSE) {
                //echo $num_pos . " " . $pattern[$key] . " " . $pos . "\r\n";
                $word_array[$pos] .= $pattern_only_numbers[$key];
            }
        }
    }

     $pattern_num_split = str_split(implode("", $pattern_numbers_all));

    foreach($pattern_num_split as $number){
        foreach($pattern_index as $item_num){
            $pos = strpos($pattern[$item_num], $number);
            if($pos !== FALSE){
                //echo $pattern[$item_num] . " " . $pos . " " . $number . "\r\n";
                $pattern_number_position[$pos][] = $number;
            }
        }
    }

    foreach($letters_array as $key => $item){
        $word_with_numbers_array[] = $word_array[$key] . $item;
    }

    $word_with_numbers_dotted = implode("", $word_with_numbers_array);
    $word_with_numbers = str_replace('.', '', $word_with_numbers_dotted);
    $odd_numbers = [1,3,5,7,9];
    $even_numbers = [0,2,4,6,8];
    $remove_even_numbers = str_replace($even_numbers, "", $word_with_numbers);
    $hyphenated_word = str_replace($odd_numbers, "-", $remove_even_numbers);

    echo $finished_word = ltrim($hyphenated_word, '-');

    //print_r($pattern_number_position);

    print_r($pattern_numbers_all);

    //print_r($pattern_num_split);

//    print_r($pattern_index);

    //echo $word_with_numbers;
//    print_r($word_with_numbers_array);
//    print_r($word_array);
//    print_r($letters_array);

    echo "\r\n";
        echo $word;
    echo "\r\n";

}

?>
