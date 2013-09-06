<?php 
namespace Manager\Form;
use Zend\Form\Form;
class ManagerForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('manager');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type'  => 'text',
            	'required'=>'required',
            ),
            'options' => array(
                'label' => 'UserName',
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'password',
            		'required'=>'required',
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));
        
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Submit',
                'id' => 'submitbutton',
            	'class'=>'btnArea',
            ),
        ));
    
    }
}
