<?php

namespace Inc\Application\Controller;

use Inc\Application\Core\Controller;
use Inc\Application\Core\Model;

class Index extends Controller
{
    public function home()
    {
        echo $this->loadView('head');
        echo $this->loadView('sidebar');
        echo $this->loadView('submitForm');
        echo $this->loadView('index');
        echo $this->loadView('footer');
    }
}