<?php

namespace Inc\Application\Model;

use Inc\Application\Core\Model;

class TableModel extends Model
{
    public function insertWord($tableName, $word)
    {
        $data = [];
        if (isset($_POST['word']) && $tableName === 'words') {
            $data = ["word" => $word];
        } elseif (isset($_POST['word']) && $tableName === 'patterns') {
            $data = ["pattern" => $word];
        }
        $this->con->insert($tableName, $data);
    }
}