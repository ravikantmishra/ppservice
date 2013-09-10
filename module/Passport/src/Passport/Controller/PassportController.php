<?php
/*
 * Organization: OSSCube Added: Ramandeep Singh Scope: Passport module controller Dated: 11-09-2013
 */
namespace Passport\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Passport\Form\ApplyForm;
use Zend\Session\Container;
use Passport\Form\PassportForm;
use Passport\Model\Entity\PassportEntity;

class PassportController extends AbstractActionController {
	protected $_countryTable;
	
	// function use to fetch table object beu=ing define as a service on Module.php
	public function getCountryTable() {
		if (! $this->_passportTable) {
			$this->_countryTable = $this->getServiceLocator ()->get ( 'CountryTable' );
		}
		return $this->_countryTable;
	}
	public function indexAction() {
	}
	public function applyAction() {

		$container = new Container('user');
		$data= $container->frontidsession;

		if($data){

			$result = $this->getCountryTable ()->fetchAllCountry ();
			foreach ( $result as $key => $val ) {
				$country[$key+1] = $val->name;
			}
			
			$form = new ApplyForm ($country);
			$form->get ( 'submit' )->setValue ( 'Submit' );
			
			
			return array (
					'applyForm' => $form,
			);
		}else {
			return  $this->redirect()->toRoute('login');
		}
		
	}
	
	public function applypassportAction() {
		
		$container = new Container('user');
		$data= $container->frontidsession;
		
		if($data){
		
			$result = $this->getCountryTable ()->fetchAllCountry ();
			foreach ( $result as $key => $val ) {
				$country[$key+1] = $val->name;
			}
				
			$form = new PassportForm($country);
			$form->get ( 'submit' )->setValue ( 'Pay Now' );
				
			$request = $this->getRequest();
			if ($request->isPost()) {
					
				$passport = new PassportEntity();
// 				echo "<pre>";
// 				print_r($passport);
// 				die;
				$form->setInputFilter($passport->getInputFilter());
				$rr = $form->setData($request->getPost());
// 	echo "<pre>";
// 				print_r($rr);
// 				die;
				
				if ($form->isValid()) {
					$passport->exchangeArray($form->getData());
					die("insert data");
				}
			}
			
				
			return array (
					'passportForm' => $form,
			);
		}else {
			return  $this->redirect()->toRoute('login');
		}
	}
	
}