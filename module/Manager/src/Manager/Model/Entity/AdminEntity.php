<?php

namespace Manager\Model\Entity;
use Zend\Db\Adapter\Adapter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Db\TableGateway\AbstractTableGateway;


class AdminEntity implements InputFilterAwareInterface
{
	public $id;
	public $username;
	public $password;
	public $email;
	public $firstname;
	public $lastname;
	public $status;
	protected $inputFilter;

	
	public function exchangeArray($data)
	{
		$this->id     = (isset($data['id']))     ? $data['id']     : null;
		$this->username = (isset($data['username'])) ? $data['username'] : null;
		$this->password  = (isset($data['password']))  ? $data['password']  : null;
		$this->email  = (isset($data['email']))  ? $data['email']  : null;
		$this->status  = (isset($data['status']))  ? $data['status']  : null;
		$this->firstname = (isset($data['firstname'])) ? $data['firstname'] : null;
		$this->lastname  = (isset($data['firstname']))  ? $data['firstname']  : null;
	}
	


	// Add content to this method:
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception("Not used");
	}

	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$factory     = new InputFactory();


			$inputFilter->add($factory->createInput(array(
					'name'     => 'username',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1,
											'max'      => 100,
									),
							),
					),
			)));

			$inputFilter->add($factory->createInput(array(
					'name'     => 'password',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1,
											'max'      => 100,
									),
							),
					),
			)));

			

			$inputFilter->add($factory->createInput(array(
					'name'     => 'email',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1,
											'max'      => 100,
									),
							),
					),
			)));

			$inputFilter->add($factory->createInput(array(
					'name'     => 'firstname',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1,
											'max'      => 100,
									),
							),
					),
			)));

			$inputFilter->add($factory->createInput(array(
					'name'     => 'lastname',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1,
											'max'      => 100,
									),
							),
					),
			)));
			
		

			$this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	}
}