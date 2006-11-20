<?php

class IDbConnection
{
	var $dbType = '';
	var $dbUser = '';
	var $dbPassword = '';
	var $hostSpec = '';
	var $dbNames = array();
	
	var $_db = null;
	var $_connected = false;
	var $_command = '';
	var $_params = array();
	
	/**
	* To be implemented by child
	* @param string
	* @param string 
	* @param string 
	* @param string 
	* @param array
	*/
	function IDbConnection($dbType, $dbUser, $dbPassword, $hostSpec, $dbNames = array()) { }
	
	/**
	* To be implemented by child
	*/
	function connect($safeMode = false) { }
	
	/**
	* To be implemented by child
	*/
	function disconnect() { }
	
	/**
	* To be implemented by child
	* @param string $command command text to execute
	* @return none
	*/
	function setCommand($command) { }
	
	/**
	* To be implemented by child
	* @param string $name name of the parameter from the command text
	* @param string $value value of the parameter
	* @return none
	*/
	function addParameter($name, $value) { }

	/**
	* To be implemented by child
	* @param array $paramNames the names of the parameters
	* @param array $paramValues the corresponding values of the parameters
	* @return IReader
	*/
	function &query() { } 
	
	/**
	* To be implemented by child
	* @param array $paramNames the names of the parameters
	* @param array $paramValues the corresponding values of the parameters
	*/
	function &execute() { }
}

class IReader
{
	var $result = null;
	
	/**
	* To be implemented by child
	*/
	function Reader() { }
	
	/**
	* To be implemented by child
	* @return array
	*/
	function &getRow() { }
	
	/**
	* To be implemented by child
	* @return int
	*/
	function numRows() { }
}

/**
* Abstract PEAR::DB details
*/
class PearDbConnection extends IDbConnection
{
	var $dbType = '';
	var $dbUser = '';
	var $dbPassword = '';
	var $hostSpec = '';
	var $dbNames = array();
	
	var $_db = null;
	var $_connected = false;
	var $_command = '';
	var $_params = array();
	
	function PearDbConnection($dbType, $dbUser, $dbPassword, $hostSpec, $dbNames = array()) {
		$this->dbType = $dbType;
		$this->dbUser = $dbUser;
		$this->dbPassword = $dbPassword;
		$this->hostSpec = $hostSpec;
		$this->dbNames = $dbNames;
	}
	
	function connect($safeMode = false) {
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
		
		$dsn = "$this->dbType://$this->dbUser:$this->dbPassword@$this->hostSpec/{$this->dbNames[0]}";

        $db = DB::connect($dsn, true);	// Make persistant connection to database
        
        if (DB::isError($db)) {			// If there is an error, print to browser, print to logfile and kill app
            die ('Error connecting to database: ' . $db->getMessage() );
        }
        
		$this->_connected = true;
        $db->setFetchMode(DB_FETCHMODE_ASSOC);	// Set fetch mode to return associatve array
        
        $this->_db = $db;
	}
	
	function disconnect() {
		$this->_db->disconnect();
	}
	
	function setCommand($command) {
		$this->_command = preg_replace("/\@[\w\d]+/", '?', $command);
	}
	
	function addParameter($name, $value) {
		$this->_params[$name] = $value;
	}
	
	function &query() {
		$result = $this->_db->query($this->_command, $paramValues);		
		$this->_checkForError($result);		
		return new PearReader($result);
	}
	
	function &execute() {
		$result = $this->_db->execute($this->_command, $paramValues);		
		$this->_checkForError($result);		
		return true;
	}
	
	function _checkForError($result) {
	  if (DB::isError($result))
            CmnFns::do_error_box(translate('There was an error executing your query') . '<br />'
                . $result->getMessage()
                . '<br />' . '<a href="javascript: history.back();">' . translate('Back') . '</a>');
        return false;
	}
}

class PearReader extends IReader
{
	/**
	* Takes a PEAR::DB DB_result object to abstract its methods
	* @param DB_result $DB_result
	*/
	function PearReader(&$DB_result) {
		$this->result = $DB_result;
	}
	
	function &getRow() {
		return $this->result->fetchRow();
	}
	
	function numRows() {
		return $this->result->numRows();
	}
}
?>