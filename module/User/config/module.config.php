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
            'register' => array('type' => 'segment', 
                'options' => array('route' => '/register', 
                    'defaults' => array('controller' => 'User\Controller\User', 
                        'action' => 'register'))), 
            'forgetPassword' => array('type' => 'segment', 
                'options' => array('route' => '/forgetPassword', 
                    'defaults' => array('controller' => 'User\Controller\User', 
                        'action' => 'forgetpassword'))), 
            'changePassword' => array('type' => 'segment', 
                'options' => array('route' => '/change', 
                    'defaults' => array('controller' => 'User\Controller\User', 
                        'action' => 'changepassword'))), 
//             'login' => array('type' => 'Zend\Mvc\Router\Http\Regex',
//             'options' => array('regex' => '/login',
//             'defaults' => array('controller' => 'User\Controller\User',
//             'action' => 'login'), 'spec' => 'index.php/login')),
            
//             'register' => array('type' => 'Zend\Mvc\Router\Http\Regex', 
//                 'options' => array('regex' => '/register', 
//                     'defaults' => array('controller' => 'User\Controller\User', 
//                         'action' => 'register'), 'spec' => 'index.php/register')), 
            
            'logout' => array('type' => 'segment', 
                'options' => array('route' => '/logout', 
                    'defaults' => array('controller' => 'User\Controller\User', 
                        'action' => 'logout'))), 
            
//             'forgetPassword' => array('type' => 'Zend\Mvc\Router\Http\Regex', 
//                 'options' => array('regex' => '/forgetPassword', 
//                     'defaults' => array('controller' => 'User\Controller\User', 
//                         'action' => 'forgetpassword'), 
//                     'spec' => 'index.php/forgetPassword')), 
            
//             'changePassword' => array('type' => 'Zend\Mvc\Router\Http\Regex', 
//                 'options' => array('regex' => '/change', 
//                     'defaults' => array('controller' => 'User\Controller\User', 
//                         'action' => 'changepassword'), 
//                     'spec' => 'index.php/change'))
)), 
    
    'view_manager' => array(
        'template_path_stack' => array('User' => __DIR__ . '/../view')));