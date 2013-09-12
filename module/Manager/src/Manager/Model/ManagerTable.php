<?php 
/*
* Organization: OSSCube
* Added: Vinod K Maurya
* Scope: Class use for  fetch data from database
* Dated: 05-09-2013
*/


namespace Manager\Model;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Config\Config;

class ManagerTable extends AbstractTableGateway
{
	
	
    protected $table ='admin';
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Manager());
        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getManager($id)
    {
        $id  = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    
    
     public function saveManager(Manager $manager)
    {
        $data = array(
            'id' => $manager->id,
            'user_name'  => $manager->user_name,
            'password'  => $manager->password,
            
        );
        $id = (int)$manager->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getContact($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
    
}
