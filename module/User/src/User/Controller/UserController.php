<?php
/*
 * Organization: OSSCube Added: Ramandeep Singh Scope: User module controller
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

class UserController extends AbstractActionController
{
    protected $_userTable;

    /**
     * function use to fetch table object being define as a service on
     * Module.php
     *
     * @return Ambigous <object, multitype:>
     */
    public function getUserTable()
    {
        if (!$this->_userTable) {
            $this->_userTable = $this->getServiceLocator()->get('UserTable');
        }
        return $this->_userTable;
    }

//     public function indexAction()
//     {
//     }

    /**
     * display login form vaditae it and redirect it to home
     * if request is from appy visa/passport or know your status then will lead
     * to that specific form
     *
     * @return Ambigous <\Zend\Http\Response,
     *         \Zend\Stdlib\ResponseInterface>|multitype:\User\Form\LoginForm
     *         multitype:
     */
    public function loginAction()
    {
        $container = new Container('user');
        $data = $container->frontidsession;
        
        if (!$data) {
            
            $form = new LoginForm();
            $form->get('submit')->setValue('Sign In');
            
            $request = $this->getRequest();
            if ($request->isPost()) {
                
                $login = new LoginEntity();
                $form->setInputFilter($login->getInputFilter());
                $form->setData($request->getPost());
                if ($form->isValid()) {
                    $login->exchangeArray($form->getData());
                    if ($this->getUserTable()->validateUser($login)) {
                        
                        $container = new Container('SiteLink');
                        $data = $container->LastVisitPage;
                        if ($data) {
                            return $this->redirect()->toRoute($data);
                        }
                        return $this->redirect()->toRoute('home');
                    } else {
                        $message = "The username and/or password is invalid.";
                        $this->flashmessenger()->addMessage($message);
                    }
                }
            }
            $flashMessages = $this->flashMessenger()->getCurrentMessages();
            $this->flashMessenger()->clearCurrentMessages();
            $this->flashMessenger()->clearMessages();
            
            return array('loginForm' => $form, 'flashMessage' => $flashMessages);
        } else {
            return $this->redirect()->toRoute('home');
        }
    }

    /**
     * Display register form and lead to home page by creating session
     *
     * @return Ambigous <\Zend\Http\Response,
     *         \Zend\Stdlib\ResponseInterface>|multitype:\User\Form\RegisterForm
     */
    public function registerAction()
    {
        $form = new RegisterForm();
        $form->get('submit')->setValue('Register');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $userObj = new RegisterEntity();
            $form->setInputFilter($userObj->getInputFilter());
            
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $userObj->exchangeArray($form->getData());
                $data = array('user_name' => $userObj->user_name, 
                    'password' => md5(utf8_encode($userObj->password)), 
                    'email' => $userObj->email, 
                    'first_name' => $userObj->first_name, 
                    'last_name' => $userObj->last_name);
                
                $lastId = $this->getUserTable()->saveUser($data);
                if ($lastId) {
                    $this->getUserTable()->setUserSession('frontidsession', 
                        $lastId);
                    
                    $message = "You have registered successfully.";
                    $this->flashmessenger()->addMessage($message);
                    
                    return $this->redirect()->toRoute('home');
                } else {
                    // some error occured
                }
            }
        }
        
        return array('registerForm' => $form);
    }

    /**
     * unset the session so that image get change in application module
     * headerlayout
     *
     * @return Ambigous <\Zend\Http\Response, \Zend\Stdlib\ResponseInterface>
     */
    public function logoutAction()
    {
        $userSession = new Container('user');
        $userSession->getManager()->getStorage()->clear('user');
        $container = new Container('SiteLink');
        $container->getManager()->getStorage()->clear('SiteLink');
        return $this->redirect()->toRoute('home');
    }

    /**
     * will generate a mail for user against request for change password
     *
     * @return Ambigous <\Zend\Http\Response,
     *         \Zend\Stdlib\ResponseInterface>|multitype:\User\Form\ForgetPasswordForm
     */
    public function forgetpasswordAction()
    {
        $form = new ForgetPasswordForm();
        $form->get('submit')->setValue('Request');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $userObj = new ForgetPasswordEntity();
            $form->setInputFilter($userObj->getInputFilter());
            
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $userObj->exchangeArray($form->getData());
                $result = $this->getUserTable()->getUser(
                    array('email' => $userObj->email));
                
                if (isset($result)) {
                    
                    $result = (array) $result[0];
                    /*
                     * done so that multi level array lead to single level
                     */
                    $encryptLink = $result['id'] . '_' . $result['email'] . '_' .
                         $result['user_name'];
                    $result = (array) $result;
                    $result['link'] = md5(utf8_decode($encryptLink));
                    
                    $this->mailConfiguration($result);
                    $this->getUserTable()->updateUser(
                        array('link' => $result['link']), 
                        array('user_name' => $result['user_name']));
                    // to do set mgs that mail has been send
                    
                    return $this->redirect()->toRoute('login');
                } else {
                    die("invalid email");
                }
            }
        }
        
        return array('forgetPasswordForm' => $form);
    }

    /**
     * send mail to user against request for change password
     *
     * @param unknown $emailLinkArray            
     */
    public function mailConfiguration($emailLinkArray)
    {
        $uri = $this->getRequest()->getUri();
        $scheme = $uri->getScheme();
        $host = $uri->getHost();
        $base = sprintf('%s://%s', $scheme, $host);
        $url = $this->url()->fromRoute('changePassword');
        
        $mail = new Mail\Message();
        $html = '<a href="' . $base . $url . '?unique_key=' .
             $emailLinkArray['link'] . '" >Click to change password</a>';
        $bodyPart = new \Zend\Mime\Message();
        
        $bodyMessage = new \Zend\Mime\Part($html);
        $bodyMessage->type = 'text/html';
        $bodyPart->setParts(array($bodyMessage));
        
        $mail->setBody($bodyPart);
        $mail->setFrom('ramandeep.singh@osscube.com', 'admin');
        $mail->addTo($emailLinkArray['email']);
        $mail->setSubject('Change Password');
        $transport = new SmtpTransport();
        $options = new SmtpOptions(
            array('name' => 'localhost', 'host' => 'smtp.gmail.com', 
                'connection_class' => 'login', 'port' => '465', 
                'connection_config' => array('ssl' => 'ssl', /* Page would hang without this line being added */
						'username' => 'somethingworthy2013', 
                    'password' => 'test8765why')));
        $transport->setOptions($options);
        
        $transport->send($mail);
        return;
    }

    /**
     * change pasword action willl update password
     *
     * @return Ambigous <\Zend\Http\Response,
     *        
     *         \Zend\Stdlib\ResponseInterface>|multitype:\User\Form\ChangePasswordForm
     */
    public function changepasswordAction()
    {
        if (isset($_GET['unique_key']) || $_POST['unique_key']) {
            
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
                    $result = $this->getUserTable()->getUser(
                        array('link' => $_POST['unique_key']));
                    
                    if (isset($result)) {
                        $result = (array) $result[0];
                        /*
                         * done so that multi level array lead to singlelevel
                         */
                        $this->getUserTable()->updateUser(
                            array(
                                'password' => md5(
                                    utf8_encode($userObj->password))), 
                            array('id' => $result['id']));
                        return $this->redirect()->toRoute('login');
                    } else {
                        // todo plz select right link
                    }
                }
            }
            
            return array('changePasswordForm' => $form);
        } else {
            return $this->redirect()->toRoute('home');
        }
    }

    /**
     * will validate the email provided for registration is unique or not
     *
     * @return \Zend\Stdlib\ResponseInterface Ambigous
     *         \Zend\Stdlib\ResponseInterface>
     */
    public function checkemailAction()
    {
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $result = $this->getUserTable()->getUser(
                array('email' => $_POST['email']));
            
            if ($result) {
                $check = true;
            } else {
                $check = false;
            }
            
            $response = $this->getResponse();
            $response->setContent(json_encode($check));
            return $response;
        } else {
            return $this->redirect()->toRoute('home');
        }
    }
}