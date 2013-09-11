<?php 
/*
 * Added       : Vinod Kumar Maurya 
 * Orgaization : OSSCube Solutions
 * Scope       : Multiple Routing including main and child (Tree level)
 * Dated       : 10-09-2013
 */



return array(
		'controllers' => array(
				'invokables' => array(
						'Manager\Controller\Manager' => 'Manager\Controller\ManagerController',
						'Manager\Controller\Success' => 'Manager\Controller\SuccessController'
		
				),
		),
		
		'router' => array(
				'routes' => array(
						// Top route named "Manager"
						'manager' => array(
								'type' => 'segment',
								'options' => array(
										'route'    => '/manager[/:action][/page/:page][/:id][/order_by/:order_by][/:order]',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     => '[0-9]+',
												'status'=>'[a-zA-Z0-9]+',
										),
										'defaults' => array(
												'controller' => 'Manager\Controller\Manager',
												'action' => 'index'
										)
								)
						),
						// Literal route named "contact", with child routes
						'contact' => array(
								'type' => 'segment',
								'options' => array(
										'route'    => '/contact[/:action][/page/:page][/:id][/order_by/:order_by][/:order]',
										'constraints' => array(
												'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     => '[0-9]+',
												'page' => '[0-9]+',
												'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'order' => 'ASC|DESC',
										),
										'defaults' => array(
												'controller' => 'Manager\Controller\Manager',
												'action' => 'contact'
										),
								),
										'may_terminate' => true,
										'child_routes' => array(
								// Segment route for viewing one feedback post
										'post' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/feedback[/:action][/page/:page][/:id][/order_by/:order_by][/:order]',
														'constraints' => array(
														'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
														'id'     => '[0-9]+',
														'page' => '[0-9]+',
														'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
														'order' => 'ASC|DESC',
														),
												'defaults' => array(
												'controller' => 'Manager\Controller\Manager',
												'action' => 'feedback'
														)
												)
										),
										// Literal route for viewing register 
										'rss' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/register[/:action][/page/:page][/:id][/order_by/:order_by][/:order]',
														'constraints' => array(
														'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
														'id'     => '[0-9]+',
														'page' => '[0-9]+',
														'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
														'order' => 'ASC|DESC',
														),
														'defaults' => array(
															'controller' => 'Manager\Controller\Manager',
															'action' => 'register'
														)
												)
										) 
								) 
						),
				),
		),
		
		
		'view_manager' => array(
				'template_path_stack' => array(
						'manager' => __DIR__ . '/../view',
				),
				'template_map' => array(
						'customLayout' => __DIR__.'/../view/customlayout/layout.phtml',
						'manager-paginator-slide' => __DIR__ . '/../view/customlayout/slidePaginator.phtml',
						'feedback-paginator-slide' => __DIR__ . '/../view/customlayout/feedback-paging.phtml',
						'register-paginator-slide' => __DIR__ . '/../view/customlayout/user-paging.phtml',
		
				)
		),
		
		
);


