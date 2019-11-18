<?php

namespace Fornecedor\Controller;

use Exception;
use Fornecedor\Form\ItemForm;
use Zend\Mvc\Controller\AbstractActionController; // Class  AbstractActionController vem do zend
use Zend\View\Model\ViewModel;

class FornecedorController extends AbstractActionController {

    private $tableFornecedor;
    private $tableItem;
    private $tableTitulo;

    public function __construct($tableFornecedor,$tableItem,$tableGatewayTitulo) {
        $this->tableFornecedor = $tableFornecedor;
        $this->tableItem = $tableItem;
        $this->tableTitulo = $tableGatewayTitulo;
    }

    public function indexAction() { // todo action tem que retornar uma view
        // return new ViewModel(['Fornecedores' => FornecedorTable::fetchAll()]);
        return new ViewModel(['fornecedores' => $this->tableFornecedor->fetchAll()]);
    }

    public function cardapioAction() {
        $form = new ItemForm();
        return new ViewModel(['form' => $form,'arTitulos' => $this->tableTitulo->fetchAll()->toArray(), 'tableItem' =>$this->tableItem]);
    }

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

    public function adicionarAction() {
        $request = $this->getRequest();
        $modelItem = new \Fornecedor\Model\Item();
        $modelTitulo = new \Fornecedor\Model\Titulo();
        $params = $request->getPost()->toArray();
        $dados =  $params['data'];
        $stTitulo = $dados['ST_TITULO_TIT'];
        $objTituloTable = $this->tableTitulo->getIdTitulo($stTitulo);

        if (isset($objTituloTable)) {
            echo json_encode(['erro' => 'Menu já existente, para alteralo clique em editar']);exit;
        }else {
            $modelTitulo->exchangeArray($dados);
            $this->tableTitulo->salvarTitulo($modelTitulo);
        }

        unset($dados['ST_TITULO_TIT']);
        $idTitulo = $this->tableTitulo->getIdTitulo($stTitulo)->getIdTitulo();

        foreach ($dados as $dado) {
            $arItens = ['ST_NOME_ITM' => $dado[0], 'ST_DESCRICAO_ITM' => $dado[1], 'VL_ITEM_ITM' => $dado[2], 'ID_TITULO_TIT' => $idTitulo]; 
            $modelItem->exchangeArray($arItens);
            $this->tableItem->salvarItem($modelItem);
        }
        echo json_encode(['sucesso' => 'Menu adicionado com sucesso!']);exit;
    }

    public function deletarmenuAction() {
        $request = $this->getRequest();
        $params = $request->getPost()->toArray();
        $idTitulo =  $params['data'];
        $this->tableItem->deletarItemDoTitulo($idTitulo);
        $this->tableTitulo->deletarTitulo($idTitulo);
        echo json_encode(['sucesso' => 'Deletado com sucesso!']);exit;
    }

    public function qrcodeAction() {
        $server = new Zend_Rest_Server();
        $server->addFunction('api');
        $server->handle();
       
    }

    public function api(){
        $arTitulos = $this->tableTitulo->fetchAll()->toArray();
        $arItens = $this->tableItem->fetchAll()->toArray();
        $dados = [];
        foreach ($arTitulos as $titulo){
            foreach ($arItens as $itens){
                if($titulo['ID_TITULO_TIT'] == $itens['ID_TITULO_TIT']){
                    $dados['produtos'][] = [
                        'id' => $itens['ID_ITEM_ITM'],
                        'nome' => $itens['ST_NOME_ITM'],
                        'descricao' => $itens['ST_DESCRICAO_ITM'],
                        'valor' => $itens['VL_ITEM_ITM'],
                        'categoria' => $titulo['ST_TITULO_TIT'],
                    ];
                }
            }
        }
        echo json_encode(['data' => $dados]);exit;
    }    
}

?>