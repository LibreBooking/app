<?php
$LOCAL_PEAR = dirname(__FILE__) . '/../../../lib/pear/';
ini_set('include_path', ($LOCAL_PEAR  . PATH_SEPARATOR . ini_get('include_path') ));
require_once(ROOT_DIR . 'lib/pear/MDB2.php');

/**
* Pear::MDB2 implementation
*/
class Mdb2Connection implements IDbConnection
{
	private $_dbType = '';
	private $_dbUser = '';
	private $_dbPassword = '';
	private $_hostSpec = '';
	private $_dbName = '';
	
	private $_db = null;
	private $_connected = false;
	
	public function __construct($_dbType, $_dbUser, $_dbPassword, $_hostSpec, $_dbName) 
	{
		//echo "type: $_dbType user: $_dbUser password: $_dbPassword host: $_hostSpec dbname: $_dbName";
		$this->_dbType = $_dbType;
		$this->_dbUser = $_dbUser;
		$this->_dbPassword = $_dbPassword;
		$this->_hostSpec = $_hostSpec;
		$this->_dbName = $_dbName;
	}
	
	public function SetDb(&$db)
	{
		$this->_db =& $db;
	}
	
	public function Connect() 
	{
		if ($this->_connected && !is_null($this->_db)) 
		{
			return;
		}
		
		$dsn = array('phptype'  => $this->_dbType,
			    'username' => $this->_dbUser,
			    'password' => $this->_dbPassword,
			    'hostspec' => $this->_hostSpec,
			    'database' => $this->_dbName);

		$options = array(
		    'debug'       => 0,
		    'portability' => MDB2_PORTABILITY_ALL,
		    'persistent'  => true
		);
		
		$this->_db =& MDB2::connect($dsn, $options);
        
        if (MDB2::isError($this->_db)) 
        {			
        	// If there is an error, print to browser, print to logfile and kill app
            throw new Exception("Error connecting to database\nError: " . $this->_db->getMessage() . "\nDebug: " . $this->_db->getDebugInfo());
            // LOG
        }
        
        $this->_db->setFetchMode(MDB2_FETCHMODE_ASSOC);	// Set fetch mode to return associatve array
        
		$this->_connected = true;
	}
	
	public function Disconnect() 
	{
		$this->_db->disconnect();
		$this->_connected = false;
	}
	
	public function AddParameter($name, $value) 
	{
		$this->_params[$name] = $value;
	}
	
	public function Query(&$sqlCommand) 
	{
		return $this->_PrepareAndExecute($sqlCommand, MDB2_PREPARE_RESULT);
	}
	
	public function Execute(&$sqlCommand) 
	{
		$this->_PrepareAndExecute($sqlCommand, MDB2_PREPARE_MANIP);
	}
	
	public function GetLastInsertId()
	{
		$id = $this->_db->lastInsertID();
		$this->_isError($id);
		
		return $id;
	}
	
	public function _PrepareAndExecute(&$sqlCommand, $prepareType) 
	{
		$cmd = new Mdb2CommandAdapter($sqlCommand);
		$stmt =& $this->_db->prepare($cmd->GetQuery(), true, $prepareType);		
		$result =& $stmt->execute($cmd->GetValues());	
		$this->_isError($result);

		return new Mdb2Reader($result);
	}
	
	private function _isError($result) 
	{
		if (MDB2::isError($result)) 
		{
			throw new Exception('There was an error executing your query');
           	// LOG: . $result->getMessage()
		}
        return false;
	}
		
	public function GetDbType() 
	{ 
		return $this->_dbType; 
	}
	
	public function GetDbUser() 
	{ 
		return $this->_dbUser;
	}
	
	public function GetDbPassword() 
	{ 
		return $this->_dbPassword;
	}
	
	public function GetHostSpec() 
	{
		return $this->_hostSpec;
	}
	
	public function GetDbName() 
	{ 
		return $this->_dbName;
	}
}
?>