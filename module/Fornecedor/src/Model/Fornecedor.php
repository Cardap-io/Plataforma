<?php

namespace Fornecedor\Model;

class Fornecedor  implements \Zend\Stdlib\ArraySerializableInterface {
    // public class Fornecedor  { 

    private $id;
    private $nome;
    private $sobrenome;
    private $email;
    private $situacao;

    public function exchangeArray(array $data) {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->nome = !empty($data['nome']) ? $data['nome'] : null;
        $this->sobrenome = !empty($data['sobrenome']) ? $data['sobrenome'] : null;
        $this->email = !empty($data['email']) ? $data['email'] : null;
        $this->situacao = !empty($data['situacao']) ? $data['situacao'] : null;
        $this->item = !empty($data['item']) ? $data['item'] : null;
        $this->valor = !empty($data['valor']) ? $data['valor'] : null;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getSobrenome() {
        return $this->sobrenome;
    }

    public function setSobrenome($sobrenome) {
        $this->sobrenome = $sobrenome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getSituacao() {
        return $this->situacao;
    }

    public function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    public function getItem() {
        return $this->item;
    }

    public function setItem($item) {
        $this->item = $item;
    }

    public function getValor() {
        return $this->Valor;
    }

    public function setValor($Valor) {
        $this->Valor = $Valor;
    }
    public function getArrayCopy(): array {
        return[
            'id' => $this->id,
            'nome' => $this->nome,
            'sobrenome' => $this->sobrenome,
            'email' => $this->email,
            'situacao' => $this->situacao,
            'item' => $this->item,
            'valor' => $this->valor,
        ];
    }
}

?>