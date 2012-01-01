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


class UniqueEmailValidator extends ValidatorBase implements IValidator 
{
	private $_email;
	private $_userid;
	
	public function __construct($email, $userid = null)
	{
		$this->_email = $email;
		$this->_userid = $userid;
	}
	
	public function Validate()
	{
		$this->isValid = true;

		$results = ServiceLocator::GetDatabase()->Query(new CheckEmailCommand($this->_email));

		if ($row = $results->GetRow())
		{
			$this->isValid = ($row[ColumnNames::USER_ID] == $this->_userid);
		}
	}
}
?>