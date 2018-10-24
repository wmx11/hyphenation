<?php

namespace Inc\Application\Controller;

use Inc\Application\Core\Controller;
use Inc\Application\Model\TableModel;

class Submit extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new TableModel();
    }

    public function insert()
    {
        $tableName = $_POST['table'];
        $word = $_POST['word'];
        $this->model->insertWord($tableName, $word);
    }
}