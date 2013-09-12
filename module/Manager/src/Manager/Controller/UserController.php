<?php
namespace User\Controller;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Config\StandardConfig;
use Zend\Session\SessionManager;
use Zend\Session\Container;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;

class UserController extends AbstractActionController
{
	
	public $viewmodel;
	protected $authservice;
	
	
	public function getAuthService()
	{
		if (! $this->authservice) {
			$this->authservice = $this->getServiceLocator()
			->get('AuthService');
		}
		return $this->authservice;
	}
	
	
	
	function indexAction()
	{
		echo "hello";
		die;
	}
	
	
}