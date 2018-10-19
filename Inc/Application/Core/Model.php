<?php

namespace Inc\Application\Core;

use Inc\Database\Database;

class Model
{
    public $con;

    public function __construct()
    {
        $this->con = new Database();
    }
}