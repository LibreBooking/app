<?php
/**
 * Copyright 2015 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

class UserImportCsvRow
{
	public $username;
	public $email;
	public $firstName = 'imported';
	public $lastName = 'imported';
	public $password;
	public $phone;
	public $organization;
	public $position;
	public $timezone;
	public $language;
	public $groups = array();

	private $values = array();
	private $indexes = array();

	/**
	 * @param $values array
	 * @param $indexes array
	 */
	public function __construct($values, $indexes)
	{
		$this->values = $values;
		$this->indexes = $indexes;
        
		$this->username = $this->valueOrDefault('username');
		$this->email = $this->valueOrDefault('email');
		$this->firstName = $this->valueOrDefault('firstName');
		$this->lastName = $this->valueOrDefault('lastName');
		$this->password = $this->valueOrDefault('password');
		$this->phone = $this->valueOrDefault('phone');
		$this->organization = $this->valueOrDefault('organization');
		$this->position = $this->valueOrDefault('position');
		$this->timezone = $this->valueOrDefault('timezone');
		$this->language = $this->valueOrDefault('language');
		$this->groups = (!array_key_exists('groups', $this->indexes) || $indexes['groups'] === false) ? array() : array_map('trim', explode(',', $values[$indexes['groups']]));
	}

	public function IsValid()
	{
		$isValid = !empty($this->username) && !empty($this->email);
        if (!$isValid)
        {
            Log::Debug('User import row is not valid. Username %s, Email %s', $this->username, $this->email);
        }
        return $isValid;
	}

	/**
	 * @param $values
	 * @return bool|string[]
	 */
	public static function GetHeaders($values)
	{
		if (!in_array('email', $values) && !in_array('username', $values))
		{
			return false;
		}

		$indexes['email'] = array_search('email', $values);
		$indexes['username'] = array_search('username', $values);
		$indexes['firstName'] = array_search('first name', $values);
		$indexes['lastName'] = array_search('last name', $values);
		$indexes['password'] = array_search('password', $values);
		$indexes['phone'] = array_search('phone', $values);
		$indexes['organization'] = array_search('organization', $values);
		$indexes['position'] = array_search('position', $values);
		$indexes['timezone'] = array_search('timezone', $values);
		$indexes['language'] = array_search('language', $values);
		$indexes['groups'] = array_search('groups', $values);

		return $indexes;
	}

	/**
	 * @param $column string
	 * @return string
	 */
	private function valueOrDefault($column)
	{
		return ($this->indexes[$column] === false || !array_key_exists($this->indexes[$column], $this->values)) ? '' : trim($this->values[$this->indexes[$column]]);
	}
}

class UserImportCsv
{
	/**
	 * @var UploadedFile
	 */
	private $file;

	/**
	 * @var int[]
	 */
	private $skippedRowNumbers = array();

	public function __construct(UploadedFile $file)
	{
		$this->file = $file;
	}

	/**
	 * @return UserImportCsvRow[]
	 */
	public function GetRows()
	{
		$rows = array();

        $csvRows = str_getcsv($this->file->Contents(), "\n");

		if (count($csvRows) == 0)
		{
            Log::Debug('No rows in user import file');
			return $rows;
		}

		$headers = UserImportCsvRow::GetHeaders(str_getcsv($csvRows[0]));

		if (!$headers)
		{
            Log::Debug('No headers in user import file');
            return $rows;
		}

		for($i = 1; $i < count($csvRows); $i++)
		{
			$values = str_getcsv($csvRows[$i]);

			$row = new UserImportCsvRow($values, $headers);

			if ($row->IsValid())
			{
				$rows[] = $row;
			}
			else
			{
				Log::Error('Skipped import of user row %s. Values %s', $i, print_r($values, true));
				$this->skippedRowNumbers[] = $i;
			}
		}

		return $rows;
	}

	/**
	 * @return int[]
	 */
	public function GetSkippedRowNumbers()
	{
		return $this->skippedRowNumbers;
	}
}