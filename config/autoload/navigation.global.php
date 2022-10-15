<?php

/**
 * This file determines the navigation of the application ,
 * works with ACL
 *
 */
return array(
    'navigation' => array(
        'default' => array(
            [ // Begining Hone tab
                'label' => '<i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span>',
                'route' => 'dashboard',
                
                'pages' => [ // Begining Offer sub Tab
                    [
                        'label' => 'DashBoard',
                        'route' => 'dashboard',
                        'controller' => 'Index',
                        'action' => 'dashboard',
                        'resource' => 'Home\Controller\Index',
                        'privilege' => 'dashboard',
                        'params' => [
                            'action' => 'dashboard'
                        ]
                    
                    ],
                    [
                        'label' => 'Invoices',
                        'route' => 'invoice'
                        // 'params' => [
                        // 'action' => 'index'
                        // ]
                    ],
                    [
                        'label' => 'View All Property',
                        'route' => 'proparty/default',
                        'params' => [
                            'action' => 'all'
                        ]
                    ],
                    [
                        'label' => 'Messages',
                        'route' => 'messages/default',
                        'params' => [
                            'action' => 'index'
                        ]
                    ]
                    
                    // [
                    // 'label' => 'Non-Electronic Payments',
                    // 'route' => 'payment/default',
                    // 'params' => [
                    // 'action' => 'view-manual-payment'
                    // ]
                    // ],
                ]
            ],
            // [
            // 'label' => 'View All Objects',
            // 'route' => 'object/default',
            // 'params' => [
            // 'action' => 'view-all-object'
            // ]
            // ],
            
            // End of Offer sub Tab
            // End home Tab
            
            [
                'label' => '<i class="fa fa-umbrella"></i> Policies <span class="fa fa-chevron-down"></span>',
                'uri' => '#',
                'pages' => [
                    
                    [
                        'label' => 'Policy',
                        'route' => 'policy/default',
                        'params' => [
                            'action' => 'all'
                        ]
                    ],
                    
                    [
                        'label' => 'Expired Policy',
                        'route' => 'policy/default',
                        'params' => [
                            'action' => 'expired'
                        ]
                    ],
                    
                    [
                        'label' => 'Cover Note',
                        'route' => 'cover-note/default',
                        'params' => [
                            'action' => 'all'
                        ]
                    ]
                    
                    // [
                    // 'label' => 'Unpublished Policy',
                    // 'route' => 'policy/default',
                    // 'params' => [
                    // 'action' => 'floatall'
                    // ]
                    // ],
                    // [
                    // 'label' => 'Generate Policy',
                    // 'route' => 'policy'
                    // ]
                ]
            ],
            // [
            // 'label' => 'View Company Policies',
            // 'route' => 'policy/default',
            // 'params' => [
            // 'action' => 'company-policy'
            // ]
            // ]
            
            // [ // Begining Ofer Tab
            // 'label' => '<i class=" fa fa-folder-open"></i> Quote <span class="fa fa-chevron-down"></span> ',
            // 'route' => 'offer',
            // 'pages' => [ // Begining Offer sub Tab
            // [
            // 'label' => 'View Active Quote',
            // 'route' => 'offer/default'
            // ]
            // ]
            // ],
            // 'params' => [
            // 'action' => 'index'
            // ]
            
            // [
            // 'label' => ' Make New Offer',
            // 'route' => 'offer/default',
            
            // 'params' => [
            // 'action' => 'offer-information'
            // ]
            // ]
            
            // [
            // 'label' => ' Help',
            // 'route' => 'offer/default',
            
            // 'params' => [
            // 'action' => 'help'
            // ]
            // ]
            
            [ // Begining Ofer Tab
                'label' => '<i class=" fa fa-male"></i> Customer <span class="fa fa-chevron-down"></span> ',
                'route' => 'customer',
                'pages' => [ // Begining Offer sub Tab
                    [
                        'label' => 'New Customer',
                        'route' => 'customer/default'
                    ],
                    // 'params' => [
                    // 'action' => 'index'
                    // ]
                    
                    [
                        'label' => 'Registered Customer',
                        'route' => 'customer/default',
                        'params' => [
                            'action' => 'all'
                        ]
                    ]
                ]
            ],
            
            // [ // Begining Ofer Tab
            // 'label' => '<i class=" fa fa-plus-square"></i> Packages <span class="fa fa-chevron-down"></span> ',
            // 'route' => 'packages',
            // 'pages' => [ // Begining Offer sub Tab
            // [
            // 'label' => 'Create Package',
            // 'route' => 'packages/default',
            // 'params' => [
            // 'action' => 'create'
            // ]
            // ],
            
            // [
            // 'label' => 'View All Package',
            // 'route' => 'packages/default',
            // 'params' => [
            // 'action' => 'all'
            // ]
            // ],
            
            // [
            // 'label' => 'Feature Packages',
            // 'route' => 'packages/default',
            // 'params' => [
            // 'action' => 'featured'
            // ]
            // ],
            
            // [
            // 'label' => 'Acquired Packages',
            // 'route' => 'acquired-packages/default',
            // 'params' => [
            // 'action' => 'index'
            // ]
            // ]
            // ]
            // ],
            
            [ // Begining Ofer Tab
                'label' => '<i class=" fa fa-edit"></i> Proposals <span class="fa fa-chevron-down"></span> ',
                'route' => 'proposal',
                'pages' => [ // Begining Offer sub Tab
                             
                    // [
                             // 'label' => 'Proposals',
                             // 'route' => 'proposal/default',
                             // 'params' => [
                             // 'action' => 'create'
                             // ]
                             // ],
                             
                    // [
                             // 'label' => 'Generate Proposals',
                             // 'route' => 'proposal/default',
                             // 'params' => [
                             // 'action' => 'create'
                             // ]
                             // ],
                             // 'params' => [
                             // 'action' => 'index'
                             // ]
                    
                    [
                        'label' => 'My Proposals ',
                        'route' => 'proposal/default',
                        'params' => [
                            'action' => 'my-proposals'
                        ]
                    ]
                ]
            ],
            // [
            // 'label' => ' View company Proposals',
            // 'route' => 'proposal/default',
            // 'params' => [
            // 'action' => 'create'
            // ]
            // ]
            
            // End of Offer sub Tab
            // [
            // 'label' => '<i class="fa fa-line-chart"></i> Report <span class="fa fa-chevron-down"></span> ',
            // 'uri' => '#',
            // 'pages' => [
            // [
            // 'label' => 'View Report',
            // 'route' => 'report'
            // ]
            // ]
            // ],
            
            [
                'label' => '<i class="fa fa-tasks"></i> Claims <span class="fa fa-chevron-down"></span> ',
                'uri' => '#',
                'pages' => [
                    // [
                    // 'label' => 'Lay Claims',
                    // 'route' => 'claims'
                    // ],
                    
                    [
                        'label' => 'View Claims', // this is for brokers
                        'route' => 'claims/default',
                        'params' => [
                            'action' => 'all'
                        ]
                    ]
                ]
            ],
            
            [ // Begin Agennt Tools tabs
                'label' => '<i class="fa fa-cloud"></i>Analyzer <span class="fa fa-chevron-down"></span>',
                'uri' => '#',
                'pages' => [
                    [
                        'label' => 'Business Analysis',
                        'route' => 'analytics/default',
                        "params" => [
                            "action" => "business"
                        ]
                    ],
                    [
                        'label' => 'Consumer Analysis',
                        'route' => 'analytics/default',
                        "params" => [
                            "action" => "consumer"
                        ]
                    ],
                    [
                        'label' => 'Risk Analysis',
                        'route' => 'analytics/default',
                        "params" => [
                            "action" => "risk"
                        ]
                    ]
                ]
            ],
            
            // [
            // 'label' => '<i class="fa fa-gears"></i>Brokers Tools <span class="fa fa-chevron-down"></span>',
            // 'uri' => '#',
            // 'pages' => [
            // // [
            // // 'label' => 'Process Documents',
            // // 'route' => 'brokers-tool'
            // // ],
            // // [
            // // 'label' => 'Process Objects',
            // // 'route' => 'brokers-tool'
            // // ],
            // [
            // 'label' => 'Send SMS',
            // 'route' => 'brokers-tool'
            // ],
            // [
            // 'label' => 'Add Customer Object',
            // 'route' => 'object/default',
            // 'params' => [
            // 'action' => 'new'
            // ]
            // ],
            
            // ]
            // ],
            
            [
                'label' => '<i class="fa fa-wrench"></i>Settings <span class="fa fa-chevron-down"></span>',
                'uri' => '#',
                'resource' => 'Settings\Controller\Settings',
                'privilege' => 'index',
                'pages' => [
                    
                    [
                        'label' => 'Wallet',
                        "action" => "overview",
                        "controller" => "Wallet",
                        'route' => 'wallet',
                        'resource' => 'Wallet\Controller\Wallet',
                        // 'privilege' => 'pr',
                        "params" => [
                            "action" => "overview"
                        ]
                    ],
                    
                    [
                        'label' => 'Company Profile',
                        "action" => "profile",
                        "controller" => "Settings",
                        'route' => 'user_broker',
                        'resource' => 'Settings\Controller\Settings',
                        'privilege' => 'profile',
                        "params" => [
                            "action" => "info"
                        ]
                    ],
                    [
                        'label' => 'Company Bank Account',
                        'route' => 'settings/default',
                        'resource' => 'Settings\Controller\Settings',
                        'privilege' => 'profile',
                        'params' => [
                            'action' => 'broker-bank-account'
                        ]
                    ],
                    [
                        'label' => 'Buy SMS Credit',
                        'route' => 's-m-s/default',
                        'resource' => 'Settings\Controller\Settings',
                        'privilege' => 'profile',
                        'params' => [
                            'action' => 'buy-sms'
                        ]
                    ],
                    [
                        'label' => 'Staff',
                        'route' => 'brokers-tool/default',
                        'params' => [
                            'action' => 'add-staff'
                        ]
                    ],
                    
                    [
                        'label' => 'Web Config',
                        "action" => "webconfig",
                        "controller" => "Settings",
                        'route' => 'settings/default',
                        'resource' => 'Settings\Controller\Settings',
                        'privilege' => 'profile',
                        "params" => [
                            "action" => "info"
                        ]
                    ]
                    // [
                    // 'label' => 'Setup Payment Gateway',
                    // 'route' => 'brokers-tool/default',
                    // 'params' => [
                    // 'action' => 'brokerflutterwave'
                    // ]
                    // ],
                ]
            ]
        )
    ),
    
    'service_manager' => [
        'factories' => [
            'navigation' => 'Laminas\Navigation\Service\DefaultNavigationFactory'
        ]
    ]
); 