<?php

namespace Pessoa\Controller;
use Zend\Mvc\Controller\AbstractActionController; // Class  AbstractActionController vem do zend
use Zend\View\Model\ViewModel;

class PessoaController extends AbstractActionController {

    public function indexAction() { // todo action tem que retornar uma view
        return new ViewModel();
    }
}

?>