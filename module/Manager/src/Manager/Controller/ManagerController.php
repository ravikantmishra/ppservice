<?php 
/* Organization: OSSCube
 * Added:  Vinod Maurya 
 * Scope:  Admin login Class
 * Dated: 03/09/2013
 * */
namespace Manager\Controller;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Manager\Model\Manager;    
use Manager\Model\ManagerTable;
use Manager\Model\AdminTable;
use Manager\Form\ManagerForm; 
use Manager\Form\AdminForm;
use Zend\Session\Config\StandardConfig;
use Zend\Session\SessionManager;
use Zend\Session\Container;
use Manager\Model\Entity\AdminEntity;
class ManagerController extends AbstractActionController
{
	protected $managerTable;
	protected $adminTable;
	protected $form;
	protected $storage;
	protected $authservice;
	public $viewmodel;

	public function getAuthService()
    {
        if (! $this->authservice) {
            $this->authservice = $this->getServiceLocator()
                                      ->get('AuthService');
        }
        
        return $this->authservice;
    }
	
    /*
     *  Function use for getting the object of manager table class
     */
    
    public function getManagerTable()
    {
        if (!$this->managerTable) {
            $sm = $this->getServiceLocator();            
            $this->managerTable = $sm->get('\Manager\Model\ManagerTable');
        }
        
        return $this->managerTable;
    }
    
    
    public function getAdminTable()
    {
    	if (!$this->adminTable) {
    		$this->adminTable = $this->getServiceLocator ()->get ( 'AdminTable' );
    	}
    
    	return $this->adminTable;
    }
    /*
     *  Function use for getting the object of manager table class
    */
   
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


 
    
    /*
     * Function use for redirect the page after login
    */
    
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
    		return $this->redirect()->toRoute('manager', array('action' => 'index','flashMessages'=> $this->flashmessenger()->getMessages()));
    	}
	    
    	$this->flashmessenger()->addMessage($messages);
    	return array(
    			'flashMessages'  => $this->flashmessenger()->getMessages()
    	);
    } 
    
    

    /*
     * Function use for check the username and password for admin login
    */
    
    
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
                if ($result->isValid()) 
                {
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
                	$this->flashMessenger()->addMessage($message);
				 }
				 
              }
              
			}
			$flashMessages = $this->flashMessenger()->getMessages();
	 			 return array('form' => $form,
	 			 				'flashMessage' => $flashMessages,
	 			 			);
  		}

  	/*
  	 * Function use for add user Action
  	 */
  		

  		
  		
    public function adduserAction()
    {
    	$container = new Container('namespace');
        $container->adminsession;
        $manager = new Manager();
        $form = new AdminForm();
        $form->get('status')->setValue('1');
        $form->setInputFilter($manager->getInputFilter());
        $request = $this->getRequest();
        if ($request->isPost()) 
        {
        	$userObj = new AdminEntity();
        	$form->setInputFilter($userObj->getInputFilter());
        	$form->setData($request->getPost());
        	if ($form->isValid()) {
        		$userObj->exchangeArray($form->getData());
        		$this->getAdminTable()->saveUser($userObj);
        		$message="Admin user added successfully";
        		$this->flashmessenger()->addMessage($message);
        		
        	}
        	
        	return $this->redirect()->toRoute('manager', array('action' => 'userlist'));
        }

       
       	return array('form' => $form);
    }
    
    /*
     * Function use for  admin user listing
    */
    
    
    public function userlistAction()
    {
    	$container = new Container('namespace');
    	$container->adminsession;
    	$manager = new Manager();
    	$form = new AdminForm();
    	$form->setInputFilter($manager->getInputFilter());
    	$flashMessages = $this->flashMessenger()->getMessages();
    	return new ViewModel(array(
    			'userlist' => $this->getAdminTable()->fetchAll(),'form' => $form,'flashMessage' => $flashMessages,
    	));
	
    }
    
    
    /*
     * Function use for  admin user delete data
    */
    
    
    Public function admindeleteAction()
    {
    	
    	 $id = (int) $this->params()->fromRoute('id', 0);
    	
    	if (!$id) {
    		return $this->redirect()->toRoute('manager',array('action'=>'userlist'));
    	}
    	
    	$request = $this->getRequest();
    	$this->getAdminTable()->deleteAdmin($id);
    	
    	$message="Record deleted Successfully";
    	
    	$this->flashmessenger()->addMessage($message);
    		
    	return $this->redirect()->toRoute('manager',array('action'=>'userlist'));
    }
    	

    /*
     * Function use for  active user data
    */
    
    
    function activeuserlistAction()
    {
    	
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$status = (int) $this->params()->fromRoute('status', 0);
    	$contact = $this->getAdminTable()->getAdmin($id);
    	$this->getAdminTable()->updateAdmin(array('status'=>($contact->status) ? 0:1),array('id'=>$contact->id));
    	return $this->redirect()->toRoute('manager',array('action'=>'userlist'));
		    	
    }
    
    
    
    
    
    
    /*
     * Function use for admin user Action
    */
    
    
    public function adminuserAction()
    {
		$container = new Container('namespace');
        $container->adminsession;
    }
    
    /*
     * Function use for admin session logout
    */
    
	
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
