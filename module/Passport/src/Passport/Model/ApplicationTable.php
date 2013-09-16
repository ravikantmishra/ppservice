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

class ApplicationTable
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
     * @param $data array
     *            consist value to be store in database
     * @return last id being inserted
     */
    public function saveApplication($data)
    {
        if ($this->tableGateway->insert($data)) {
            $lastId = $this->tableGateway->lastInsertValue;
            return $lastId;
        } else {
            return false;
        }
    }

    /**
     *
     * @param string $where
     *            array for where condition
     */
    public function fetchApplication($where = null)
    {
        $row = $this->tableGateway->select($where);
        if (!$row) {
            return false;
        } else {
            foreach ($row as $key => $val) {
                $result[$key] = (array) $val;
            }
            return $result;
        }
    }
}