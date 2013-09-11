<?php
/*
 * Organization: OSSCube
* Added: Ramandeep Singh
* Scope: Passport module route page
* Dated: 11-09-2013
*/
return array(
    'controllers' => array(
        'invokables' => array(
            'Passport\Controller\Passport' => 'Passport\Controller\PassportController',
        ),
    ),
		'router' => array(
				'routes' => array(
						'apply' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/apply',										
										'defaults' => array(
												'controller' => 'Passport\Controller\Passport',
												'action'     => 'apply',
										),
								),
						),
						'passportAplication' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/passportAplication',
										'defaults' => array(
												'controller' => 'Passport\Controller\Passport',
												'action'     => 'applypassport',
										),
								),
						),
						
				),
		),
		
    'view_manager' => array(
        'template_path_stack' => array(
            'Passport' => __DIR__ . '/../view',
        ),
    ),
);