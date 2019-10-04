<?php

namespace Fornecedor\Controller;

use Fornecedor\Model\Fornecedor;
// use Fornecedor\Model\FornecedorTable;
use Zend\Mvc\Controller\AbstractActionController; // Class  AbstractActionController vem do zend
use Zend\View\Model\ViewModel;

class FornecedorController extends AbstractActionController {

    private $table;

    public function __construct($table) {
        $this->table = $table;
    }

    public function indexAction() { // todo action tem que retornar uma view

        // return new ViewModel(['Fornecedores' => FornecedorTable::fetchAll()]);
        return new ViewModel(['fornecedores' => $this->table->fetchAll()]);
    }

    public function adicionarAction() {
        return new ViewModel();
    }

    public function salvarAction() {
        return new ViewModel();
    }

    public function editarAction() {
        return new ViewModel();
    }

    public function removerAction() {
        return new ViewModel();
    }

    public function confirmacaoAction() {
    }
}

?>