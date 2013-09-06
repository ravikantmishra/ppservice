<?php 

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
