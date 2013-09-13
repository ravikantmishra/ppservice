<?php
/*
 * Organization: OSSCube Added: Ramandeep Singh Scope: Register server side
 * validation form Dated: 05-09-2013
 */
namespace User\Model\Entity;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class RegisterEntity implements InputFilterAwareInterface
{
    public $id;
    public $user_name;
    public $password;
    public $confirm_password;
    public $email;
    public $first_name;
    public $last_name;
    protected $inputFilter;

    /**
     *
     * @param unknown $data
     *            array containing value from form
     */
    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->user_name = (isset($data['user_name'])) ? $data['user_name'] : null;
        $this->password = (isset($data['password'])) ? $data['password'] : null;
        $this->confirm_password = (isset($data['confirm_password'])) ? $data['confirm_password'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->first_name = (isset($data['first_name'])) ? $data['first_name'] : null;
        $this->last_name = (isset($data['last_name'])) ? $data['last_name'] : null;
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
                    array('name' => 'user_name', 'required' => true, 
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim')), 
                        'validators' => array(
                            array('name' => 'StringLength', 
                                'options' => array('encoding' => 'UTF-8', 
                                    'min' => 1, 'max' => 100))))));
            
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
            
            $inputFilter->add(
                $factory->createInput(
                    array('name' => 'email', 'required' => true, 
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim')), 
                        'validators' => array(
                            array('name' => 'StringLength', 
                                'options' => array('encoding' => 'UTF-8', 
                                    'min' => 1, 'max' => 100))))));
            
            $inputFilter->add(
                $factory->createInput(
                    array('name' => 'first_name', 'required' => false,
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim')), 
                        'validators' => array(
                            array('name' => 'StringLength', 
                                'options' => array('encoding' => 'UTF-8', 
                                    'min' => 1, 'max' => 100))))));
            
            $inputFilter->add(
                $factory->createInput(
                    array('name' => 'last_name', 'required' => false, 
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim')), 
                        'validators' => array(
                            array('name' => 'StringLength', 
                                'options' => array('encoding' => 'UTF-8', 
                                    'min' => 1, 'max' => 100))),
            )));

            $this->inputFilter = $inputFilter;
        }
        
        return $this->inputFilter;
    }
}