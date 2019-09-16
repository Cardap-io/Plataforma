<?php

namespace Pessoa;
use Zend\ServiceManager\Factory\InvokableFactory;
/*
Configuracao, retorna a rota conforme você passar as informações na URL ela vai
direcionar para o caminho de cada arquivo e o que deve ser chamado de 
cada arquivo com qual parametro passar etc.
*/
return [
    'router' => [               //definindo a rota
        'routes' => [           // definindo chave das rotas do router
            'pessoa' => [       // o app
                'type' => \Zend\router\Http\Segment::class, // tipo dela é segment que é uma rota que vc cria uma configuração do tipo /pessoa/metodo etc... 
                'options' => [
                    'route' => '/pessoa[/:action[/:id]]', // o que vai poder ser passado ou não (opcional)
                    'constraints' => [ // as limitações para evitar sqlinjection
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ],
                    'defaults' =>[  // valores padroes
                        'controller' => Controller\PessoaController:: //controller padrao
                        class,
                        'action' => 'index', //action padrao
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [ // definindo construtor do controller
        'factories' => [
            Controller\PessoaController::class => InvokableFactory::class, // quando tentar acessar o controller default ele vai usar o construtor generico do zend
        ],
    ],
    'view_manager' => [ //onde está nossas views para informa o zend
        'template_path_stack' => [ //caminho do template
            'pessoa' => __DIR__. '/../view', // variavel do php que faz referencia ao diretorio atual
        ],
    ] ,

];



?>