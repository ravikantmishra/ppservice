<?php

namespace Manager;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Authentication\AuthenticationService;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
use Manager\Model\Entity\AdminEntity;
use Manager\Model\AdminTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module implements AutoloaderProviderInterface {
	public function onBootstrap($e) {
		$e->getApplication ()->getServiceManager ()->get ( 'translator' );
		$eventManager = $e->getApplication ()->getEventManager ();
		$moduleRouteListener = new ModuleRouteListener ();
		$moduleRouteListener->attach ( $eventManager );
		$sharedEvents = $e->getApplication ()->getEventManager ()->getSharedManager ();
		$sharedEvents->attach ( __NAMESPACE__, 'dispatch', function ($e) {
			$controller = $e->getTarget ();
			if (is_readable ( __DIR__ . '/view/customlayout/layout.phtml' )) {
				$controller->layout ( 'customLayout' );
			}
		}, 100 );
	}
	public function getAutoloaderConfig() {
		return array (
				'Zend\Loader\ClassMapAutoloader' => array (
						__DIR__ . '/autoload_classmap.php' 
				),
				'Zend\Loader\StandardAutoloader' => array (
						'namespaces' => array (
								// if we're in a namespace deeper than one level we need to fix the \ in the path
								__NAMESPACE__ => __DIR__ . '/src/' . str_replace ( '\\', '/', __NAMESPACE__ ) 
						) 
				) 
		);
	}
	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}
	public function getServiceConfig() {
		return array (
				
				'factories' => array (
						
						'Manager\Model\MyAuthStorage' => function ($sm) {
							return new \Manager\Model\MyAuthStorage ( 'passportservices' );
						},
						
						'admin_user_form' => function ($sm) {
							$form = new Form\AdminForm ();
							$form->setHydrator ( new ClassMethods () );
							return $form;
						},
						
						'AuthService' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$dbTableAuthAdapter = new DbTableAuthAdapter ( $dbAdapter, 'admin', 'username', 'password', 'MD5(?)' );
							
							$authService = new AuthenticationService ();
							$authService->setAdapter($dbTableAuthAdapter);
		    				$authService->setStorage($sm->get('Manager\Model\MyAuthStorage'));		     
		   					 return $authService;
						},
						'AdminTable' =>  function($sm) {
							$tableGateway = $sm->get('AdminTableGateway');
							$table = new AdminTable($tableGateway);
							return $table;
						},
						'AdminTableGateway' => function ($sm) {
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype(new AdminEntity());
							return new TableGateway('admin', $dbAdapter, null, $resultSetPrototype);
						}
            ),
        );
    }

}


