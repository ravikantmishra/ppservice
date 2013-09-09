<?php
/*
 * Organization: OSSCube
* Added: Ramandeep Singh
* Scope: Change Password form client side validation
* Dated: 06-09-2013
*/
namespace User\Form;

use Zend\Form\Form;

class ChangePasswordForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('user');
		$this->setAttribute('method', 'post');

		
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
				'name' => 'unique_key',
				'attributes' => array(
						'type'  => 'hidden',
				)
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