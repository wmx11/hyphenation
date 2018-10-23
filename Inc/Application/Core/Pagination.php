<?php

namespace Inc\Application\Core;

class Pagination
{
    const PAGE = 3;
    const CONTROLLER = 2;

    public function paginate()
    {
        $pageSegment = explode("/", $_SERVER['REQUEST_URI'])[self::PAGE];
        $page = explode("/", $_SERVER['REQUEST_URI'])[self::CONTROLLER];
        if (empty($pageSegment) === true || $pageSegment === 0) {
            $nextPage = $pageSegment + 10;
            $prevPage = 0;
            $data['nextPage'] = $nextPage;
            $data['prevPage'] = $prevPage;
            $data['page'] = $page;
            return $data;
        } elseif ($pageSegment >= 10) {
            $nextPage = $pageSegment + 10;
            $prevPage = $pageSegment - 10;
            $data['nextPage'] = $nextPage;
            $data['prevPage'] = $prevPage;
            $data['page'] = $page;
            $data['pageNumber'] = $pageSegment;
            return $data;
        }
    }
}