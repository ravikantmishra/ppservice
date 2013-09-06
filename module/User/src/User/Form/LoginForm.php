<?php
/*
 * Organization: OSSCube
* Added: Ramandeep Singh
* Scope: User login form for client side validation
* Dated: 05-09-2013
*/
namespace User\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('user');
		$this->setAttribute('method', 'post');
		$this->add(array(
				'name' => 'user_name',
				'type'=>'Zend\Form\Element\Text',
				'attributes' => array(
						'type'  => 'text',
						'id' => 'user_name',
						'required' => 'required',
						'onblur' => 'checkUserName(this.value);',
				),
				'options' => array(
						'label' => 'Username or E-Mail',
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