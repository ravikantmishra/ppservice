<?php
/*
 * Organization: OSSCube Added: Ramandeep Singh Scope: ChangePassword server
 * side validation form Dated: 06-09-2013
 */
namespace User\Model\Entity;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class ChangePasswordEntity implements InputFilterAwareInterface
{
    public $id;
    public $password;
    public $confirm_password;
    public $unique_key;
    protected $inputFilter;

    /**
     *
     * @param unknown $data
     *            array containing value from form
     */
    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->password = (isset($data['password'])) ? $data['password'] : null;
        $this->confirm_password = (isset($data['confirm_password'])) ? $data['confirm_password'] : null;
        $this->unique_key = (isset($data['unique_key'])) ? $data['unique_key'] : null;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Zend\InputFilter\InputFilterAwareInterface::setInputFilter()
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Zend\InputFilter\InputFilterAwareInterface::getInputFilter()
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
            
            $inputFilter->add(
                $factory->createInput(
                    array('name' => 'password', 'required' => true, 
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim')), 
                        'validators' => array(
                            array('name' => 'StringLength', 
                                'options' => array('encoding' => 'UTF-8', 
                                    'min' => 1, 'max' => 100))))));
            
            $inputFilter->add(
                $factory->createInput(
                    array('name' => 'confirm_password', 'required' => true, 
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim')), 
                        'validators' => array(
                            array('name' => 'StringLength', 
                                'options' => array('encoding' => 'UTF-8', 
                                    'min' => 1, 'max' => 100))))));
            


            $this->inputFilter = $inputFilter;
        }
        
        return $this->inputFilter;
    }
}