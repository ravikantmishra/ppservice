<?php
/*
 * Organization: OSSCube
* Added: Sanchit Puri
* Scope: Coomunicate module controller for Contact Us and Feedback
* Dated: 05-09-2013
*/
namespace Communicate\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Communicate\Model\Contact;
use Communicate\Model\Feedback;
class CommunicateController extends AbstractActionController
{
	protected $_contactTable;
	protected $_feedbackTable;
	
	// returns the object of ContactTable model class
	public function getContactTable()
	{
		if (! $this->_contactTable)
		{
			$this->_contactTable = $this->getServiceLocator ()->get ( 'Communicate\Model\ContactTable' );
		}
		return $this->_contactTable;
	}
	
	// returns the object of FeedbackTable model class
	public function getFeedbackTable()
	{
		if (! $this->_feedbackTable)
		{
			$this->_feedbackTable = $this->getServiceLocator ()->get ( 'Communicate\Model\FeedbackTable' );
		}
		return $this->_feedbackTable;
	}
	
	// contactus View form
	public function contactusAction()
	{
		$contactUsForm = $this->getServiceLocator()->get('contact_us_form'); // create an instance of contact form

		$flashMessages = $this->flashMessenger()->getCurrentMessages();
		$this->flashMessenger()->clearCurrentMessages();
		$this->flashMessenger()->clearMessages();
		
		return new ViewModel(array('contactUs' => $contactUsForm,
									'flashMessage' => $flashMessages,
							));
	}
	
	// used to insert the enquiry into the database table contact and returns the message
	public function saveContactUsAction()
	{
		$contactUsForm = $this->getServiceLocator()->get('contact_us_form');
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		if ($request->isPost ())
		{
			$contactUs = new Contact();
			$contactUsForm->setInputFilter($contactUs->getInputFilter());
			$contactUsForm->setData ( $request->getPost () );
		
			if ($contactUsForm->isValid ())
			{
				$contactUs->exchangeArray ( $contactUsForm->getData () );
				if($this->getContactTable()->saveContact($contactUs))
				{
					$message = "Thanks for showing interest. We will get back to you soon.";
					$this->flashMessenger()->addMessage($message);
				}
				else
				{
					$message = "There is some problem occured";
					$this->flashMessenger()->addMessage($message);
				}
			}
			else
			{
				$message = "Please Fill Valid Data in fields";
				$this->flashMessenger()->addMessage($message);
			}
		
		}
		
		return $this->redirect()->toRoute('communicate',array('action' => 'contactus'));
	}
	
	// Feedback view form
	public function feedbackAction()
	{
		$feedbackForm = $this->getServiceLocator()->get('feedback_form'); // create an instance of contact form
		
		$flashMessages = $this->flashMessenger()->getCurrentMessages();
		$this->flashMessenger()->clearCurrentMessages();
		$this->flashMessenger()->clearMessages();
		
		return new ViewModel(array('feedback' => $feedbackForm,
									'flashMessage' => $flashMessages,
						));
	}
	
	// used to insert the feedback into the database table feedback and returns the message
	public function saveFeedbackAction()
	{
		$feedbackForm = $this->getServiceLocator()->get('feedback_form'); // create an instance of contact form
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		
		if ($request->isPost ()) {
			$feedback = new Feedback();
			$feedbackForm->setInputFilter($feedback->getInputFilter());
			$feedbackForm->setData ( $request->getPost () );
			if ($feedbackForm->isValid ())
			{
				$feedback->exchangeArray ( $feedbackForm->getData () );
				if($this->getFeedbackTable()->saveFeedback($feedback))
				{
					$message = "Thanks for your feedback. We will get back to you soon.";
					$this->flashMessenger()->addMessage($message);
				}
				else
				{
					$message = "There is some problem occured";
					$this->flashMessenger()->addMessage($message);
				}
			}
			else
			{
				$message = "Please Fill Valid Data in fields";
				$this->flashMessenger()->addMessage($message);
			}
		
		}
		
		return $this->redirect()->toRoute('communicate',array('action' => 'feedback'));
	}
}
