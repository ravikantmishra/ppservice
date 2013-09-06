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

	public function saveUser(RegisterEntity $userObj) {
		$data = array (
				'user_name' => $userObj->user_name,
				'password' => md5(utf8_encode($userObj->password)),
				'email' => $userObj->email,
				'first_name' => $userObj->first_name,
				'last_name' => $userObj->last_name
		);
		
		$this->tableGateway->insert ( $data );
		$lastId =  $this->tableGateway->lastInsertValue;
		 
		$user_session = new Container('user');
		$user_session->frontidsession = $lastId;		
	}
	
	public function getRegisterUserName($formValue) {
		$row = $this->tableGateway->select ( array (
				'user_name' => $formValue 
		) )->current ();
		if (! $row) {
			return false;
		} else {
			return true;
		}
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

				$user_session = new Container('user');
				$user_session->frontidsession = $row->id;
			
				return true;
			} else {
				return false;
			}
		}
	}
	
}