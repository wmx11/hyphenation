<?php

namespace Controller;

use Inc\Model\Uri;

class Controller {

    public $view;
    public $uri;

    public function __construct()
    {
        $this->view = new Views();
        $this->uri = new Uri();
    }

    public function index()
    {
        $this->view->create('index', "./");
        $this->view->create('Sidebar', 'Views');
        $this->view->create('Head', 'Views');
        $this->view->create('Footer', 'Views');
        $this->view->load('Head');
        $this->view->load('Sidebar');
        $this->view->load('Footer');
        $this->uri->setUriParameters();
    }

}