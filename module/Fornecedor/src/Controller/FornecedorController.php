<?php

namespace Fornecedor\Controller;

// use Fornecedor\Model\Fornecedor;
// use Fornecedor\Model\FornecedorTable;

use Exception;
use Fornecedor\Form\FornecedorForm;
use Zend\Mvc\Controller\AbstractActionController; // Class  AbstractActionController vem do zend
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\Plugin\Url;

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
        $form = new FornecedorForm();
        $form->get('submit')->setValue('Adicionar');
        $request = $this->getRequest(); ///Pega as informações da requisição que foi enviado pelo php via objeto
        if (!$request->isPost())
            return new ViewModel(['form' => $form]);

        $fornecedor = new \Fornecedor\Model\Fornecedor();
        $form->setData($request->getPost());
        if (!$form->isValid()) 
            return new ViewModel(['form' => $form]);

        $fornecedor->exchangeArray($form->getData());
        $this->table->salvarFornecedor($fornecedor);
        return $this->redirect()->toRoute('fornecedor');
    }

    public function editarAction() {
        $id = (int) $this->params()->fromRoute('id', 0); // pega o param id se não tiver ele assume 0
        if ($id === 0)
            return $this->redirect()->toRoute('fornecedor', ['action' => 'adicionar']);
        
        try {
            $fornecedor = $this->table->getFornecedor($id);
        } catch (Exception $exc) {
            return $this->redirect()->toRoute('fornecedor', ['action' => 'index']);
        }

        $form = new FornecedorForm();
        $form->bind($fornecedor); //vai receber fornecedor e vai pegar os dados e vai popular
        $form->get('submit')->setAttribute('value', 'Salvar');
        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];
        if (!$request->isPost())
            return $viewData;

        $form->setData($request->getPost());
        if (!$form->isValid()) 
            return $viewData;

        $this->table->salvarFornecedor($form->getData());
        return $this->redirect()->toRoute('fornecedor');
    }

    public function removerAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (0 == $id)
            return $this->redirect()->toRoute('fornecedor');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $deletar = $request->getPost('deletar','Não');
            if ($deletar == 'Sim') {
                $id = (int) $request->getPost('id');
                $this->table->deletarFornecedor($id);
            }
            return $this->redirect()->toRoute('fornecedor');
        }
        return ['id' => $id, 'fornecedor' => $this->table->getFornecedor($id)];
    }

    public function cardapioAction() {
        $form = new FornecedorForm();
      
            return new ViewModel(['form' => $form]);
        
    }

    public function testeAction() {
        $request = $this->getRequest();
        $params = $request->getPost()->toArray();
        $form = new FornecedorForm();
        if (!$request->isPost())
            return new ViewModel(['form' => $form]);

        $fornecedor = new \Fornecedor\Model\Fornecedor();
        $form->setData($request->getPost());
        if (!$form->isValid()) 
            return new ViewModel(['form' => $form]);
//storage
        print_r($params['data']);
        die('aloo');
        // $fornecedor->exchangeArray($form->getData());
        // $this->table->salvarFornecedor($fornecedor);
        // return $this->redirect()->toRoute('fornecedor');
    }

}

?>