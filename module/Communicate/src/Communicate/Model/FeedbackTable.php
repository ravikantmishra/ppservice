<?php 
/*
 * Organization: OSSCube
* Added: Sanchit Puri
* Scope: Feedback Table class interact with the database table feedback
* Dated: 05-09-2013
*/

namespace Communicate\Model;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class FeedbackTable extends AbstractTableGateway
{
    protected $table ='feedback';

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

    // used to insert the data coming from feedback form into the database table feedback
    public function saveFeedback(Feedback $feedback)
    {
        $data = array(
            'name'  => htmlentities($feedback->name),
            'email'  => htmlentities($feedback->email),
            'mobile_number'  => htmlentities($feedback->phone),
        	'comment'  => htmlentities($feedback->enquiry),
        );
        
        if (!$this->insert($data))
        	return false;
        return $this->getLastInsertValue();
    }
}
