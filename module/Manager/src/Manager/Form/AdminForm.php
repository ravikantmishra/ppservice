<?php
namespace Manager\Form;
use Zend\Form\Form;
class AdminForm extends Form
{
	public function __construct($name = null)
	{
		// we want to ignore the name passed
		parent::__construct('manager');
		$this->setAttribute('method', 'post');
		$this->add(array(
				'name' => 'id',
				'attributes' => array(
						'type'  => 'hidden',
				),
		));
		
		$this->add(array(
				'name' => 'firstname',
				'attributes' => array(
						'type'  => 'text',
						'required'=>'required',
				),
				'options' => array(
						'label' => 'First Name',
				),
		));
		
		
		$this->add(array(
				'name' => 'lastname',
				'attributes' => array(
						'type'  => 'text',
						'required'=>'required',
				),
				'options' => array(
						'label' => 'Last Name',
				),
		));
		
		
		

		$this->add(array(
				'name' => 'email',
				'attributes' => array(
						'type'  => 'text',
						'required'=>'required',
				),
				'options' => array(
						'label' => 'Email',
				),
		));
		
		
		
		$this->add(array(
				'name' => 'username',
				'attributes' => array(
						'type'  => 'text',
						'required'=>'required',
				),
				'options' => array(
						'label' => 'UserName',
				),
		));
		$this->add(array(
				'name' => 'password',
				'attributes' => array(
						'type'  => 'password',
						'required'=>'required',
				),
				'options' => array(
						'label' => 'Password',
				),
		));
		
		
		
		$this->add(array(
				'name' => 'status',
				'attributes' => array(
						'type'  => 'radio',
						'required'=>'required',
				),
				'options' => array(
						'label' => 'Status',
				),
		));
		
		
		$this->add(array(
				'type' => 'Zend\Form\Element\Radio',
				'name' => 'status',
				'options' => array(
						'label' => 'Status',
						'value_options' => array(
								'0' => 'Inactive',
								'1' => 'Active',
						),
				)
		));
		
		
	

		$this->add(array(
				'name' => 'submit',
				'attributes' => array(
						'type'  => 'submit',
						'value' => 'Submit',
						'id' => 'submitbutton',
						'class'=>'btnArea',
				),
		));

	}
}
