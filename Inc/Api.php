<?php

namespace Inc;

use Inc\Helper\ApiUrlParser;
use Inc\Database\Database;

class Api extends ApiUrlParser
{
    private $db;
    private $id;
    private $tableName;
    private $endPoint;

    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->setUriParameters();
        $this->tableName = $this->setTableNameInitial();
        $this->id = $this->setId();
        $this->endPoint = $this->setEndpoint();
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
            $query = $this->buildQuery();
            $tableName = $this->extractTableNameFromGet();
            $this->db->select();
            $this->db->from($tableName);
            $this->db->where($query);
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
}
