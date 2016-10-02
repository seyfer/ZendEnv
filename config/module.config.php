<?php

return [
    'controllers' => [
        'invokables' => [
            'Env\Controller\Env' => ZendEnv\Controller\EnvController::class,
        ]
    ],
    'console'     => [
        'router' => [
            'routes' => [
                'env' => [
                    'type'    => 'simple',
                    'options' => [
                        'route'    => 'env install <env> [--dbu=<dbu>] [--dbp=<dbp>] [--dbn=<dbn>]',
                        'defaults' => [
                            'controller' => 'Env\Controller\Env',
                            'action'     => 'install',
                        ]
                    ]
                ],
            ]
        ]
    ],
];
