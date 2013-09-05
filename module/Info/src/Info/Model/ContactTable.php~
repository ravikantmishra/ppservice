<?php 

namespace Contact\Model;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class ContactTable extends AbstractTableGateway
{
    protected $table ='contact';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Contact());
        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getContact($id)
    {
        $id  = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    
    
     public function saveContact(Contact $contact)
    {
        $data = array(
            'id' => $contact->id,
            'name'  => $contact->name,
            'description'  => $contact->description,
            'status'  => $contact->status,
        );
        $id = (int)$contact->id;
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
    
    
    
     public function deleteContact($id)
    {
        $this->delete(array('id' => $id));
    }
    

    

}
