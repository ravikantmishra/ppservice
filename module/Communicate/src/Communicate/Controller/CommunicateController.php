<?php
namespace Communicate\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Communicate\Model\Contact;
use Communicate\Model\Feedback;
class CommunicateController extends AbstractActionController
{
	protected $_contactTable;
	protected $_feedbackTable;
	
	public function getContactTable()
	{
		if (! $this->_contactTable) {
			$this->_contactTable = $this->getServiceLocator ()->get ( 'Communicate\Model\ContactTable' );
		}
		return $this->_contactTable;
	}
	public function getFeedbackTable()
	{
		if (! $this->_feedbackTable) {
			$this->_feedbackTable = $this->getServiceLocator ()->get ( 'Communicate\Model\FeedbackTable' );
		}
		return $this->_feedbackTable;
	}
	
	public function contactusAction()
	{
		$contactUsForm = $this->getServiceLocator()->get('contact_us_form'); // create an instance of contact form
		return new ViewModel(array('contactUs' => $contactUsForm));
	}
	
	public function savecontactAction()
	{
		$contactForm = $this->getServiceLocator()->get('contact_us_form');
		$request = $this->getRequest ();
		$response = $this->getResponse ();
		if ($request->isPost ()) {
			$contactUs = new Contact();
			$contactForm->setInputFilter($contactUs->getInputFilter());
			$contactForm->setData ( $request->getPost () );
			if ($contactForm->isValid ()) 
			{
				$contactUs->exchangeArray ( $contactForm->getData () );
				if($this->getContactTable()->savecontact($contactUs))
				{
					$response->setContent ( \Zend\Json\Json::encode ( array (
							'response' => true,
							'message' => 'Your Enquiry has been send to us. We will get back to you soon.'
					) ) );
					return $response;
					
// 					$message = "Your Enquiry has been send to us. We will get back to you soon.";
// 					$this->flashmessenger()->addMessage($message);
// 					return $this->redirect()->toRoute('communicate' , array('action' => 'contactus'));
					
				}
				else 
				{
					$response->setContent ( \Zend\Json\Json::encode ( array (
							'response' => false,
							'message' => 'There is some problem occured. Please try Again'
					) ) );
					return $response;
					
// 					$message = "There is some problem occured";
// 					die("hel not done");
					
				}
			}
			else
			{
				$response->setContent ( \Zend\Json\Json::encode ( array (
						'response' => false,
						'message' => 'Please Fill Valid Data in fields'
				) ) );
				return $response;
				
// 				$message = "Please Fill Valid Data in fields";
// 				$this->redirect()->toRoute('communicate',array('action' => 'contactus'));
				
			}
				
		}
		else
		{
			return $this->redirect()->toRoute('Communicate',array('action' => 'contactus'));
		}	
	}
	
	// Feedback work
	
	public function feedbackAction()
	{
		$feedbackForm = $this->getServiceLocator()->get('feedback_form'); // create an instance of contact form
		return new ViewModel(array('feedback' => $feedbackForm));
	}
	
	public function savefeedbackAction()
	{
		$feedbackForm = $this->getServiceLocator()->get('feedback_form');
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
					$response->setContent ( \Zend\Json\Json::encode ( array (
							'response' => true,
							'message' => 'Your Enquiry has been send to us. We will get back to you soon.'
					) ) );
					return $response;
						
					// 					$message = "Your Enquiry has been send to us. We will get back to you soon.";
					// 					$this->flashmessenger()->addMessage($message);
					// 					return $this->redirect()->toRoute('communicate' , array('action' => 'contactus'));
						
				}
				else
				{
					$response->setContent ( \Zend\Json\Json::encode ( array (
							'response' => false,
							'message' => 'There is some problem occured. Please try Again'
					) ) );
					return $response;
						
					// 					$message = "There is some problem occured";
					// 					die("hel not done");
						
				}
			}
			else
			{
				$response->setContent ( \Zend\Json\Json::encode ( array (
						'response' => false,
						'message' => 'Please Fill Valid Data in fields'
				) ) );
				return $response;
		
				// 				$message = "Please Fill Valid Data in fields";
				// 				$this->redirect()->toRoute('communicate',array('action' => 'contactus'));
		
			}
		
		}
		else
		{
			return $this->redirect()->toRoute('communicate',array('action' => 'feedback'));
		}
		
	}
}
