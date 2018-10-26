<?php

namespace Inc\Helper;

use Inc\Model\Uri;

class ApiUrlParser extends Uri
{
    private $hook = "api";
    const POSITION_HOOK = 2;
    const POSITION_TABLENAME = 3;
    const POSITION_ENDPOINT = 4;
    const POSITION_BEFORE_QUERY = 0;

    public function setTableNameInitial()
    {
        return $this->segment(self::POSITION_TABLENAME);
    }

    public function setId()
    {
        return $this->segment(self::POSITION_ENDPOINT);
    }

    public function setEndpoint()
    {
        if (is_numeric($this->segment(self::POSITION_ENDPOINT)) === false) {
            return $this->segment(self::POSITION_ENDPOINT);
        }
    }

    public function extractTableNameFromGet()
    {
        $url = $this->getUrl();
        if (strpos($url, "?") !== false) {
            $url_path = explode("?", $url)[self::POSITION_BEFORE_QUERY];
            $tableName = explode('/', $url_path)[self::POSITION_TABLENAME];
            return $tableName;
        }
    }

    public function validateUrlGet()
    {
        if ($this->segment(self::POSITION_HOOK) === $this->hook && empty($this->segment(self::POSITION_ENDPOINT)) === true) {
            return true;
        } else {
            return false;
        }
    }

    public function getParameters()
    {
        if (strpos($this->getUrl(), "?") !== false) {
            return true;
        } else {
            return false;
        }
    }

    public function validateAnchor()
    {
        if ($this->segment(self::POSITION_HOOK) === $this->hook) {
            return true;
        } else {
            return false;
        }
    }

    public function validateUrlParametersGet()
    {
        if ($this->segment(self::POSITION_HOOK) === $this->hook && filter_var($this->segment(self::POSITION_ENDPOINT), FILTER_VALIDATE_INT)) {
            return true;
        } else {
            return false;
        }
    }

    public function buildQuery()
    {
        $string = "";
        foreach ($_GET as $column => $filter) {
            if (is_numeric($filter) === true) {
                $string .= "$column = $filter AND ";
            } else {
                $string .= "$column = '$filter' AND ";
            }
        }
        $query = preg_replace('/[^A-Za-z0-9\-=_ ]/', '', rtrim($string, " AND"));
        return $query;
    }
}