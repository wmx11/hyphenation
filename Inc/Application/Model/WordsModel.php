<?php

namespace Inc\Application\Model;

use Inc\Application\Core\Model;

class WordsModel extends Model
{
    public function getWords()
    {
        $this->con->select('*');
        $this->con->from('words');
        $this->con->orderBy('id', 'desc');
        $this->con->limit(10);
        return $this->con->get();
    }

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