<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/


class MySqlConnection implements IDbConnection
{
	private $_dbUser = '';
	private $_dbPassword = '';
	private $_hostSpec = '';
	private $_dbName = '';
	
	private $_db = null;
	private $_connected = false;
	
	public function __construct($_dbUser, $_dbPassword, $_hostSpec, $_dbName) 
	{
		//echo "type: $_dbType user: $_dbUser password: $_dbPassword host: $_hostSpec dbname: $_dbName";
		$this->_dbUser = $_dbUser;
		$this->_dbPassword = $_dbPassword;
		$this->_hostSpec = $_hostSpec;
		$this->_dbName = $_dbName;
	}
	
	public function Connect() 
	{
		if ($this->_connected && !is_null($this->_db)) 
		{
			return;
		}
		
		$this->_db = mysql_connect($this->_hostSpec, $this->_dbUser, $this->_dbPassword );
		mysql_select_db($this->_dbName, $this->_db);
		
		if (!$this->_db) 
		{
			throw new Exception("Error connecting to database\nError: " . mysql_error());
			Log::Error("Error connecting to database\n%s",  mysql_error());
		}
        
		$this->_connected = true;
	}
	
	public function Disconnect() 
	{
		mysql_close($this->_db); 
		$this->_db = null;		
		$this->_connected = false;
	}
	
	public function Query(ISqlCommand $sqlCommand) 
	{
		$mysqlCommand = new MySqlCommandAdapter($sqlCommand);

		Log::Sql('MySql Query: ' . str_replace('%', '%%', $mysqlCommand->GetQuery()));

		$result = mysql_query($mysqlCommand->GetQuery());
		
		$this->_handleError($result);
		
		return new MySqlReader($result);
	}

	public function LimitQuery(ISqlCommand $command, $limit, $offset = 0)
	{
		return $this->Query(new MySqlLimitCommand($command, $limit, $offset));
	}
	
	public function Execute(ISqlCommand $sqlCommand) 
	{
		$mysqlCommand = new MySqlCommandAdapter($sqlCommand);

		Log::Sql('MySql Execute: ' . str_replace('%', '%%', $mysqlCommand->GetQuery()));

		$result = mysql_query($mysqlCommand->GetQuery());
		
		$this->_handleError($result);
	}
	
	public function GetLastInsertId()
	{
		return mysql_insert_id($this->_db);
	}
	
	private function _handleError($result, $sqlCommand = null) 
	{
		if (!$result) 
		{
			if ($sqlCommand != null)
			{
				echo $sqlCommand->GetQuery();
			}
			throw new Exception('There was an error executing your query\n' .  mysql_error());
		
           	Log::Error("Error executing MySQL query %s",  mysql_error());
		}
        return false;
	}
}

class MySqlLimitCommand extends SqlCommand
{
	/**
	 * @var \ISqlCommand
	 */
	private $baseCommand;

	private $limit;
	private $offset;

	public function __construct(ISqlCommand $baseCommand, $limit, $offset)
	{
		parent::__construct();
		
		$this->baseCommand = $baseCommand;
		$this->limit = $limit;
		$this->offset = $offset;

		$this->Parameters = $baseCommand->Parameters;
	}
	
	public function GetQuery()
	{
		return $this->baseCommand->GetQuery() . sprintf(" LIMIT %s OFFSET %s",  $this->limit, $this->offset);
	}

}
?>
