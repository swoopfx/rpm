<?php

declare(strict_types=1);

namespace Authentication;

use Authentication\Controller\AuthenticateController;
use Authentication\Controller\Factory\AuthenticateControllerFactory;
use Authentication\Entity\User;
use Authentication\Form\Fieldset\UserFieldset;
use Authentication\Form\Fieldset\Factory\UserFieldsetFactory;
use Authentication\Options\Factory\ModuleOptionsFactory;
use Authentication\Options\ModuleOptions;
// use Authentication\Service\AuthenticationService as AuthService;
use Authentication\Service\Factory\AuthenticateFactory;
use Authentication\Service\Factory\AuthenticateServiceFactory;
use Authentication\Service\Factory\JWTConfigurationFactory;
use Authentication\Service\Factory\JWTIssuerFactory;
use Authentication\Service\JWTIssuer;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => AuthenticateController::class,
                        'action'     => 'login',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => AuthenticateController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            AuthenticateController::class => AuthenticateControllerFactory::class
        ],
    ],

    "form_manager" => [
        "factories" => [
            // fieldset
            UserFieldset::class => UserFieldsetFactory::class
        ],
    ],
    'input_filters'=>[
        "factories"=>[
            
        ]
    ],

    "service_manager" => [
        "factories" => [
            // vendor authentication service
            "Laminas\Authentication\AuthenticationService" => AuthenticateFactory::class,
            // authentication service used internally by app
            "app_authenticate_service" => AuthenticateServiceFactory::class,
            "Authentication\Service\JWTConfiguration" => JWTConfigurationFactory::class,
            "Authentication\Service\JWTIssuer" => JWTIssuerFactory::class,
            ModuleOptions::class => ModuleOptionsFactory::class,

        ],

        "aliases" => [
            "authenticate_module_option" => ModuleOptions::class,
            "authentication_service" => "Laminas\Authentication\AuthenticationService"
        ]

    ],


    'view_manager' => [

        'template_map' => [
            "login-layout" => __DIR__ . "/../view/layout/login_layout.phtml"
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],

    'doctrine' => [
        'doctrine' => [
            'authentication' => [
                'orm_default' => [
                    'object_manager' => EntityManager::class,
                    'identity_class' => User::class,
                    'identity_property' => 'username',
                    'credential_property' => 'password',
                    'credential_callable' => "Authentication\Service\AuthenticationService::verifyHashedPassword"
                ],
            ],
        ],

        'driver' => [
            __NAMESPACE__ . '_driver' => array(
                'class' => AnnotationDriver::class,
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
];
