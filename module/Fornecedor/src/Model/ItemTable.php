<?php

namespace ItemTable\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class ItemTable {

    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        return $this->tableGateway->select(); // retorna tudo do tableGateway do banco
    }

    public function getItem($idItem) {
        $idItem = (int) $idItem; 
        $rowset = $this->tableGateway->select(['ID_ITEM_ITM' => $idItem]); // where id
        $row = $rowset->current(); // se existe um registro o current retorna a linha atual
        if (!$row)
            throw new RuntimeException(sprintf('Não foi encontrado o item %d',$idItem)); //se ocorrer um erro encontrado no tempo de execução
        return $row;
    }

    public function salvarItem(Item $Item) {
        $data = [
            'ST_NOME_ITM' => $Item->getNomeItem(),
            'VL_ITEM_ITM' => $Item->getValorItem(),
            'ID_TITULO_TIT' => $Item->getIdTitulo(),
        ];

        $idItem = (int) $Item->getIdItem();
        if ($idItem === 0) { // se não encontrar nenhum id ele faz um insert (o current retorna 0 caso não encontre nada)
            $this->tableGateway->insert($data);
            return;
        }
        $this->tableGateway->update($data,['ID_ITEM_ITM' => $idItem]); // where no update
    }

    public function deletarItem($idItem) {
        $this->tableGateway->delete(['ID_ITEM_ITM' => (int)$idItem]);
    }
}
?>