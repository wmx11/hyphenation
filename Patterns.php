<?php
class Patterns {
    public $patterns;

    public function readPatternFile($fileLocation){
        $this->patterns = file($fileLocation);
    }

    public function getPatterns(){
        return $this->patterns;
    }
}
?>