<?php 

return array(
    'controllers' => array(
        'invokables' => array(
            'Apply\Controller\Apply' => 'Apply\Controller\ApplyController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'apply' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/apply[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Apply\Controller\Apply',
                        'action'     => 'index',
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





