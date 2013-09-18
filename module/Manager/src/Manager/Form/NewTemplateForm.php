<?php

/**
 * Organization: OSSCube
 * Added: Sanchit Puri
 * Scope: Class used to create the add template view form
 * Dated: 11-09-2013
 */
namespace Manager\Form;

use Zend\Form\Form;

class NewTemplateForm extends Form
{

    /**
     * constructs the object of the NewTemplateForm class
     * 
     * @param string $name            
     */
    public function __construct($name = null)
    {
        parent::__construct('manager');
        $this->setAttribute('method', 'post');
        $this->add(
            array('name' => 'id', 'attributes' => array('type' => 'hidden')));
        
        $this->add(
            array('name' => 'templateName', 
                'attributes' => array('type' => 'text', 'id' => 'templateName', 
                    'onblur' => 'isTemplateExist(this.value)'), 
                'options' => array('label' => 'Template Name')));
        
        $this->add(
            array('name' => 'templateSubject', 
                'attributes' => array('type' => 'text', 
                    'id' => 'templateSubject'), 
                'options' => array('label' => 'Template Subject')));
        
        $this->add(
            array('name' => 'templateBody', 
                'attributes' => array('type' => 'textarea', 
                    'id' => 'templateBodyArea'), 
                'options' => array('label' => 'Template Body')));
        
        $this->add(
            array('name' => 'submit', 
                'attributes' => array('type' => 'submit', 'value' => 'Submit', 
                    'id' => 'submitbutton', 'class' => 'btnArea')));
    }
}
