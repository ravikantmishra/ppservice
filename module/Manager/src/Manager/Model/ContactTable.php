<?php
/*
* Organization: OSSCube
* Added: Vinod K Maurya
* Scope: Contact table class (to intract with database)
* Dated: 09-09-2013
*/
namespace Manager\Model;
use Zend\Db\TableGateway\TableGateway;
use Manager\Model\Entity\ContactEntity;
use Zend\Session\Container;
use Zend\Db\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Update;

class ContactTable
{
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}

	public function saveUser(ContactEntity $contactObj) {
		

		
		
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
			
			if ($this->getConatct($id)) {
				
				$this->tableGateway->update($data, array('id' => $id));
			
			} else {
				throw new \Exception('Form id does not exist');
			}
		}

	}
	

	public function getContact($id)
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
	
	
	public function deleteContact($id)
	{
		$this->tableGateway->delete(array('id' => $id));
	}
	
	
	public function updateContact($column,$where)
	{
		
		$data= $this->tableGateway->update( $column , $where );
			
	}
	
}
	
	
