<?php
/*
 * Organization: OSSCube Added: Ramandeep Singh Scope: Login form server side
 * validation Dated: 05-09-2013
 */
namespace User\Model\Entity;

use Zend\InputFilter\Factory as InputFactory; // <-- Add this import
use Zend\InputFilter\InputFilter; // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface; // <-- Add this import
use Zend\InputFilter\InputFilterInterface; // <-- Add this import
class LoginEntity implements InputFilterAwareInterface
{
    public $user_name;
    public $password;
    protected $inputFilter; // <-- Add this variable
    /**
     *
     * @param unknown $data
     *            array containing value from form
     */
    public function exchangeArray($data)
    {
        $this->user_name = (isset($data['user_name'])) ? $data['user_name'] : null;
        $this->password = (isset($data['password'])) ? $data['password'] : null;
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
                    array('name' => 'user_name', 
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim')))));
            
            $inputFilter->add(
                $factory->createInput(
                    array('name' => 'password', 
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim'),
                ),
               
            )));
            
            

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}
