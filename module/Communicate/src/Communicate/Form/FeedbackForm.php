<?php

/**
 * Organization: OSSCube
 * Added: Sanchit Puri
 * Scope: Class to create the feedback view form
 * Dated: 05-09-2013
 */
namespace Communicate\Form;

use Zend\Form\Form;

class FeedbackForm extends Form
{

    /**
     * used to create the instance of FeedbackForm class to generate the
     * feedback view form
     *
     * @param string $name            
     */
    public function __construct($name = null)
    {
        parent::__construct('feedback');
        $this->setAttribute('method', 'post');
        
        $this->add(
            array('name' => 'txt_name', 
                'attributes' => array('type' => 'text', 'id' => 'txt_name', 
                    'class' => 'flushMe'), 'options' => array('label' => 'Name:')));
        
        $this->add(
            array('name' => 'txt_email', 
                'attributes' => array('type' => 'text', 'id' => 'txt_email', 
                    'class' => 'flushMe'), 
                'options' => array('label' => 'Email:')));
        
        $this->add(
            array('name' => 'txt_phone', 
                'attributes' => array('type' => 'text', 'id' => 'txt_phone', 
                    'class' => 'flushMe'), 
                'options' => array('label' => 'Phone:')));
        
        $this->add(
            array('name' => 'txt_enquiry', 
                'attributes' => array('type' => 'textarea', 
                    'id' => 'txt_enquiry', 'class' => 'flushMe'), 
                'options' => array('label' => 'Enquiry:')));
        
        $this->add(
            array('name' => 'submit', 
                'attributes' => array('type' => 'submit', 'value' => 'Submit', 
                    'class' => 'btnArea')));
        $this->add(
            array('name' => 'cancel', 'type' => 'Zend\Form\Element\Button', 
                'attributes' => array('value' => 'Cancel', 'class' => 'btnArea', 
                    'onclick' => "window.location='/'")));
    }
}