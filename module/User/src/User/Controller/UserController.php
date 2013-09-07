<?php
/*
 * Organization: OSSCube
* Added: Ramandeep Singh
* Scope: User module controller
* Dated: 05-09-2013
*/
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Form\LoginForm;
use User\Model\Entity\LoginEntity;
use User\Form\RegisterForm;
use User\Model\Entity\RegisterEntity;
use Zend\Session\Container;

class UserController extends AbstractActionController {
	
	protected $_userTable;
	
	//function use to fetch table object beu=ing define as a service on Module.php
	public function getUserTable() {
		if (! $this->_userTable) {
			$this->_userTable = $this->getServiceLocator ()->get ( 'UserTable' );
		}
		return $this->_userTable;
	}
	
	public function indexAction() {
		
	}
	
	// login action 
	public function loginAction() {

		$form = new LoginForm();
		$form->get('submit')->setValue('Sign In');
		
		$request = $this->getRequest();		
		if ($request->isPost()) {
			
			$login = new LoginEntity();
			$form->setInputFilter($login->getInputFilter());		
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$login->exchangeArray($form->getData());
				if ( $this->getUserTable()->validateUser($login) ){
					return  $this->redirect()->toRoute('home');
				}
				else{
// 					$this->redirect()->toRoute('login');					
				}
			}
		}
		
		return array('loginForm' => $form);
	}
	
	//register action
	public function registerAction() {
		$form = new RegisterForm();
		$form->get('submit')->setValue('Register');
		$form->get('back')->setValue('Back');

		$request = $this->getRequest();
		if ($request->isPost()) {
			$userObj = new RegisterEntity();
			$form->setInputFilter($userObj->getInputFilter());
		
			$form->setData($request->getPost());

			if ($form->isValid()) {
				$userObj->exchangeArray($form->getData());
				$this->getUserTable()->saveUser($userObj);
				$this->redirect()->toRoute('home');
			}
		}
		
		return array('registerForm' => $form);
	}
	
	// unset the session so that image get change in application module header layout 
	public function logoutAction() {		
		SESSION_START();
		UNSET($_SESSION['user']);
		RETUrn $this->redirect()->toRoute('home');
	}
}