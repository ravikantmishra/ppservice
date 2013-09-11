<?php
/*
* Organization: OSSCube
* Added: Vinod K Maurya
* Scope: User table class (to intract with database)
* Dated: 09-09-2013
*/
namespace Manager\Model;
use Zend\Db\TableGateway\TableGateway;
use Manager\Model\Entity\RegisterEntity;
use Zend\Session\Container;
use Zend\Db\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Update;

class RegisterTable
{
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}

	
	public function saveUser(RegisterEntity $userObj) {


		$data = array (
				'id'=> $userObj->id,
				'user_name' => $userObj->user_name,
				'email' =>$userObj->email,
				'first_name' => $userObj->first_name,
				'last_name ' => $userObj->last_name,
				'status ' => $userObj->status

		);

		$id = (int)$userObj->id;

		if ($id == 0) {
			$this->tableGateway->insert($data);
					
		} else {
				
			if ($this->get($id)) {

				$this->tableGateway->update($data, array('id' => $id));
					
			} else {
				throw new \Exception('Form id does not exist');
			}
		}

	}


	public function getRegister($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();

		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}


	public function fetchAll(Select $select = null) {
	
		if (null === $select)
			$select = new Select();
		$data=$select->from($this->tableGateway->table);
		$resultSet = $this->tableGateway->selectWith($select);
		$resultSet->buffer();
		return $resultSet;
	}
	

	public function deleteRegister($id)
	{
		$this->tableGateway->delete(array('id' => $id));
	}


	public function updateRegister($column,$where)
	{

		$data= $this->tableGateway->update( $column , $where );
			
	}

}


