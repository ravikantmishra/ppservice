<?php
/*
 * Organization: OSSCube
* Added: Ramandeep Singh
* Scope: forrgetp password server side validation form
* Dated: 06-09-2013
*/
namespace User\Model\Entity;

use Zend\InputFilter\Factory as InputFactory;     
use Zend\InputFilter\InputFilter;                 
use Zend\InputFilter\InputFilterAwareInterface;   
use Zend\InputFilter\InputFilterInterface;        

class ForgetPasswordEntity implements InputFilterAwareInterface
{
    public $id;
    public $email;
    protected $inputFilter;                       

    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id']))     ? $data['id']     : null;
        $this->email  = (isset($data['email']))  ? $data['email']  : null;
        
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

            $this->inputFilter = $inputFilter;
        }
        
        return $this->inputFilter;
    }
}