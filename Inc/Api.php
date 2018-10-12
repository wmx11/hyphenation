<?php

namespace Inc;

use Inc\Database;

class Api
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
        $this->setUrl();
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

    private function setUrl()
    {
        if (strpos($_SERVER['REQUEST_URI'], "?") === false) {
            $this->url = explode("/", $_SERVER['REQUEST_URI']);
        }
    }

    private function setParameters()
    {
        $this->tableName = $this->url[3]; // Sets Table Name
        if (!empty($this->url[4])): $this->id = $this->url[4]; endif; // Sets ID for Get Request
        if (!empty($this->url[4]) && is_numeric($this->url[4]) === false): $this->endPoint = $this->url[4]; endif; // Sets Endpoint for Post, Put, Delete Requests
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
        foreach ($_GET as $key => $value) {
            if (is_numeric($value) === true) {
                $string .= "$key = $value AND ";
            } else {
                $string .= "$key = '$value' AND ";
            }
        }
        $this->query = rtrim($string, " AND");
        $this->setTableName();
    }

    private function setTableName()
    {
        $url1 = explode("?", $_SERVER['REQUEST_URI'])[0];
        $this->tableName = explode("/", $url1)[3];
    }

    private function get()
    {
        if ($this->validateUrlGet() === true && $this->getParameters() === false) {
            header("Content-Type: application/json");
            $patterns = $this->db->get('*', $this->tableName, "limit 50");
            print_r(json_encode($patterns));

        } elseif ($this->validateUrlParametersGet() === true && $this->getParameters() === false) {
            header("Content-Type: application/json");
            $patterns = $this->db->get('*', $this->tableName, "WHERE id = $this->id");
            print_r(json_encode($patterns));

        } elseif ($this->getParameters() === true) {
            header("Content-Type: application/json");
            $this->buildQuery();
            $patterns = $this->db->get('*', $this->tableName, "WHERE $this->query");
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
}