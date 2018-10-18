<?php

namespace Model;

use Inc\Database\Database;

class Model
{
    private $con;

    public function __construct()
    {
        $this->con = new Database();
    }

    public function getAllWords()
    {
        $this->con->select('*');
        $this->con->from('words');
        $this->con->orderBy('id', 'asc');
        $this->con->limit(10);
        return $this->con->get();
    }
}