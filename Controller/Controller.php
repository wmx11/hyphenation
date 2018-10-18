<?php

namespace Controller;

use Inc\Model\Uri;
use Model\Model;

class Controller {

    public $view;
    public $uri;
    public $model;

    public function __construct()
    {
        $this->view = new Views();
        $this->uri = new Uri();
        $this->model = new Model();
    }

    public function index()
    {
        if(isset($_GET['addnew'])) {
            $this->addNew();
        } elseif (isset($_GET['editword'])) {
            $this->edit();
        } elseif (isset($_GET['editpattern'])) {
            $this->edit();
        } else {
            $this->view->load('Head');
            $this->view->load('Sidebar');
            $this->view->load('Footer');
            $this->uri->setUriParameters();
        }
    }

    public function addNew()
    {
        $this->view->load('Head');
        $this->view->load('Sidebar');
        $this->view->load('SendForm');
        $this->view->load('Footer');
    }

    public function edit()
    {
        $this->view->load('Head');
        $this->view->load('Sidebar');
        $this->view->load('EditForm');
        $this->view->load('Footer');
    }

}