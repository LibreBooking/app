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

class Installer
{
    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * @param $should_create_db bool
     * @param $should_create_user bool
     * @param $should_create_sample_data bool
     * @return array|InstallationResult[]
     */
    public function InstallFresh($should_create_db, $should_create_user, $should_create_sample_data)
    {
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

        $populate_sample_data = new MySqlScript(ROOT_DIR . 'database_schema/sample-data-utf8.sql');
        $populate_sample_data->Replace('phpscheduleit2', $database_name);

        $create_schema = new MySqlScript(ROOT_DIR . 'database_schema/schema-utf8.sql');
        $populate_data = new MySqlScript(ROOT_DIR . 'database_schema/data-utf8.sql');

        if ($should_create_db)
        {
            $results[] = $this->ExecuteScript($hostname, 'mysql', $this->user, $this->password, $create_database);
        }

        $results[] = $this->ExecuteScript($hostname, $database_name, $this->user, $this->password, $create_schema);

        if ($should_create_user)
        {
            $results[] = $this->ExecuteScript($hostname, $database_name, $this->user, $this->password, $create_user);
        }

        $results[] = $this->ExecuteScript($hostname, $database_name, $this->user, $this->password, $populate_data);

        //$upgradeResults = $this->Upgrade();

		/**
		 * Populate sample data given in /phpScheduleIt/database_schema/sample-data-utf8.sql
		 */
		if ($should_create_sample_data)
		{
			$results[] = $this->ExecuteScript($hostname, $database_name, $this->user, $this->password, $populate_sample_data);
		}

        //$results = array_merge($results, $upgradeResults);
        return $results;
    }

    /**
     * @return array|InstallationResult[]
     */
    public function Upgrade()
    {
        $results = array();

        $upgradeDir = ROOT_DIR . 'database_schema/upgrades';
        $upgrades = scandir($upgradeDir);

        $currentVersion = $this->GetVersion();

        usort($upgrades, array($this, 'SortDirectories'));

        foreach ($upgrades as $upgrade)
        {
            if ($upgrade === '.' || $upgrade === '..' || strpos($upgrade, '.') === 0)
            {
                continue;
            }

            $upgradeResults = $this->ExecuteUpgrade($upgradeDir, $upgrade, $currentVersion);
            $results = array_merge($results, $upgradeResults);
        }

        return $results;
    }

    /**
     * @param string $upgradeDir
     * @param string $versionNumber
     * @param string $currentVersion
     * @return array|InstallationResult[]
     */
    private function ExecuteUpgrade($upgradeDir, $versionNumber, $currentVersion)
    {
        $results = array();
        $fullUpgradeDir = "$upgradeDir/$versionNumber";
        if (!is_dir($fullUpgradeDir))
        {
            $results[] = new InstallationResultSkipped($versionNumber);
        }
        else
        {
            $greaterThanCurrent = floatval($versionNumber) > floatval($currentVersion);

            if ($greaterThanCurrent)
            {
                $config = Configuration::Instance();
                $hostname = $config->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_HOSTSPEC);
                $database_name = $config->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_NAME);
                $database_user = $this->user;
                $database_password = $this->password;

                $create_schema = new MySqlScript("$fullUpgradeDir/schema.sql");
                $results[] = $this->ExecuteScript($hostname, $database_name, $database_user, $database_password, $create_schema);

                $populate_data = new MySqlScript("$fullUpgradeDir/data.sql");
                $results[] = $this->ExecuteScript($hostname, $database_name, $database_user, $database_password, $populate_data);
            }
        }
        return $results;
    }

    private function SortDirectories($dir1, $dir2)
    {
        $d1 = floatval($dir1);
        $d2 = floatval($dir2);

        if ($d1 == $d2)
        {
            return 0;
        }
        return ($d1 < $d2) ? -1 : 1;
    }

    protected function ExecuteScript($hostname, $database_name, $db_user, $db_password, MySqlScript $script)
    {
        $result = new InstallationResult($script->Name());

        $sqlErrorCode = 0;
        $sqlErrorText = null;
        $sqlStmt = null;

        $link = @mysql_connect($hostname, $db_user, $db_password);
        if (!$link)
        {
            $result->SetConnectionError();
            return $result;
        }

        $select_db_result = @mysql_select_db($database_name, $link);
        if (!$select_db_result)
        {
            $result->SetAuthenticationError();
            return $result;
        }

        $sqlArray = explode(';', $script->GetFullSql());
        foreach ($sqlArray as $stmt)
        {
            if (strlen($stmt) > 3 && substr(ltrim($stmt), 0, 2) != '/*')
            {
                $queryResult = @mysql_query($stmt);
                if (!$queryResult)
                {
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

    /**
     * @return float
     */
    public function GetVersion()
    {
        // if dbversion table does not exist or version in db is less than current

        $config = Configuration::Instance();
        $hostname = $config->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_HOSTSPEC);
        $database_name = $config->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_NAME);
        $database_user = $config->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_USER);
        $database_password = $config->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_PASSWORD);

        $link = mysql_connect($hostname, $database_user, $database_password);
        if (!$link)
        {
            return false;
        }

        $select_db_result = mysql_select_db($database_name, $link);
        if (!$select_db_result)
        {
            return false;
        }

        $getVersion = 'SELECT * FROM dbversion';
        $result = mysql_query($getVersion);

        if (!$result)
        {
            return 2.0;
        }

        if ($row = mysql_fetch_assoc($result))
        {
            return $row['version_number'];
        }

        return 2.0;
    }

    public function ClearCachedTemplates()
    {
        try
        {
            $templateDirectory = ROOT_DIR . 'tpl_c';
            $d = dir($templateDirectory);
            while ($entry = $d->read())
            {
                if ($entry != "." && $entry != "..")
                {
                    @unlink($templateDirectory . '/' . $entry);
                }
            }
            $d->close();
        }
        catch(Exception $ex)
        {
            // eat it and move on
        }
    }
}

?>
