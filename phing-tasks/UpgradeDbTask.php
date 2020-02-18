<?php
/**
Copyright 2012-2019 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */
//require_once "phing/Task.php";

//require __DIR__ . '../vendor/autoload.php';

class UpgradeDbTask // extends Task
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
        $dblink = mysqli_connect($this->host, $this->username, $this->mysqlPassword, $this->database);
		if (!$dblink)
		{
		    die('Could not connect: ' . mysqli_error($dblink));
		}

		mysqli_select_db($dblink, $this->database);

		mysqli_query($dblink, 'SET foreign_key_checks = 0;');

        $path = "$fullUpgradeDir/$fileName";
        print("Executing $path\n");

        $sqlArray = explode(';', $this->GetFullSql($path));
        foreach ($sqlArray as $stmt)
        {
            if (strlen($stmt) > 3 && substr(ltrim($stmt), 0, 2) != '/*')
            {
                $queryResult = mysqli_query($dblink, $stmt);
                if (!$queryResult)
                {
                    $sqlErrorCode = mysqli_errno($dblink);
                    $sqlErrorText = mysqli_error($dblink);
                    $sqlStmt = $stmt;

                    print("Failed on statement \"$sqlStmt\". ErrorCode: $sqlErrorCode, ErrorText: $sqlErrorText\n");
                    break;
                }
            }
        }

		mysqli_query($dblink, 'SET foreign_key_checks = 1;');
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

$task = new UpgradeDbTask();
$task->setUsername($argv[1]);
$task->setPassword($argv[2]);
$task->setHost($argv[3]);
$task->setDatabase($argv[4]);
$task->setSchemadir($argv[5]);
$task->main();