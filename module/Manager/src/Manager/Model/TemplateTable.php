<?php

/**
 * Organization: OSSCube 
 * Added: Sanchit Puri 
 * Scope: Class used to interact with database table template 
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
    protected $table = 'template';

    /**
     * used to construct the object of TemplateTable Model class
     *
     * @param Adapter $adapter            
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        // $this->resultSetPrototype = new ResultSet();
        // $this->resultSetPrototype->setArrayObjectPrototype(new Manager());
        // $this->initialize();
    }

    /**
     * used to get the selected template on he basis of valida tempalte id else
     * returns all templates available
     *
     * @param number $id            
     * @return an emty array or all templates sstored in database in an array
     */
    public function getAllTemplates($id = 0)
    {
        // checks if id != 0 means a valid tempalte id is provided
        if ($id != 0) {
            return ($this->select(array('id' => $id))->toArray());
        } else {
            $resultSet = $this->select();
            return $resultSet->toArray();
        }
    }

    /**
     * used to update the existing tempalte in database on the basis of valid
     * tempalte id
     *
     * @param TemplateEntity $template            
     */
    public function updateTemplate(TemplateEntity $template)
    {
        $data = array('template_name' => $template->template_name, 
            'template_subject' => $template->template_subject, 
            'template_data' => htmlentities($template->template_data));
        return $this->update($data, array('id' => $template->id));
    }

    /**
     * used to save a new template entry into the database return 1 on succsfull
     * insertion an false if template with same name already exist
     *
     * @param TemplateEntity $template            
     * @return boolean Ambigous \Zend\Db\TableGateway\mixed>
     */
    public function saveTemplate(TemplateEntity $template)
    {
        $data = array('template_name' => $template->template_name, 
            'template_subject' => $template->template_subject, 
            'template_data' => htmlentities($template->template_data), 
            'created_on' => date('Y-n-d H:i:s'));
        $templateExist = $this->isTemplateExist($template->template_name);
        if ($templateExist == "true") {
            return false;
        } else {
            return $this->insert($data);
        }
    }

    /**
     * used to check that if any template with the same name exist or not
     *
     * @param string $templateName            
     * @return string ("true" or "false")
     */
    public function isTemplateExist($templateName = "")
    {
        if (isset($templateName) && !empty($templateName)) {
            $result = $this->select(array('template_name' => $templateName))->toArray();
            if (!empty($result)) {
                return "true";
            } else {
                return "false";
            }
        }
    }

    /**
     * used to get the template subject and template data (body) of a selected
     * template in case of sending mail to user
     *
     * @param string $templateName            
     * @return array if exist otherwise false
     */
    public function getTemplateByName($templateName = "")
    {
        $result = $this->select(array('template_name' => $templateName))->toArray();
        if (!empty($result)) {
            return array($result[0]['template_subject'], 
                $result[0]['template_data']);
        } else {
            return false;
        }
    }
}
