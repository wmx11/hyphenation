<?php

namespace Inc\Application\Controller;

use Inc\Application\Core\Controller;
use Inc\Application\Model\WordsModel;

class Words extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new WordsModel();
    }

    public function home()
    {
        $words = $this->model->getWords();
        echo $this->loadView('head');
        echo $this->loadView('sidebar');
        echo $this->loadView('submitForm');
        echo $this->loadView('editPopup');
        echo $this->loadView('words', $words);
        echo $this->loadView('footer');
    }

    public function submit()
    {
        $tableName = $_POST['table'];
        $word = $_POST['word'];
        $this->model->insertWord($tableName, $word);
    }

    public function delete()
    {
        $word = $_POST['word'];
        $this->model->deleteWord($word);
    }

    public function edit()
    {
        $word = $_POST['word'];
        $editValue = $_POST['editedWord'];
        $this->model->editWord($word, $editValue);
    }
}