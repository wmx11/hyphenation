<?php

namespace Inc\Database;

interface DatabaseInterface
{
    public function insert($tableName, $data);
    public function get($select, $tableName);
    public function delete($tableName, $where);
    public function clear($tableName);
}