<?php

namespace Model;

use Inc\Database\Database;

class Model
{
    private $con;

    public function __construct()
    {
        $this->con = new Database();
    }

    public function getAllWords()
    {
        $this->con->select('*');
        $this->con->from('words');
        $this->con->orderBy('id', 'desc');
        $this->con->limit(10);
        return $this->con->get();
    }

    public function getAllPatterns()
    {
        $this->con->select('*');
        $this->con->from('patterns');
        $this->con->orderBy('id', 'desc');
        $this->con->limit(10);
        return $this->con->get();
    }

    public function insert($tableName, $insert)
    {
        $data = [];
        if ($tableName === 'patterns') {
            $data = ["pattern" => $insert];
        } elseif ($tableName === 'words') {
            $data = ["word" => $insert];
        }
        $this->con->insert($tableName, $data);
    }

    public function update($tableName, $update, $id)
    {
        $data = [];
        if ($tableName === 'patterns') {
            $data = ["pattern" => $update];
        } elseif ($tableName === 'words') {
            $data = ["word" => $update];
        }
        $this->con->update($tableName, $data, "id = $id");
    }

    public function get($tableName, $id)
    {
        $this->con->select('*');
        $this->con->from($tableName);
        $this->con->where("id = $id");
        return $this->con->get();
    }

    public function delete($id)
    {
        $this->con->from('words');
        $this->con->where("id = $id");
        $this->con->delete();
    }
}