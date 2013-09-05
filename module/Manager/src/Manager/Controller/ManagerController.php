<?php 
/* 
 * Added:  Vinod Maurya 
 * Scope:  Admin login Class
 * Dated: 03/09/2013
 * 
 * */

namespace Manager\Controller;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Manager\Model\Manager;    
use Manager\Model\ManagerTable;
use Manager\Form\ManagerForm; 
use Zend\Session\Config\StandardConfig;
use Zend\Session\SessionManager;
use Zend\Session\Container;
use Blog\Controller\ViewController;

class ManagerController extends AbstractActionController
{

	protected $managerTable;
	protected $form;
	protected $storage;
	protected $authservice;

	
	public function getAuthService()
    {
        if (! $this->authservice) {
            $this->authservice = $this->getServiceLocator()
                                      ->get('AuthService');
        }
        
        return $this->authservice;
    }
	
	
    public function getManagerTable()
    {
        if (!$this->managerTable) {
            $sm = $this->getServiceLocator();            
            $this->managerTable = $sm->get('\Manager\Model\ManagerTable');
        }
        
        return $this->managerTable;
    }


	   public function getSessionStorage()
    {
        if (! $this->storage) {
            $this->storage = $this->getServiceLocator()
                                  ->get('Manager\Model\MyAuthStorage');
        }
        
        return $this->storage;
    }
    
    public function getForm()
    {
        if (!$this->form) {
            $user       = new Manager();
            $builder    = new AnnotationBuilder();
            $this->form = $builder->createForm($user);
        }
        
        return $this->form;
    }

	
	public function loginAction()
    {
	
        //if already login, redirect to success page 
        if ($this->getAuthService()->hasIdentity()){
            return $this->redirect()->toRoute('success');
        }
                
        $form       = $this->getForm();
        
        return array(
            'form'      => $form,
            'messages'  => $this->flashmessenger()->getMessages()
        );
    }
	
	
    function successAction()
    {
    	$container = new Container('namespace');
        $container->adminsession;
        if ($container->adminsession)
    	{
    	
			$messages="Welcome to administrator";
    	}
    	else
    	{
    		$messages="Sorry Your username or password is incorrect";
    		
    	}

	    $this->flashmessenger()->addMessage($messages);
	    
    	return array(
    			 
    			'flashMessages'  => $this->flashmessenger()->getMessages()
    	);	
    	
    }
    
    
    

  public function indexAction()
  {
	   if ($this->getAuthService()->hasIdentity())
	    {
	    	return $this->redirect()->toRoute('manager', array('action' => 'success'));
	    }
   		 $form = new ManagerForm();
	 	 $request = $this->getRequest();
	     if ($request->isPost()) {
		 $manager = new Manager();
		 $form->setInputFilter($manager->getInputFilter());
         $form->setData($request->getPost());
         if ($form->isValid()) 
         {
			$manager->exchangeArray($form->getData());
			$authAdapter= $this->getAuthService()->getAdapter()
                          ->setIdentity($request->getPost('username'))
                           ->setCredential($request->getPost('password'));
                                       
             $result = $this->getAuthService()->authenticate();
             $resultnew= $authAdapter->getResultRowObject();
//              foreach($result->getMessages() as $message)
//               {
//                 $this->flashmessenger()->addMessage($message);
//              }
            
                if ($result->isValid()) {
					if ($this->getAuthService()->hasIdentity())
					{
					  $adminsession=$resultnew->id;
					  $config = new StandardConfig();
					  $manager = new SessionManager($config);
					  $container = new Container('namespace');
					  $container->adminsession = $adminsession;

					  $messages="Welcome to administrator";
					  $this->flashmessenger()->addMessage($messages);
					  return $this->redirect()->toRoute('manager', array('action' => 'success'));
					}
					$this->getAuthService()->setStorage($this->getSessionStorage());
                    $this->getAuthService()->getStorage()->write($request->getPost('username'));
                   
                }
                else
                {
                	
                	$message="Your username and password Incorrect";
                	return $this->redirect()->toRoute('manager', array('action' => 'index'));
                	
				}
             }
			}
	 			 return array('form' => $form);
   			 }
    
   			 
   			 
   			 
 	
    public function adduserAction()
    {
    	
    	$container = new Container('namespace');
        $container->adminsession;
        if ($container->adminsession)
        {
        	$messages="Welcome to administrator";
        }
        else
        {
        	$messages="Sorry Your username or password is incorrect";
        }
        $this->flashmessenger()->addMessage($messages);
    		
    }
    
    
    public function adminuserAction()
    {
		$container = new Container('namespace');
        $container->adminsession;
    	if ($container->adminsession)
    	{
    		$messages="Welcome to administrator";
    	}
    	else
    	{
    		$messages="Sorry Your username or password is incorrect";
    	}
    	$this->flashmessenger()->addMessage($messages);
    	
    	
    	
    }
    
    
	
	public function logoutAction()
    {
    	$config = new StandardConfig();
    	$manager = new SessionManager($config);
    	
        if ($this->getAuthService()->hasIdentity()) {
            $this->getSessionStorage()->forgetMe();
            $this->getAuthService()->clearIdentity();
            $manager->destroy();
            $this->flashmessenger()->addMessage("You've been logout");
        }
        
        return $this->redirect()->toRoute('manager');
    }



}
