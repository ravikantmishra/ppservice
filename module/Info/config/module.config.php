<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Info\Controller\Info' => 'Info\Controller\InfoController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'info' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/info[/:action[/:id]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Info\Controller\Info',
                        'action' => 'privacy',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'admin' => __DIR__ . '/../view',
        ),
    ),
);