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
}