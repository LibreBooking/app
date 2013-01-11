<?php
/**
Copyright 2013 Nick Korbel

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

class CreateUserRequest
{
	public $firstName;
	public $lastName;
	public $emailAddress;
	public $userName;
	public $timezone;
	public $language;
	public $password;
	public $phone;
	public $organization;
	public $position;
	/** @var array|AttributeValueRequest[] */
	public $customAttributes = array();
}

class ExampleCreateUserRequest extends CreateUserRequest
{
	public function __construct()
	{
		$this->firstName = 'first';
		$this->lastName = 'last';
		$this->emailAddress = 'email@address.com';
		$this->userName = 'username';
		$this->timezone = 'America/Chicago';
		$this->language = 'en_us';
		$this->password = 'unencrypted password';
		$this->phone = '123-456-7989';
		$this->organization = 'organization';
		$this->position = 'position';
		$this->customAttributes = array(new AttributeValueRequest(99, 'attribute value'));
	}

}

?>