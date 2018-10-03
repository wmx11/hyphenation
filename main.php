<?php
require_once('hyphenate.php');
include('Timer.php');
$timer = new Timer;

$words = ['mistranslate','buttons','alphabetical', 'bewildering','ceremony','hovercraft','lexicographically','programmer','recursion'];

//$words = file('words.txt');

foreach($words as $input){
    hyphenate($input);
}

//hyphenate($argv[1]);

$timer->printTimeElapsed();
?>