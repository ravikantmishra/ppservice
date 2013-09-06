<?php
/*
 * Organization: OSSCube
* Added: Ramandeep Singh
* Scope: User table class (to intract with database)
* Dated: 05-09-2013
*/
namespace User\Model;


use Zend\Db\TableGateway\TableGateway;
use User\Model\Entity\LoginEntity;
use Zend\Session\Container;
use User\Model\Entity\RegisterEntity;
use Zend\Db\Sql;
use Zend\Db\Sql\Where;

class UserTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}

	public function saveUser($data) {	
		$this->tableGateway->insert ( $data );
		$lastId =  $this->tableGateway->lastInsertValue;
		 
		return $lastId;		
	}
	
	public function setUserSession($key,$value) {
		$userSession = new Container('user');
		$userSession[$key] = $value;
	}
	
	public function getUser($where) {
		$row = $this->tableGateway->select ( $where )->current();
		if (! $row) {
			return false;
		} else {
			return $row;
		}
	}
	
	public function updateUser($value,$where) {
		
		$this->tableGateway->update( $value, $where );
	}

	public function validateUser(LoginEntity $login) {
		
		$where = new Where();
		$where->equalTo( 'user_name', $login->user_name );
		$where->OR->equalTo( 'email', $login->user_name );
		
		$row = $this->tableGateway->select ($where)->current ();

		if (! $row) {
			return false;
		} else {
			if (md5(utf8_encode($login->password)) == $row->password) {

				$userSession = new Container('user');
				$userSession->frontidsession = $row->id;
			
				return true;
			} else {
				return false;
			}
		}
	}
	
}