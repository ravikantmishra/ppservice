<?php
/*
 * Organization: OSSCube
* Added: Ramandeep Singh
* Scope: Register form client side validation
* Dated: 05-09-2013
*/
namespace User\Form;

use Zend\Form\Form;

class RegisterForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('user');
		$this->setAttribute('method', 'post');

		$this->add(array(
				'name' => 'user_name',
				'attributes' => array(
						'type'  => 'text',
						'id' => 'user_name',
						'required' => 'required',
						'onblur' => 'checkUserName(this.value);',
				),
				'options' => array(
						'label' => 'User Name',
				),
		));
		$this->add(array(
				'name' => 'password',
				'attributes' => array(
						'type'  => 'password',
						'id' => 'password',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Password',
				),
		));
		$this->add(array(
				'name' => 'confirm_password',
				'attributes' => array(
						'type'  => 'password',
						'id' => 'confirm_password',
						'required' => 'required',
						'onkeyup' => 'checkPassword();',
				),
				'options' => array(
						'label' => 'Confirm Password',
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
				'name' => 'submit',
				'attributes' => array(
						'type'  => 'submit',
						'value' => 'Go',
						'id' => 'submitbutton',
						'class' => 'btnArea',
				),
		));
		
		$this->add(array(
				'name' => 'back',
				'attributes' => array(
						'type'  => 'button',
						'value' => 'Go',
						'id' => 'backbutton',
						'class' => 'btnArea',
				),
		));
	}
}