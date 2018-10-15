<?php

namespace Inc;

use PDO;
use PDOException;

class Database extends QueryBuilder implements DatabaseInterface
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
        } catch (PDOException $e) {
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

    private function resetValues()
    {
        $this->rowValues = "";
        $this->insertValues = "";
        $this->updateValues = "";
    }

    public function insert($tableName, $data)
    {
        $this->setValues($data);
        $sql = "INSERT INTO $tableName ($this->rowValues) VALUES ($this->insertValues)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($data);
        $this->resetValues();
        echo "Inserted";
    }

    public function get($select = null, $tableName = null, $parameter = null)
    {
        $sql = null;
        if ($select !== null || $tableName !== null || $parameter !== null) {
            $sql = "SELECT $select FROM $tableName $parameter";
        } else {
            $sql = $this->returnQuery();
        }
        $stmt = $this->connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return $stmt;

    }

    public function delete($tableName = null, $where = null)
    {
        $sql = null;
        if ($tableName !== null || $where !== null) {
            $sql = "DELETE FROM $tableName WHERE $where";
        } else {
            $sql = "DELETE " . $this->returnQuery();
        }
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
        $this->resetValues();
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