<?php

namespace Inc\Application\Controller;

use Inc\Application\Core\Controller;
use Inc\Application\Model\WordsModel;
use Inc\Application\Core\Pagination;

class Words extends Controller
{
    private $model;
    private $pagination;

    public function __construct()
    {
        $this->model = new WordsModel();
        $this->pagination = new Pagination();
    }

    public function home()
    {
        $data['words'] = $this->model->getWords();
        $data['paginate'] = $this->pagination;
        $data['numberOfPages'] = $this->model->getWordPages();

        $this->loadView('head');
        $this->loadView('sidebar');
        $this->loadView('submitForm');
        $this->loadView('editPopup');
        $this->loadView('words', $data);
        $this->loadView('footer');
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