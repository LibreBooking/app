<?php
/**
Copyright 2013-2014 Nick Korbel

This file is part of Booked SchedulerBooked SchedulereIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later versBooked SchedulerduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
alBooked SchedulercheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

class PasswordComplexityValidator extends ValidatorBase implements IValidator
{
	private $password;

	public function __construct($passwordPlainText)
	{
		$this->password = $passwordPlainText;
	}

	public function Validate()
	{
		$caseRequirements = Configuration::Instance()->GetSectionKey(ConfigSection::PASSWORD, ConfigKeys::PASSWORD_UPPER_AND_LOWER, new BooleanConverter());
		$letters = Configuration::Instance()->GetSectionKey(ConfigSection::PASSWORD, ConfigKeys::PASSWORD_LETTERS, new IntConverter());
		$numbers = Configuration::Instance()->GetSectionKey(ConfigSection::PASSWORD, ConfigKeys::PASSWORD_NUMBERS, new IntConverter());

		$passwordNumbers = preg_match_all( "/[^a-zA-Z]/", $this->password, $m1);
		$passwordUpper = preg_match_all( "/[A-Z]/", $this->password, $m2);
		$passwordLower = preg_match_all( "/[a-z]/", $this->password, $m3);
		$passwordLetters = strlen($this->password);

		if (empty($letters))
		{
			$letters = 6;
		}

		$this->isValid = $passwordNumbers >= $numbers && $passwordLetters >= $letters;

		if ($caseRequirements)
		{
			$this->isValid = $this->isValid && $passwordUpper > 0 && $passwordLower > 0;
		}

		if (!$this->IsValid())
		{
			if (!$caseRequirements)
			{
				$this->AddMessage(Resources::GetInstance()->GetString('PasswordError', array($letters, $numbers)));
			}
			else
			{
				$this->AddMessage(Resources::GetInstance()->GetString('PasswordErrorRequirements', array($letters, $numbers)));
			}
		}
	}

}