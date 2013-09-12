<?php 
/* Organization: OSSCube
 * Added:  Vinod k Maurya 
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
use Manager\Model\ContactTable;
use Manager\Model\RegisterTable;
use Manager\Model\FeedbackTable;
use Manager\Form\ManagerForm; 
use Manager\Form\AdminForm;
use Zend\Session\Config\StandardConfig;
use Zend\Session\SessionManager;
use Zend\Session\Container;
use Manager\Model\Entity\AdminEntity;
use Manager\Model\Entity\ContactEntity;
use Manager\Model\Entity\FeedbackEntity;
use Manager\Model\Entity\RegisterEntity;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;


class ManagerController extends AbstractActionController
{
	protected $managerTable;
	protected $adminTable;
	protected $contactTable;
	protected $feedbackTable;
	protected $userTable;
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
    /*
     *  Function use for getting the object of admin table class
    */
    
    public function getAdminTable()
    {
    	if (!$this->adminTable) {
    		$this->adminTable = $this->getServiceLocator()->get ( 'AdminTable' );
    	}
    	return $this->adminTable;
    }
    /*
     *  Function use for getting the object of contact table class
    */
    
    public function getContactTable()
    {
    	if (!$this->contactTable) {
    		$this->contactTable = $this->getServiceLocator()->get ('ContactTable');
    	}
    	return $this->contactTable;
    }
  
    /*
     *  Function use for getting the object of feedback table class
    */
    
    public function getFeedbackTable()
    {
    	if (!$this->feedbackTable) {
    		$this->feedbackTable = $this->getServiceLocator()->get ('FeedbackTable');
    	}
    	return $this->feedbackTable;
    }

    /*
     *  Function use for getting the object of register table class
    */
    
    
    public function getRegisterTable()
    {
    	if (!$this->userTable) {
    		$this->userTable = $this->getServiceLocator()->get('RegisterTable');
    	}
    	return $this->userTable;
    }
    
 
    
    /*
     *  Function use for define the service of manager  class
    */
   
	public function getSessionStorage()
    {
        if (! $this->storage) {
            $this->storage = $this->getServiceLocator()
                                  ->get('Manager\Model\MyAuthStorage');
        }
        return $this->storage;
    }
    

    /*
     *  Function use for getting the object of manager table class
    */
    
    
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
    		$messages="Sorry Your username or password is incorrect.";
    		return $this->redirect()->toRoute('manager', array('action' => 'index','flashMessages'=> $this->flashmessenger()->getMessages()));
    	}
    	$this->flashmessenger()->addMessage($messages);
    	$flashMessage = $this->flashmessenger()->getMessages();
    	$this->flashMessenger()->clearCurrentMessages();
    	$this->flashMessenger()->clearMessages();
    	return array(
    			'flashMessages'  => $flashMessage,
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
                          ->setIdentity($request->getPost('user_name'))
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
					  $this->getAuthService()->setStorage($this->getSessionStorage());
					  $this->getAuthService()->getStorage()->write($request->getPost('user_name'));
					}
                }
                else
                {
                	$message="Your username and password Incorrect.";
                	$this->flashMessenger()->addMessage($message);
				 }
				 
              }
              
			}
			$flashMessages = $this->flashMessenger()->getMessages();
			$this->flashMessenger()->clearCurrentMessages();
			$this->flashMessenger()->clearMessages();
	 	    return array('form' => $form,'flashMessage' => $flashMessages,);
  		}

  	/*
  	 * Function use for add user Action
  	 */
  		
  		
    public function adduserAction()
    {
    	$container = new Container('namespace');
       
        if($container->adminsession==""){
        	return $this->redirect()->toRoute('manager',array('action'=>'index'));
        }
        $manager = new Manager();
        $form = new AdminForm();
        $form->get('status')->setValue('1');
        $form->setInputFilter($manager->getInputFilter());
        $request = $this->getRequest();
        if($request->isPost()) 
        {
        	$userObj = new AdminEntity();
        	$form->setInputFilter($userObj->getInputFilter());
        	$form->setData($request->getPost());
        	if ($form->isValid()) {
        		$userObj->exchangeArray($form->getData());
        		$this->getAdminTable()->saveUser($userObj);
        		$message="Admin user added successfully.";
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
    	if($container->adminsession==""){
        	return $this->redirect()->toRoute('manager',array('action'=>'index'));
        }
    	$manager = new Manager();
    	$form = new AdminForm();
    	$form->setInputFilter($manager->getInputFilter());
    	$flashMessages = $this->flashMessenger()->getMessages();
    	return new ViewModel(array(
    			'userlist' => $this->getAdminTable()->fetchAll(),'form' => $form,'Message' => $flashMessages,
    	));
	
    }
    /*
     * Function use for  contact user listing
    */
    
    
   public function contactlistdeleteAction()
   {
   	
   	$container = new Container('namespace');
   	if($container->adminsession==""){
   		return $this->redirect()->toRoute('manager',array('action'=>'index'));
   	}
   	$id = (int) $this->params()->fromRoute('id', 0); 
   	if (!$id) {
   		return $this->redirect()->toRoute('manager',array('action'=>'userlist'));
   	}
   	$request = $this->getRequest();
   	$this->getContactTable()->deleteContact($id);
   	$message="Record deleted Successfully.";
   	$this->flashmessenger()->addMessage($message);
   	return $this->redirect()->toRoute('manager',array('action'=>'contact'));
   }
 
   /*
    * Function use for  feed back  listing
   */
   
   public function feedbacklistdeleteAction()
   {
   	$container = new Container('namespace');
   	if($container->adminsession=="")
   	{
   		return $this->redirect()->toRoute('manager',array('action'=>'index'));
   	}
   	 
   	$id = (int) $this->params()->fromRoute('id', 0);
   	if (!$id)
   	{
   		return $this->redirect()->toRoute('manager',array('action'=>'feedback'));
   	}
	   	$request = $this->getRequest();
	   	$this->getFeedbackTable()->deleteFeedback($id);
	   	$message="Record deleted Successfully.";
	   	$this->flashmessenger()->addMessage($message);
	   	return $this->redirect()->toRoute('manager',array('action'=>'feedback'));
   	
   	
   }
   

    /*
     * Function use for delete admin user data 
    */
    
    
    Public function admindeleteAction()
    {
    	$container = new Container('namespace');
    	if($container->adminsession=="")
    	{
    		return $this->redirect()->toRoute('manager',array('action'=>'index'));
    	}
    	 
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) 
    	{
    		return $this->redirect()->toRoute('manager',array('action'=>'userlist'));
    	}
	    	$request = $this->getRequest();
	    	$this->getAdminTable()->deleteAdmin($id);
	    	$message="Record deleted Successfully.";
	    	$this->flashmessenger()->addMessage($message);
	    	return $this->redirect()->toRoute('manager',array('action'=>'userlist'));
    }
    	
    /*
     * Function use for  user  listing
    */
    
    
    Public function registerlistdeleteAction()
    {
    	$container = new Container('namespace');
    	if($container->adminsession=="")
    	{
    		return $this->redirect()->toRoute('manager',array('action'=>'index'));
    	}
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) 
    	{
    		return $this->redirect()->toRoute('manager',array('action'=>'register'));
    	}
	    	$request = $this->getRequest();
	    	$this->getRegisterTable()->deleteRegister($id);
	    	$message="Record deleted Successfully.";
	    	$this->flashmessenger()->addMessage($message);
	    	return $this->redirect()->toRoute('manager',array('action'=>'register'));
    }

    
    /*
     * Function use for delete contact  data
    */
    
    
    function contactactivelistAction()
    {   
    	$container = new Container('namespace');
	    	if($container->adminsession=="")
	    	{
	    		return $this->redirect()->toRoute('manager',array('action'=>'index'));
	    	}
    	 
	    	$id = (int) $this->params()->fromRoute('id', 0);
	    	$status =  $this->params()->fromRoute('status', 'inactive');
	    	if($id!="" && $status!="")
	    	{
		    	$contact = $this->getContactTable()->getContact($id);
		    	if($contact->seen == 'active'){ $check = 'inactive'; }else {$check = 'active';}
		    	$this->getContactTable()->updateContact(array('seen'=>$check),array('id'=>$contact->id));
		    	return $this->redirect()->toRoute('manager',array('action'=>'contact'));
	    	}
    }

    /*
     * Function use for  feed back active deactive functinality
    */

    function feedbackactivelistAction()
    {	
    	$container = new Container('namespace');
    	if($container->adminsession=="")
    	{
    		return $this->redirect()->toRoute('manager',array('action'=>'index'));
    	}
    	 
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$status =  $this->params()->fromRoute('status', 'inactive');
    	if($id!="" && $status!="")
    	{
	    	$contact = $this->getFeedbackTable()->getFeedback($id);
	    	if($contact->seen == 'active'){ $check = 'inactive'; }else {$check = 'active';}
	    	$this->getFeedbackTable()->updateFeedback(array('seen'=>$check),array('id'=>$contact->id));
	    	return $this->redirect()->toRoute('manager',array('action'=>'feedback'));
    	}
    }
    

    /*
     * Function use for  active user data
    */
    
    
    function activeuserlistAction()
    {
    	$container = new Container('namespace');
    	if($container->adminsession=="")
    	{
    		return $this->redirect()->toRoute('manager',array('action'=>'index'));
    	}
    	 
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$status = $this->params()->fromRoute('status');
    	if($id!="" && $status!="")
    	{
	    	$contact = $this->getAdminTable()->getAdmin($id);
	    	$this->getAdminTable()->updateAdmin(array('status'=>($contact->status) ? 0:1),array('id'=>$contact->id));
	    	return $this->redirect()->toRoute('manager',array('action'=>'userlist'));
    	}
    }
    
    

    /*
     * Function use for  active user data
    */
    

    function registeractivelistAction()
    {
    	$container = new Container('namespace');
    	if($container->adminsession==""){
    		return $this->redirect()->toRoute('manager',array('action'=>'index'));
    	}
    	 
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$status =  $this->params()->fromRoute('status', 'inactive');
    	if($id!="" && $status!="")
    	{
	    	$registerData = $this->getRegisterTable()->getRegister($id);
	    	if($registerData->status == 'active'){ $check = 'inactive'; }else {$check = 'active';}
	    	$this->getRegisterTable()->updateRegister(array('status'=>$check),array('id'=>$registerData->id));
	    	return $this->redirect()->toRoute('manager',array('action'=>'register'));
    	}
    	 
    }
   
    /*
     * Function use for change status for contact table
    */
    
    public function contactAction()
    {
    	
   		$container = new Container('namespace');
	   	if($container->adminsession=="")
	   	{
	   		return $this->redirect()->toRoute('manager',array('action'=>'index'));
	   	}
    	$manager = new Manager();
    	$flashMessages = $this->flashMessenger()->getMessages();
    	$select = new Select();
    	$order_by = $this->params()->fromRoute('order_by') ?
    	$this->params()->fromRoute('order_by') : 'id';
    	$order = $this->params()->fromRoute('order') ?
    	$this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
    	$page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;
    	$contactData = $this->getContactTable()->fetchAll($select->order($order_by . ' ' . $order));
    	$itemsPerPage = 10;
    	$contactData->current();
    	$paginator = new Paginator(new paginatorIterator($contactData));
    	$paginator->setCurrentPageNumber($page)
    	->setItemCountPerPage($itemsPerPage)
    	->setPageRange(7);
    	$flashMessages = $this->flashMessenger()->getMessages();
    	return new ViewModel(array(
    			'order_by' => $order_by,
    			'order' => $order,
    			'page' => $page,
    			'Message'=>$flashMessages,
    			'contactlist' => $paginator,
    	)); 

    }

    /*
     * Function use for fetch all feedback table data
    */
    
    public function feedbackAction()
    {
    	$container = new Container('namespace');
    	if($container->adminsession=="")
    	{
    		return $this->redirect()->toRoute('manager',array('action'=>'index'));
    	}
    	$manager = new Manager();
    	$flashMessages = $this->flashMessenger()->getMessages();
    	$select = new Select();
    	$order_by = $this->params()->fromRoute('order_by') ?
    	$this->params()->fromRoute('order_by') : 'id';
    	$order = $this->params()->fromRoute('order') ?
    	$this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
    	$page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;
    	$contactData = $this->getFeedbackTable()->fetchAll($select->order($order_by . ' ' . $order));
    	$itemsPerPage = 10;
    	$contactData->current();
    	$paginator = new Paginator(new paginatorIterator($contactData));
    	$paginator->setCurrentPageNumber($page)
    	->setItemCountPerPage($itemsPerPage)
    	->setPageRange(7);
    	$flashMessages = $this->flashMessenger()->getMessages();
    	return new ViewModel(array(
    			'order_by' => $order_by,
    			'order' => $order,
    			'page' => $page,
    			'Message'=>$flashMessages,
    			'feedbacklist' => $paginator,
    	));

    }
    
    /*
     *  Function use for  user  listing
    */
    
    
    public  function registerAction()
    {
	    $container = new Container('namespace');
	   	if($container->adminsession=="")
	   	{
	   		return $this->redirect()->toRoute('manager',array('action'=>'index'));
	   	}
    	$flashMessages = $this->flashMessenger()->getMessages();
    	$select = new Select();
    	$order_by = $this->params()->fromRoute('order_by') ?
    	$this->params()->fromRoute('order_by') : 'id';
    	$order = $this->params()->fromRoute('order') ?
    	$this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
    	$page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;
    	$contactData = $this->getRegisterTable()->fetchAll($select->order($order_by . ' ' . $order));
    	$itemsPerPage = 10;
    	$contactData->current();
    	$paginator = new Paginator(new paginatorIterator($contactData));
    	$paginator->setCurrentPageNumber($page)
    	->setItemCountPerPage($itemsPerPage)
    	->setPageRange(7);
    	$flashMessages = $this->flashMessenger()->getMessages();
    	return new ViewModel(array(
    			'order_by' => $order_by,
    			'order' => $order,
    			'page' => $page,
    			'Message'=>$flashMessages,
    			'listuser' => $paginator,
    	));
    }
    /*
     * Function use for logout admin session 
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
