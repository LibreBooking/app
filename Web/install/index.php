<?php
define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'lib/Config/namespace.php');

class Installer
{
	public function InstallFresh()
	{
		$config = Configuration::Instance();

		$hostname = $config->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_HOSTSPEC);
		$database_name = $config->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_NAME);
		$database_user = $config->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_USER);
		$database_password = $config->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_PASSWORD);

		
		$create_database = new MySqlScript(ROOT_DIR . 'database_schema/create-db.sql');
		$create_database->Replace('phpscheduleit2', $database_name);
		
		$create_user = new MySqlScript(ROOT_DIR . 'database_schema/create-user.sql');
		$create_user->Replace('phpscheduleit2', $database_name);
		$create_user->Replace('schedule_user', $database_user);
		$create_user->Replace('localhost', $hostname);
		$create_user->Replace('password', $database_password);

		$create_schema = new MySqlScript(ROOT_DIR . 'database_schema/schema-utf8.sql');
		$populate_data = new MySqlScript(ROOT_DIR . 'database_schema/data-utf8.sql');

		$this->ExecuteScript($hostname, $database_name, 'root', '', $create_database);
		$this->ExecuteScript($hostname, $database_name, 'root', '', $create_schema);
		$this->ExecuteScript($hostname, $database_name, 'root', '', $create_user);
		$this->ExecuteScript($hostname, $database_name, 'root', '', $populate_data);
	}

	public function ExecuteScript($hostname, $database_name, $db_user, $db_password, MySqlScript $script)
	{
		echo "<br/>Executing: {$script->Name()}<br/>";
		
		$sqlErrorCode = 0;
		
		$link = mysql_connect($hostname, $db_user, $db_password);
		if (!$link)
		{
			die ("MySQL Connection error");
		}

		mysql_select_db($database_name, $link) or die ("Wrong MySQL Database");

		$sqlArray = explode(';', $script->GetFullSql());
		foreach ($sqlArray as $stmt) {
			if (strlen($stmt) > 3 && substr(ltrim($stmt), 0, 2) != '/*') {
				$result = mysql_query($stmt);
				if (!$result) {
					$sqlErrorCode = mysql_errno();
					$sqlErrorText = mysql_error();
					$sqlStmt = $stmt;
					break;
				}
			}
		}
		if ($sqlErrorCode == 0) {
			echo "Script is executed successfully!";
		}
		else
		{
			echo "An error occured during installation!<br/>";
			echo "Error code: $sqlErrorCode<br/>";
			echo "Error text: $sqlErrorText<br/>";
			echo "Statement:<br/> $sqlStmt<br/>";
		}
	}
}

class MySqlScript
{
	/**
	 * @var string
	 */
	private $path;

	/**
	 * @var array|string[]
	 */
	private $tokens = array();
	
	public function __construct($path)
	{
		$this->path = $path;
	}

	/**
	 * @return string
	 */
	public function Name()
	{
		return $this->path;
	}

	public function Replace($search, $replace)
	{
		$this->tokens[$search] = $replace;
	}

	public function GetFullSql()
	{
		$f = fopen($this->path, "r+");
		$sql = fread($f, filesize($this->path));
		fclose($f);

		foreach ($this->tokens as $search => $replace)
		{
			$sql = str_replace($search, $replace, $sql);
		}

		return $sql;
	}
}

$installer = new Installer();
$installer->InstallFresh();

?>