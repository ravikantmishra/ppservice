<?php
/*
 * Organization: OSSCube Added: Ramandeep Singh Scope: Passport module
 * controller Dated: 11-09-2013
 */
namespace Passport\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Passport\Form\ApplyForm;
use Zend\Session\Container;
use Passport\Form\PassportForm;
use Passport\Model\Entity\ApplicationEntity;
use Passport\Form\VisaForm;

class PassportController extends AbstractActionController
{
    protected $_countryTable;
    protected $_applicationTable;

    /**
     * function use to fetch table object being define as a service on
     * Module.php
     *
     * @return Ambigous <object, multitype:>
     */
    public function getCountryTable()
    {
        if (!$this->_passportTable) {
            $this->_countryTable = $this->getServiceLocator()->get(
                'CountryTable');
        }
        return $this->_countryTable;
    }

    /**
     * function use to fetch table object being define as a service on
     * Module.php
     *
     * @return Ambigous <object, multitype:>
     */
    public function getApplicationTable()
    {
        if (!$this->_applicationTable) {
            $this->_applicationTable = $this->getServiceLocator()->get(
                'ApplicationTable');
        }
        return $this->_applicationTable;
    }

    public function indexAction()
    {
    }

    /**
     * will display apply form
     *
     * @return multitype:\Passport\Form\ApplyForm |Ambigous
     *         <\Zend\Http\Response, \Zend\Stdlib\ResponseInterface>
     */
    public function applyAction()
    {
        $container = new Container('user');
        $data = $container->frontidsession;
        
        if ($data) {
            
            $result = $this->getCountryTable()->fetchCountry();
            if ($result) {
                foreach ($result as $key => $val) {
                    $country[$key + 1] = $val->name;
                }
                $form = new ApplyForm($country);
            } else {
                $form = new ApplyForm();
            }
            $form->get('btnSubmit')->setValue('Submit');
            
            return array('applyForm' => $form);
        } else {
            $userSession = new Container('SiteLink');
            $userSession->LastVisitPage = 'apply';
            return $this->redirect()->toRoute('login');
        }
    }

    /**
     * will display apply passport form
     *
     * @return multitype:\Passport\Form\PassportForm multitype:
     *         |multitype:\Passport\Form\PassportForm |Ambigous
     *         <\Zend\Http\Response, \Zend\Stdlib\ResponseInterface>
     */
    public function applypassportAction()
    {
        $container = new Container('user');
        $data = $container->frontidsession;
        
        $result = $this->getCountryTable()->fetchCountry();
        if ($result) {
            foreach ($result as $key => $val) {
                $country[$key + 1] = $val->name;
            }
            $form = new PassportForm($country);
        } else {
            $form = new PassportForm();
        }
        $form->get('submit')->setValue('Pay Now');
        
        if ($data) {
            
            $flashMessages = $this->flashMessenger()->getCurrentMessages();
            $this->flashMessenger()->clearCurrentMessages();
            $this->flashMessenger()->clearMessages();
            
            if ($flashMessages) {
                return array('passportForm' => $form, 
                    'flashMessage' => $flashMessages);
            }
            
            if ($_POST["application_type"] == 1) {
                return array('passportForm' => $form);
            } else {
                return $this->redirect()->toRoute('apply');
            }
        } else {
            $userSession = new Container('SiteLink');
            $userSession->LastVisitPage = 'apply';
            return $this->redirect()->toRoute('login');
        }
    }

    /**
     * will display apply visa form
     *
     * @return multitype:\Passport\Form\VisaForm multitype:
     *         |multitype:\Passport\Form\VisaForm |Ambigous
     *         <\Zend\Http\Response, \Zend\Stdlib\ResponseInterface>
     */
    public function applyvisaAction()
    {
        $container = new Container('user');
        $data = $container->frontidsession;
        
        $result = $this->getCountryTable()->fetchCountry();
        if ($result) {
            foreach ($result as $key => $val) {
                $country[$key + 1] = $val->name;
            }
            $form = new VisaForm($country);
        } else {
            $form = new VisaForm();
        }
        $form->get('submit')->setValue('Pay Now');
        
        if ($data) {
            
            $flashMessages = $this->flashMessenger()->getCurrentMessages();
            $this->flashMessenger()->clearCurrentMessages();
            $this->flashMessenger()->clearMessages();
            
            if ($flashMessages) {
                return array('visaForm' => $form, 
                    'flashMessage' => $flashMessages);
            }
            
            if ($_POST["application_type"] == 2) {
                return array('visaForm' => $form);
            } else {
                return $this->redirect()->toRoute('apply');
            }
        } else {
            $userSession = new Container('SiteLink');
            $userSession->LastVisitPage = 'apply';
            return $this->redirect()->toRoute('login');
        }
    }

    /**
     * will save passport details and lead to form for payment credentials
     *
     * @return Ambigous <\Zend\Http\Response, \Zend\Stdlib\ResponseInterface>
     */
    public function savepassportAction()
    {
        $container = new Container('user');
        $data = $container->frontidsession;
        
        if ($data) {
            $form = new PassportForm();
            $request = $this->getRequest();
            if ($request->isPost()) {
                $passport = new ApplicationEntity();
                $form->setInputFilter($passport->getInputFilter());
                $form->setData($request->getPost());
                
                if ($form->isValid()) {
                    $passport->exchangeArray($form->getData());
                    
                    $date = $passport->date_of_birth["passport_application"]["day"] .
                         '-';
                    $date .= $passport->date_of_birth["passport_application"]["month"] .
                         '-';
                    $date .= $passport->date_of_birth["passport_application"]["year"];
                    
                    $values = array('type' => 'Passport', 
                        'title' => $passport->title, 
                        'first_name' => $passport->first_name, 
                        'last_name' => $passport->last_name, 
                        'gender' => $passport->gender, 
                        'date_of_birth' => date("Y-m-d", strtotime($date)), 
                        'address1' => $passport->address1, 
                        'address2' => $passport->address2, 
                        'email' => $passport->email, 'state' => $passport->state, 
                        'country_id' => $passport->country, 
                        'user_id' => $container->frontidsession);
                    $lastId = $this->getApplicationTable()->saveApplication(
                        $values);
                    if ($lastId) {
                        die("insert data");
                    } else {
                        // some error occured
                    }
                } else {
                    
                    $this->flashmessenger()->addMessage($form->getMessages());
                    $this->flashmessenger()->addMessage($form->getData());
                    
                    return $this->redirect()->toRoute('passportAplication');
                }
            } else {
                return $this->redirect()->toRoute('apply');
            }
        } else {
            $userSession = new Container('SiteLink');
            $userSession->LastVisitPage = 'apply';
            return $this->redirect()->toRoute('login');
        }
    }

    /**
     * will save visa details and lead to form for payment credentials
     *
     * @return Ambigous <\Zend\Http\Response, \Zend\Stdlib\ResponseInterface>
     */
    public function savevisaAction()
    {
        $container = new Container('user');
        $data = $container->frontidsession;
        
        if ($data) {
            $form = new VisaForm();
            $request = $this->getRequest();
            if ($request->isPost()) {
                $visa = new ApplicationEntity();
                $form->setInputFilter($visa->getInputFilter());
                $form->setData($request->getPost());
                
                if ($form->isValid()) {
                    $visa->exchangeArray($form->getData());
                    
                    $values = array('type' => 'Visa', 'title' => $visa->title, 
                        'first_name' => $visa->first_name, 
                        'last_name' => $visa->last_name, 
                        'gender' => $visa->gender, 
                        'date_of_birth' => $visa->date_of_birth, 
                        'address1' => $visa->address1, 
                        'address2' => $visa->address2, 'email' => $visa->email, 
                        'state' => $visa->state, 'country_id' => $visa->country, 
                        'passport_number' => $visa->passport_number, 
                        'user_id' => $container->frontidsession);
                    
                    if ($values["passport_number"] == null ||
                         $values["passport_number"] == "") {
                        $this->flashmessenger()->addMessage(
                            array(
                                'passport_number' => 'passport field is required'));
                        $this->flashmessenger()->addMessage($form->getData());
                        return $this->redirect()->toRoute('visaAplication');
                    } else {
                        $lastId = $this->getApplicationTable()->saveApplication(
                            $values);
                        if ($lastId) {
                            die("insert data");
                        } else {
                            // some error occured
                        }
                    }
                } else {
                    $this->flashmessenger()->addMessage($form->getMessages());
                    $this->flashmessenger()->addMessage($form->getData());
                    
                    return $this->redirect()->toRoute('visaAplication');
                }
            }
        } else {
            $userSession = new Container('SiteLink');
            $userSession->LastVisitPage = 'apply';
            return $this->redirect()->toRoute('login');
        }
    }

    /**
     * will show list of passport/visa being applied by person
     *
     * @return multitype:unknown |Ambigous <\Zend\Http\Response,
     *         \Zend\Stdlib\ResponseInterface>
     */
    public function knowyourstatusAction()
    {
        $container = new Container('user');
        $data = $container->frontidsession;
        
        if ($data) {
            $values = $this->getApplicationTable()->fetchApplication(
                array('user_id' => $container->frontidsession));
            
            return array('data' => $values);
        } else {
            $userSession = new Container('SiteLink');
            $userSession->LastVisitPage = 'knowyourstatus';
            
            return $this->redirect()->toRoute('login');
        }
    }
}