<?php
/**
Copyright 2011-2019 Nick Korbel

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


/**
 * Display successful/failure message after attempting the auto installation
 */
class InstallationResult
{
	public $connectionError = false;
	public $authError = false;
	public $taskName;
	public $sqlErrorCode;
	public $sqlErrorText;
	public $sqlText;

	public function __construct($taskName)
	{
		$this->taskName = $taskName;
	}

	public function SetConnectionError()
	{
		$this->connectionError = true;
		$this->sqlErrorText = "Error connecting to mysql database.  Check your configured host and entered username and password.";
	}

	public function SetAuthenticationError()
	{
		$this->authError = true;
		$this->sqlErrorText = "Error selecting to mysql database.  Check entered username and password.";
	}

	public function SetResult($sqlErrorCode, $sqlErrorText, $sqlStmt)
	{
		$this->sqlErrorCode = $sqlErrorCode;
		$this->sqlErrorText = $sqlErrorText;
		$this->sqlText = $sqlStmt;
	}

	public function WasSuccessful()
	{
		return !$this->connectionError && !$this->authError && $this->sqlErrorCode == 0;
	}

}

class InstallationResultSkipped extends InstallationResult
{
	public function __construct($versionNumber)
	{
		$this->taskName = "Skipping $versionNumber";
	}

	public function WasSuccessful()
	{
		true;
	}
}

