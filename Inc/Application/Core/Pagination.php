<?php

namespace Inc\Application\Core;

class Pagination
{
    const POSITION_PAGE_NUMBER = 3;
    const POSITION_CONTROLLER_NAME = 2;

    public function paginate()
    {
        $pageSegment = explode("/", $_SERVER['REQUEST_URI'])[self::POSITION_PAGE_NUMBER];
        $page = explode("/", $_SERVER['REQUEST_URI'])[self::POSITION_CONTROLLER_NAME];
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