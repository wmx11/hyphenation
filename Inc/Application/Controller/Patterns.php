<?php

namespace Inc\Application\Controller;

use Inc\Application\Core\Controller;
use Inc\Application\Core\Pagination;
use Inc\Application\Model\PatternsModel;

class Patterns extends Controller
{
    private $model;
    private $pagination = null;

    public function __construct()
    {
        $this->model = new PatternsModel();
        if ($this->pagination === null) {
            $this->pagination = new Pagination();
        }
    }

    public function home()
    {
        $data['patterns'] = $this->model->getPatterns();
        $data['paginate'] = $this->pagination;
        $data['numberOfPages'] = $this->model->getPatternPages();

        $this->loadView('head');
        $this->loadView('sidebar');
        $this->loadView('submitForm');
        $this->loadView('editPopup');
        $this->loadView('patterns', $data);
        $this->loadView('footer');
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