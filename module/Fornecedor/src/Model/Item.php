<?php

namespace Fornecedor\Model;

class Item  implements \Zend\Stdlib\ArraySerializableInterface { // basicamente serve par transformar um valor em um objeto dentro de um fluxo ou vise versa

    private $idItem;
    private $stNomeItem;
    private $vlItem;
    private $idTitulo;

    public function exchangeArray(array $data) {
        $this->idItem = !empty($data['ID_ITEM_ITM']) ? $data['ID_ITEM_ITM'] : null;
        $this->stNomeItem = !empty($data['ST_NOME_ITM']) ? $data['ST_NOME_ITM'] : null;
        $this->vlItem = !empty($data['VL_ITEM_ITM']) ? $data['VL_ITEM_ITM'] : null;
        $this->idTitulo = !empty($data['ID_TITULO_TIT']) ? $data['ID_TITULO_TIT'] : null;
    }

    public function getIdItem() {
        return $this->idItem;
    }

    public function setIdItem($idItem) {
        $this->idItem = $idItem;
    }

    public function getNomeItem() {
        return $this->stNomeItem;
    }

    public function setNomeItem($stNomeItem) {
        $this->stNomeItem = $stNomeItem;
    }

    public function getValorItem() {
        return $this->vlItem;
    }

    public function setValorItem($vlItem) {
        $this->vlItem = $vlItem;
    }

    public function getIdTitulo() {
        return $this->idTitulo;
    }

    public function setIdTitulo($idTitulo) {
        $this->idTitulo = $idTitulo;
    }
    public function getArrayCopy(): array {
        return[
            'ID_ITEM_ITM' => $this->idItem,
            'ST_NOME_ITM' => $this->stNomeItem,
            'VL_ITEM_ITM' => $this->vlItem,
            'ID_TITULO_TIT' => $this->idTitulo,
        ];
    }
}

?>