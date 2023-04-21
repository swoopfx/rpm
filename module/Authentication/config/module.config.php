<?php

declare(strict_types=1);

namespace Authentication;

use Authentication\Controller\ApiauthenticateController;
use Authentication\Controller\AuthenticateController;
use Authentication\Controller\Factory\ApiauthenticateControllerFactory;
use Authentication\Controller\Factory\AuthenticateControllerFactory;
use Authentication\Entity\User;
use Authentication\Form\Fieldset\UserFieldset;
use Authentication\Form\Fieldset\Factory\UserFieldsetFactory;
use Authentication\Form\InputFilter\Factory\RegisterInputfilterFactory;
use Authentication\Form\InputFilter\LoginInputFilter;
use Authentication\Form\InputFilter\RegisterInputfilter;
use Authentication\Options\Factory\ModuleOptionsFactory;
use Authentication\Options\ModuleOptions;
use Authentication\Service\ApiAuthenticateService;
use Authentication\Service\Factory\ApiAuthenticateServiceFactory;
// use Authentication\Service\AuthenticationService as AuthService;
use Authentication\Service\Factory\AuthenticateFactory;
use Authentication\Service\Factory\AuthenticateServiceFactory;
use Authentication\Service\Factory\JWTConfigurationFactory;
use Authentication\Service\Factory\JWTIssuerFactory;
use Authentication\Service\Factory\RegisterServiceFactory;
use Authentication\Service\JWTIssuer;
use Authentication\Service\RegisterService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'authentication' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/[:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        // 'id' => '[a-zA-Z0-9]*'
                    ),
                    'defaults' => [
                        'controller' => AuthenticateController::class,
                        'action'     => 'login',
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
            'api-auth' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/api[/:action[/:id]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9]*'
                    ),
                    'defaults' => [
                        'controller' => ApiauthenticateController::class,
                        'action'     => 'login',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            AuthenticateController::class => AuthenticateControllerFactory::class,
            ApiauthenticateController::class => ApiauthenticateControllerFactory::class
        ],
    ],

    "form_manager" => [
        "factories" => [
            // fieldset
            UserFieldset::class => UserFieldsetFactory::class
        ],
    ],
    'input_filters' => [

        "factories" => [
            RegisterInputfilter::class => RegisterInputfilterFactory::class,
            LoginInputFilter::class => InvokableFactory::class
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
            ApiAuthenticateService::class => ApiAuthenticateServiceFactory::class,
            RegisterService::class => RegisterServiceFactory::class,

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
        // 'strategies' => array(
        //     'ViewJsonStrategy'
        // )
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

    'rabbitmq' => [
        'producer' => [
            'login-trig' => [
                'connection' => 'default', // the connection name
                'exchange' => [
                    'type' => 'direct',
                    'name' => 'imappv2',
                    'durable' => true,      // (default)
                    'auto_delete' => false, // (default)
                    'internal' => false,    // (default)
                    'no_wait' => false,     // (default)
                    'declare' => true,      // (default)
                    'arguments' => [],      // (default)
                    'ticket' => 0,          // (default)
                    'exchange_binds' => []  // (default)
                ],
                'queue' => [ // optional queue
                    'name' => 'email-imapp', // can be an empty string,
                    'type' => null,         // (default)
                    'passive' => false,     // (default)
                    'durable' => true,      // (default)
                    'auto_delete' => false, // (default)
                    'exclusive' => false,   // (default)
                    'no_wait' => false,     // (default)
                    'arguments' => [],      // (default)
                    'ticket' => 0,          // (default)
                    'routing_keys' => []    // (default)
                ],
                'auto_setup_fabric_enabled' => true // auto-setup exchanges and queues 
            ]
        ]
    ]
];
