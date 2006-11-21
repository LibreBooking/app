<?php

class IDbConnection
{	
	/**
	* To be implemented by child
	*/
	function IDbConnection($_dbType, $_dbUser, $_dbPassword, $_hostSpec, $_dbName)) { }
	
	/**
	* To be implemented by child
	*/
	function Connect($safeMode = false) { }
	
	/**
	* To be implemented by child
	*/
	function Disconnect() { }
	
	/**
	* To be implemented by child
	* @param string $command command text to execute
	* @return none
	*/
	function SetCommand($command) { }
	
	/**
	* To be implemented by child
	* @param string $name name of the parameter from the command text
	* @param string $value value of the parameter
	* @return none
	*/
	function AddParameter($name, $value) { }

	/**
	* To be implemented by child
	* @param array $paramNames the names of the parameters
	* @param array $paramValues the corresponding values of the parameters
	* @return IReader
	*/
	function &Query() { } 
	
	/**
	* To be implemented by child
	* @param array $paramNames the names of the parameters
	* @param array $paramValues the corresponding values of the parameters
	*/
	function &Execute() { }
}

class IReader
{
	/**
	* To be implemented by child
	*/
	function Reader() { }
	
	/**
	* To be implemented by child
	* @return array
	*/
	function &GetRow() { }
	
	/**
	* To be implemented by child
	* @return int
	*/
	function NumRows() { }
}

/**
* Pear::DB implementation
*/
class PearDbConnection extends IDbConnection
{
	var $_dbType = '';
	var $_dbUser = '';
	var $_dbPassword = '';
	var $_hostSpec = '';
	var $_dbName = '';
	
	var $_db = null;
	var $_connected = false;
	var $_command = '';
	var $_params = array();
	
	function PearDbConnection($_dbType, $_dbUser, $_dbPassword, $_hostSpec, $_dbName) {
		$this->_dbType = $_dbType;
		$this->_dbUser = $_dbUser;
		$this->_dbPassword = $_dbPassword;
		$this->_hostSpec = $_hostSpec;
		$this->_dbName = $_dbName;
	}
	
	function Connect($safeMode = false) {
		if ($this->connected) {
			return;
		}
		
		if ($safeMode) {
			ini_set('include_path', ( dirname(__FILE__) . '/pear/' . PATH_SEPARATOR . ini_get('include_path') ));
			include_once('pear/DB.php');
		}
		else {
			include_once('DB.php');
		}
		
		$dsn = "$this->_dbType://$this->_dbUser:$this->_dbPassword@$this->_hostSpec/{$this->_dbName}";

        $db = DB::connect($dsn, true);	// Make persistant connection to database
        
        if (DB::isError($db)) {			// If there is an error, print to browser, print to logfile and kill app
            die ('Error connecting to database: ' . $db->getMessage() );
        }
        
		$this->_connected = true;
        $db->setFetchMode(DB_FETCHMODE_ASSOC);	// Set fetch mode to return associatve array
        
        $this->_db = $db;
	}
	
	function Disconnect() {
		$this->_db->disconnect();
	}
	
	function SetCommand($command) {
		$this->_command = preg_replace("/\@[\w\d]+/", '?', $command);
	}
	
	function AddParameter($name, $value) {
		$this->_params[$name] = $value;
	}
	
	function &Query() {
		$result = $this->_db->query($this->_command, $paramValues);		
		$this->_checkForError($result);		
		return new PearReader($result);
	}
	
	function &Execute() {
		$result = $this->_db->execute($this->_command, $paramValues);		
		$this->_checkForError($result);		
		return true;
	}
	
	function _checkForError($result) {
		if (DB::isError($result)) {
            die('There was an error executing your query: ' . $result->getMessage());
		}
        return false;
	}
}

class PearReader extends IReader
{
	var $_result = null;
	
	/**
	* Takes a PEAR::DB DB_result object to abstract its methods
	* @param DB_result $DB_result
	*/
	function PearReader(&$DB_result) {
		$this->_result = $DB_result;
	}
	
	function &GetRow() {
		return $this->_result->fetchRow();
	}
	
	function NumRows() {
		return $this->_result->numRows();
	}
}
?>