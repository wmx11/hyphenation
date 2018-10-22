<?php

namespace Inc\Application\Model;

use Inc\Application\Core\Model;

class PatternsModel extends Model
{
    public function getPatterns()
    {
        $this->con->select('*');
        $this->con->from('patterns');
        $this->con->orderBy('id', 'desc');
        $this->con->limit(10);
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
        $deletePattern = '"'.trim($pattern).'"';
        $this->con->delete('patterns', "pattern = $deletePattern");
    }

    public function editPattern($pattern, $editValue)
    {
        $data = ["pattern" => trim($editValue)];
        $updatePattern = '"'.trim($pattern).'"';
        $this->con->update('patterns', $data, "pattern = $updatePattern");
    }
}