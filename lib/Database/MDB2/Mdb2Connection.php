<?php
$LOCAL_PEAR = dirname(__FILE__) . '/../../lib/pear/';
ini_set('include_path', ($LOCAL_PEAR  . PATH_SEPARATOR . ini_get('include_path') ));
require_once($LOCAL_PEAR . 'MDB2.php');
require_once('namespace.php');

/**
* Pear::MDB2 implementation
*/
class Mdb2Connection extends IDbConnection
{
	var $_dbType = '';
	var $_dbUser = '';
	var $_dbPassword = '';
	var $_hostSpec = '';
	var $_dbName = '';
	
	var $_db = null;
	var $_connected = false;
	
	function Mdb2Connection($_dbType, $_dbUser, $_dbPassword, $_hostSpec, $_dbName) {
		$this->_dbType = $_dbType;
		$this->_dbUser = $_dbUser;
		$this->_dbPassword = $_dbPassword;
		$this->_hostSpec = $_hostSpec;
		$this->_dbName = $_dbName;
	}
	
	function Connect() {
		if ($this->_connected) {
			return;
		}
		
		$dsn = "$this->_dbType://$this->_dbUser:$this->_dbPassword@$this->_hostSpec/{$this->_dbName}";

        $db = MDB2::connect($dsn, true);	// Make persistant connection to database
        
        if (MDB2::isError($db)) {			// If there is an error, print to browser, print to logfile and kill app
            die ('Error connecting to database: ' . $db->getMessage() );
        }
        
        $db->setFetchMode(DB_FETCHMODE_ASSOC);	// Set fetch mode to return associatve array
        
        $this->_db = $db;
		$this->_connected = true;
	}
	
	function Disconnect() {
		$this->_db->disconnect();
		$this->_connected = false;
	}
	
	function AddParameter($name, $value) {
		$this->_params[$name] = $value;
	}
	
	function &Query(&$sqlCommand) {
		return $this->_PrepareAndExecute($sqlCommand, MDB2_PREPARE_RESULT);
	}
	
	function Execute(&$sqlCommand) {
		$this->_PrepareAndExecute($sqlCommand, MDB2_PREPARE_MANIP);
	}
	
	function &_PrepareAndExecute(&$sqlCommand, $prepareType) {
		$cmd = new Mdb2CommandAdapter($sqlCommand);
		
		$stmt =& $this->_db->prepare($cmd->GetQuery(), true, $prepareType);
		$result =& $stmt->execute($cmd->GetValues());		
		$this->_isError($result);
		
		return new Mdb2Reader($result);
	}
	
	function _isError($result) {
		if (MDB2::isError($result)) {
            die('There was an error executing your query: ' . $result->getMessage());
		}
        return false;
	}
		
	function GetDbType() { 
		return $this->_dbType; 
	}
	
	function GetDbUser() { 
		return $this->_dbUser;
	}
	
	function GetDbPassword() { 
		return $this->_dbPassword;
	}
	
	function GetHostSpec() {
		return $this->_hostSpec;
	}
	
	function GetDbName() { 
		return $this->_dbName;
	}
}
?>