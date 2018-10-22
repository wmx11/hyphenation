<?php

namespace Inc\Application\Controller;

use Inc\Application\Core\Controller;
use Inc\Application\Model\PatternsModel;

class Patterns extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new PatternsModel();
    }

    public function home()
    {
        $patterns = $this->model->getPatterns();
        $patternCount = $this->model->patternCount()[0]['COUNT(*)'];
        echo $this->loadView('head');
        echo $this->loadView('sidebar');
        echo $this->loadView('submitForm');
        echo $this->loadView('editPopup');
        echo $this->loadView('patterns', $patterns);
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