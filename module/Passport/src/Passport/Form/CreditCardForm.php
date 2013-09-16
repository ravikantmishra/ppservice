<?php
/*
 * Organization: OSSCube Added: Ramandeep Singh Scope: Credit Card form for
 * client side validation Dated: 16-09-2013
 */
namespace Passport\Form;

use Zend\Form\Form;

class CreditCardForm extends Form
{

    /**
     *
     * @param string $name            
     */
    public function __construct($values = null)
    {
        parent::__construct('passport');
        $this->setAttribute('method', 'post');
        
        $this->add(
            array('name' => 'first_name', 
                'attributes' => array('type' => 'text', 
                    'required' => 'required', 'id' => 'first_name', 
                    'value' => $values[0][first_name]), 
                
                'options' => array('label' => 'First Name')));
        
        $this->add(
            array('name' => 'last_name', 
                'attributes' => array('type' => 'text', 'id' => 'last_name', 
                    'value' => $values[0][last_name]), 
                'options' => array('label' => 'Last Name')));
        $this->add(
            array('name' => 'address1', 
                'attributes' => array('type' => 'text', 
                    'required' => 'required', 'id' => 'address1', 
                    'value' => $values[0][address1]), 
                'options' => array('label' => 'Address 1')));
        
        $this->add(
            array('name' => 'address2', 
                'attributes' => array('type' => 'text', 'id' => 'address2', 
                    'value' => $values[0][address2]), 
                'options' => array('label' => 'Address 2')));
        $this->add(
            array('type' => 'Zend\Form\Element\Select', 
                'attributes' => array('type' => 'select', 'value' => 0), 
                'name' => 'country', 
                'options' => array('label' => 'Country:', 
                    'value_options' => $values[0][country])));
        
        $this->add(
            array('name' => 'town', 
                'attributes' => array('type' => 'text', 'id' => 'town'), 
                'options' => array('label' => 'Town')));
        
        $this->add(
            array('name' => 'state', 
                'attributes' => array('type' => 'text', 
                    'required' => 'required', 'id' => 'state', 
                    'value' => $values[0][state]), 
                'options' => array('label' => 'State')));
        
        $this->add(
            array('name' => 'zip', 
                'attributes' => array('type' => 'text', 'id' => 'zip'), 
                'options' => array('label' => 'Zip')));
        
        $this->add(
            array('name' => 'email', 
                'attributes' => array('type' => 'text', 'id' => 'email', 
                    'required' => 'required', 
                    'onblur' => 'checkEmail(this.value);', 
                    'value' => $values[0][email]), 
                'options' => array('label' => 'Email')));
        
        $this->add(
            array('name' => 'phone', 
                'attributes' => array('type' => 'text', 'id' => 'phone'), 
                'options' => array('label' => 'Phone Number')));
        
        $this->add(
            array('type' => 'Zend\Form\Element\Select', 
                'attributes' => array('type' => 'select'), 'name' => 'card_type', 
                'options' => array('label' => 'Card Type', 
                    'value' => array('A' => 'American Express', 
                        'M' => 'Master Card', 'V' => 'VISA Card'))));
        $this->add(
            array('name' => 'card_number', 
                'attributes' => array('type' => 'text', 
                    'required' => 'required', 'id' => 'card_number'), 
                'options' => array('label' => 'Card Number')));
        
        $this->add(
            array('name' => 'card_holder', 
                'attributes' => array('type' => 'text', 
                    'required' => 'required', 'id' => 'card_holder'), 
                'options' => array('label' => 'Card Holder')));
        
        $this->add(
            array('type' => 'Zend\Form\Element\Select', 
                'attributes' => array('type' => 'select'), 
                'name' => 'expiry_date[month]', 
                'options' => array(
                    'value_option' => array('1' => '01', '2' => '02', 
                        '3' => '03', '4' => '04', '5' => '05', '6' => '06', 
                        '7' => '07', '8' => '08', '9' => '09', '10' => '10', 
                        '11' => '11', '12' => '12'))));
        
        $this->add(
            array('type' => 'Zend\Form\Element\Select', 
                'attributes' => array('type' => 'select'), 
                'name' => 'expiry_date[year]', 
                'options' => array('label' => 'Expiry Date', 
                    'value_option' => array('2013' => '2013', '2014' => '2014', 
                        '2015' => '2015', '2016' => '2016', '2017' => '2017', 
                        '2018' => '2018', '2019' => '2019', '2020' => '2020', 
                        '2021' => '2021', '2022' => '2022', '2023' => '2023'))));
        
        $this->add(
            array('name' => 'cvv', 
                'attributes' => array('type' => 'text', 
                    'required' => 'required', 'id' => 'cvv'), 
                'options' => array('label' => 'CVV')));
        
        $this->add(
            array('name' => 'submit', 
                'attributes' => array('type' => 'submit', 'value' => 'Go', 
                    'id' => 'submitbutton', 'class' => 'btnArea')));
    }
}