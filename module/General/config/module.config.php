<?php

declare(strict_types=1);

namespace General;

use General\Service\Factory\GeneralServiceFactory;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    // 'router' => [
    //     'routes' => [
    //         'home' => [
    //             'type'    => Literal::class,
    //             'options' => [
    //                 'route'    => '/',
    //                 'defaults' => [
    //                     'controller' => Controller\IndexController::class,
    //                     'action'     => 'index',
    //                 ],
    //             ],
    //         ],
    //         'application' => [
    //             'type'    => Segment::class,
    //             'options' => [
    //                 'route'    => '/application[/:action]',
    //                 'defaults' => [
    //                     'controller' => Controller\IndexController::class,
    //                     'action'     => 'index',
    //                 ],
    //             ],
    //         ],
    //     ],
    // ],
    'controllers' => [
        'factories' => [
            // Controller\IndexController::class => InvokableFactory::class,
        ],
    ],

    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/Entity'
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        ]
    ],
    "service_manager" => [
        "factories" => [
            "General\Service\GeneralService" => GeneralServiceFactory::class
        ],
        "aliases" => [
            "general_service" => "General\Service\GeneralService",
        ]
    ],
    'view_manager' => [

        'template_map' => [],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
