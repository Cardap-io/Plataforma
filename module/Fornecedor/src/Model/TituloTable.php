<?php

namespace Fornecedor\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class TituloTable {

    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        return $this->tableGateway->select(); // retorna tudo do tableGateway do banco
    }

    public function getTitulo($idTitulo) {
        $idTitulo = (int) $idTitulo; 
        $rowset = $this->tableGateway->select(['ID_TITULO_TIT' => $idTitulo]); // where id
        $row = $rowset->current(); // se existe um registro o current retorna a linha atual
        // if (!$row)
        //     throw new RuntimeException(sprintf('Não foi encontrado o título %d',$idTitulo)); //se ocorrer um erro encontrado no tempo de execução
        return $row;
    }

    public function getIdTitulo($stTitulo) {
        $rowset = $this->tableGateway->select(['ST_TITULO_TIT' => $stTitulo]);
        $row = $rowset->current();
        // if (!$row)
        //     throw new RuntimeException(sprintf('Não foi encontrado o título %d',$idTitulo));
        return $row;
    }

    public function salvarTitulo(Titulo $Titulo) {
        $data = [
            'ST_TITULO_TIT' => $Titulo->getNomeTitulo(),
        ];

        $idTitulo = (int) $Titulo->getIdTitulo();
        if ($idTitulo === 0) { // se não encontrar nenhum id ele faz um insert (o current retorna 0 caso não encontre nada)
            $this->tableGateway->insert($data);
            return;
        }
        $this->tableGateway->update($data,['ID_TITULO_TIT' => $idTitulo]); // where no update
    }

    public function deletarTitulo($idTitulo) {
        $this->tableGateway->delete(['ID_TITULO_TIT' => (int)$idTitulo]);
    }
}
?>