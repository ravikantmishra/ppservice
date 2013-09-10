<?php
/*
* Organization: OSSCube
* Added: Vinod K Maurya
* Scope: Feedback table class (to intract with database)
* Dated: 09-09-2013
*/
namespace Manager\Model;
use Zend\Db\TableGateway\TableGateway;
use Manager\Model\Entity\FeedbackEntity;
use Zend\Session\Container;
use Zend\Db\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Update;

class FeedbackTable
{
	
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}

	public function saveUser(FeedbackEntity $feedbackObj) {
		
		$data = array (
				'id'=> $contactObj->id,
				'name' => $contactObj->name,
				'mobile_number' =>$contactObj->mobile_number,
				'comment' => $contactObj->comment,
				'seen' => $contactObj->seen
				
		);
		
		$id = (int)$contactObj->id;
		
		if ($id == 0) {
			$this->tableGateway->insert($data);
			
			
		} else {
			
			if ($this->getFeedback($id)) {
				
				$this->tableGateway->update($data, array('id' => $id));
			
			} else {
				throw new \Exception('Form id does not exist');
			}
		}

	}
	

	public function getFeedback($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}
	

	
	public function fetchAll($query = 0)
	{
		
		$resultSet = $this->tableGateway->select(function (Select $select){
			$select->columns(array('id', 'name', 'email','mobile_number','comment','seen',));
			$select->order(array('id asc'));
		});
		
	    return $resultSet;
	}
	
	
	public function deleteFeedback($id)
	{
		$this->tableGateway->delete(array('id' => $id));
	}
	
	
	public function updateFeedback($column,$where)
	{
		
		$data= $this->tableGateway->update( $column , $where );
			
	}
	
}
	
	
