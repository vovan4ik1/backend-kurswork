<?php
/**

* @access public
*/


include_once('connect.php');

class MySQL {
    /**
    * @access private
    * @var string
    */
    private $host;

    /**
    * @access private
    * @var string
    */
    private $dbUser;

    /**
    * @access private
    * @var string
    */
    private $dbPass;

    /**
    * @access private
    * @var string
    */
    private $dbName;

    /**
    * @access private
    * @var resource
    */
    private $dbConn;

    /**
    * @access private
    * @var string
    */
    private $connectError;

    /**
    * @param string
    * @param string
    * @param string
    * @param string
    * @access public
    */
    public function __construct($host, $dbUser, $dbPass, $dbName) {
        $this->host = $host;
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
        $this->dbName = $dbName;
        $this->connectToDb();
    }

    /**
    * @return void
    * @access private
    */
    private function connectToDb() {
        
        $this->dbConn = mysqli_connect($this->host, $this->dbUser, $this->dbPass, $this->dbName);

        if (!$this->dbConn) {
            trigger_error('Could not connect to server: ' . mysqli_connect_error(), E_USER_ERROR);
            $this->connectError = true;
        }
    }

    /**
    * @return boolean
    * @access public
    */
    public function isError() {
        if ($this->connectError) {
            return true;
        }

        $error = mysqli_error($this->dbConn);
        return !empty($error);
    }

    /**

    * @param string
    * @return MySQLResult
    * @access public
    */
    public function query($sql) {
        $queryResource = mysqli_query($this->dbConn, $sql);
        if (!$queryResource) {
            trigger_error('Query failed: ' . mysqli_error($this->dbConn) . ' SQL: ' . $sql, E_USER_ERROR);
        }
        return new MySQLResult($this, $queryResource);
    }
}

/**
* @access public
*/
class MySQLResult {
    /**
    * @access private
    * @var MySQL
    */
    private $mysql;

    /**
    * @access private
    * @var resource
    */
    private $query;

    /**
    * @param MySQL 
    * @param resource
    * @access public
    */
    public function __construct($mysql, $query) {
        $this->mysql = $mysql;
        $this->query = $query;
    }

    /**
    * @return array
    * @access public
    */
    public function fetch() {
        if ($row = mysqli_fetch_array($this->query, MYSQLI_ASSOC)) {
            return $row;
        } else if ($this->size() > 0) {
            mysqli_data_seek($this->query, 0);
            return false;
        } else {
            return false;
        }
    }

    /**
    * @param int $i
    * @return boolean
    * @access public
    */
    public function seek($i) {
        return mysqli_data_seek($this->query, $i);
    }

    /**
    * @return int
    * @access public
    */
    public function size() {
        return mysqli_num_rows($this->query);
    }

    /**
    * @return int
    * @access public
    */
    public function insertID() {
        return mysqli_insert_id($this->mysql->dbConn);
    }

    /**
    * @return boolean
    * @access public
    */
    public function isError() {
        return $this->mysql->isError();
    }
}


$db = new MySQL($host, $user, $pass, $name);

?>
