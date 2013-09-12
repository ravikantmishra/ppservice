<?php 
/*
* Organization: OSSCube
* Added: Sanchit Puri
* Scope: Class use for  fetch data from database
* Dated: 10-09-2013
*/


namespace Manager\Model;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Config\Config;
use Zend\Db\Sql\Select;
use Manager\Model\Entity\TemplateEntity;

class TemplateTable extends AbstractTableGateway
{
	
	
    protected $table ='template';
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
//         $this->resultSetPrototype = new ResultSet();
//         $this->resultSetPrototype->setArrayObjectPrototype(new Manager());
//         $this->initialize();
    }

    public function getAllTemplates($id = 0)
    {
    	if($id !=0)
    	{
    		return($this->select(array('id' => $id))->toArray());
    	}
    	else 
    	{
    	$resultSet = $this->select();
    	return $resultSet->toArray();
    	}
    }
    
    public function updateTemplate(TemplateEntity $template)
    {
    	$data = array(
    			'template_name'  => $template->template_name,
    			'template_subject'  => $template->template_subject,
    			'template_data'  => htmlentities($template->template_data),
    	);
    	return $this->update($data,array('id' => $template->id));
    }

    public function saveTemplate(TemplateEntity $template)
    {
    	$data = array(
    			'template_name'  => $template->template_name,
    			'template_subject'  => $template->template_subject,
    			'template_data'  => htmlentities($template->template_data),
    			'created_on' => date('Y-n-d H:i:s'),
    	);
    	$templateExist = $this->isTemplateExist($template->template_name);
    	if($templateExist == "true")
    	{
    		return false;
    	}
    	else 
    	{
    	return $this->insert($data);
    	}
    }
    
    public function isTemplateExist($templateName = "")
    {
    	if(isset($templateName) && !empty($templateName))
    	{
    		$result = $this->select(array('template_name' =>$templateName))->toArray();
    		if(!empty($result))
    		{
    			return "true";
    		}
    		else 
    		{
    			return "false";
    		}
    		
    	}
    }
    
    
    
    public function getTemplateByName($templateName ="")
    {
    	$result = $this->select(array('template_name' => $templateName))->toArray();
    	if(!empty($result))
    	{
    		return array($result[0]['template_subject'],$result[0]['template_data']);
    	}
    	else
    	{
    	 return false;
    	}
    }
    
}
