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
				'name' => 'first_name',
				'attributes' => array(
						'type'  => 'text',
						'required'=>'required',
				),
				'options' => array(
						'label' => 'First Name',
				),
		));
		
		
		$this->add(array(
				'name' => 'last_name',
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
						'id' => 'email',
						'required'=>'required',
						'onblur' => 'checkEmail(this.value);',
				),
				'options' => array(
						'label' => 'Email',
				),
		));
		
		
		
		$this->add(array(
				'name' => 'user_name',
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
						'required'=>'required',
// 						'setValue'=>'1',
						'value_options' => array(
								'1' => 'Active',
								'0' => 'Inactive',
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
