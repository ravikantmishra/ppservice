<?php
/*
 * Organization: OSSCube Added: Ramandeep Singh Scope: User table class (to
 * intract with database) Dated: 05-09-2013
 */
namespace User\Model;

use Zend\Db\TableGateway\TableGateway;
use User\Model\Entity\LoginEntity;
use Zend\Session\Container;
use User\Model\Entity\RegisterEntity;
use Zend\Db\Sql;
use Zend\Db\Sql\Where;

class UserTable
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
     * Function to insert value in user table requires an multidimentioanal
     * array
     *
     * @param unknown $data            
     * @return unknown
     */
    public function saveUser($data)
    {
        if ($this->tableGateway->insert($data)) {
            $lastId = $this->tableGateway->lastInsertValue;
            return $lastId;
        } else {
            return false;
        }
    }

    /**
     * Function to set the session require key regarding which the session has
     * to be created and value
     *
     * @param unknown $key            
     * @param unknown $value            
     */
    public function setUserSession($key, $value)
    {
        $userSession = new Container('user');
        $userSession[$key] = $value;
    }

    /**
     * Function to fetch recordes from user table require an array for where
     * condition
     *
     * @param unknown $where            
     * @return boolean array
     */
    public function getUser($where)
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

    /**
     * Function to update user require two multidimentional array first for
     * value to be updated second for where clause
     *
     * @param unknown $value            
     * @param unknown $where            
     */
    public function updateUser($value, $where)
    {
      $this->tableGateway->update($value, $where);
    }

    /**
     * Fucntion to valid the user at the time of login
     *
     * @param LoginEntity $login            
     * @return boolean
     */
    public function validateUser(LoginEntity $login)
    {
        $where = new Where();
        $where->equalTo('user_name', $login->user_name);
        $where->AND->equalTo('status', 'active');
        $where->OR->equalTo('email', $login->user_name);
        
        $row = $this->tableGateway->select($where)->current();
        
        if (!$row) {
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