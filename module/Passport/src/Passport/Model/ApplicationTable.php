<?php
/*
 * Organization: OSSCube
* Added: Ramandeep Singh
* Scope: User table class (to intract with database)
* Dated: 05-09-2013
*/
namespace Passport\Model;


use Zend\Db\TableGateway\TableGateway;
use Zend\Session\Container;
use Zend\Db\Sql;
use Zend\Db\Sql\Where;

class ApplicationTable {
	protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	public function saveApplication($data){

		$data['date_of_birth']="01-01-1989";
		$aa = $this->tableGateway->insert ( $data );
		$lastId =  $this->tableGateway->lastInsertValue;
		return $lastId;
	}
}