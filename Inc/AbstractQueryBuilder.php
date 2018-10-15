<?php

namespace Inc;

abstract class AbstractQueryBuilder
{
    abstract function select();
    abstract function from($tableName);
    abstract function where();
    abstract function orderBy();
    abstract function limit();
    abstract function returnQuery();
}