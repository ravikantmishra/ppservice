<?php
/*
 * Organization: OSSCube
* Added: Ramandeep Singh
* Scope: Apply form for client side validation
* Dated: 10-09-2013
*/
namespace Passport\Form;

use Zend\Form\Form;

class ApplyForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('passport');
		$this->setAttribute('method', 'post');
		
		if(isset($name)) {
			$name[0]='-- Please Select Country --';
		}
		$this->add(array(
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'type' => 'select',
						'id' => 'application_type',
						'value'=> '0',
						'onChange' => 'checkApplicationType(this.value);',
				),
				'name' => 'application_type',
				'options' => array(
						'label' => 'Application Type:',
						'value_options' => array(
								'0' => '-- Please Select Application --',
								'1' => 'Passport',
								'2' => 'Visa',
						),
				),
		));
		
		$this->add(array(
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'type' => 'select',
						'id' => 'country',
						'value'=> '0',
						'onChange' => 'checkCountry(this.value);',
				),
				'name' => 'country',
				'options' => array(
						'label' => 'Processing Country:',
						'value_options' => $name,
				),
		));				
		
		$this->add(array(
				'name' => 'btnSubmit',
				'attributes' => array(
						'type'  => 'submit',
						'value' => 'Go',
						'id' => 'submitbutton',
						'class' => 'btnArea',
				),
		));
	}
}