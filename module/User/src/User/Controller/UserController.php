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
use User\Form\ForgetPasswordForm;
use User\Model\Entity\ForgetPasswordEntity;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mail;
use User\Form\ChangePasswordForm;
use User\Model\Entity\ChangePasswordEntity;
use Zend\Validator\NotEmpty;


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

// 		echo __DIR__ . '/../../../view';
// 		die;
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
					$message="The username and/or password is invalid.";
					$this->flashmessenger()->addMessage($message);
				}
			}
		}		
		$flashMessages = $this->flashMessenger()->getCurrentMessages();
		$this->flashMessenger()->clearCurrentMessages();
		$this->flashMessenger()->clearMessages();
		//die('here');
		return array('loginForm' => $form,
				'flashMessage' => $flashMessages,
		);				
	}
	
	//register action
	public function registerAction() {
		$form = new RegisterForm();
		$form->get('submit')->setValue('Register');

		$request = $this->getRequest();
		if ($request->isPost()) {
			$userObj = new RegisterEntity();
			$form->setInputFilter($userObj->getInputFilter());
		
			$form->setData($request->getPost());

			if ($form->isValid()) {
				$userObj->exchangeArray($form->getData());
				$data = array (
						'user_name' => $userObj->user_name,
						'password' => md5(utf8_encode($userObj->password)),
						'email' => $userObj->email,
						'first_name' => $userObj->first_name,
						'last_name' => $userObj->last_name
				);
				
				$lastId = $this->getUserTable()->saveUser($data);
				$this->getUserTable()->setUserSession('frontidsession',$lastId);
				
				$message="You have registered successfully.";
				$this->flashmessenger()->addMessage($message);
				
				return $this->redirect()->toRoute('home');
			}
		}
		
		return array('registerForm' => $form);
	}
	
	// unset the session so that image get change in application module header layout 
	public function logoutAction() {		
		SESSION_START();
		UNSET($_SESSION['user']);
		return $this->redirect()->toRoute('home');
	}
	
	public function forgetpasswordAction() {
		$form = new ForgetPasswordForm();
		$form->get('submit')->setValue('Request');
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$userObj = new ForgetPasswordEntity();
			$form->setInputFilter($userObj->getInputFilter());
		
			$form->setData($request->getPost());
		
			if ($form->isValid()) {
				$userObj->exchangeArray($form->getData());
				$result = $this->getUserTable()->getUser(array('email' => $userObj->email));
				
				if(isset($result)) {

					$result = (array)$result[0];// done so that multi level array lead to single level
					
					$encryptLink = $result['id'].'_'.$result['email'].'_'.$result['user_name'];
					$result = (array)$result;
					$result['link']=md5(utf8_decode($encryptLink));
				
					$this->mailConfiguration($result);					
					$this->getUserTable()->updateUser(array('link' => $result['link']), array('user_name' => $result['user_name']));
					//to do set mgs that mail has been send
					return  $this->redirect()->toRoute('login');
				}else {
					die("invalid email");
				}
				
			}
		}
		
		return array('forgetPasswordForm' => $form);
	}
	
	public function mailConfiguration($emailLinkArray)
	{
		
		$mail = new Mail\Message();
		$html = '<a href="http://www.ppservice.com/change?unique_key='.$emailLinkArray['link'].'" >Click to change password</a>';
		$bodyPart = new \Zend\Mime\Message();
		
		$bodyMessage = new \Zend\Mime\Part($html);
		$bodyMessage->type = 'text/html';
		$bodyPart->setParts(array($bodyMessage));

		
    	$mail->setBody($bodyPart);
		$mail->setFrom('ramandeep.singh@osscube.com', 'admin');
		$mail->addTo($emailLinkArray['email']);
		$mail->setSubject('Change Password');
		$transport = new SmtpTransport();
		$options = new SmtpOptions(array(
				'name' => 'localhost',
				'host' => 'smtp.gmail.com',
				'connection_class' => 'login',
				'port' => '465',
				'connection_config' => array(
						'ssl' => 'ssl', /* Page would hang without this line being added */
						'username' => 'ramandeep.singh@osscube.com',
						'password' => 'raman123',
				),
		));
		$transport->setOptions($options);
		
		$transport->send($mail);
		return;
	}
	
	public function changepasswordAction() {

		if(isset($_GET['unique_key']) || $_POST['unique_key']) {

			$form = new ChangePasswordForm();
			$form->get('submit')->setValue('Change');
			$form->get('unique_key')->setValue($_GET['unique_key']);
			$form->get('first_last_name')->setValue();
			
			$request = $this->getRequest();
			if ($request->isPost()) {
				$userObj = new ChangePasswordEntity();
				$form->setInputFilter($userObj->getInputFilter());
				
				$form->setData($request->getPost());
			
				if ($form->isValid()) {
					$userObj->exchangeArray($form->getData());					
					$result = $this->getUserTable()->getUser(array('link' => $_POST['unique_key']));

					if(isset($result)) {
						$result = (array)$result[0];// done so that multi level array lead to single level
						echo "<pre>";
						print_r($result);
						die;
						$this->getUserTable()->updateUser(array('password'=> md5(utf8_encode($userObj->password)) ) , array('id'=>$result['id']));
						return $this->redirect()->toRoute('login');
					}else{
					// todo plz select right link	
					}					
				}
			}
			
			return array('changePasswordForm' => $form);
				
		}else {
			return $this->redirect()->toRoute('home');
		}
	}
	
	
	public function checkemailAction() {

		$request = $this->getRequest();
	
		if ($request->isPost()) {
			$result =  $this->getUserTable()->getUser(array('email'=>$_POST['email']));

			if($result) {
				$check = true;
			}else {
				$check = false;
			}
			
			$response = $this->getResponse();
			$response->setContent(json_encode($check));
			return $response;
	
		}else {
			return $this->redirect()->toRoute('home');
		}
	}
	
}