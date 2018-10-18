<?php

namespace Controller;

class Views
{
    private $views = [];

    public function __construct()
    {
        $this->create('index', "./");
        $this->create('Sidebar', 'Views');
        $this->create('Head', 'Views');
        $this->create('Footer', 'Views');
        $this->create('SendForm', 'Views');
        $this->create('EditForm', 'Views');
    }

    public function create($viewName, $path = null)
    {
        $this->views[$viewName] = [$viewName => "$path/$viewName.php"];
    }

    public function load($viewName){
        include ($this->views[$viewName][$viewName]);
    }
}