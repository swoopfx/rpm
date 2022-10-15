<?php

namespace Navigation;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    "view_helpers" => [
        "factories" => [
            "navigation" => ""
        ]
    ],

    "view_manager"=>[
        "template_map"=>[
            "navigation-partial"=>__DIR__ . '/../view/partial/navigation-partial.phtml',
        ]
    ],

    "doctrine" => [
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

];
