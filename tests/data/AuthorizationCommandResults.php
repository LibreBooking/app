<?php
/**
Copyright 2011-2013 Nick Korbel

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

class AuthorizationCommandResults
{
	private $rows = array();

	public $UserId = 1;
	public $Password = 'password';
	public $Salt = 'salt';
	public $OldPassword = 'oldpassword';

	public static function ValidUser()
	{
		$results = new AuthorizationCommandResults();
		$results->AddDefaultUser();

		return $results;
	}

	public static function InvalidUser()
	{
		return new AuthorizationCommandResults();
	}

	private function AddDefaultUser()
	{
		$this->AddRow($this->UserId, $this->Password, $this->Salt, $this->OldPassword);
	}

	public function AddRow($userid, $password, $salt, $oldpassword)
	{
		$this->rows[] = array(
			ColumnNames::USER_ID => $userid,
			ColumnNames::PASSWORD => $password,
			ColumnNames::SALT => $salt,
			ColumnNames::OLD_PASSWORD => $oldpassword);
	}

	public function Rows()
	{
		return $this->rows;
	}
}
?>