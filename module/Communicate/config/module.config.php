<?php 
return array(
    'controllers' => array(
        'invokables' => array(
            'Communicate\Controller\Communicate' => 'Communicate\Controller\CommunicateController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'communicate' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/communicate[/:action[/:id]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Communicate\Controller\Communicate',
                        'action'     => 'contactus',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'communicate' => __DIR__ . '/../view',
        ),
    ),
);
