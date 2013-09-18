<?php

/**
 * Organization: OSSCube
 * Added: Sanchit Puri
 * Scope: Custom Class used to store global functions to use tempalte engine
 * Dated: 12-09-2013
 */
namespace Zend\CustomLibrary;

use Manager\Model\TemplateTable;
// use Zend\ServiceManager\ServiceManager;
// use Zend\ServiceManager\ServiceLocatorInterface;
// use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

class CustomTemplateMail implements ServiceLocatorAwareInterface
{

    /**
     * Setting a Service
     *
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
     */
    public function setServiceLocator(ServiceLocatorInterface $sm)
    {
        $this->_sm = $sm;
    }

    /**
     * Getting a Service
     *
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
     */
    public function getServiceLocator()
    {
        return $this->_sm;
    }

    /**
     * used to return the array that contains tempalte subject and template data
     * (body) of the required template
     *
     * @param string $templateName            
     * @param string $sendTo            
     * @param array $placeholderDetails            
     * @return return array that contains template subject and data (body) on
     *         success otherwise return array with faliure message
     */
    public function templateMail($templateName = "Sign Up", $sendTo = "user", 
        $placeholderDetails = array('#userName#' => 'abcd', '#email#' => 'user@user.com'))
    {
        if (isset($templateName) && !empty($templateName)) {
            if (isset($sendTo) && !empty($sendTo)) {
                
                $templateTableObj = $this->getServiceLocator()->get(
                    'Manager\Model\TemplateTable');
                
                $template = $templateTableObj->getTemplateByName($templateName);
                
                if ($template) {
                    foreach ($placeholderDetails as $key => $value) {
                        $template[1] = str_replace($key, $value, $template[1]);
                    }
                } else {
                    return (array(
                        "message" => "template name provided does not exist"));
                }
            } else {
                return (array(
                    "message" => "Please provide email at which you want to send the mail"));
            }
        } else {
            return (array(
                "message" => "Please Provide template name which you want to use"));
        }
        
        $replaceExtraPlaceHolder = CustomTemplateMail::getPalceHolderArray();
        
        foreach ($replaceExtraPlaceHolder as $key => $value) {
            $template[1] = str_replace($key, $value, $template[1]);
        }
        
        return (array('subject' => $template[0], 
            'body' => trim(html_entity_decode($template[1]))));
    }

    /**
     * used to get the available placeholders for template
     *
     * @return array of placeholders with default value seted to NULL
     */
    public static function getPalceHolderArray()
    {
        return array('#userName#' => "", '#email#' => "", '#password#' => "", 
            '#url#' => "");
    }
}