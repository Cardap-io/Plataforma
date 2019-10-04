<?php

namespace Fornecedor;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Fornecedor\Controller\FornecedorController;
use Fornecedor\Model\FornecedorTable;
/*
quando module.config for chamado no zend pelos rotas etc, vai 
chamar esse arquivo que informa que nosso diretorio é um module
*/
class Module implements ConfigProviderInterface {

    public function getConfig() {       // metodo da class ConfigProviderInterface
        return include __DIR__."/../config/module.config.php";
    }
    // configurando o tableGateway para que ele conheça a class Fornecedor e possa se comunicar com banco
    //vai fornecer um tableFornecedor ja com table gateway configurado
    public function getServiceConfig() { //configuracao de servico que fornece o Fornecedor table com tablegetway dentro
        return [
            'factories' => [                                        // quando serviceManager criar a class Fornecedor table (for chamado model/FornecedorTable )o zend vai acionar esse metodo passando esse container
                Model\FornecedorTable::class => function($container) { //retorna nome da class, usa container que é uma class do zend que utiliza para passar injeção de dependencia para varias classes
                    $tableGateway = $container->get(Model\FornecedorTableGateway::class); //container é nosso serviceManager
                    return new FornecedorTable($tableGateway); // quando ele procurar essa class FornecedorTableGateway ele respoder pelo factorie abaixo inves da propria class
                },
                Model\FornecedorTableGateway::class => function($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Fornecedor());
                    return new TableGateway('fornecedores',$dbAdapter,null,$resultSetPrototype);
                }
            ]
        ];
    }

    public function getControllerConfig() {
        return [
            'factories' => [
                FornecedorController::class => function($container) {
                    $tableGateway = $container->get(Model\FornecedorTable::class);
                    return new FornecedorController($tableGateway);
                },
            ]
        ];
    }
}
?>