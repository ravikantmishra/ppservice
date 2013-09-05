<?php 
namespace Info\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
class InfoController extends AbstractActionController
{

    public function indexAction()
    {
		return $this->redirect()->toRoute('info',array('action'=>'howtoapply'));
    }
    
    Public function privacyAction()
    {
    	
    }
    Public function howtoapplyAction()
    {
    	 
    }
}
