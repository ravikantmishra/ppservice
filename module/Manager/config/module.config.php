<?php 

return array(
    'controllers' => array(
        'invokables' => array(
            'Manager\Controller\Manager' => 'Manager\Controller\ManagerController',
            'Manager\Controller\Success' => 'Manager\Controller\SuccessController'

        ),
    ),
    'router' => array(
        'routes' => array(
            'manager' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/manager[/:action][/:id][/:status]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    	'status'=>'[a-zA-Z0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Manager\Controller\Manager',
                        'action'     => 'index',
                    ),
                ),
                
                'may_terminate' => true,
                'child_routes' => array(
                    'process' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/manager[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            		
                            ),
                            'defaults' => array(
                            ),
                        ),
 	
                    		
                    ),
                ),
            ),
        		
   		

        		
        ),
    ),
    
     
		'view_manager' => array(
				'template_path_stack' => array(
						'manager' => __DIR__ . '/../view',
				),
				
				'template_map' => array(
						'paginator-slide' => __DIR__ . '/../view/customlayout/slidePaginator.phtml',
				),
				
				'template_map' => array(
						'customLayout' => __DIR__.'/../view/customlayout/layout.phtml'
				)
		),
		
		
    
    
);





