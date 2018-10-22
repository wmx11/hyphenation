<?php

namespace Inc\Application\Controller;

use Inc\Application\Core\Controller;
use Inc\Application\Core\Pagination;
use Inc\Application\Model\PatternsModel;

class Patterns extends Controller
{
    private $model;
    private $pagination;

    public function __construct()
    {
        $this->model = new PatternsModel();
        $this->pagination = new Pagination();
    }

    public function home()
    {
        $data['patterns'] = $this->model->getPatterns();
        $data['paginate'] = $this->pagination;

        echo $this->loadView('head');
        echo $this->loadView('sidebar');
        echo $this->loadView('submitForm');
        echo $this->loadView('editPopup');
        echo $this->loadView('patterns', $data);
        echo $this->loadView('footer');
    }

    public function delete()
    {
        $pattern = $_POST['pattern'];
        $this->model->deletePattern($pattern);
    }

    public function edit()
    {
        $pattern = $_POST['pattern'];
        $editValue = $_POST['editedPattern'];
        $this->model->editPattern($pattern, $editValue);
    }

}