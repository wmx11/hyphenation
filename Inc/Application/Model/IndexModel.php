<?php

namespace Inc\Application\Model;

use Inc\Application\Core\Model;

class IndexModel extends Model
{

    public function getPattersCount()
    {
        $patterns = $this->con->get('COUNT(*)', 'patterns');
        return number_format($patterns[0]['COUNT(*)']);
    }

    public function getWordsCount()
    {
        $words = $this->con->get('COUNT(*)', 'words');
        return number_format($words[0]['COUNT(*)']);
    }

}