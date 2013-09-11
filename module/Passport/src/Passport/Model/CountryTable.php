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

class CountryTable {
	protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	public function fetchAllCountry(){
		return $this->tableGateway->select ();
	}
}