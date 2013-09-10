<?php
namespace Passport;

use Passport\Model\CountryTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Passport\Model\Entity\CountryEntity;
class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
    	return array(
    			'factories' => array(
    					'CountryTable' =>  function($sm) {
    						$tableGateway = $sm->get('CountryTableGateway');
    						$table = new CountryTable($tableGateway);
    						return $table;
    					},
    					'CountryTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new CountryEntity());
    						return new TableGateway('country', $dbAdapter, null, $resultSetPrototype);
    					}
    			),
    	);
    }
}
