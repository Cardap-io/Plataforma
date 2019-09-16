<?php

namespace Pessoa;
use Zend\ModuleManager\Feature\ConfigProviderInterface; // pra saber que ele tem que buscar dessa class na hora de carregar essa class
/*
quando module.config for chamado no zend pelos rotas etc, vai 
chamar esse arquivo que informa que nosso diretorio é um module
*/
class Module implements ConfigProviderInterface {

    public function getConfig() {       // metodo da class ConfigProviderInterface
        return include __DIR__."/../config/module.config.php";
    } 
}
?>