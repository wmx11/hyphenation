<?php

namespace Inc\Application\Controller;

use Inc\Application\Core\Controller;
use Inc\Application\Model\IndexModel;

class Index extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new IndexModel();
    }

    public function home()
    {
        $data['patternCount'] = $this->model->getPattersCount();
        $data['wordCount'] = $this->model->getWordsCount();

        $this->loadView('head');
        $this->loadView('sidebar');
        $this->loadView('submitForm');
        $this->loadView('index', $data);
        $this->loadView('footer');
    }

    public function test()
    {
        echo $this->model->getTest();
    }
}