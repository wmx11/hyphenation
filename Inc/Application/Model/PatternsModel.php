<?php

namespace Inc\Application\Model;

use Inc\Application\Core\Model;

class PatternsModel extends Model
{
    private $itemsPerPage = 10;
    private $limit = 0;

    public function getPatterns()
    {
        if (!empty(explode("/", $_SERVER['REQUEST_URI'])[3])) {
            $this->limit = explode("/", $_SERVER['REQUEST_URI'])[3];
        }
        $this->con->select('*');
        $this->con->from('patterns');
        $this->con->orderBy('id', 'desc');
        $this->con->limit("$this->limit, $this->itemsPerPage");
        return $this->con->get();
    }

    public function getPatternPages()
    {
        $numberOfWords = $this->con->get('COUNT(*)', 'patterns');
        $numberOfPages = ceil($numberOfWords[0]['COUNT(*)'] / $this->itemsPerPage);
        return $numberOfPages;
    }

    public function getPattern($pattern)
    {
        $this->con->select('*');
        $this->con->from('patterns');
        $this->con->where("pattern = '$pattern'");
        return $this->con->get();
    }

    public function deletePattern($pattern)
    {
        $deletePattern = '"' . trim($pattern) . '"';
        $this->con->delete('patterns', "pattern = $deletePattern");
    }

    public function editPattern($pattern, $editValue)
    {
        $data = array("pattern" => trim($editValue));
        $updatePattern = '"' . trim($pattern) . '"';
        $this->con->update('patterns', $data, "pattern = $updatePattern");
    }
}

