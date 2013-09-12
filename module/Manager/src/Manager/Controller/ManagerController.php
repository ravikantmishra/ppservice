<?php 
/* Organization: OSSCube
 * Added:  Vinod Maurya 
 * Scope:  Admin login Class
 * Dated: 03/09/2013
 * */
namespace Manager\Controller;
use Zend\CustomLibrary\AbstractController;
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
	public $templateTable;

	
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
    		$this->adminTable = $this->getServiceLocator ()->get ( 'AdminTable' );
    	}
    	return $this->adminTable;
    }
    /*
     *  Function use for getting the object of contact table class
    */
    
    public function getContactTable()
    {
    	if (!$this->contactTable) {
    		$this->contactTable = $this->getServiceLocator ()->get ( 'ContactTable' );
    	}
    	return $this->contactTable;
    }
    
    
    public function getFeedbackTable()
    {
    	if (!$this->feedbackTable) {
    		$this->feedbackTable = $this->getServiceLocator ()->get ('FeedbackTable');
    	}
    	return $this->feedbackTable;
    }
    
    
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
                	$message="Your username and password Incorrect.";
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
     * Function use for  contact user listing
    */
    
    
   public function contactlistdeleteAction()
   {
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
   	
   	$id = (int) $this->params()->fromRoute('id', 0);
   	 
   	if (!$id) {
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
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
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
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
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
    	
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$status = (int) $this->params()->fromRoute('status', 0);
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
     * Function use for admin user Action
    */
    
    
    public function adminuserAction()
    {
		$container = new Container('namespace');
        $container->adminsession;
    }
    
    /*
     * Function use for change status for contact table
    */
    
    public function contactAction()
    {
    	$container = new Container('namespace');
    	$container->adminsession;
    	$manager = new Manager();
    	$flashMessages = $this->flashMessenger()->getMessages();
    	return new ViewModel(array(
    			'contactlist' => $this->getContactTable()->fetchAll(),'flashMessage' => $flashMessages,
    	));
    	
    }
    

    /*
     * Function use for fetch all feedback table data
    */
    
    public function feedbackAction()
    {
    	$container = new Container('namespace');
    	$container->adminsession;
    	$manager = new Manager();
    	$flashMessages = $this->flashMessenger()->getMessages();
    	return new ViewModel(array(
    			'feedbacklist' => $this->getFeedbackTable()->fetchAll(),'flashMessage' => $flashMessages,
    	));
    	
    }
    
    /*
     *  Function use for  user  listing
    */
    
    
    public  function registerAction()
    {
    	
    	
    	$container = new Container('namespace');
    	$container->adminsession;
    	$flashMessages = $this->flashMessenger()->getMessages();
    	return new ViewModel(array(
    			'listuser' => $this->getRegisterTable()->fetchAll(),'flashMessage' => $flashMessages,
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
    
    // added after 10-9-2013 email template work
    
    public function getTemplateTable()
    {
    	if (!$this->templateTable) {
    		$this->templateTable = $this->getServiceLocator ()->get ( 'Manager\Model\TemplateTable' );
    	}
    	return $this->templateTable;
    }
    
    // function for template
    public function templatesAction()
    {
    	$tamplateArray = $this->getTemplateTable()->getAllTemplates();
    	
    	$flashMessages = $this->flashMessenger()->getCurrentMessages();
    	$this->flashMessenger()->clearCurrentMessages();
    	$this->flashMessenger()->clearMessages();
    	
    	return (array('templateArray' => $tamplateArray,
    					'flashMessage' => $flashMessages,
    			));
    }
    
    public function addtemplateAction()
    {
    	$newTemplateForm = $this->getServiceLocator ()->get ( 'new_template_form' );
    	
    	$flashMessages = $this->flashMessenger()->getCurrentMessages();
    	$this->flashMessenger()->clearCurrentMessages();
    	$this->flashMessenger()->clearMessages();
    	
    	return new ViewModel(array('newTemplate' => $newTemplateForm,
    								'flashMessage' =>$flashMessages,
    					));
    }
    
    public function edittemplateAction()
    {
    	$id = $this->params()->fromRoute('id');
    	
    	$editTemplateForm = $this->getServiceLocator()->get('edit_template_form');
    	$resultVal = $this->getTemplateTable()->getAllTemplates($id);
    	$editTemplateForm->setData(array('id' => $resultVal[0]['id'],
    									'templateBody' => html_entity_decode($resultVal[0]['template_data']),
    									'templateName' => $resultVal[0]['template_name'],
    									'templateSubject' => $resultVal[0]['template_subject'],
    								));
    	
    	$flashMessages = $this->flashMessenger()->getCurrentMessages();
    	$this->flashMessenger()->clearCurrentMessages();
    	$this->flashMessenger()->clearMessages();
    	
    	return new ViewModel(array('editTemplate' => $editTemplateForm,
    								'flashMessage' =>$flashMessages,
    					));

    }
    
    public function updateTemplateAction()
    {
    	$id = $this->params()->fromPost('id');
    	$editTemplateForm = $this->getServiceLocator()->get('edit_template_form');
    	$request = $this->getRequest ();
    	$response = $this->getResponse ();
    	if ($request->isPost ())
    	{
    		$templateEntity = new \Manager\Model\Entity\TemplateEntity();
    		$editTemplateForm->setInputFilter($templateEntity->getInputFilter());
    		$editTemplateForm->setData ( $request->getPost () );
    	
    		if ($editTemplateForm->isValid ())
    		{
    			$templateEntity->exchangeArray ( $editTemplateForm->getData () );
    			if($this->getTemplateTable()->updateTemplate($templateEntity))
    			{
    				$this->redirect()->toRoute('manager',array('action' => 'templates'));
    			}
    			else 
    			{
    				$this->redirect()->toRoute('manager',array('action' => 'templates'));
    			}
    		}
    		else
    		{
    			$message = "No field should left empty. Please Fill Valid data in all fields"; 
				$this->flashMessenger()->addMessage($message);
				return $this->redirect()->toRoute('manager' , array('action' =>'edittemplate','id' => $id));
    		}
	    }
		else 
		{
			$message = "Not a valid Request";
			$this->flashMessenger()->addMessage($message);
			return $this->redirect()->toRoute('manager',array('action' => 'templates'));
		}
	}
	
	public function saveTemplateAction()
	{
		$newTemplateForm = $this->getServiceLocator ()->get ( 'new_template_form' );
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		if ($request->isPost ())
		{
			$templateEntity = new \Manager\Model\Entity\TemplateEntity();
			$newTemplateForm->setInputFilter($templateEntity->getInputFilter());
			$newTemplateForm->setData ( $request->getPost () );
			 
			if ($newTemplateForm->isValid ())
			{
				$templateEntity->exchangeArray ( $newTemplateForm->getData () );
				if($this->getTemplateTable()->saveTemplate($templateEntity))
				{
					$this->redirect()->toRoute('manager',array('action' => 'templates'));
				}
				else
				{
					$this->redirect()->toRoute('manager',array('action' => 'templates'));
				}
			}
			else
			{
				$message = "No field should left empty. Please Fill Valid data in all fields"; 
				$this->flashMessenger()->addMessage($message);
				return $this->redirect()->toRoute('manager' , array('action' =>'addtemplate'));
			}
		}
		else
		{
			$message = "Not a valid Request";
			$this->flashMessenger()->addMessage($message);	
		}
	}
	
	public function templateExistAction()
	{
		$templateName = $this->params()->fromPost('templateName');	
		$result = $this->getTemplateTable()->isTemplateExist($templateName);
		$response = $this->getResponse();
		if($result == "true")
		{
			$response->setContent( \Zend\Json\Json::encode ( array (
								'response' => true,
								'result' => 'Template Already Exist'
						) ) );
			return $response;
		}
		else 
		{
			$response->setContent( \Zend\Json\Json::encode ( array (
					'response' => false,
			) ) );
			return $response;
		}
	}
	
	public function templateMailAction()
	{
		
		die(\Zend\CustomLibrary\CustomTemplateMail::templateMail(
				$templateName ="Sign Up", $sendTo ="user", 
				$placeholderDetails = array('#userName#' => 'abcd', '#email#' => 'user@user.com'),
				$this->getTemplateTable()
		));
	}	
	
/*	public function templateMailAction($templateName ="Sign Up", $sendTo ="user", $placeholderDetails = array('#userName#' => 'abcd', '#email#' => 'user@user.com'))
	{
		if(isset($templateName) && !empty($templateName))
		{
			if(isset($sendTo) && !empty($sendTo))
			{
				$template =$this->getTemplateTable()->getTemplateByName($templateName);
				if($template)
				{
					foreach($placeholderDetails as $key => $value)
					{
						$template[1]  = str_replace($key, $value, $template[1]);
					}
				}
				else
				{
					return ("template name provided does not exist");
				}
			}
			else
			{
				return ( "Please provide email at which you want to send the mail");
			}
		}
		else
		{
			return ( "Please Provide template name which you want to use");
		}
		echo html_entity_decode($template[1]); die;
	} */
}