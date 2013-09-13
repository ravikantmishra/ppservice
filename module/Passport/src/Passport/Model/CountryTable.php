<?php
/*
 * Organization: OSSCube Added: Ramandeep Singh Scope: User table class (to
 * intract with database) Dated: 05-09-2013
 */
namespace Passport\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Session\Container;
use Zend\Db\Sql;
use Zend\Db\Sql\Where;

class CountryTable
{
    protected $tableGateway;

    /**
     *
     * @param TableGateway $tableGateway            
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     *
     * @param string $where
     *            array for where condition
     */
    public function fetchCountry($where = null)
    {
        if (isset($where)) {
            if ($this->tableGateway->select($where)) {
                return $this->tableGateway->select($where);
            } else {
                return false;
            }
        } else {
            if ($this->tableGateway->select()) {
                return $this->tableGateway->select();
            } else {
                return false;
            }
        }
    }
}
