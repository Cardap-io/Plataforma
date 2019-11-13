<?php

namespace Fornecedor;
// use Zend\ServiceManager\Factory\InvokableFactory;
/*
Configuracao, retorna a rota conforme você passar as informações na URL ela vai
direcionar para o caminho de cada arquivo e o que deve ser chamado de 
cada arquivo com qual parametro passar etc.
*/
return [
    'router' => [               //definindo a rota
        'routes' => [           // definindo chave das rotas do router
            'fornecedor' => [       // o app
                'type' => \Zend\router\Http\Segment::class, // tipo dela é segment que é uma rota que vc cria uma configuração do tipo /Fornecedor/metodo etc... 
                'options' => [
                    'route' => '/fornecedor[/:action[/:id]]', // o que vai poder ser passado ou não (opcional)
                    'constraints' => [ // as limitações para evitar sqlinjection
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ],
                    'defaults' => [  // valores padroes
                        'controller' => Controller\FornecedorController:: //controller padrao
                        class,
                        'action' => 'cardapio', //action padrao
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [ // definindo construtor do controller
        'factories' => [ // talvez não vai precisar do invokable pois ja construi um factorie no module pois ele não passa nada e no controller precisa do table
            // Controller\FornecedorController::class => InvokableFactory::class, // quando tentar acessar o controller default ele vai usar o construtor generico do zend
        ],
    ],
    'view_manager' => [ //onde está nossas views para informa o zend
        'template_path_stack' => [ //caminho do template
            'fornecedor' => __DIR__. '/../src/view', // variavel do php que faz referencia ao diretorio atual
        ],
    ] ,
    'db' => [
        'driver' => 'Pdo_Mysql',
        'database' => 'fornecedor',
        'username' => 'root',
        'password' => 'root',
        'hostname' => 'localhost',
    ],
];
?>