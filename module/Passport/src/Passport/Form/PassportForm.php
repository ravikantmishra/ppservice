<?php
/*
 * Organization: OSSCube
* Added: Ramandeep Singh
* Scope: Passport form for client side validation
* Dated: 10-09-2013
*/
namespace Passport\Form;

use Zend\Form\Form;

class PassportForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('passport');
		$this->setAttribute('method', 'post');
		
		
		$this->add(array(
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'type' => 'select',
						'value'=>0,
				),
				'name' => 'title',
				'options' => array(
						'label' => 'Title',
						'value_options' => array(
								'0' => 'MR',
								'1' => 'MRS',
								'2' => 'MISS',
								'3' => 'DR',
						),
				),
		));
		
		$this->add(array(
				'name' => 'first_name',
				'attributes' => array(
						'type'  => 'text',
						'id' => 'first_name',
				),
				'options' => array(
						'label' => 'First Name',
				),
		));
		
		$this->add(array(
				'name' => 'last_name',
				'attributes' => array(
						'type'  => 'text',
						'id' => 'last_name',
				),
				'options' => array(
						'label' => 'Last Name',
				),
		));
		
		$this->add(array(
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'type' => 'select',
						'value'=>0,
				),
				'name' => 'gender',
				'options' => array(
						'label' => 'Gender',
						'value_options' => array(
								'0' => 'Male',
								'1' => 'Female',
						),
				),
		));
		
		$this->add(array(
				'name' => 'address1',
				'attributes' => array(
						'type'  => 'text',
						'id' => 'address1',
				),
				'options' => array(
						'label' => 'Address 1',
				),
		));
		
		$this->add(array(
				'name' => 'address2',
				'attributes' => array(
						'type'  => 'text',
						'id' => 'address2',
				),
				'options' => array(
						'label' => 'Address 2',
				),
		));
		
		$this->add(array(
				'name' => 'email',
				'attributes' => array(
						'type'  => 'text',
						'id' => 'email',
						'required' => 'required',
						'onblur' => 'checkEmail(this.value);',
				),
				'options' => array(
						'label' => 'Email',
				),
		));
		
		$this->add(array(
				'type' => 'Zend\Form\Element\Select',
				'attributes' => array(
						'type' => 'select',
						'value'=>0,
				),
				'name' => 'country',
				'options' => array(
						'label' => 'Processing Country:',
						'value_options' => $name,
				),
		));
		
		$this->add(array(
				'name' => 'town',
				'attributes' => array(
						'type'  => 'text',
						'id' => 'town',
				),
				'options' => array(
						'label' => 'Town',
				),
		));
		
		$this->add(array(
				'name' => 'state',
				'attributes' => array(
						'type'  => 'text',
						'id' => 'state',
				),
				'options' => array(
						'label' => 'State',
				),
		));
		
		$this->add(array(
				'name' => 'zip',
				'attributes' => array(
						'type'  => 'text',
						'id' => 'zip',
				),
				'options' => array(
						'label' => 'Zip',
				),
		));

		$this->add(array(
				'name' => 'phone',
				'attributes' => array(
						'type'  => 'text',
						'id' => 'phone',
				),
				'options' => array(
						'label' => 'Phone Number',
				),
		));
		
		$this->add(array(
				'name' => 'submit',
				'attributes' => array(
						'type'  => 'submit',
						'value' => 'Go',
						'id' => 'submitbutton',
						'class' => 'btnArea',
				),
		));
	}
}