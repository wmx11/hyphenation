<?php

namespace Inc\Application\Model;

use Inc\Application\Core\Model;

class WordsModel extends Model
{
    public function getWords()
    {
        $itemsPerPage = 10;
        $limit = 0;
        if (!empty(explode("/", $_SERVER['REQUEST_URI'])[3])) {
            $limit = explode("/", $_SERVER['REQUEST_URI'])[3];
        }
        $this->con->select('*');
        $this->con->from('words');
        $this->con->orderBy('id', 'desc');
        $this->con->limit("$limit, $itemsPerPage");
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

    public function deleteWord($word)
    {
        $deleteWord = '"' . trim($word) . '"';
        $this->con->delete('words', "word = $deleteWord");
    }

    public function editWord($word, $editValue)
    {
        $data = ["word" => trim($editValue)];
        $this->con->update('words', $data, "word = '$word'");
    }
}