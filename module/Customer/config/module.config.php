<?php

namespace Customer;

use Customer\Controller\CustomerController;
use Customer\Controller\Factory\CustomerControllerFactory;
use Laminas\Router\Http\Segment;

return [
    "controllers" => [
        "factories" => [
            CustomerController::class => CustomerControllerFactory::class
        ]
    ],

    'router' => [
        'routes' => [
            'customer-api' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/customer[/:interface[/:action[/:id]]]',
                    'constraints' => array(
                        'interface' => '[a-zA-Z]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9]*'
                    ),
                    'defaults' => [
                        'controller' => CustomerController::class,
                        "interface"=>"web",
                        'action'     => 'index',
                    ],
                ],
            ],
            // 'loginjson' => [
            //     'type'    => Literal::class,
            //     'options' => [
            //         'route'    => '/login',
            //         'defaults' => [
            //             'controller' => AuthenticateController::class,
            //             'action'     => 'login',
            //         ],
            //     ],
            // ],

        ],
    ],
    "view_manager" => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ]

];
