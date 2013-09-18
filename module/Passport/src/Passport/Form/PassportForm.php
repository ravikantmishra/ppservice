<?php
/*
 * Organization: OSSCube Added: Ramandeep Singh Scope: Passport form for client
 * side validation Dated: 10-09-2013
 */
namespace Passport\Form;

use Zend\Form\Form;

class PassportForm extends Form
{

    /**
     *
     * @param string $values            
     */
    public function __construct($values = null)
    {
        parent::__construct('passport');
        $this->setAttribute('method', 'post');
        
        $this->add(
            array('type' => 'Zend\Form\Element\Select', 
                'attributes' => array('type' => 'select'), 'name' => 'title', 
                'options' => array('label' => 'Title', 
                    'value_options' => array('MR' => 'MR', 'MRS' => 'MRS', 
                        'MISS' => 'MISS', 'DR' => 'DR'))));
        
        // $this->add(array(
        // 'type' => 'Zend\Form\Element\Select',
        // 'attributes' => array(
        // 'type' => 'select',
        // ),
        // 'name' => 'date_of_birth[passport_application][day]',
        // 'options' => array(
        // 'value_options' => array(
        // '1'=>'01',
        // '2'=>'02',
        // '3'=>'03',
        // '4'=>'04',
        // '5'=>'05',
        // '6'=>'06',
        // '7'=>'07',
        // '8'=>'08',
        // '9'=>'09',
        // '10'=>'10',
        // '11'=>'11',
        // '12'=>'12',
        // '13'=>'13',
        // '14'=>'14',
        // '15'=>'15',
        // '16'=>'16',
        // '17'=>'17',
        // '18'=>'18',
        // '19'=>'19',
        // '20'=>'20',
        // '21'=>'21',
        // '22'=>'22',
        // '23'=>'23',
        // '24'=>'24',
        // '25'=>'25',
        // '26'=>'26',
        // '27'=>'27',
        // '28'=>'28',
        // '29'=>'29',
        // '30'=>'30',
        // '31'=>'31',
        // ),
        // ),
        // ));
        // $this->add(array(
        // 'type' => 'Zend\Form\Element\Select',
        // 'attributes' => array(
        // 'type' => 'select',
        // ),
        // 'name' => 'date_of_birth[passport_application][month]',
        // 'options' => array(
        // 'value_options' => array(
        // '1'=>'01',
        // '2'=>'02',
        // '3'=>'03',
        // '4'=>'04',
        // '5'=>'05',
        // '6'=>'06',
        // '7'=>'07',
        // '8'=>'08',
        // '9'=>'09',
        // '10'=>'10',
        // '11'=>'11',
        // '12'=>'12',
        // ),
        // ),
        // ));
        
        $this->add(
            array('name' => 'first_name', 
                'attributes' => array('type' => 'text', 
                    'required' => 'required', 'id' => 'first_name'), 
                'options' => array('label' => 'First Name')));
        
        $this->add(
            array('name' => 'last_name', 
                'attributes' => array('type' => 'text', 'id' => 'last_name'), 
                'options' => array('label' => 'Last Name')));
        
        $this->add(
            array('type' => 'Zend\Form\Element\Select', 
                'attributes' => array('type' => 'select'), 'name' => 'gender', 
                'options' => array('label' => 'Gender', 
                    'value_options' => array('Male' => 'Male', 
                        'Female' => 'Female'))));
        
        $this->add(
            array('name' => 'address1', 
                'attributes' => array('type' => 'text', 
                    'required' => 'required', 'id' => 'address1'), 
                'options' => array('label' => 'Address 1')));
        
        $this->add(
            array('name' => 'address2', 
                'attributes' => array('type' => 'text', 'id' => 'address2'), 
                'options' => array('label' => 'Address 2')));
        
        $this->add(
            array('name' => 'email', 
                'attributes' => array('type' => 'text', 'id' => 'email', 
                    'required' => 'required', 
                    'onblur' => 'checkEmail(this.value);'), 
                'options' => array('label' => 'Email')));
        
        $this->add(
            array('type' => 'Zend\Form\Element\Select', 
                'attributes' => array('type' => 'select', 'value' => 0), 
                'name' => 'country', 
                'options' => array('label' => 'Country:', 
                    'value_options' => $values['country'])));
        
        $this->add(
            array('name' => 'state', 
                'attributes' => array('type' => 'text', 
                    'required' => 'required', 'id' => 'state'), 
                'options' => array('label' => 'State')));
        
        $this->add(
            array('name' => 'submit', 
                'attributes' => array('type' => 'submit', 'value' => 'Go', 
                    'id' => 'submitbutton', 'class' => 'btnArea')));
    }
}