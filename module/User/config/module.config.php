<?php
/*
 * Organization: OSSCube
* Added: Ramandeep Singh
* Scope: User module route page
* Dated: 05-09-2013
*/
return array(
    'controllers' => array(
        'invokables' => array(
            'User\Controller\User' => 'User\Controller\UserController',
        ),
    ),
		'router' => array(
				'routes' => array(
						'login' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/login',										
										'defaults' => array(
												'controller' => 'User\Controller\User',
												'action'     => 'login',
										),
								),
						),
						'logout' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/logout',
										'defaults' => array(
												'controller' => 'User\Controller\User',
												'action'     => 'logout',
										),
								),
						),
						'register' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/register',
										'defaults' => array(
												'controller' => 'User\Controller\User',
												'action'     => 'register',
										),
								),
						),
				),
		),
		
    'view_manager' => array(
        'template_path_stack' => array(
            'User' => __DIR__ . '/../view',
        ),
    ),
);