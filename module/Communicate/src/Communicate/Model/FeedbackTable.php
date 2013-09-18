<?php

/**
 * Organization: OSSCube 
 * Added: Sanchit Puri 
 * Scope: Feedback Table Model class interact with the database table feedback 
 * Dated: 05-09-2013
 */
namespace Communicate\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Communicate\Model\Entity\Feedback;

class FeedbackTable extends AbstractTableGateway
{
    protected $table = 'feedback';

    /**
     * used to construct the object of the FeedbackTable class
     *
     * @param Adapter $adapter            
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Feedback());
        $this->initialize();
    }

    /**
     * used to save the feedback coming from feedback view form
     *
     * @param Contact $contact            
     * @return boolean number
     */
    public function saveFeedback(Feedback $feedback)
    {
        $data = array('name' => htmlentities($feedback->name), 
            'email' => htmlentities($feedback->email), 
            'mobile_number' => htmlentities($feedback->phone), 
            'comment' => htmlentities($feedback->enquiry));
        
        if (!$this->insert($data)) {
            return false;
        } else {
            return $this->getLastInsertValue();
        }
    }
}
