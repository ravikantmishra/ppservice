<?php
/*
 * Organization: OSSCube Added: Ramandeep Singh Scope: Register server side
 * validation form Dated: 05-09-2013
 */
namespace Passport\Model\Entity;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class CountryEntity implements InputFilterAwareInterface
{
    public $id;
    public $name;
    protected $inputFilter;

    /**
     *
     * @param unknown $data
     *            will consist values being send from form
     */
    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
    }

    /**
     * non-PHPdoc)
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
                    array('name' => 'name', 'required' => true, 
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim')))));
            
            $this->inputFilter = $inputFilter;
        }
        
        return $this->inputFilter;
    }
}