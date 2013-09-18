<?php

namespace Communicate;

use Zend\Stdlib\Hydrator\ClassMethods;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php'), 
            
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__)));
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Communicate\Model\ContactTable' => function ($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new Model\ContactTable($dbAdapter);
                    return $table;
                }, 
                'Communicate\Model\FeedbackTable' => function ($sm)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new Model\FeedbackTable($dbAdapter);
                    return $table;
                }, 
                'contact_us_form' => function ($sm)
                {
                    $form = new Form\ContactForm();
                    $form->setHydrator(new ClassMethods());
                    return $form;
                }, 
                'feedback_form' => function ($sm)
                {
                    $form = new Form\FeedbackForm();
                    $form->setHydrator(new ClassMethods());
                    return $form;
                }));
    }
}
