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

    public function editarAction() {
        $request = $this->getRequest();
        $modelItem = new \Fornecedor\Model\Item();
        $modelTitulo = new \Fornecedor\Model\Titulo();
        $params = $request->getPost()->toArray();
        $dados =  $params['data'];
        $idTitulo =  $params['titulo'];
        $dados['ID_TITULO_TIT'] = $idTitulo;
        $arItens = $this->tableItem->fetchAll()->toArray();
        $modelTitulo->exchangeArray($dados);
        $this->tableTitulo->salvarTitulo($modelTitulo);
        unset($dados['ST_TITULO_TIT']);
        unset($dados['ID_TITULO_TIT']);

        foreach ($arItens as $itens)
            if($idTitulo == $itens['ID_TITULO_TIT'])
                $idsAntigos[] = $itens['ID_ITEM_ITM'];
        
        foreach ($dados as $dado)
            if($dado[3] != '' || $dado[3] == null)
                $idsRestantes[] = $dado[3];
        
        foreach ($idsAntigos as $id)
            if(!in_array($id,$idsRestantes))
                $this->tableItem->deletarItem($id);

        foreach ($dados as $dado) {
            $arItens = ['ID_ITEM_ITM' => $dado[3], 'ST_NOME_ITM' => $dado[0], 'ST_DESCRICAO_ITM' => $dado[1], 'VL_ITEM_ITM' => $dado[2], 'ID_TITULO_TIT' => $idTitulo]; 
            $modelItem->exchangeArray($arItens);
            $this->tableItem->salvarItem($modelItem);
        }
        echo json_encode(['sucesso' => 'Menu alterado com sucesso!']);exit;
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

    public function getitensdotituloAction() {
        $request = $this->getRequest();
        $params = $request->getPost()->toArray();
        $idTitulo =  $params['data'];
        $arItens = $this->tableItem->fetchAll()->toArray();
        $stTitulo = $this->tableTitulo->getTitulo($idTitulo)->getNomeTitulo();

        foreach ($arItens as $itens) {
            if($idTitulo == $itens['ID_TITULO_TIT']){
                $dados[] = [
                    'id' => $itens['ID_ITEM_ITM'],
                    'nome' => $itens['ST_NOME_ITM'],
                    'descricao' => $itens['ST_DESCRICAO_ITM'],
                    'valor' => $itens['VL_ITEM_ITM'],
                ];
            }
        }
        $dados[] = ['stTitulo' => $stTitulo];
        echo json_encode($dados);exit;
    }

}

?>