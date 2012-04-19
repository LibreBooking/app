<?php
/**
Copyright 2012 Nick Korbel

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
require_once "phing/Task.php";

class UpgradeDbTask extends Task
{
    private $username = null;

    public function setUsername($username)
    {
        $this->username = $username;
    }

    private $mysqlPassword = null;

    public function setPassword($password)
    {
        $this->mysqlPassword = $password;
    }

    private $host = null;

    public function setHost($host)
    {
        $this->host = $host;
    }

    private $database = null;

    public function setDatabase($database)
    {
        $this->database = $database;
    }

    private $schemaDir = null;

    public function setSchemadir($schemadir)
    {
        $this->schemaDir = $schemadir;
    }

    /**
     * The init method: Do init steps.
     */
    public function init()
    {
        // nothing to do here
    }

    /**
     * The main entry point method.
     */
    public function main()
    {
        $upgradeDir = "{$this->schemaDir}/upgrades";
        $upgrades = scandir($upgradeDir);

        usort($upgrades, array($this, 'SortDirectories'));

        foreach ($upgrades as $upgrade)
        {
            if ($upgrade === '.' || $upgrade === '..' || strpos($upgrade, '.') === 0)
            {
                continue;
            }

            $this->ExecuteUpgrade($upgradeDir, $upgrade);
        }
    }

    private function ExecuteUpgrade($upgradeDir, $upgrade)
    {
        $fullUpgradeDir = "$upgradeDir/$upgrade";
        if (!is_dir($fullUpgradeDir))
        {
            return;
        }

        print("Upgrading database to version $upgrade\n");

       // $this->ExecuteFile($fullUpgradeDir, 'clean.sql');
        $this->ExecuteFile($fullUpgradeDir, 'schema.sql');
        $this->ExecuteFile($fullUpgradeDir, 'data.sql');

        print("Finished upgrading database to version $upgrade\n");
    }

    private function ExecuteFile($fullUpgradeDir, $fileName)
    {
        $dblink = mysql_connect($this->host, $this->username, $this->mysqlPassword);
		if (!$dblink)
		{
		    die('Could not connect: ' . mysql_error());
		}

		mysql_select_db($this->database, $dblink);

        $path = "$fullUpgradeDir/$fileName";
        print("Executing $path\n");

        $sqlArray = explode(';', $this->GetFullSql($path));
        foreach ($sqlArray as $stmt)
        {
            if (strlen($stmt) > 3 && substr(ltrim($stmt), 0, 2) != '/*')
            {
                $queryResult = mysql_query($stmt);
                if (!$queryResult)
                {
                    $sqlErrorCode = mysql_errno();
                    $sqlErrorText = mysql_error();
                    $sqlStmt = $stmt;

                    print("Failed on statement \"$sqlStmt\". ErrorCode: $sqlErrorCode, ErrorText: $sqlErrorText\n");
                    break;
                }
            }
        }
    }

    private function  GetFullSql($file)
    {
        $f = fopen($file, "r");
        $sql = fread($f, filesize($file));
        fclose($f);
        return $sql;
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
}

?>