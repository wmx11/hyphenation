<?php

namespace Inc;

use PDO;
use PDOException;

class Database implements DatabaseInterface
{
    private $rowValues;
    private $insertValues;
    private $updateValues;
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
     * @param $data an array with column_name => value;
     */

    private function setValues($data)
    {
        foreach ($data as $row => $value) {
            $this->rowValues .= ", " . $row;
            $this->insertValues .= " :" . $row . ",";
            $this->updateValues .= "$row=:$row, ";
        }
        $row = ltrim($this->rowValues, ", ");
        $values = rtrim(ltrim($this->insertValues, " "), ",");
        $update = rtrim($this->updateValues, ", ");

        $this->rowValues = $row;
        $this->insertValues = $values;
        $this->updateValues = $update;
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
        $this->updateValues = "";
        echo "Inserted";
    }

    public function get($select = "*", $tableName, $parameter = null)
    {
        $sql = "SELECT $select FROM $tableName $parameter";
        $stmt = $this->connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return $stmt;
    }

    public function delete($tableName, $where)
    {
        $sql = "DELETE FROM $tableName WHERE $where";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        echo "Deleted";
    }

    public function update($tableName, $data, $where)
    {
        $this->setValues($data);
        $sql = "UPDATE $tableName SET $this->updateValues WHERE $where";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($data);
        $this->rowValues = "";
        $this->insertValues = "";
        $this->updateValues = "";
        echo "Updated";
    }

    public function clear($tableName)
    {
        $sql = "DELETE FROM $tableName";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
    }

    public function beginTransaction()
    {
        $this->connection->beginTransaction();
    }

    public function commit()
    {
        $this->connection->commit();
    }

    public function rollBack()
    {
        $this->connection->rollBack();
    }
}