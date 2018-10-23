<?php

namespace Inc\Application\Model;

use Inc\Application\Core\Model;

class WordsModel extends Model
{
    private $itemsPerPage = 10;
    private $limit = 0;

    public function getWords()
    {
        if (!empty(explode("/", $_SERVER['REQUEST_URI'])[3])) {
            $this->limit = explode("/", $_SERVER['REQUEST_URI'])[3];
        }
        $this->con->select('*');
        $this->con->from('words');
        $this->con->orderBy('id', 'desc');
        $this->con->limit("$this->limit, $this->itemsPerPage");
        return $this->con->get();
    }

    public function getWordPages()
    {
        $numberOfWords = $this->con->get('COUNT(*)', 'words');
        $numberOfPages = ceil($numberOfWords[0]['COUNT(*)'] / $this->itemsPerPage);
        return $numberOfPages;
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