<?php

namespace Fornecedor\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class FornecedorTable {

    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        return $this->tableGateway->select(); // retorna tudo do tableGateway do banco
    }

    public function getFornecedor($id) {
        $id = (int) $id; 
        $rowset = $this->tableGateway->select(['id' => $id]); // where id
        $row = $rowset->current(); // se existe um registro o current retorna a linha atual
        if (!$row)
            throw new RuntimeException(sprintf('Não foi encontrado o id %d',$id)); //se ocorrer um erro encontrado no tempo de execução
        return $row;
    }

    public function salvarFornecedor(Fornecedor $Fornecedor) {
        $data = [
            'nome' => $Fornecedor->getNome(),
            'sobrenome' => $Fornecedor->getSobrenome(),
            'email' => $Fornecedor->getEmail(),
            'situacao' => $Fornecedor->getSituacao(),
        ];

        $id = (int) $Fornecedor->getId();
        if ($id === 0) { // se não encontrar nenhum id ele faz um insert (o current retorna 0 caso não encontre nada)
            $this->tableGateway->insert($data);
            return;
        }
        $this->tableGateway->update($data,['id' => $id]); // where no update
    }

    public function deletarFornecedor($id) {
        $this->tableGateway->delete(['id' => (int)$id]);
    }
}
?>