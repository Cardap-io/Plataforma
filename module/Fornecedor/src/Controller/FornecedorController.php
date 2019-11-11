<?php

namespace Fornecedor\Controller;

use Exception;
// use Fornecedor\Form\FornecedorForm;
use Fornecedor\Form\ItemForm;
use Zend\Mvc\Controller\AbstractActionController; // Class  AbstractActionController vem do zend
use Zend\View\Model\ViewModel;

class FornecedorController extends AbstractActionController {

    private $tableFornecedor;
    private $tableItem;
    private $tableTitulo;

    public function __construct($tableFornecedor,$tableItem,$tableTitulo) {
        $this->tableFornecedor = $tableFornecedor;
        $this->tableItem = $tableItem;
        $this->tableTitulo = $tableTitulo;
    }

    public function indexAction() { // todo action tem que retornar uma view
        // return new ViewModel(['Fornecedores' => FornecedorTable::fetchAll()]);
        return new ViewModel(['fornecedores' => $this->tableFornecedor->fetchAll()]);
    }

    // public function adicionarAction() {
    //     $form = new FornecedorForm();
    //     $form->get('submit')->setValue('Adicionar');
    //     $request = $this->getRequest(); ///Pega as informações da requisição que foi enviado pelo php via objeto
    //     if (!$request->isPost())
    //         return new ViewModel(['form' => $form]);

    //     $fornecedor = new \Fornecedor\Model\Fornecedor();
    //     $form->setData($request->getPost());
    //     if (!$form->isValid()) 
    //         return new ViewModel(['form' => $form]);

    //     $fornecedor->exchangeArray($form->getData());
    //     $this->tableFornecedor->salvarFornecedor($fornecedor);
    //     return $this->redirect()->toRoute('fornecedor');
    // }

    // public function editarAction() {
    //     $id = (int) $this->params()->fromRoute('id', 0); // pega o param id se não tiver ele assume 0
    //     if ($id === 0)
    //         return $this->redirect()->toRoute('fornecedor', ['action' => 'adicionar']);
        
    //     try {
    //         $fornecedor = $this->tableFornecedor->getFornecedor($id);
    //     } catch (Exception $exc) {
    //         return $this->redirect()->toRoute('fornecedor', ['action' => 'index']);
    //     }

    //     $form = new FornecedorForm();
    //     $form->bind($fornecedor); //vai receber fornecedor e vai pegar os dados e vai popular
    //     $form->get('submit')->setAttribute('value', 'Salvar');
    //     $request = $this->getRequest();
    //     $viewData = ['id' => $id, 'form' => $form];
    //     if (!$request->isPost())
    //         return $viewData;

    //     $form->setData($request->getPost());
    //     if (!$form->isValid()) 
    //         return $viewData;

    //     $this->tableFornecedor->salvarFornecedor($form->getData());
    //     return $this->redirect()->toRoute('fornecedor');
    // }

    // public function removerAction() {
    //     $id = (int) $this->params()->fromRoute('id', 0);
    //     if (0 == $id)
    //         return $this->redirect()->toRoute('fornecedor');

    //     $request = $this->getRequest();
    //     if ($request->isPost()) {
    //         $deletar = $request->getPost('deletar','Não');
    //         if ($deletar == 'Sim') {
    //             $id = (int) $request->getPost('id');
    //             $this->tableFornecedor->deletarFornecedor($id);
    //         }
    //         return $this->redirect()->toRoute('fornecedor');
    //     }
    //     return ['id' => $id, 'fornecedor' => $this->tableFornecedor->getFornecedor($id)];
    // }

    public function cardapioAction() {
        $form = new ItemForm();
      
        return new ViewModel(['form' => $form]);
        
    }

    public function testeAction() {
        $request = $this->getRequest();
        $params = $request->getPost()->toArray();
        $form = new ItemForm();
        if (!$request->isPost())
            return new ViewModel(['form' => $form]);

        $Item = new \Fornecedor\Model\Item();
        $form->setData($request->getPost());
        if (!$form->isValid())
            return new ViewModel(['form' => $form]);

        print_r($params['data']['TITULO']);
        die('alo');
        // foreach($params['data'] as $param){
        //     print_R($param);
        //     die('vix');

        // }

        // $fornecedor->exchangeArray($form->getData());
        $this->tableItem->salvarItem($Item);
        return $this->redirect()->toRoute('fornecedor/cardapio');
    }

}

?>