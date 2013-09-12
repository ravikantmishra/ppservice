<?php

namespace Manager\Model\Entity;
use Zend\Db\Adapter\Adapter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Db\TableGateway\AbstractTableGateway;


class TemplateEntity  //implements InputFilterAwareInterface
{
	public $id;
	public $template_name;
	public $template_data;
	public $created_on;
	public $updated_on;
	public $template_subject;

	
	public function exchangeArray($data)
	{
		$this->id     = (isset($data['id']))     ? $data['id']     : null;
		$this->template_name = (isset($data['templateName'])) ? $data['templateName'] : null;
		$this->template_subject = (isset($data['templateSubject'])) ? $data['templateSubject'] : null;
		$this->template_data  = (isset($data['templateBody']))  ? $data['templateBody']  : null;
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
					'name'     => 'templateName',
					'required' => true,
					'filters'  => array(
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'min'      => 1,
											'max'      => 100,
									),
							),
					),
			)));

			$inputFilter->add($factory->createInput(array(
					'name'     => 'templateSubject',
					'required' => true,
					'filters'  => array(
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'min'      => 1,
											'max'      => 100,
									),
							),
					),
			)));

			

			$inputFilter->add($factory->createInput(array(
					'name'     => 'templateBody',
					'required' => true,
					'filters'  => array(
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'min'      => 1,
									),
							),
					),
			)));
			
			$this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	} 
}