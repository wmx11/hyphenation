<?php

namespace Inc\Helper;

use Inc\Model\Uri;

class ApiUrlParser extends Uri
{
    private $api = "api";
    const HOOK = 2;
    const TABLENAME = 3;
    const ENDPOINT = 4;
    const BEFORE_QUERY = 0;

    public function setTableNameInitial()
    {
        return $this->segment(self::TABLENAME);
    }

    public function setId()
    {
        return $this->segment(self::ENDPOINT);
    }

    public function setEndpoint()
    {
        if (is_numeric($this->segment(self::ENDPOINT)) === false) {
            return $this->segment(self::ENDPOINT);
        }
    }

    public function extractTableNameFromGet()
    {
        $url = $this->getUrl();
        if (strpos($url, "?") !== false) {
            $url_path = explode("?", $url)[self::BEFORE_QUERY];
            $tableName = explode('/', $url_path)[self::TABLENAME];
            return $tableName;
        }
    }

    public function validateUrlGet()
    {
        if ($this->segment(self::HOOK) === $this->api && empty($this->segment(self::ENDPOINT)) === true) {
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
        if ($this->segment(self::HOOK) === $this->api) {
            return true;
        } else {
            return false;
        }
    }

    public function validateUrlParametersGet()
    {
        if ($this->segment(self::HOOK) === $this->api && filter_var($this->segment(self::ENDPOINT), FILTER_VALIDATE_INT)) {
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