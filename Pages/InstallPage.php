<?php
require_once(ROOT_DIR . 'Pages/Page.php');

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

		$this->ExecuteScript($hostname, 'mysql', 'root', '', $create_database);
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

interface IInstallPage
{
	public function SetInstallPasswordMissing($isMissing);

	public function GetInstallPassword();

	public function SetShowPasswordPrompt($bool1);

	public function SetShowInvalidPassword($bool1);

	public function SetShowDatabasePrompt($bool1);
}

class InstallPage extends Page implements IInstallPage
{
	/**
	 * @var \InstallPresenter
	 */
	private $presenter;

	public function __construct()
	{
		parent::__construct('Install', 1);

		$this->presenter = new InstallPresenter($this);
	}
	
	public function PageLoad()
	{
		$this->presenter->PageLoad();
		
		$this->Display('install.tpl');
		//$installer = new Installer();
		//$installer->InstallFresh();
	}

	public function SetInstallPasswordMissing($isMissing)
	{
		$this->Set('InstallPasswordMissing', $isMissing);
	}

	public function GetInstallPassword()
	{
		return $this->GetForm(FormKeys::INSTALL_PASSWORD);
	}

	public function SetShowPasswordPrompt($showPrompt)
	{
		$this->Set('ShowPasswordPrompt', $showPrompt);
	}

	public function SetShowInvalidPassword($showInvalidPassword)
	{
		$this->Set('ShowInvalidPassword', $showInvalidPassword);
	}

	public function SetShowDatabasePrompt($showDatabasePrompt)
	{
		$this->Set('ShowDatabasePrompt', $showDatabasePrompt);
	}
}

class InstallPresenter
{
	/**
	 * @var \IInstallPage
	 */
	private $page;

	const VALIDATED_INSTALL = 'validated_install';
	
	public function __construct(IInstallPage $page)
	{
		//ServiceLocator::GetServer()->SetSession(SessionKeys::INSTALLATION, null);
		$this->page = $page;
	}

	public function PageLoad()
	{
		$this->CheckForInstallPasswordInConfig();
		$this->CheckForInstallPasswordProvided();
		$this->CheckForAuthentication();
	}

	public function CheckForInstallPasswordInConfig()
	{
		$installPassword = Configuration::Instance()->GetKey(ConfigKeys::INSTALLATION_PASSWORD);

		if (empty($installPassword)) {
			$this->page->SetInstallPasswordMissing(true);
			return;
		}

		$this->page->SetInstallPasswordMissing(false);
	}

	private function CheckForInstallPasswordProvided()
	{
		if ($this->IsAuthenticated())
		{
			return;
		}

		$installPassword = $this->page->GetInstallPassword();

		if (empty($installPassword))
		{
			$this->page->SetShowPasswordPrompt(true);
			return;
		}

		$validated = $this->Validate($installPassword);
		if (!$validated)
		{
			$this->page->SetShowPasswordPrompt(true);
			$this->page->SetShowInvalidPassword(true);
			return;
		}
		
		$this->page->SetShowPasswordPrompt(false);
		$this->page->SetShowInvalidPassword(false);
	}

	private function CheckForAuthentication()
	{
		if ($this->IsAuthenticated())
		{
			$this->page->SetShowDatabasePrompt(true);
			return;
		}

		$this->page->SetShowDatabasePrompt(false);
	}

	private function IsAuthenticated()
	{
		return ServiceLocator::GetServer()->GetSession(SessionKeys::INSTALLATION) == self::VALIDATED_INSTALL;
	}

	private function Validate($installPassword)
	{
		$validated = $installPassword == Configuration::Instance()->GetKey(ConfigKeys::INSTALLATION_PASSWORD);

		if ($validated)
		{
			ServiceLocator::GetServer()->SetSession(SessionKeys::INSTALLATION, self::VALIDATED_INSTALL);
		}
		else
		{
			ServiceLocator::GetServer()->SetSession(SessionKeys::INSTALLATION, null);
		}

		return $validated;
	}
}

?>