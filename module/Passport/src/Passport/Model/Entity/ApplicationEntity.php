<?php
/*
 * Organization: OSSCube Added: Ramandeep Singh Scope: Passport server side
 * validation form Dated: 11-09-2013
 */
namespace Passport\Model\Entity;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class ApplicationEntity implements InputFilterAwareInterface
{
    public $id;
    public $type;
    public $title;
    public $first_name;
    public $last_name;
    public $gender;
    public $date_of_birth;
    public $address1;
    public $address2;
    public $email;
    public $state;
    public $country;
    public $town;
    public $zip;
    public $phone;
    public $amount;
    public $payment;
    public $passport_number;
    public $order_number;
    public $status;
    public $created_date;
    protected $inputFilter;

    /**
     *
     * @param unknown $data
     *            will consist values being send from form
     */
    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->type = (isset($data['type'])) ? $data['type'] : null;
        $this->title = (isset($data['title'])) ? $data['title'] : null;
        $this->first_name = (isset($data['first_name'])) ? $data['first_name'] : null;
        $this->last_name = (isset($data['last_name'])) ? $data['last_name'] : null;
        $this->gender = (isset($data['gender'])) ? $data['gender'] : null;
        $this->date_of_birth = (isset($data['date_of_birth'])) ? $data['date_of_birth'] : null;
        $this->address1 = (isset($data['address1'])) ? $data['address1'] : null;
        $this->address2 = (isset($data['address2'])) ? $data['address2'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->state = (isset($data['state'])) ? $data['state'] : null;
        $this->country = (isset($data['country'])) ? $data['country'] : null;
        $this->town = (isset($data['town'])) ? $data['town'] : null;
        $this->zip = (isset($data['zip'])) ? $data['zip'] : null;
        $this->phone = (isset($data['phone'])) ? $data['phone'] : null;
        $this->amount = (isset($data['amount'])) ? $data['amount'] : null;
        $this->payment = (isset($data['payment'])) ? $data['payment'] : null;
        $this->passport_number = (isset($data['passport_number'])) ? $data['passport_number'] : null;
        $this->order_number = (isset($data['order_number'])) ? $data['order_number'] : null;
        $this->status = (isset($data['status'])) ? $data['status'] : null;
        $this->created_date = (isset($data['created_date'])) ? $data['created_date'] : null;
        $this->order_number = (isset($data['order_number'])) ? $data['order_number'] : null;
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
                    array('name' => 'type', 'required' => false, 
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim')))));
            
            $inputFilter->add(
                $factory->createInput(
                    array('name' => 'title', 
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim')))));
            $inputFilter->add(
                $factory->createInput(
                    array('name' => 'first_name', 
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim')))));
            $inputFilter->add(
                $factory->createInput(
                    array('name' => 'last_name', 'required' => false, 
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim')))));
            $inputFilter->add(
                $factory->createInput(
                    array('name' => 'gender', 
                        
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim')))));
            $inputFilter->add(
                $factory->createInput(
                    array('name' => 'date_of_birth', 'required' => false, 
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim')))));
            $inputFilter->add(
                $factory->createInput(
                    array('name' => 'address1', 
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim')))));
            $inputFilter->add(
                $factory->createInput(
                    array('name' => 'address2', 'required' => false, 
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim')))));
            $inputFilter->add(
                $factory->createInput(
                    array('name' => 'email', 
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim')))));
            $inputFilter->add(
                $factory->createInput(
                    array('name' => 'state', 
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim')))));
            $inputFilter->add(
                $factory->createInput(
                    array('name' => 'country', 
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim')))));
            $inputFilter->add(
                $factory->createInput(
                    array('name' => 'town', 'required' => false, 
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim')))));
            $inputFilter->add(
                $factory->createInput(
                    array('name' => 'zip', 'required' => false, 
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim')))));
            $inputFilter->add(
                $factory->createInput(
                    array('name' => 'phone', 'required' => false, 
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim')))));
            $inputFilter->add(
                $factory->createInput(
                    array('name' => 'amount', 'required' => false, 
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim')))));
            $inputFilter->add(
                $factory->createInput(
                    array('name' => 'payment', 'required' => false, 
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim')))));
            $inputFilter->add(
                $factory->createInput(
                    array('name' => 'passport_number', 'required' => false, 
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim')))));
            $inputFilter->add(
                $factory->createInput(
                    array('name' => 'order_number', 'required' => false, 
                        'filters' => array(array('name' => 'StripTags'), 
                            array('name' => 'StringTrim')))));
            
            $this->inputFilter = $inputFilter;
        }
        
        return $this->inputFilter;
    }
}