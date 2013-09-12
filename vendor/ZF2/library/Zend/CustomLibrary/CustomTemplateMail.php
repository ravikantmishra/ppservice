<?php
namespace Zend\CustomLibrary;
use Manager\Model\TemplateTable;
use Zend\ServiceManager\ServiceManager;

class CustomTemplateMail
{
	public static function templateMail($templateName ="Sign Up", $sendTo ="user", $placeholderDetails = array('#userName#' => 'abcd', '#email#' => 'user@user.com'), $templateTableObj = "")
	{
		if(isset($templateName) && !empty($templateName))
		{
			if(isset($sendTo) && !empty($sendTo))
			{
// 				$sm = new \Zend\ServiceManager\ServiceManager();
				
// 				echo "<pre>";print_r($sm1); die("sm obj");
// 				$templateTableObj = new TemplateTable($sm->get ( 'Zend\Db\Adapter\Adapter' ));
// 				var_dump($templateTableObj); die("hel");
				$template =$templateTableObj->getTemplateByName($templateName);
				if($template)
				{
					foreach($placeholderDetails as $key => $value)
					{
						$template[1]  = str_replace($key, $value, $template[1]);
					}
				}
				else
				{
					return ("template name provided does not exist");
				}
			}
			else
			{
				return ( "Please provide email at which you want to send the mail");
			}
		}
		else
		{
			return ( "Please Provide template name which you want to use");
		}
		
		$replaceExtraPlaceHolder = CustomTemplateMail::getPalceHolderArray();
		
		foreach ($replaceExtraPlaceHolder as $key => $value)
		{
			$template[1] = str_replace($key, $value, $template[1]);
		}
		
		echo trim(html_entity_decode($template[1])); die;
	}
	
	public static function getPalceHolderArray()
	{
		return array( '#userName#' => "",
					  '#email#' => "",
					  '#password#' => "",
					  '#url#' => "",	
			);
	}
}