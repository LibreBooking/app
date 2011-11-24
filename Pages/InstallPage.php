<?php

/**
 * This file contains 5 classes and 1 interface:
 *  InstallationResult, Installer, MySqlScript InstallPage, InstallPresenter, and IIinstallPage respectively.
 */
require_once(ROOT_DIR . 'Pages/Page.php');

class InstallationResult {

    public $connectionError = false;
    public $authError = false;
    public $taskName;
    public $sqlErrorCode;
    public $sqlErrorText;
    public $sqlText;

    public function __construct($taskName) {
        $this->taskName = $taskName;
    }

    public function SetConnectionError() {
        $this->connectionError = true;
        $this->sqlErrorText = "Error connecting to mysql database.  Check your configured host and entered username and password.";
    }

    public function SetAuthenticationError() {
        $this->authError = true;
        $this->sqlErrorText = "Error selecting to mysql database.  Check entered username and password.";
    }

    public function SetResult($sqlErrorCode, $sqlErrorText, $sqlStmt) {
        $this->sqlErrorCode = $sqlErrorCode;
        $this->sqlErrorText = $sqlErrorText;
        $this->sqlText = $sqlStmt;
    }

    public function WasSuccessful() {
        return!$this->connectionError && !$this->authError && $this->sqlErrorCode == 0;
    }

}

class Installer {

    private $user;
    private $password;

    public function __construct($user, $password) {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * @param $should_create_db bool
     * @param $should_create_user bool
     * @return array|InstallationResult[]
     */
    public function InstallFresh($should_create_db, $should_create_user) {
        $results = array();

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

        if ($should_create_db) {
            $results[] = $this->ExecuteScript($hostname, 'mysql', $this->user, $this->password, $create_database);
        }

        $results[] = $this->ExecuteScript($hostname, $database_name, $this->user, $this->password, $create_schema);

        if ($should_create_user) {
            $results[] = $this->ExecuteScript($hostname, $database_name, $this->user, $this->password, $create_user);
        }

        $results[] = $this->ExecuteScript($hostname, $database_name, $this->user, $this->password, $populate_data);

        return $results;
    }

    public function ExecuteScript($hostname, $database_name, $db_user, $db_password, MySqlScript $script) {
        $result = new InstallationResult($script->Name());

        $sqlErrorCode = 0;
        $sqlErrorText = null;
        $sqlStmt = null;

        $link = mysql_connect($hostname, $db_user, $db_password);
        if (!$link) {
            $result->SetConnectionError();
            return $result;
        }

        $select_db_result = mysql_select_db($database_name, $link);
        if (!$select_db_result) {

            $result->SetAuthenticationError();
            return $result;
        }

        $sqlArray = explode(';', $script->GetFullSql());
        foreach ($sqlArray as $stmt) {
            if (strlen($stmt) > 3 && substr(ltrim($stmt), 0, 2) != '/*') {
                $queryResult = mysql_query($stmt);
                if (!$queryResult) {
                    $sqlErrorCode = mysql_errno();
                    $sqlErrorText = mysql_error();
                    $sqlStmt = $stmt;
                    break;
                }
            }
        }

        $result->SetResult($sqlErrorCode, $sqlErrorText, $sqlStmt);

        return $result;
    }

}

class MySqlScript {

    /**
     * @var string
     */
    private $path;

    /**
     * @var array|string[]
     */
    private $tokens = array();

    public function __construct($path) {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function Name() {
        return $this->path;
    }

    public function Replace($search, $replace) {
        $this->tokens[$search] = $replace;
    }

    public function GetFullSql() {
        $f = fopen($this->path, "r");
        $sql = fread($f, filesize($this->path));
        fclose($f);

        foreach ($this->tokens as $search => $replace) {
            $sql = str_replace($search, $replace, $sql);
        }

        return $sql;
    }

}

class InstallPresenter {

    /**
     * @var \IInstallPage
     */
    private $page;

    const VALIDATED_INSTALL = 'validated_install';

    public function __construct(IInstallPage $page) {
        //ServiceLocator::GetServer()->SetSession(SessionKeys::INSTALLATION, null);
        $this->page = $page;
    }

    public function PageLoad() {
        if ($this->page->RunningInstall()) {
            $this->RunInstall();
            return;
        }

        $dbname = Configuration::Instance()->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_NAME);
        $dbuser = Configuration::Instance()->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_USER);
        $dbhost = Configuration::Instance()->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_HOSTSPEC);
        $this->page->SetDatabaseConfig($dbname, $dbuser, $dbhost);

        $this->CheckForInstallPasswordInConfig();
        $this->CheckForInstallPasswordProvided();
        $this->CheckForAuthentication();
    }

    public function CheckForInstallPasswordInConfig() {
        $installPassword = Configuration::Instance()->GetKey(ConfigKeys::INSTALLATION_PASSWORD);

        if (empty($installPassword)) {
            $this->page->SetInstallPasswordMissing(true);
            return;
        }

        $this->page->SetInstallPasswordMissing(false);
    }

    private function CheckForInstallPasswordProvided() {
        if ($this->IsAuthenticated()) {
            return;
        }

        $installPassword = $this->page->GetInstallPassword();

        if (empty($installPassword)) {
            $this->page->SetShowPasswordPrompt(true);
            return;
        }

        $validated = $this->Validate($installPassword);
        if (!$validated) {
            $this->page->SetShowPasswordPrompt(true);
            $this->page->SetShowInvalidPassword(true);
            return;
        }

        $this->page->SetShowPasswordPrompt(false);
        $this->page->SetShowInvalidPassword(false);
    }

    private function CheckForAuthentication() {
        if ($this->IsAuthenticated()) {
            $this->page->SetShowDatabasePrompt(true);
            return;
        }

        $this->page->SetShowDatabasePrompt(false);
    }

    private function IsAuthenticated() {
        return ServiceLocator::GetServer()->GetSession(SessionKeys::INSTALLATION) == self::VALIDATED_INSTALL;
    }

    private function Validate($installPassword) {
        $validated = $installPassword == Configuration::Instance()->GetKey(ConfigKeys::INSTALLATION_PASSWORD);

        if ($validated) {
            ServiceLocator::GetServer()->SetSession(SessionKeys::INSTALLATION, self::VALIDATED_INSTALL);
        } else {
            ServiceLocator::GetServer()->SetSession(SessionKeys::INSTALLATION, null);
        }

        return $validated;
    }

    private function RunInstall() {
        $install = new Installer($this->page->GetInstallUser(), $this->page->GetInstallUserPassword());

        $results = $install->InstallFresh($this->page->GetShouldCreateDatabase(), $this->page->GetShouldCreateUser());

        $this->page->SetInstallResults($results);
    }

}

interface IInstallPage {

    /**
     * @abstract
     */
    public function SetInstallPasswordMissing($isMissing);

    /**
     * @abstract
     * @return string
     */
    public function GetInstallPassword();

    /**
     * @abstract
     */
    public function SetShowPasswordPrompt($showPasswordPrompt);

    /**
     * @abstract
     */
    public function SetShowInvalidPassword($showInvalidPassword);

    /**
     * @abstract
     */
    public function SetShowDatabasePrompt($showDatabasePrompt);

    /**
     * @abstract
     */
    public function SetDatabaseConfig($dbname, $dbuser, $dbhost);

    /**
     * @abstract
     * @return bool
     */
    public function RunningInstall();

    /**
     * @abstract
     * @return string
     */
    public function GetInstallUser();

    /**
     * @abstract
     * @return string
     */
    public function GetInstallUserPassword();

    /**
     * @abstract
     * @return bool
     */
    public function GetShouldCreateDatabase();

    /**
     * @abstract
     * @return bool
     */
    public function GetShouldCreateUser();

    /**
     * @abstract
     * @param $results array|InstallationResult[]
     * @return void
     */
    public function SetInstallResults($results);
}

class InstallPage extends Page implements IInstallPage {

    /**
     * @var \InstallPresenter
     */
    private $presenter;

    public function __construct() {
        parent::__construct('Install', 1);

        $this->presenter = new InstallPresenter($this);
    }

    public function PageLoad() {
        $this->presenter->PageLoad();   // Calling to class InstallPresenter's method
        $this->Display('install.tpl');  // Calling to class Page's method
    }

    public function SetInstallPasswordMissing($isMissing) {
        $this->Set('InstallPasswordMissing', $isMissing);
    }

    public function GetInstallPassword() {
        return $this->GetForm(FormKeys::INSTALL_PASSWORD);
    }

    public function SetShowPasswordPrompt($showPrompt) {
        $this->Set('ShowPasswordPrompt', $showPrompt);
    }

    public function SetShowInvalidPassword($showInvalidPassword) {
        $this->Set('ShowInvalidPassword', $showInvalidPassword);
    }

    public function SetShowDatabasePrompt($showDatabasePrompt) {
        $this->Set('ShowDatabasePrompt', $showDatabasePrompt);
    }

    public function SetDatabaseConfig($dbname, $dbuser, $dbhost) {
        $this->Set('dbname', $dbname);
        $this->Set('dbuser', $dbuser);
        $this->Set('dbhost', $dbhost);
    }

    public function RunningInstall() {
        $run_install = $this->GetForm('run_install');
        return!empty($run_install);
    }

    public function GetInstallUser() {
        return $this->GetForm(FormKeys::INSTALL_DB_USER);
    }

    public function GetInstallUserPassword() {
        return $this->GetForm(FormKeys::INSTALL_DB_PASSWORD);
    }

    public function GetShouldCreateDatabase() {
        $x = $this->GetForm('create_database');
        return isset($x) && $x == true;
    }

    public function GetShouldCreateUser() {
        $x = $this->GetForm('create_user');
        return isset($x) && $x == true;
    }

    /**
     * @param $results array|InstallationResult[]
     * @return void
     */
    public function SetInstallResults($results) {
        $failure = false;
        foreach ($results as $result) {
            if (!$result->WasSuccessful()) {
                $failure = true;
            }
        }

        $this->Set('InstallCompletedSuccessfully', !$failure);
        $this->Set('InstallFailed', $failure);
        $this->Set('installresults', $results);
    }

}

?>