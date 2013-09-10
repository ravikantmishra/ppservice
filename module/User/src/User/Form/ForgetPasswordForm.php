<?php
/*
 * Organization: OSSCube
* Added: Ramandeep Singh
* Scope: User forget password form for client side validation
* Dated: 06-09-2013
*/
namespace User\Form;

use Zend\Form\Form;

class ForgetPasswordForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('user');
		$this->setAttribute('method', 'post');
				
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