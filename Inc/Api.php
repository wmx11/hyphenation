<?php

namespace Inc;

use Inc\Helper\ApiUrlParser;

class Api extends ApiUrlParser
{
    private $db;
    private $url;
    private $id;
    private $api = "api";
    private $query;
    private $tableName;
    private $endPoint;

    public function __construct($db)
    {
        $this->db = $db;
        $this->url = $this->setUrl();
        $this->setParameters();
    }

    public function __destruct()
    {
        $this->db = null;
    }

    public function runApi()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->get();
                break;

            case 'POST':
                $this->post();
                break;

            case 'PUT':
                $this->put();
                break;

            case 'DELETE':
                $this->delete();
                break;

            default:
                echo "Access Denied";
                break;
        }
    }

    private function setParameters()
    {
        // Set Table Name
        $this->tableName = $this->url[3];

        // Set ID for Get Request
        if (!empty($this->url[4])) {
            $this->id = $this->url[4];
        }

        // Set Endpoint for Post, Put, Delete Requests
        if (!empty($this->url[4]) && is_numeric($this->url[4]) === false) {
            $this->endPoint = $this->url[4];
        }
    }

    private function validateUrlGet()
    {
        if (!empty($this->url[2]) && $this->url[2] === $this->api && empty($this->url[4])) {
            return true;
        } else {
            return false;
        }
    }

    private function getParameters()
    {
        if (strpos($_SERVER['REQUEST_URI'], "?") !== false) {
            return true;
        } else {
            return false;
        }
    }

    private function validateAnchor()
    {
        if (!empty($this->url[2]) && $this->url[2] === $this->api) {
            return true;
        } else {
            return false;
        }
    }

    private function validateUrlParametersGet()
    {
        if (!empty($this->url[4]) && $this->url[2] === $this->api && filter_var($this->url[4], FILTER_VALIDATE_INT)) {
            return true;
        } else {
            return false;
        }
    }

    private function buildQuery()
    {
        $string = "";
        foreach ($_GET as $column => $filter) {
            if (is_numeric($filter) === true) {
                $string .= "$column = $filter AND ";
            } else {
                $string .= "$column = '$filter' AND ";
            }
        }
        $this->query = preg_replace('/[^A-Za-z0-9\-=_ ]/', '', rtrim($string, " AND"));
        $this->setTableName();
    }

    private function setTableName()
    {
        // TODO -- Remove key indexes, find a method
        $url = explode("?", $_SERVER['REQUEST_URI'])[0];
        $this->tableName = explode("/", $url)[3];
    }

    private function get()
    {
        if ($this->validateUrlGet() === true && $this->getParameters() === false) {
            header("Content-Type: application/json");
            $this->db->select();
            $this->db->from($this->tableName);
            $this->db->orderBy('id', 'desc');
            $this->db->limit(20);
            $patterns = $this->db->get();
            print_r(json_encode($patterns));

        } elseif ($this->validateUrlParametersGet() === true && $this->getParameters() === false) {
            header("Content-Type: application/json");
            $this->db->select();
            $this->db->from($this->tableName);
            $this->db->where("id = $this->id");
            $patterns = $this->db->get();
            print_r(json_encode($patterns));

        } elseif ($this->getParameters() === true) {
            header("Content-Type: application/json");
            $this->buildQuery();
            $this->db->select();
            $this->db->from($this->tableName);
            $this->db->where($this->query);
            $patterns = $this->db->get();
            print_r(json_encode($patterns));
        }
    }

    private function post()
    {
        if ($this->validateAnchor() === true && $this->endPoint === 'post') {
            $info = json_decode(file_get_contents("php://input"), true);
            $this->db->insert($this->tableName, $info);
        }
    }

    private function put()
    {
        if ($this->validateAnchor() === true && $this->endPoint === 'put') {
            $info = json_decode(file_get_contents("php://input"), true);
            $id = $info['id'];
            $data = array_splice($info, 1, 1);
            $this->db->update($this->tableName, $data, "id = $id");
        }
    }

    private function delete()
    {
        if ($this->validateAnchor() === true && $this->endPoint === 'delete') {
            $info = json_decode(file_get_contents("php://input"), true);
            $id = $info['id'];
            $this->db->delete($this->tableName, "id = $id");
        }
    }

    public function getUrl()
    {
        return $this->url;
    }
}
// TODO metodas key'ams