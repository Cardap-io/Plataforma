<?php
namespace Fornecedor\Form;

use Zend\Form\Form;

class ItemForm extends Form {

    public function __construct() {
        parent::__construct('item', []);

        $this->add(new \Zend\Form\Element\Hidden('ID_ITEM_ITM'));
        $this->add(new \Zend\Form\Element\Text("ST_TITULO_TIT", ['label' => "Título"]));
        $this->add(new \Zend\Form\Element\Text("ST_NOME_ITM", ['label' => "Item"]));
        $this->add(new \Zend\Form\Element\Text("VL_ITEM_ITM", ['label' => "Valor"]));
        $this->add(new \Zend\Form\Element\Hidden('ID_TITULO_TIT'));
        $this->add(new \Zend\Form\Element\Text('ST_DESCRICAO_ITM', ['label' => "Descrição"]));

        $submit = new \Zend\Form\Element\Submit('submit');
        $submit->setAttributes(['value' => 'Salvar', 'id' => 'submitbutton']);
        $this->add($submit);
    }
}
?>