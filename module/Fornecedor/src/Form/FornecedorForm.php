<?php
namespace Fornecedor\Form;

// use Zend\Form\Element\Hidden;
use Zend\Form\Form;
// trabalha com elementos html em nivel de objeto no php e quando renderizar ele transforma em html
class FornecedorForm extends Form {

    public function __construct() {
        parent::__construct('fornecedor', []);

        $this->add(new \Zend\Form\Element\Hidden('id'));
        $this->add(new \Zend\Form\Element\Text("nome", ['label' => "Nome"]));
        $this->add(new \Zend\Form\Element\Text("sobrenome", ['label' => "Sobrenome"]));
        $this->add(new \Zend\Form\Element\Text("email", ['label' => "Email"]));
        $this->add(new \Zend\Form\Element\Text("situacao", ['label' => "Situação"]));
        $this->add(new \Zend\Form\Element\Text("titulo", ['label' => "Título"]));
        $this->add(new \Zend\Form\Element\Text("item", ['label' => "Item"]));
        $this->add(new \Zend\Form\Element\Text("valor", ['label' => "Valor"]));

        $submit = new \Zend\Form\Element\Submit('submit');
        $submit->setAttributes(['value' => 'Salvar', 'id' => 'submitbutton']);
        $this->add($submit);
    }
}
?>