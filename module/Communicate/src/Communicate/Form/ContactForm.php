<?php
namespace Communicate\Form;

use Zend\Form\Form;

class ContactForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('contact');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'txt_name',
            'attributes' => array(
                'type'  => 'text',
            	'id' => 'txt_name',
            	'required' => 'required',
            		'class' => 'flushMe',
            ),
            'options' => array(
                'label' => 'Name',
            ),
        ));
        $this->add(array(
            'name' => 'txt_email',
            'attributes' => array(
                'type'  => 'text',
            	'id' => 'txt_email',
            	'required' => 'required',
            		'class' => 'flushMe',
            ),
            'options' => array(
                'label' => 'Email',
            ),
        ));
        
        
         $this->add(array(
            'name' => 'txt_phone',
            'attributes' => array(
                'type'  => 'text',
            	'id' => 'txt_phone',
            	'required' => 'required',
            		'class' => 'flushMe',
            ),
            'options' => array(
                'label' => 'Phone',
            ),
        ));
         
         $this->add(array(
         		'name' => 'txt_enquiry',
         		'attributes' => array(
         			'type'  => 'textarea',
         			'id' => 'txt_enquiry',
         			'required' => 'required',
         				'class' => 'flushMe',
         		),
         		'options' => array(
         			'label' => 'Enquiry',
         		),
         ));
         
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Submit',
                'class' => 'btnArea',
            ),
        ));
        $this->add(array(
        		'name' => 'cancel',
        		'type' => 'Zend\Form\Element\Button',
        		'attributes' => array(
        				'value' => 'Cancel',
        				'class' => 'btnArea',
        				'onclick' => "window.location='/'"
        		),
        ));
    }
}