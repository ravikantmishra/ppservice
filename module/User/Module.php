<?php
/*
 * Organization: OSSCube Added: Ramandeep Singh Scope: user module class Dated:
 * 05-09-2013
 */
namespace User;

use User\Model\UserTable;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use User\Model\Entity\RegisterEntity;

class Module
{

    /**
     * 
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * 
     * @return multitype:multitype:multitype:string
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__)));
    }

    /**
     * 
     * @return multitype:multitype:NULL  |\User\Model\UserTable|\Zend\Db\TableGateway\TableGateway
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'UserTable' => function ($sm)
                {
                    $tableGateway = $sm->get('UserTableGateway');
                    $table = new UserTable($tableGateway);
                    return $table;
                }, 
                'UserTableGateway' => function ($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(
                        new RegisterEntity());
                    return new TableGateway('user', $dbAdapter, null, 
                        $resultSetPrototype);
                }));
    }
}
