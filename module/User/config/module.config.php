<?php
/*
 * Organization: OSSCube Added: Ramandeep Singh Scope: User module route page
 * Dated: 05-09-2013
 */
return array(
    'controllers' => array(
        'invokables' => array(
            'User\Controller\User' => 'User\Controller\UserController')), 
    'router' => array(
        'routes' => array(
            'login' => array('type' => 'segment', 
                'options' => array('route' => '/login', 
                    'defaults' => array('controller' => 'User\Controller\User', 
                        'action' => 'login'))), 
            'logout' => array('type' => 'segment', 
                'options' => array('route' => '/logout', 
                    'defaults' => array('controller' => 'User\Controller\User', 
                        'action' => 'logout'))), 
            'register' => array('type' => 'segment', 
                'options' => array('route' => '/Register[/:action]', 
                    'constraints' => array('action' => '[a-zA-Z][a-zA-Z0-9_-]*'), 
                    
                    'defaults' => array('controller' => 'User\Controller\User', 
                        'action' => 'register'))), 
            'forgetPassword' => array('type' => 'segment', 
                'options' => array('route' => '/forgetPassword', 
                    'defaults' => array('controller' => 'User\Controller\User', 
                        'action' => 'forgetpassword'))), 
            'changePassword' => array('type' => 'segment', 
                'options' => array('route' => '/change', 
                    // 'route' => '/change[/:id]',
                    // 'constraints' => array(
                    // 'id' => '[a-zA-Z0-9_-]*',
                    // ),
                    'defaults' => array('controller' => 'User\Controller\User', 
                        'action' => 'changepassword'))))), 
    
    'view_manager' => array(
        'template_path_stack' => array('User' => __DIR__ . '/../view')));