<?php
/**
Copyright 2012-2018 Nick Korbel

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
require_once "phing/Task.php";

class CombineDbFilesTask extends Task
{
    private $schemaDir = null;

    public function setSchemadir($schemadir)
    {
        $this->schemaDir = $schemadir;
    }

	private $schemaFile = null;

    public function setSchemafile($schemaFile)
    {
        $this->schemaFile = $schemaFile;
    }

	private $dataFile = null;

    public function setDatafile($dataFile)
    {
        $this->dataFile = $dataFile;
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

		print("Searching $upgradeDir for upgrade directories\n");

        $upgrades = scandir($upgradeDir);

        usort($upgrades, array($this, 'SortDirectories'));

        foreach ($upgrades as $upgrade)
        {
            if ($upgrade === '.' || $upgrade === '..' || strpos($upgrade, '.') === 0)
            {
                continue;
            }

            $this->Combine($upgradeDir, $upgrade);
        }
    }

    private function Combine($upgradeDir, $versionNumber)
    {
        $fullUpgradeDir = "$upgradeDir/$versionNumber";
        if (!is_dir($fullUpgradeDir))
        {
            return;
        }

        print("Combining database files for version $versionNumber\n");

        $this->CombineMainFiles($fullUpgradeDir, $versionNumber);
        $this->CombineUpgradeFiles($fullUpgradeDir, $versionNumber);

        print("Finished combining database files for version $versionNumber\n");
    }

	private function CombineMainFiles($upgradeDir, $versionNumber)
	{
		$versionInfo = "\r\n\r\n-- UPGRADE TO VERSION $versionNumber\r\n\r\n";

		// schema
		$schemaHandle = fopen($this->schemaFile, "a");
		$upgradeSchema = $this->GetSchemaFileContents($upgradeDir);
		$newContents = "$versionInfo\r\n\r\n$upgradeSchema";

		fwrite($schemaHandle, $newContents);
		fclose($schemaHandle);

		// data
		$dataHandle = fopen($this->dataFile, "a");
		$upgradeData = $this->GetDataFileContents($upgradeDir);
		$newContents = "$versionInfo\r\n\r\n$upgradeData";

		fwrite($dataHandle, $newContents);
		fclose($dataHandle);
	}

	private function CombineUpgradeFiles($upgradeDir, $versionNumber)
	{
		$upgradeHandle = fopen("$upgradeDir/upgrade.sql", "w+");

		$upgradeSchema = $this->GetSchemaFileContents($upgradeDir);
		$upgradeData = $this->GetDataFileContents($upgradeDir);

		fwrite($upgradeHandle, "\r\n\r\n$upgradeSchema\r\n\r\n$upgradeData");
		fclose($upgradeHandle);
	}

    private function GetFullSql($file)
    {
        $f = fopen($file, "r");
        $sql = fread($f, filesize($file));
        fclose($f);
        return $sql;
    }

	private function GetSchemaFileContents($upgradeDir)
	{
		return $this->GetFullSql("$upgradeDir/schema.sql");
	}

	private function GetDataFileContents($upgradeDir)
	{
		return $this->GetFullSql("$upgradeDir/data.sql");
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