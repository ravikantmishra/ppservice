<?php
/*
* Organization: OSSCube
* Added: Vinod K Maurya
* Scope: User table class (to intract with database)
* Dated: 05-09-2013
*/
namespace Manager\Model;

use Zend\Db\TableGateway\TableGateway;
use Manager\Model\Entity\AdminEntity;
use Zend\Session\Container;
use Zend\Db\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Update;

class AdminTable
{
	
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}

	public function saveUser(AdminEntity $userObj) {
		
		$data = array (
				'id'=> $userObj->id,
				'username' => $userObj->username,
				'password' => md5(utf8_encode($userObj->password)),
				'email' => $userObj->email,
				'firstname' => $userObj->firstname,
				'lastname' => $userObj->lastname,
				'status' => $userObj->status
		);
		
		$id = (int)$userObj->id;
		
		if ($id == 0) {
			$this->tableGateway->insert($data);
			
			
		} else {
			
			if ($this->getAdmin($id)) {
				
				$this->tableGateway->update($data, array('id' => $id));
			
			} else {
				throw new \Exception('Form id does not exist');
			}
		}

	}
	

	public function getAdmin($id)
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
			$select->columns(array('id', 'firstname', 'lastname','email','username','status',));
			$select->order(array('id asc'));
		});
		
			return $resultSet;
	}
	
	
	public function deleteAdmin($id)
	{
		$this->tableGateway->delete(array('id' => $id));
	}
	
	
	public function updateAdmin($column,$where)
	{
		
		$data= $this->tableGateway->update( $column , $where );
			
	}
	
}
	
	
