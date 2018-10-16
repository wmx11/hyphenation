<?php

namespace Inc\Controller;

abstract class AbstractWordsParser
{
    abstract function setWordLength($input);
    abstract function setWordLettersArray($input);
    abstract function setWordLengthArrayEmpty();

}