<?php

namespace Pessoa\Controller;
use Zend\Mvc\Controller\AbstractActionController; // Class  AbstractActionController vem do zend
use Zend\View\Model\ViewModel;

class PessoaController extends AbstractActionController {

    public function indexAction() { // todo action tem que retornar uma view
        return new ViewModel();
    }

    public function adicionarAction(){
        return new ViewModel();
    }

    public function salvarAction(){
        return new ViewModel();
    }

    public function editarAction(){
        return new ViewModel();
    }

    public function removerAction(){
        return new ViewModel();
    }

    public function confirmacaoAction(){
    }
}

?>