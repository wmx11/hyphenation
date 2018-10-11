<?php

namespace Inc;

use Inc\Database;

class Api
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function __destruct()
    {
        $this->db = null;
    }

    public function runApi()
    {
        switch($_SERVER['REQUEST_METHOD']) {
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

    public function get()
    {
        if(isset($_GET['get'])) {
            $request = $_GET['get'];
            if ($request === 'patterns') {
                header("Access-Control-Allow-Methods: GET");
                header("Content-Type: application/json");
                $patterns = $this->db->get('id, pattern', 'patterns', "limit 50");
                print_r(json_encode($patterns));
            } elseif ($request === 'pattern' && filter_var($_GET['id'], FILTER_VALIDATE_INT) !== false) {
                $id = $_GET['id'];
                header("Access-Control-Allow-Methods: GET");
                header("Content-Type: application/json");
                $pattern = $this->db->get('id, pattern', 'patterns', "WHERE id = $id");
                print_r(json_encode($pattern));
            }
        }
    }

    public function post()
    {
        $insert = $_GET['insert'];
        $info = json_decode(file_get_contents("php://input"), true);
        $this->db->insert($insert, $info);
    }

    public function put()
    {
        $table = $_GET['update'];
        $id = $_GET['id'];
        $info = json_decode(file_get_contents("php://input"), true);
        $this->db->update($table, $info, "id = $id");
    }

    public function delete()
    {
        $table = $_GET['delete'];
        $id = $_GET['id'];
        $this->db->delete($table, "id = $id");
    }
}