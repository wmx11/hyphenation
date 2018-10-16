<?php

namespace Inc\Helper;

use Inc\Model\Uri;

class ApiUrlParser extends Uri
{
    private $api = "api";

    public function setTableNameInitial()
    {
        return $this->segment(3);
    }

    public function setId()
    {
        return $this->segment(4);
    }

    public function setEndpoint()
    {
        if (is_numeric($this->segment(4)) === false) {
            return $this->segment(4);
        }
    }

    public function extractTableNameFromGet()
    {
        $url = $this->getUrl();
        if (strpos($url, "?") !== false) {
            $url_path = explode("?", $url)[0];
            $tableName = explode('/', $url_path)[3];
            return $tableName;
        }
    }

    public function validateUrlGet()
    {
        if ($this->segment(2) === $this->api && empty($this->segment(4)) === true) {
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
        if ($this->segment(2) === $this->api) {
            return true;
        } else {
            return false;
        }
    }

    public function validateUrlParametersGet()
    {
        if ($this->segment(2) === $this->api && filter_var($this->segment(4), FILTER_VALIDATE_INT)) {
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