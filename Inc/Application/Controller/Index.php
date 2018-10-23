<?php

namespace Inc\Application\Controller;

use Inc\Application\Core\Controller;

class Index extends Controller
{
    public function home()
    {
        $this->loadView('head');
        $this->loadView('sidebar');
        $this->loadView('submitForm');
        $this->loadView('index');
        $this->loadView('footer');
    }
}