<?php

namespace Inc;

use PDO;
use PDOException;

class Database implements DatabaseInterface
{
    private $rowValues;
    private $insertValues;
    private $connection;

    public function __construct()
    {
        $db = require_once('Config.php');
        $localhost = $db->localhost;
        $database = $db->database;
        $user = $db->user;
        $password = $db->password;

        try {
            $this->connection = new PDO("mysql:host=$localhost;dbname=$database", $user, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function __destruct()
    {
        $this->connection = null;
    }

    public function connect()
    {
        return $this->connection;
    }

    /**
     * @param $data is an array with column name => value;
     */

    private function setValues($data)
    {
        foreach ($data as $row => $value) {
            $this->rowValues .= ", " . $row;
            $this->insertValues .= " :" . $row . ",";
        }
        $row = ltrim($this->rowValues, ", ");
        $values = rtrim(ltrim($this->insertValues, " "), ",");

        $this->rowValues = $row;
        $this->insertValues = $values;
    }

    public function insert($tableName, $data)
    {
        $this->setValues($data);
        $sql = "INSERT INTO $tableName ($this->rowValues) VALUES ($this->insertValues)";
        $stmt = $this->connection->prepare($sql);
        //echo $sql . "\r\n";
        $stmt->execute($data);
        $this->rowValues = "";
        $this->insertValues = "";
    }

    public function get($select = "*", $tableName, $parameter = null)
    {
        $sql = "SELECT $select FROM $tableName $parameter";
        $stmt = $this->connection->query($sql)->fetchAll();
        return $stmt;
    }

    public function delete($tableName, $where)
    {
        $sql = "DELETE FROM $tableName WHERE $where";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
    }

    public function clear($tableName)
    {
        $sql = "DELETE FROM $tableName";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
    }
}