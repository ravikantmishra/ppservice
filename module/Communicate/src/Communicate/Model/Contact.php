<?php 
/*
 * Organization: OSSCube
* Added: Sanchit Puri
* Scope: Contact Model class used to set the form fields and validate the fields data
* Dated: 05-09-2013
*/
namespace Communicate\Model;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Contact
{
    public $name;
    public $email;
    public $phone;
    public $enquiry;

    // used to set the data coming from form
	public function exchangeArray($data)
    {
        $this->name = (isset($data['txt_name'])) ? $data['txt_name'] : null;
        $this->email = (isset($data['txt_email'])) ? $data['txt_email'] : null;
        $this->phone  = (isset($data['txt_phone'])) ? $data['txt_phone'] : null;
        $this->enquiry  = (isset($data['txt_enquiry'])) ? $data['txt_enquiry'] : null;
    }
    
    
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
    
    // returns the validation on the fields
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'txt_name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                	array(
                		'name' => 'Regex',
                		'options' => array(
                		'pattern' => '/^[a-zA-Z]+((\s|\-)[a-zA-Z]+)?$/',
                		),
                	),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'txt_email',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                    		'name' => 'EmailAddress',
                        	'options' => array(
	                            'encoding' => 'UTF-8',
	                            'min'      => 5,
	                            'max'      => 100,
                        ),
                    ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
            		'name'     => 'txt_phone',
            		'required' => true,
            		'filters'  => array(
            				array('name' => 'StripTags'),
            				array('name' => 'StringTrim'),
            		),
            		'validators' => array(
            				array(
			                    'name' => 'Regex',
			                    'options' => array(
			                    'pattern' => '/^[0-9]+$/',
                       			),
                    		),
            				array(
            						'name'    => 'StringLength',
            						'options' => array(
            								'encoding' => 'UTF-8',
            								'min'      => 10,
            								'max'      => 12,
            						),
            				),
                	),
            )));
            
            
            $inputFilter->add($factory->createInput(array(
            		'name'     => 'txt_enquiry',
            		'required' => true,
            		'filters'  => array(
            				array('name' => 'StripTags'),
            				array('name' => 'StringTrim'),
            		),
            		'validators' => array(
            				array(
            						'name'    => 'StringLength',
            						'options' => array(
            								'encoding' => 'UTF-8',
            								'min'      => 5,
            								'max'      => 500,
            						),
            				),
            		),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
    
    
    
    
   
    
    
    
}
