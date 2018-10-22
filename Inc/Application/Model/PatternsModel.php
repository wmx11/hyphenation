<?php

namespace Inc\Application\Model;

use Inc\Application\Core\Model;

class PatternsModel extends Model
{
    public function getPatterns()
    {
        $itemsPerPage = 10;
        $limit = 0;
        if (!empty(explode("/", $_SERVER['REQUEST_URI'])[3])) {
            $limit = explode("/", $_SERVER['REQUEST_URI'])[3];
        }
        $this->con->select('*');
        $this->con->from('patterns');
        $this->con->orderBy('id', 'asc');
        $this->con->limit("$limit, $itemsPerPage");
        return $this->con->get();
    }

    public function patternCount()
    {
        return $this->con->get("COUNT(*)", 'patterns');
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
        $data = ["pattern" => trim($editValue)];
        $updatePattern = '"' . trim($pattern) . '"';
        $this->con->update('patterns', $data, "pattern = $updatePattern");
    }
}