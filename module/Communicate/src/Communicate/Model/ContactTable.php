<?php
/**
 * Organization: OSSCube 
 * Added: Sanchit Puri 
 * Scope: Contact Table Model class interact with the database table contact 
 * Dated: 05-09-2013
 */
namespace Communicate\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Communicate\Model\Entity\Contact;

class ContactTable extends AbstractTableGateway
{
    protected $table = 'contact';

    /**
     * used to construct the object of the ContactTable class
     *
     * @param Adapter $adapter            
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Contact());
        $this->initialize();
    }

    /**
     * used to save the enquiry coming from contact us view form
     *
     * @param Contact $contact            
     * @return boolean number
     */
    public function saveContact(Contact $contact)
    {
        $data = array('name' => htmlentities($contact->name), 
            'email' => htmlentities($contact->email), 
            'mobile_number' => htmlentities($contact->phone), 
            'comment' => htmlentities($contact->enquiry));
        
        if (!$this->insert($data)) {
            return false;
        } else {
            return $this->getLastInsertValue();
        }
    }
}
