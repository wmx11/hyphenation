<?php

namespace Inc;

use Inc\Controller\PatternsInterface;
use Inc\Controller\PatternReader;

class ProxyPattern implements PatternsInterface
{
    private $fileLocation;
    private $patterns;

    public function __construct($fileLocation)
    {
        $this->fileLocation = $fileLocation;
    }

    public function readFile($fileLocation)
    {
        if ($this->patterns === null) {
            $this->patterns = new PatternReader($this->fileLocation);
        }
    }
}