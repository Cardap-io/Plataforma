<?php

namespace Titulo\Model;

class Titulo  implements \Zend\Stdlib\ArraySerializableInterface { // basicamente serve par transformar um valor em um objeto dentro de um fluxo ou vise versa

    private $stNomeTitulo;
    private $idTitulo;

    public function exchangeArray(array $data) {
        $this->idTitulo = !empty($data['ID_TITULO_TIT']) ? $data['ID_TITULO_TIT'] : null;
        $this->stNomeTitulo = !empty($data['ST_TITULO_TIT']) ? $data['ST_TITULO_TIT'] : null;
    }

    public function getIdTitulo() {
        return $this->idTitulo;
    }

    public function setIdTitulo($idTitulo) {
        $this->idTitulo = $idTitulo;
    }

    public function getNomeTitulo() {
        return $this->stNomeTitulo;
    }

    public function setNomeTitulo($stNomeTitulo) {
        $this->stNomeTitulo = $stNomeTitulo;
    }
    public function getArrayCopy(): array {
        return[
            'ID_TITULO_TIT' => $this->idTitulo,
            'ST_TITULO_TIT' => $this->stNomeTitulo,
        ];
    }
}

?>