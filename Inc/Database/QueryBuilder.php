<?php

namespace Inc\Database;

class QueryBuilder extends AbstractQueryBuilder
{
    private $query = [];

    public function select($select = "*")
    {
        return $this->query[] = "SELECT $select";
    }

    public function from($tableName)
    {
        return $this->query[] = " FROM $tableName";
    }

    public function where($where = null)
    {
        if ($where !== null) {
            return $this->query[] = " WHERE $where";
        }
    }

    public function orderBy($orderBy = null, $order = null)
    {
        if ($orderBy !== null && $order !== null) {
            return $this->query[] = " ORDER BY $orderBy $order";
        }
    }

    public function limit($limit = null, $limit2 = null)
    {
        if ($limit !== null) {
            return $this->query[] = " LIMIT $limit $limit2";
        }
    }

    public function returnQuery()
    {
        return implode($this->query);
    }
}