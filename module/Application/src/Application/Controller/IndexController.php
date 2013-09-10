<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
    	$flashMessages = $this->flashMessenger()->getCurrentMessages();
    	$this->flashMessenger()->clearCurrentMessages();
    	$this->flashMessenger()->clearMessages();
    	
        return new ViewModel(array('flashMessage' => $flashMessages,));
    }
    
    protected function _getApplicationUrl() {
    	return $_SERVER['SERVER_NAME'];
    }
    
    protected function _getPublicPath() {
    	return realpath(APPLICATION_PATH . '/../public/');
    }
    
}
