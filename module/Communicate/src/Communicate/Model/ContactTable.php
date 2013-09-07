<?php 
/*
 * Organization: OSSCube
* Added: Sanchit Puri
* Scope: Contact Table class interact with the database table contact
* Dated: 05-09-2013
*/

namespace Communicate\Model;
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
	
    // used to insert the data coming from contactus form into the database table contact
    public function saveContact(Contact $contact)
    {
        $data = array(
            'name'  => htmlentities($contact->name),
            'email'  => htmlentities($contact->email),
            'mobile_number'  => htmlentities($contact->phone),
        	'comment'  => htmlentities($contact->enquiry),
        );
        
        if (!$this->insert($data))
        	return false;
        return $this->getLastInsertValue();
    }
}
