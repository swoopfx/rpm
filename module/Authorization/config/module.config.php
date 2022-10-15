<?php

declare(strict_types=1);

namespace Authorization;

use Authorization\Controller\Plugin\Factory\IsAllowedFactory;
// use Authorization\Controller\Plugin\IsAllowed;
use Authorization\View\Helper\Factory\IsAllowedFactory as FactoryIsAllowedFactory;
// use Authorization\View\Helper\IsAllowed as HelperIsAllowed;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;


return [
    "controller_plugin" => [
        "factories" => [
            "isAllowed" => IsAllowedFactory::class,
        ]
    ],
    "view_helpers" => [
        "factories" => [
            "isAllowed" => FactoryIsAllowedFactory::class
        ]
    ],
    "doctrine"=>[
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
        ],
    ],
    

    "service_manager" => [
        "factories" => [
            "Authorization\Acl\Acl" => "Authorization\Acl\AclFactory"
        ],
        "alias" => [
            "acl_service" => "Authorization\Acl\Acl"
        ]
    ],

];
